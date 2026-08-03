<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-cake2"></i> Catalogo de Productos
    </h2>
    <?php if ($_SESSION['rol'] === 'admin'): ?>
        <a href="/sweet-dreams/public/index.php?accion=crearProducto" class="btn btn-dorado">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </a>
    <?php endif; ?>
</div>

<?php if (empty($productos)): ?>
    <div class="alert text-center" style="background-color: #f3e5dc; border-left: 4px solid var(--cafe-oscuro);">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <strong>No hay productos disponibles.</strong>
        <?php if ($_SESSION['rol'] === 'admin'): ?>
            <br><a href="/sweet-dreams/public/index.php?accion=crearProducto" class="btn btn-cafe btn-sm mt-2">
                <i class="bi bi-plus-circle"></i> Agregar primer producto
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">

                    <!-- Imagen del producto -->
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="<?= htmlspecialchars($producto['imagen']) ?>" 
                            class="card-img-top" 
                            alt="<?= htmlspecialchars($producto['nombre']) ?>"
                            style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center" 
                            style="height: 200px; background-color: #f3e5dc;">
                            <i class="bi bi-cake2" style="font-size: 4rem; color: var(--cafe-claro);"></i>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title fw-bold" style="color: var(--cafe-oscuro);">
                            <?= htmlspecialchars($producto['nombre']) ?>
                        </h5>
                        <p class="card-text text-muted small">
                            <?= htmlspecialchars(substr($producto['descripcion'] ?? '', 0, 80)) ?>
                            <?= strlen($producto['descripcion'] ?? '') > 80 ? '...' : '' ?>
                        </p>

                        <!-- Precio y stock -->
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="fw-bold fs-5" style="color: var(--dorado);">
                                $<?= number_format($producto['precio'], 2) ?>
                            </span>
                            <span class="badge <?= $producto['stock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                <?= $producto['stock'] > 0 ? 'Stock: ' . $producto['stock'] : 'Sin stock' ?>
                            </span>
                        </div>
                    </div>

                    <!-- Botones de accion -->
                    <div class="card-footer bg-transparent d-flex gap-2">
                        <a href="/sweet-dreams/public/index.php?accion=verProducto&id=<?= $producto['id'] ?>" 
                        class="btn btn-cafe btn-sm flex-fill">
                            <i class="bi bi-eye"></i> Ver
                        </a>

                        <?php if ($_SESSION['rol'] === 'cliente'): ?>
                            <a href="/sweet-dreams/public/index.php?accion=crearPedido" 
                            class="btn btn-dorado btn-sm flex-fill">
                                <i class="bi bi-bag-plus"></i> Pedir
                            </a>
                        <?php endif; ?>

                        <?php if ($_SESSION['rol'] === 'admin'): ?>
                            <a href="/sweet-dreams/public/index.php?accion=editarProducto&id=<?= $producto['id'] ?>" 
                            class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="/sweet-dreams/public/index.php?accion=eliminarProducto&id=<?= $producto['id'] ?>" 
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Estas seguro de eliminar este producto?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>