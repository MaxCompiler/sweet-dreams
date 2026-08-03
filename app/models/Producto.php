<?php
include_once __DIR__ . '/../../config/database.php';

class Producto {
    private $db;

    public function __construct() {
        $this->db = Database::getConexion();
    }

    public function crear($nombre, $descripcion, $precio, $stock, $imagen) {
        try {
            // Validaciones
            $nombre = trim($nombre);
            $descripcion = trim($descripcion);
            $imagen = trim($imagen);

            if ($nombre === '') {
                return ['Exito' => false, 'mensaje' => 'El nombre del producto es obligatorio'];
            }
            if (!is_numeric($precio) || $precio <= 0) {
                return ['Exito' => false, 'mensaje' => 'El precio debe ser mayor a 0'];
            }
            if (!is_numeric($stock) || $stock < 0) {
                return ['Exito' => false, 'mensaje' => 'El stock no puede ser negativo'];
            }

            $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$nombre, $descripcion, $precio, $stock, $imagen]);

            return ['Exito' => true, 'mensaje' => 'Producto creado correctamente'];

        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al crear producto: ' . $e->getMessage()];
        }
    }

    public function obtenerTodos() {
        try {
            $sql = "SELECT id, nombre, descripcion, precio, stock, imagen, creacion_imagen 
                    FROM productos 
                    ORDER BY creacion_imagen DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            return [];
        }
    }

    public function obtenerPorId($id) {
        try {
            $sql = "SELECT id, nombre, descripcion, precio, stock, imagen, creacion_imagen 
                    FROM productos 
                    WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $stock, $imagen) {
        try {
            // Validaciones
            $nombre = trim($nombre);
            $descripcion = trim($descripcion);
            $imagen = trim($imagen);

            if ($nombre === '') {
                return ['Exito' => false, 'mensaje' => 'El nombre del producto es obligatorio'];
            }
            if (!is_numeric($precio) || $precio <= 0) {
                return ['Exito' => false, 'mensaje' => 'El precio debe ser mayor a 0'];
            }
            if (!is_numeric($stock) || $stock < 0) {
                return ['Exito' => false, 'mensaje' => 'El stock no puede ser negativo'];
            }

            $sql = "UPDATE productos 
                    SET nombre = ?, descripcion = ?, precio = ?, stock = ?, imagen = ? 
                    WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$nombre, $descripcion, $precio, $stock, $imagen, $id]);

            return ['Exito' => true, 'mensaje' => 'Producto actualizado correctamente'];

        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al actualizar producto: ' . $e->getMessage()];
        }
    }

    public function eliminar($id) {
        try {
            $sql = "DELETE FROM productos WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            return ['Exito' => true, 'mensaje' => 'Producto eliminado correctamente'];

        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al eliminar producto: ' . $e->getMessage()];
        }
    }

    public function verificarStock($id, $cantidad) {
        try {
            $producto = $this->obtenerPorId($id);

            if (!$producto) {
                return ['Exito' => false, 'mensaje' => 'Producto no encontrado'];
            }
            if ($producto['stock'] < $cantidad) {
                return ['Exito' => false, 'mensaje' => 'Stock insuficiente. Disponible: ' . $producto['stock']];
            }

            return ['Exito' => true, 'mensaje' => 'Stock disponible'];

        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al verificar stock: ' . $e->getMessage()];
        }
    }

    public function actualizarStock($id, $cantidad) {
        try {
            // Verificar stock antes de reducirlo
            $verificacion = $this->verificarStock($id, $cantidad);
            if (!$verificacion['Exito']) {
                return $verificacion;
            }

            $sql = "UPDATE productos SET stock = stock - ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$cantidad, $id]);

            return ['Exito' => true, 'mensaje' => 'Stock actualizado correctamente'];

        } catch (PDOException $e) {
            return ['Exito' => false, 'mensaje' => 'Error al actualizar stock: ' . $e->getMessage()];
        }
    }
}
?>