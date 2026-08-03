<?php
include_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {

    private $modelo;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelo = new Usuario();
    }

    public function login() {

        if (isset($_SESSION['usuario_id'])) {
            $this->redirigirPorRol($_SESSION['rol']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');


            if ($email === '' || $password === '') {
                $error = 'Por favor completa todos los campos';
                include __DIR__ . '/../views/auth/login.php';
                return;
            }

            $usuario = $this->modelo->buscarPorEmail($email);

            if (!$usuario) {
                $error = 'El email no esta registrado';
                include __DIR__ . '/../views/auth/login.php';
                return;
            }

            if ($usuario['estado'] === 'inactivo') {
                $error = 'Tu cuenta esta desactivada. Contacta al administrador';
                include __DIR__ . '/../views/auth/login.php';
                return;
            }

            if (!$this->modelo->verificarPassword($password, $usuario['password'])) {
                $error = 'Contrasena incorrecta';
                include __DIR__ . '/../views/auth/login.php';
                return;
            }

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre']     = $usuario['nombre'];
            $_SESSION['email']      = $usuario['email'];
            $_SESSION['rol']        = $usuario['rol'];

            $this->redirigirPorRol($usuario['rol']);

        } else {
            include __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /sweet-dreams/public/index.php?accion=login');
        exit;
    }

    public function registro() {
        // Si ya esta logueado, redirigir
        if (isset($_SESSION['usuario_id'])) {
            $this->redirigirPorRol($_SESSION['rol']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre    = $_POST['nombre']   ?? '';
            $email     = $_POST['email']    ?? '';
            $password  = $_POST['password'] ?? '';
            $telefono  = $_POST['telefono'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $pregunta  = $_POST['pregunta_seguridad'] ?? '';
            $respuesta = $_POST['respuesta_seguridad'] ?? '';

            $resultado = $this->modelo->registrar(
                $nombre, $email, 'cliente', $password,
                $telefono, $direccion, $pregunta, $respuesta
            );

            if ($resultado['Exito']) {
                $exito = $resultado['mensaje'];
                include __DIR__ . '/../views/auth/login.php';
            } else {
                $error = $resultado['mensaje'];
                include __DIR__ . '/../views/auth/registro.php';
            }

        } else {
            include __DIR__ . '/../views/auth/registro.php';
        }
    }

    public function recuperarCuenta() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['email']) && !isset($_POST['respuesta_seguridad'])) {
                $email = trim($_POST['email']);
                $usuario = $this->modelo->buscarPorEmail($email);

                if (!$usuario) {
                    $error = 'El email no esta registrado';
                    include __DIR__ . '/../views/auth/recuperar.php';
                    return;
                }
                $_SESSION['recuperar_email'] = $email;
                $pregunta = $usuario['pregunta_seguridad'];
                include __DIR__ . '/../views/auth/verificar_pregunta.php';

            } else if (isset($_POST['respuesta_seguridad']) && !isset($_POST['nueva_password'])) {
                $email    = $_SESSION['recuperar_email'] ?? '';
                $respuesta = trim($_POST['respuesta_seguridad']);
                $usuario  = $this->modelo->buscarPorEmail($email);

                if (!$usuario || !$this->modelo->verificaRespuestaSeguridad($respuesta, $usuario['respuesta_seguridad'])) {
                    $error = 'Respuesta incorrecta';
                    $pregunta = $usuario['pregunta_seguridad'];
                    include __DIR__ . '/../views/auth/verificar_pregunta.php';
                    return;
                }

                $_SESSION['recuperar_id'] = $usuario['id'];
                include __DIR__ . '/../views/auth/nueva_password.php';

            } else if (isset($_POST['nueva_password'])) {
                $id              = $_SESSION['recuperar_id'] ?? '';
                $nueva_password  = trim($_POST['nueva_password']);
                $confirmar       = trim($_POST['confirmar_password']);

                if ($nueva_password !== $confirmar) {
                    $error = 'Las contrasenas no coinciden';
                    include __DIR__ . '/../views/auth/nueva_password.php';
                    return;
                }

                if (strlen($nueva_password) < 6) {
                    $error = 'La contrasena debe tener al menos 6 caracteres';
                    include __DIR__ . '/../views/auth/nueva_password.php';
                    return;
                }

                $resultado = $this->modelo->cambiarPassword($id, $nueva_password);

                unset($_SESSION['recuperar_email']);
                unset($_SESSION['recuperar_id']);

                $exito = 'Contrasena cambiada correctamente. Ya puedes iniciar sesion';
                include __DIR__ . '/../views/auth/login.php';
            }

        } else {
            include __DIR__ . '/../views/auth/recuperar.php';
        }
    }

    public function listar() {
        $this->verificarRol('admin');
        $usuarios = $this->modelo->obtenerTodos();
        include __DIR__ . '/../views/usuarios/listar.php';
    }

    public function editar() {
        $this->verificarSesion();
        $id = $_GET['id'] ?? $_SESSION['usuario_id'];

        if ($_SESSION['rol'] === 'cliente' && $id != $_SESSION['usuario_id']) {
            header('Location: /sweet-dreams/public/index.php?accion=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre    = $_POST['nombre']    ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $telefono  = $_POST['telefono']  ?? '';

            $resultado = $this->modelo->actualizar($id, $nombre, $direccion, $telefono);

            if ($resultado['Exito']) {
                $_SESSION['nombre'] = $nombre;
                $exito = $resultado['mensaje'];
            } else {
                $error = $resultado['mensaje'];
            }
        }

        $usuario = $this->modelo->obtenerPorId($id);
        include __DIR__ . '/../views/usuarios/editar.php';
    }

    public function eliminar() {
        $this->verificarRol('admin');
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /sweet-dreams/public/index.php?accion=listarUsuarios');
            exit;
        }

        if ($id == $_SESSION['usuario_id']) {
            header('Location: /sweet-dreams/public/index.php?accion=listarUsuarios&error=No puedes eliminarte a ti mismo');
            exit;
        }

        $this->modelo->eliminarUsuario($id);
        header('Location: /sweet-dreams/public/index.php?accion=listarUsuarios&exito=Usuario eliminado correctamente');
        exit;
    }

    public function cambiarRol() {
        $this->verificarRol('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id       = $_POST['id']  ?? null;
            $nuevo_rol = $_POST['rol'] ?? null;

            $resultado = $this->modelo->cambiarRol($id, $nuevo_rol);
            $mensaje = $resultado['mensaje'];
        }

        header('Location: /sweet-dreams/public/index.php?accion=listarUsuarios');
        exit;
    }

    public function cambiarEstado() {
        $this->verificarRol('admin');

        $id     = $_GET['id']     ?? null;
        $estado = $_GET['estado'] ?? null;

        if ($id && $estado) {
            $this->modelo->cambiarEstado($id, $estado);
        }

        header('Location: /sweet-dreams/public/index.php?accion=listarUsuarios');
        exit;
    }

    private function redirigirPorRol($rol) {
        switch ($rol) {
            case 'admin':
                header('Location: /sweet-dreams/public/index.php?accion=dashboardAdmin');
                break;
            case 'empleado':
                header('Location: /sweet-dreams/public/index.php?accion=dashboardEmpleado');
                break;
            case 'cliente':
                header('Location: /sweet-dreams/public/index.php?accion=dashboardCliente');
                break;
            default:
                header('Location: /sweet-dreams/public/index.php?accion=login');
        }
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