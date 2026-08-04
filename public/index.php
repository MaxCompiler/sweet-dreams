<?php
if (getenv('RENDER') || isset($_SERVER['RENDER'])) {
    define('BASE_URL', '');
} else {
    define('BASE_URL', '/sweet-dreams/public');
}

// Cargar controladores
include_once __DIR__ . '/../app/controllers/UsuarioController.php';
include_once __DIR__ . '/../app/controllers/ProductoController.php';
include_once __DIR__ . '/../app/controllers/PedidoController.php';

$accion = $_GET['accion'] ?? 'login';

switch ($accion) {

    // RUTAS DE USUARIO / AUTH
    case 'login':
        $controller = new UsuarioController();
        $controller->login();
        break;

    case 'logout':
        $controller = new UsuarioController();
        $controller->logout();
        break;

    case 'registro':
        $controller = new UsuarioController();
        $controller->registro();
        break;

    case 'recuperarCuenta':
        $controller = new UsuarioController();
        $controller->recuperarCuenta();
        break;

    case 'listarUsuarios':
        $controller = new UsuarioController();
        $controller->listar();
        break;

    case 'editarUsuario':
        $controller = new UsuarioController();
        $controller->editar();
        break;

    case 'eliminarUsuario':
        $controller = new UsuarioController();
        $controller->eliminar();
        break;

    case 'cambiarRolUsuario':
        $controller = new UsuarioController();
        $controller->cambiarRol();
        break;

    case 'cambiarEstadoUsuario':
        $controller = new UsuarioController();
        $controller->cambiarEstado();
        break;

    // RUTAS DE PRODUCTOS
    case 'listarProductos':
        $controller = new ProductoController();
        $controller->listar();
        break;

    case 'verProducto':
        $controller = new ProductoController();
        $controller->ver();
        break;

    case 'crearProducto':
        $controller = new ProductoController();
        $controller->crear();
        break;

    case 'editarProducto':
        $controller = new ProductoController();
        $controller->editar();
        break;

    case 'eliminarProducto':
        $controller = new ProductoController();
        $controller->eliminar();
        break;

    // RUTAS DE PEDIDOS
    case 'listarPedidos':
        $controller = new PedidoController();
        $controller->listar();
        break;

    case 'verPedido':
        $controller = new PedidoController();
        $controller->ver();
        break;

    case 'crearPedido':
        $controller = new PedidoController();
        $controller->crear();
        break;

    case 'editarPedido':
        $controller = new PedidoController();
        $controller->editar();
        break;

    case 'eliminarPedido':
        $controller = new PedidoController();
        $controller->eliminar();
        break;

    case 'cambiarEstadoPedido':
        $controller = new PedidoController();
        $controller->cambiarEstado();
        break;

    case 'asignarEmpleado':
        $controller = new PedidoController();
        $controller->asignarEmpleado();
        break;

    case 'cancelarPedido':
        $controller = new PedidoController();
        $controller->cancelar();
        break;

    // DASHBOARDS POR ROL

    case 'dashboardAdmin':
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: ' . BASE_URL . '/index.php?accion=login');
            exit;
        }
        include __DIR__ . '/../app/views/dashboard/admin.php';
        break;

    case 'dashboardEmpleado':
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'empleado') {
            header('Location: ' . BASE_URL . '/index.php?accion=login');
            exit;
        }
        include __DIR__ . '/../app/views/dashboard/empleado.php';
        break;

    case 'dashboardCliente':
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'cliente') {
            header('Location: ' . BASE_URL . '/index.php?accion=login');
            exit;
        }
        include __DIR__ . '/../app/views/dashboard/cliente.php';
        break;

    // RUTA POR DEFECTO
    default:
        header('Location: ' . BASE_URL . '/index.php?accion=login');
        exit;
}
?>