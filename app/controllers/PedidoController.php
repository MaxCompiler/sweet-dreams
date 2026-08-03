<?php

include_once __DIR__ . '/../models/Pedido.php';
include_once __DIR__ . '/../models/DetallePedido.php';
include_once __DIR__ . '/../models/Producto.php';
include_once __DIR__ . '/../models/Usuario.php';

class PedidoController {

    private $modelo;
    private $modeloDetalle;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo        = new Pedido();
        $this->modeloDetalle = new DetallePedido();
    }


    public function listar() {
        $this->verificarSesion();
        $rol = $_SESSION['rol'];

        if ($rol === 'admin') {
            $pedidos = $this->modelo->obtenerTodos();
            include __DIR__ . '/../views/pedidos/listar_admin.php';

        } else if ($rol === 'empleado') {
            $pedidos = $this->modelo->obtenerPorEmpleado($_SESSION['usuario_id']);
            include __DIR__ . '/../views/pedidos/listar_empleado.php';

        } else {

            $pedidos = $this->modelo->obtenerPorCliente($_SESSION['usuario_id']);
            include __DIR__ . '/../views/pedidos/listar_cliente.php';
        }
    }

    public function ver() {
        $this->verificarSesion();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
            exit;
        }

        $pedido = $this->modelo->obtenerPorId($id);

        if (!$pedido) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos&error=Pedido no encontrado');
            exit;
        }

        if ($_SESSION['rol'] === 'cliente' && $pedido['cliente_id'] != $_SESSION['usuario_id']) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
            exit;
        }

        if ($_SESSION['rol'] === 'empleado' && $pedido['empleado_id'] != $_SESSION['usuario_id']) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
            exit;
        }

        $detalle   = $this->modeloDetalle->obtenerPorPedido($id);
        $productos = (new Producto())->obtenerTodos();
        include __DIR__ . '/../views/pedidos/ver.php';
    }

    public function crear() {
        $this->verificarRol('cliente');

        $productos = (new Producto())->obtenerTodos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fecha_entrega = $_POST['fecha_entrega'] ?? '';
            $nota          = $_POST['nota']          ?? '';
            $cliente_id    = $_SESSION['usuario_id'];

            // Crear el pedido
            $resultado = $this->modelo->crear($cliente_id, $fecha_entrega, $nota);

            if (!$resultado['Exito']) {
                $error = $resultado['mensaje'];
                include __DIR__ . '/../views/pedidos/crear.php';
                return;
            }

            $pedido_id = $resultado['id'];

            $productos_ids    = $_POST['producto_id'] ?? [];
            $cantidades       = $_POST['cantidad']    ?? [];
            $errores_detalle  = [];

            foreach ($productos_ids as $index => $producto_id) {
                $cantidad = $cantidades[$index] ?? 1;

                if ($producto_id && $cantidad > 0) {
                    $res = $this->modeloDetalle->agregar($pedido_id, $producto_id, $cantidad);
                    if (!$res['Exito']) {
                        $errores_detalle[] = $res['mensaje'];
                    }
                }
            }

            if (!empty($errores_detalle)) {
                $error = implode(', ', $errores_detalle);
                include __DIR__ . '/../views/pedidos/crear.php';
                return;
            }

            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos&exito=Pedido creado correctamente');
            exit;

        } else {
            include __DIR__ . '/../views/pedidos/crear.php';
        }
    }

    public function editar() {
        $this->verificarSesion();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
            exit;
        }

        $pedido = $this->modelo->obtenerPorId($id);

        if (!$pedido) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos&error=Pedido no encontrado');
            exit;
        }


        if ($_SESSION['rol'] === 'cliente') {
            if ($pedido['cliente_id'] != $_SESSION['usuario_id']) {
                header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
                exit;
            }

            if ($pedido['estado'] !== 'pendiente') {
                header('Location: /sweet-dreams/public/index.php?accion=listarPedidos&error=No puedes editar un pedido que ya esta en proceso');
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fecha_entrega = $_POST['fecha_entrega'] ?? '';
            $nota          = $_POST['nota']          ?? '';

            $resultado = $this->modelo->actualizar($id, $fecha_entrega, $nota);

            if ($resultado['Exito']) {
                header('Location: /sweet-dreams/public/index.php?accion=verPedido&id=' . $id . '&exito=' . urlencode($resultado['mensaje']));
                exit;
            } else {
                $error = $resultado['mensaje'];
            }
        }

        include __DIR__ . '/../views/pedidos/editar.php';
    }

    public function eliminar() {
        $this->verificarRol('admin');
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
            exit;
        }

        $this->modeloDetalle->eliminarPorPedido($id);

        $resultado = $this->modelo->eliminar($id);

        if ($resultado['Exito']) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos&exito=' . urlencode($resultado['mensaje']));
        } else {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos&error=' . urlencode($resultado['mensaje']));
        }
        exit;
    }

    public function cambiarEstado() {
        $this->verificarSesion();

        if ($_SESSION['rol'] === 'cliente') {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id     = $_POST['id']     ?? null;
            $estado = $_POST['estado'] ?? null;

            if ($_SESSION['rol'] === 'empleado') {
                $pedido = $this->modelo->obtenerPorId($id);
                if ($pedido['empleado_id'] != $_SESSION['usuario_id']) {
                    header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
                    exit;
                }
            }

            $resultado = $this->modelo->cambiarEstado($id, $estado);
            header('Location: /sweet-dreams/public/index.php?accion=verPedido&id=' . $id . '&exito=' . urlencode($resultado['mensaje']));
            exit;
        }

        header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
        exit;
    }

    public function asignarEmpleado() {
        $this->verificarRol('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = $_POST['id']          ?? null;
            $empleado_id = $_POST['empleado_id'] ?? null;

            $resultado = $this->modelo->asignarEmpleado($id, $empleado_id);
            header('Location: /sweet-dreams/public/index.php?accion=verPedido&id=' . $id . '&exito=' . urlencode($resultado['mensaje']));
            exit;
        }

        header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
        exit;
    }

    public function cancelar() {
        $this->verificarSesion();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
            exit;
        }

        $pedido = $this->modelo->obtenerPorId($id);

        if ($_SESSION['rol'] === 'cliente' && $pedido['cliente_id'] != $_SESSION['usuario_id']) {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos');
            exit;
        }

        if ($pedido['estado'] !== 'pendiente') {
            header('Location: /sweet-dreams/public/index.php?accion=listarPedidos&error=Solo puedes cancelar pedidos pendientes');
            exit;
        }

        $this->modelo->cambiarEstado($id, 'cancelado');
        $this->modeloDetalle->eliminarPorPedido($id);

        header('Location: /sweet-dreams/public/index.php?accion=listarPedidos&exito=Pedido cancelado correctamente');
        exit;
    }

    private function verificarSesion() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /sweet-dreams/public/index.php?accion=login');
            exit;
        }
    }

    private function verificarRol($rol) {
        $this->verificarSesion();
        if ($_SESSION['rol'] !== $rol) {
            header('Location: /sweet-dreams/public/index.php?accion=login');
            exit;
        }
    }
}
?>