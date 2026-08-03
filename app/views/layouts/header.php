<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Dreams </title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --cafe-oscuro: #5D4037;
            --cafe-medio: #8D6E63;
            --cafe-claro: #A1887F;
            --dorado: #FF8F00;
            --dorado-hover: #E65100;
            --fondo: #FFF8F0;
            --texto: #3E2723;
        }

        body {
            background-color: var(--fondo);
            color: var(--texto);
            font-family: 'Poppins', sans-serif;
        }

        /* ── Navbar ── */
        .navbar {
            background-color: var(--cafe-oscuro) !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: var(--dorado) !important;
            letter-spacing: 1px;
        }

        .navbar-brand span {
            color: #fff;
        }

        .nav-link {
            color: #f5e6d3 !important;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: var(--dorado) !important;
        }

        .nav-link.active {
            color: var(--dorado) !important;
        }

        /* ── Botones ── */
        .btn-cafe {
            background-color: var(--cafe-oscuro);
            color: #fff;
            border: none;
        }

        .btn-cafe:hover {
            background-color: var(--cafe-medio);
            color: #fff;
        }

        .btn-dorado {
            background-color: var(--dorado);
            color: #fff;
            border: none;
        }

        .btn-dorado:hover {
            background-color: var(--dorado-hover);
            color: #fff;
        }

        /* ── Cards ── */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(93, 64, 55, 0.1);
        }

        .card-header {
            background-color: var(--cafe-oscuro);
            color: #fff;
            border-radius: 12px 12px 0 0 !important;
            font-family: 'Playfair Display', serif;
        }

        /* ── Tabla ── */
        .table thead {
            background-color: var(--cafe-oscuro);
            color: #fff;
        }

        .table-hover tbody tr:hover {
            background-color: #f3e5dc;
        }

        /* ── Badges de estado ── */
        .badge-pendiente {
            background-color: #FFA000;
            color: #fff;
        }

        .badge-preparacion {
            background-color: #1976D2;
            color: #fff;
        }

        .badge-listo {
            background-color: #388E3C;
            color: #fff;
        }

        .badge-entregado {
            background-color: var(--cafe-oscuro);
            color: #fff;
        }

        .badge-cancelado {
            background-color: #D32F2F;
            color: #fff;
        }

        /* ── Alertas ── */
        .alerta-exito {
            background-color: #d4edda;
            border-left: 4px solid #388E3C;
            color: #155724;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
        }

        .alerta-error {
            background-color: #f8d7da;
            border-left: 4px solid #D32F2F;
            color: #721c24;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
        }

        /* ── Footer ── */
        .footer {
            background-color: var(--cafe-oscuro);
            color: #f5e6d3;
            text-align: center;
            padding: 16px;
            margin-top: 48px;
            font-size: 0.9rem;
        }

        /* ── Titulos de pagina ── */
        .titulo-pagina {
            font-family: 'Playfair Display', serif;
            color: var(--cafe-oscuro);
            border-bottom: 3px solid var(--dorado);
            padding-bottom: 8px;
            margin-bottom: 24px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <!-- Logo / Nombre -->
            <a class="navbar-brand" href="/sweet-dreams/public/index.php?accion=login">
                <i class="bi bi-cake2"></i> Sweet <span>Dreams</span>
            </a>

            <!-- Boton hamburguesa para movil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <!-- Menu de navegacion -->
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav ms-auto align-items-center">

                    <?php if (isset($_SESSION['usuario_id'])): ?>

                        <!-- Links segun el rol -->
                        <?php if ($_SESSION['rol'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=dashboardAdmin">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=listarUsuarios">
                                    <i class="bi bi-people"></i> Usuarios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=listarProductos">
                                    <i class="bi bi-cake2"></i> Productos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=listarPedidos">
                                    <i class="bi bi-bag"></i> Pedidos
                                </a>
                            </li>

                        <?php elseif ($_SESSION['rol'] === 'empleado'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=dashboardEmpleado">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=listarPedidos">
                                    <i class="bi bi-bag"></i> Mis Pedidos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=listarProductos">
                                    <i class="bi bi-cake2"></i> Catalogo
                                </a>
                            </li>

                        <?php elseif ($_SESSION['rol'] === 'cliente'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=dashboardCliente">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=listarProductos">
                                    <i class="bi bi-cake2"></i> Catalogo
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/sweet-dreams/public/index.php?accion=listarPedidos">
                                    <i class="bi bi-bag"></i> Mis Pedidos
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Usuario logueado -->
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['nombre']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="/sweet-dreams/public/index.php?accion=editarUsuario">
                                        <i class="bi bi-pencil"></i> Mi Perfil
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="/sweet-dreams/public/index.php?accion=logout">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesion
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <!-- No hay sesion activa -->
                        <li class="nav-item">
                            <a class="nav-link" href="/sweet-dreams/public/index.php?accion=login">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/sweet-dreams/public/index.php?accion=registro">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">

        <!-- Mensajes de exito/error desde la URL -->
        <?php if (isset($_GET['exito'])): ?>
            <div class="alerta-exito">
                <i class="bi bi-check-circle"></i> <?= htmlspecialchars($_GET['exito']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alerta-error">
                <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>