<?php

include_once __DIR__ . '/../../config/database.php';

class Pedido
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConexion();
    }

    public function crear($cliente_id, $fecha_entrega, $nota)
    {
        try {
            $nota = trim($nota);

            if (empty($cliente_id)) {
                return ['Exito' => false, 'mensaje' => 'Cliente no valido'];
            }
            if (empty($fecha_entrega)) {
                return ['Exito' => false, 'mensaje' => 'La fecha de entrega es obligatoria'];
            }

            // Validar que la fecha de entrega no sea en el pasado
            if (strtotime($fecha_entrega) < strtotime('today')) {
                return ['Exito' => false, 'mensaje' => 'La fecha de entrega no puede ser en el pasado'];
            }

            $sql = "INSERT INTO pedidos (cliente_id, fecha_entrega, nota, estado, total) 
                    VALUES (?, ?, ?, 'pendiente', 0)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$cliente_id, $fecha_entrega, $nota]);

            // Retorna el id del pedido recien creado
            return ['Exito' => true, 'mensaje' => 'Pedido creado correctamente', 'id' => $this->db->lastInsertId()];
        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al crear pedido: ' . $e->getMessage()];
        }
    }

    public function obtenerTodos()
    {
        try {
            $sql = "SELECT p.id, p.fecha_pedido, p.fecha_entrega, p.estado, p.total, p.nota,
                        u.nombre AS cliente_nombre, u.email AS cliente_email,
                        e.nombre AS empleado_nombre
                    FROM pedidos p
                    INNER JOIN usuarios u ON p.cliente_id = u.id
                    LEFT JOIN usuarios e ON p.empleado_id = e.id
                    ORDER BY p.fecha_pedido DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtenerPorId($id)
    {
        try {
            $sql = "SELECT p.id, p.fecha_pedido, p.fecha_entrega, p.estado, p.total, p.nota,
                        p.cliente_id, p.empleado_id,
                        u.nombre AS cliente_nombre, u.email AS cliente_email,
                        e.nombre AS empleado_nombre
                    FROM pedidos p
                    INNER JOIN usuarios u ON p.cliente_id = u.id
                    LEFT JOIN usuarios e ON p.empleado_id = e.id
                    WHERE p.id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerPorCliente($cliente_id)
    {
        try {
            $sql = "SELECT p.id, p.fecha_pedido, p.fecha_entrega, p.estado, p.total, p.nota,
                        e.nombre AS empleado_nombre
                    FROM pedidos p
                    LEFT JOIN usuarios e ON p.empleado_id = e.id
                    WHERE p.cliente_id = ?
                    ORDER BY p.fecha_pedido DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$cliente_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtenerPorEmpleado($empleado_id)
    {
        try {
            $sql = "SELECT p.id, p.fecha_pedido, p.fecha_entrega, p.estado, p.total, p.nota,
                        u.nombre AS cliente_nombre, u.email AS cliente_email, u.telefono AS cliente_telefono
                    FROM pedidos p
                    INNER JOIN usuarios u ON p.cliente_id = u.id
                    WHERE p.empleado_id = ?
                    ORDER BY p.fecha_pedido DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$empleado_id]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    public function actualizar($id, $fecha_entrega, $nota)
    {
        try {
            $nota = trim($nota);

            if (empty($fecha_entrega)) {
                return ['Exito' => false, 'mensaje' => 'La fecha de entrega es obligatoria'];
            }

            $sql = "UPDATE pedidos SET fecha_entrega = ?, nota = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$fecha_entrega, $nota, $id]);

            return ['Exito' => true, 'mensaje' => 'Pedido actualizado correctamente'];
        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al actualizar pedido: ' . $e->getMessage()];
        }
    }

    public function eliminar($id)
    {
        try {
            $sql = "DELETE FROM pedidos WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            return ['Exito' => true, 'mensaje' => 'Pedido eliminado correctamente'];
        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al eliminar pedido: ' . $e->getMessage()];
        }
    }

    public function cambiarEstado($id, $estado)
    {
        try {
            $estadosValidos = ['pendiente', 'preparacion', 'listo', 'entregado', 'cancelado'];
            if (!in_array($estado, $estadosValidos)) {
                return ['Exito' => false, 'mensaje' => 'Estado no valido'];
            }

            $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$estado, $id]);

            return ['Exito' => true, 'mensaje' => 'Estado actualizado a: ' . $estado];
        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al cambiar estado: ' . $e->getMessage()];
        }
    }

    public function asignarEmpleado($id, $empleado_id)
    {
        try {
            $sql = "UPDATE pedidos SET empleado_id = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$empleado_id, $id]);

            return ['Exito' => true, 'mensaje' => 'Empleado asignado correctamente'];
        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al asignar empleado: ' . $e->getMessage()];
        }
    }

    public function actualizarTotal($id)
    {
        try {
            
            $sql = "UPDATE pedidos 
                    SET total = (
                        SELECT COALESCE(SUM(subtotal), 0) 
                        FROM detalle_pedidos 
                        WHERE pedido_id = ?
                    ) 
                    WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id, $id]);

            return ['Exito' => true, 'mensaje' => 'Total actualizado correctamente'];
        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al actualizar total: ' . $e->getMessage()];
        }
    }
}
