<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<h2 class="titulo-pagina">
    <i class="bi bi-speedometer2"></i> Dashboard — Empleado
</h2>

<!-- Bienvenida -->
<div class="alert mb-4" style="background-color: #f3e5dc; border-left: 4px solid var(--cafe-oscuro);">
    <i class="bi bi-hand-wave"></i> Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>. 
    Aqui puedes gestionar los pedidos asignados a ti.
</div>

<!-- Tarjetas -->
<div class="row g-4 mb-4">

    <!-- Mis pedidos -->
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-bag fs-1" style="color: var(--cafe-oscuro);"></i>
                <h5 class="mt-2 fw-bold">Mis Pedidos</h5>
                <p class="text-muted mb-3">Ver y gestionar los pedidos asignados a ti</p>
                <a href="/sweet-dreams/public/index.php?accion=listarPedidos" class="btn btn-cafe btn-sm">
                    <i class="bi bi-arrow-right"></i> Ver Pedidos
                </a>
            </div>
        </div>
    </div>

    <!-- Catalogo -->
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-cake2 fs-1" style="color: var(--dorado);"></i>
                <h5 class="mt-2 fw-bold">Catalogo</h5>
                <p class="text-muted mb-3">Ver el catalogo de productos disponibles</p>
                <a href="/sweet-dreams/public/index.php?accion=listarProductos" class="btn btn-dorado btn-sm">
                    <i class="bi bi-arrow-right"></i> Ver Catalogo
                </a>
            </div>
        </div>
    </div>

    <!-- Mi perfil -->
    <div class="col-md-4">
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

<!-- Estados de pedidos (referencia rapida) -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-info-circle"></i> Estados de Pedidos
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <span class="badge badge-pendiente px-3 py-2">Pendiente</span>
            <span class="badge badge-preparacion px-3 py-2">En Preparacion</span>
            <span class="badge badge-listo px-3 py-2">Listo</span>
            <span class="badge badge-entregado px-3 py-2">Entregado</span>
            <span class="badge badge-cancelado px-3 py-2">Cancelado</span>
        </div>
        <p class="text-muted mt-3 mb-0 small">
            <i class="bi bi-info-circle"></i> Puedes actualizar el estado de los pedidos asignados a ti desde la seccion "Mis Pedidos".
        </p>
    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>