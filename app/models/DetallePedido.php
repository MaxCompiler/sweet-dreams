<?php

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/Producto.php';
include_once __DIR__ . '/Pedido.php';

class DetallePedido {
    private $db;

    public function __construct() {
        $this->db = Database::getConexion();
    }

    public function agregar($pedido_id, $producto_id, $cantidad) {
        try {
            // Validaciones basicas
            if (empty($pedido_id) || empty($producto_id)) {
                return ['Exito' => false, 'mensaje' => 'Pedido o producto no valido'];
            }
            if (!is_numeric($cantidad) || $cantidad < 1) {
                return ['Exito' => false, 'mensaje' => 'La cantidad debe ser mayor a 0'];
            }

            // Verificar stock disponible
            $modeloProducto = new Producto();
            $verificacion = $modeloProducto->verificarStock($producto_id, $cantidad);
            if (!$verificacion['Exito']) {
                return $verificacion;
            }

            // Obtener precio actual del producto
            $producto = $modeloProducto->obtenerPorId($producto_id);
            if (!$producto) {
                return ['Exito' => false, 'mensaje' => 'Producto no encontrado'];
            }

            $precio_unitario = $producto['precio'];
            $subtotal = $precio_unitario * $cantidad;

            // Insertar el detalle del pedido
            $sql = "INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario, subtotal) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$pedido_id, $producto_id, $cantidad, $precio_unitario, $subtotal]);

            // Reducir el stock del producto
            $modeloProducto->actualizarStock($producto_id, $cantidad);

            // Actualizar el total del pedido
            $modeloPedido = new Pedido();
            $modeloPedido->actualizarTotal($pedido_id);

            return ['Exito' => true, 'mensaje' => 'Producto agregado al pedido correctamente'];

        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al agregar producto al pedido: ' . $e->getMessage()];
        }
    }

    public function obtenerPorPedido($pedido_id) {
        try {
            $sql = "SELECT dp.id, dp.cantidad, dp.precio_unitario, dp.subtotal,
                        p.nombre AS producto_nombre, p.descripcion, p.imagen
                    FROM detalle_pedidos dp
                    INNER JOIN productos p ON dp.producto_id = p.id
                    WHERE dp.pedido_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$pedido_id]);
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            return [];
        }
    }

    public function eliminar($id, $pedido_id, $producto_id, $cantidad) {
        try {
            $sql = "DELETE FROM detalle_pedidos WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            $sql = "UPDATE productos SET stock = stock + ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$cantidad, $producto_id]);

            $modeloPedido = new Pedido();
            $modeloPedido->actualizarTotal($pedido_id);

            return ['Exito' => true, 'mensaje' => 'Producto eliminado del pedido correctamente'];

        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al eliminar producto del pedido: ' . $e->getMessage()];
        }
    }

    public function eliminarPorPedido($pedido_id) {
        try {
            $detalles = $this->obtenerPorPedido($pedido_id);
            $modeloProducto = new Producto();

            foreach ($detalles as $detalle) {
                $sql = "UPDATE productos SET stock = stock + ? WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$detalle['cantidad'], $detalle['producto_id']]);
            }

            $sql = "DELETE FROM detalle_pedidos WHERE pedido_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$pedido_id]);

            return ['Exito' => true, 'mensaje' => 'Todos los productos del pedido eliminados correctamente'];

        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al eliminar productos del pedido: ' . $e->getMessage()];
        }
    }
}
?>