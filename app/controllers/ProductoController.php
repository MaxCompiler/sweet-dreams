<?php
include_once __DIR__ . '/../models/Producto.php';

class ProductoController {

    private $modelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new Producto();
    }

    public function listar() {
        $this->verificarSesion();
        $productos = $this->modelo->obtenerTodos();
        include __DIR__ . '/../views/productos/listar.php';
    }

    public function ver() {
        $this->verificarSesion();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?accion=listarProductos');
            exit;
        }

        $producto = $this->modelo->obtenerPorId($id);

        if (!$producto) {
            header('Location: ' . BASE_URL . '/index.php?accion=listarProductos&error=Producto no encontrado');
            exit;
        }

        include __DIR__ . '/../views/productos/ver.php';
    }

    public function crear() {
        $this->verificarRol('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre      = $_POST['nombre']      ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $precio      = $_POST['precio']      ?? 0;
            $stock       = $_POST['stock']       ?? 0;
            $imagen      = $_POST['imagen']      ?? '';

            $resultado = $this->modelo->crear($nombre, $descripcion, $precio, $stock, $imagen);

            if ($resultado['Exito']) {
                header('Location: ' . BASE_URL . '/index.php?accion=listarProductos&exito=' . urlencode($resultado['mensaje']));
                exit;
            } else {
                $error = $resultado['mensaje'];
                include __DIR__ . '/../views/productos/crear.php';
            }

        } else {
            include __DIR__ . '/../views/productos/crear.php';
        }
    }

    public function editar() {
        $this->verificarRol('admin');
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?accion=listarProductos');
            exit;
        }

        $producto = $this->modelo->obtenerPorId($id);

        if (!$producto) {
            header('Location: ' . BASE_URL . '/index.php?accion=listarProductos&error=Producto no encontrado');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre      = $_POST['nombre']      ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $precio      = $_POST['precio']      ?? 0;
            $stock       = $_POST['stock']       ?? 0;
            $imagen      = $_POST['imagen']      ?? '';

            $resultado = $this->modelo->actualizar($id, $nombre, $descripcion, $precio, $stock, $imagen);

            if ($resultado['Exito']) {
                header('Location: ' . BASE_URL . '/index.php?accion=listarProductos&exito=' . urlencode($resultado['mensaje']));
                exit;
            } else {
                $error = $resultado['mensaje'];
                include __DIR__ . '/../views/productos/editar.php';
            }

        } else {
            include __DIR__ . '/../views/productos/editar.php';
        }
    }

    public function eliminar() {
        $this->verificarRol('admin');
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?accion=listarProductos');
            exit;
        }

        $resultado = $this->modelo->eliminar($id);

        if ($resultado['Exito']) {
            header('Location: ' . BASE_URL . '/index.php?accion=listarProductos&exito=' . urlencode($resultado['mensaje']));
        } else {
            header('Location: ' . BASE_URL . '/index.php?accion=listarProductos&error=' . urlencode($resultado['mensaje']));
        }
        exit;
    }

    private function verificarSesion() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/index.php?accion=login');
            exit;
        }
    }

    private function verificarRol($rol) {
        $this->verificarSesion();
        if ($_SESSION['rol'] !== $rol) {
            header('Location: ' . BASE_URL . '/index.php?accion=login');
            exit;
        }
    }
}
?>