<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<h2 class="titulo-pagina">
    <i class="bi bi-speedometer2"></i> Dashboard — Administrador
</h2>

<!-- Bienvenida -->
<div class="alert mb-4" style="background-color: #f3e5dc; border-left: 4px solid var(--cafe-oscuro);">
    <i class="bi bi-hand-wave"></i> Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>. 
    Tienes acceso completo al sistema Sweet Dreams.
</div>

<!-- Tarjetas de resumen -->
<div class="row g-4 mb-4">

    <!-- Total usuarios -->
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-people fs-1" style="color: var(--cafe-oscuro);"></i>
                <h5 class="mt-2 fw-bold">Usuarios</h5>
                <p class="text-muted mb-3">Gestiona clientes y empleados</p>
                <a href="/sweet-dreams/public/index.php?accion=listarUsuarios" class="btn btn-cafe btn-sm">
                    <i class="bi bi-arrow-right"></i> Ver Usuarios
                </a>
            </div>
        </div>
    </div>

    <!-- Total productos -->
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-cake2 fs-1" style="color: var(--dorado);"></i>
                <h5 class="mt-2 fw-bold">Productos</h5>
                <p class="text-muted mb-3">Gestiona el catalogo de productos</p>
                <a href="/sweet-dreams/public/index.php?accion=listarProductos" class="btn btn-dorado btn-sm">
                    <i class="bi bi-arrow-right"></i> Ver Productos
                </a>
            </div>
        </div>
    </div>

    <!-- Total pedidos -->
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-bag fs-1" style="color: var(--cafe-medio);"></i>
                <h5 class="mt-2 fw-bold">Pedidos</h5>
                <p class="text-muted mb-3">Gestiona todos los pedidos</p>
                <a href="/sweet-dreams/public/index.php?accion=listarPedidos" class="btn btn-cafe btn-sm">
                    <i class="bi bi-arrow-right"></i> Ver Pedidos
                </a>
            </div>
        </div>
    </div>

    <!-- Mi perfil -->
    <div class="col-md-3">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-person-circle fs-1" style="color: var(--cafe-claro);"></i>
                <h5 class="mt-2 fw-bold">Mi Perfil</h5>
                <p class="text-muted mb-3">Edita tu informacion personal</p>
                <a href="/sweet-dreams/public/index.php?accion=editarUsuario" class="btn btn-cafe btn-sm">
                    <i class="bi bi-pencil"></i> Editar Perfil
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Acciones rapidas -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-lightning"></i> Acciones Rapidas
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <a href="/sweet-dreams/public/index.php?accion=crearProducto" class="btn btn-dorado">
                <i class="bi bi-plus-circle"></i> Nuevo Producto
            </a>
            <a href="/sweet-dreams/public/index.php?accion=listarPedidos" class="btn btn-cafe">
                <i class="bi bi-bag-check"></i> Ver Pedidos Pendientes
            </a>
            <a href="/sweet-dreams/public/index.php?accion=listarUsuarios" class="btn btn-cafe">
                <i class="bi bi-person-plus"></i> Gestionar Usuarios
            </a>
            <a href="/sweet-dreams/public/index.php?accion=logout" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesion
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>