<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<h2 class="titulo-pagina">
    <i class="bi bi-speedometer2"></i> Dashboard — Cliente
</h2>

<!-- Bienvenida -->
<div class="alert mb-4" style="background-color: #f3e5dc; border-left: 4px solid var(--cafe-oscuro);">
    <i class="bi bi-hand-wave"></i> Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>. 
    Explora nuestro catalogo y haz tu pedido.
</div>

<!-- Tarjetas -->
<div class="row g-4 mb-4">

    <!-- Catalogo -->
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-cake2 fs-1" style="color: var(--dorado);"></i>
                <h5 class="mt-2 fw-bold">Catalogo</h5>
                <p class="text-muted mb-3">Explora todos nuestros deliciosos productos</p>
                <a href="/sweet-dreams/public/index.php?accion=listarProductos" class="btn btn-dorado btn-sm">
                    <i class="bi bi-arrow-right"></i> Ver Catalogo
                </a>
            </div>
        </div>
    </div>

    <!-- Hacer pedido -->
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-bag-plus fs-1" style="color: var(--cafe-oscuro);"></i>
                <h5 class="mt-2 fw-bold">Hacer Pedido</h5>
                <p class="text-muted mb-3">Realiza un nuevo pedido de tus productos favoritos</p>
                <a href="/sweet-dreams/public/index.php?accion=crearPedido" class="btn btn-cafe btn-sm">
                    <i class="bi bi-plus-circle"></i> Nuevo Pedido
                </a>
            </div>
        </div>
    </div>

    <!-- Mis pedidos -->
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body py-4">
                <i class="bi bi-bag-check fs-1" style="color: var(--cafe-medio);"></i>
                <h5 class="mt-2 fw-bold">Mis Pedidos</h5>
                <p class="text-muted mb-3">Revisa el estado de tus pedidos</p>
                <a href="/sweet-dreams/public/index.php?accion=listarPedidos" class="btn btn-cafe btn-sm">
                    <i class="bi bi-arrow-right"></i> Ver Pedidos
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Informacion del proceso -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-info-circle"></i> ¿Como funciona Sweet Dreams?
    </div>
    <div class="card-body">
        <div class="row text-center g-3">
            <div class="col-md-4">
                <i class="bi bi-cake2 fs-2" style="color: var(--dorado);"></i>
                <h6 class="mt-2 fw-bold">1. Elige tus productos</h6>
                <p class="text-muted small">Explora nuestro catalogo y selecciona lo que mas te guste.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-bag-plus fs-2" style="color: var(--cafe-oscuro);"></i>
                <h6 class="mt-2 fw-bold">2. Realiza tu pedido</h6>
                <p class="text-muted small">Indica la fecha de entrega y cualquier nota especial.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-truck fs-2" style="color: var(--cafe-medio);"></i>
                <h6 class="mt-2 fw-bold">3. Recibe tu pedido</h6>
                <p class="text-muted small">Nosotros preparamos todo con amor y te lo entregamos.</p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>