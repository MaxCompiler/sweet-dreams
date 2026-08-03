<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-cake2"></i> Detalle del Producto
    </h2>
    <a href="/sweet-dreams/public/index.php?accion=listarProductos" class="btn btn-cafe">
        <i class="bi bi-arrow-left"></i> Volver al Catalogo
    </a>
</div>

<div class="row g-4">

    <!-- Imagen -->
    <div class="col-md-5">
        <div class="card shadow-sm">
            <?php if (!empty($producto['imagen'])): ?>
                <img src="<?= htmlspecialchars($producto['imagen']) ?>"
                    class="card-img-top rounded"
                    alt="<?= htmlspecialchars($producto['nombre']) ?>"
                    style="height: 350px; object-fit: cover;">
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-center rounded"
                    style="height: 350px; background-color: #f3e5dc;">
                    <i class="bi bi-cake2" style="font-size: 6rem; color: var(--cafe-claro);"></i>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Info del producto -->
    <div class="col-md-7">
        <div class="card shadow-sm h-100">
            <div class="card-body p-4">

                <h3 class="fw-bold mb-1" style="color: var(--cafe-oscuro);">
                    <?= htmlspecialchars($producto['nombre']) ?>
                </h3>

                <p class="text-muted mb-4">
                    <?= htmlspecialchars($producto['descripcion'] ?? 'Sin descripcion disponible.') ?>
                </p>

                <!-- Precio -->
                <div class="mb-3">
                    <span class="text-muted small">Precio:</span>
                    <div class="fw-bold fs-3" style="color: var(--dorado);">
                        $<?= number_format($producto['precio'], 2) ?>
                    </div>
                </div>

                <!-- Stock -->
                <div class="mb-4">
                    <span class="text-muted small">Disponibilidad:</span>
                    <div>
                        <?php if ($producto['stock'] > 0): ?>
                            <span class="badge bg-success fs-6">
                                <i class="bi bi-check-circle"></i> En stock (<?= $producto['stock'] ?> disponibles)
                            </span>
                        <?php else: ?>
                            <span class="badge bg-danger fs-6">
                                <i class="bi bi-x-circle"></i> Sin stock
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Botones segun rol -->
                <div class="d-flex gap-2 flex-wrap">
                    <?php if ($_SESSION['rol'] === 'cliente' && $producto['stock'] > 0): ?>
                        <a href="/sweet-dreams/public/index.php?accion=crearPedido"
                        class="btn btn-dorado btn-lg">
                            <i class="bi bi-bag-plus"></i> Hacer Pedido
                        </a>
                    <?php endif; ?>

                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <a href="/sweet-dreams/public/index.php?accion=editarProducto&id=<?= $producto['id'] ?>"
                        class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <a href="/sweet-dreams/public/index.php?accion=eliminarProducto&id=<?= $producto['id'] ?>"
                        class="btn btn-danger"
                        onclick="return confirm('¿Estas seguro de eliminar este producto?')">
                            <i class="bi bi-trash"></i> Eliminar
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>