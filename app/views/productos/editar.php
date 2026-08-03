<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-pencil"></i> Editar Producto
    </h2>
    <a href="/sweet-dreams/public/index.php?accion=listarProductos" class="btn btn-cafe">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <i class="bi bi-cake2"></i> Editar: <?= htmlspecialchars($producto['nombre']) ?>
            </div>
            <div class="card-body p-4">

                <?php if (isset($error)): ?>
                    <div class="alerta-error">
                        <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/sweet-dreams/public/index.php?accion=editarProducto&id=<?= $producto['id'] ?>" novalidate>

                    <div class="row">

                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label fw-semibold">
                                <i class="bi bi-tag"></i> Nombre del producto *
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="nombre"
                                name="nombre"
                                required
                                value="<?= htmlspecialchars($producto['nombre']) ?>"
                            >
                            <div class="invalid-feedback">El nombre es obligatorio.</div>
                        </div>

                        <!-- Precio -->
                        <div class="col-md-3 mb-3">
                            <label for="precio" class="form-label fw-semibold">
                                <i class="bi bi-currency-dollar"></i> Precio *
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="precio"
                                    name="precio"
                                    step="0.01"
                                    min="0.01"
                                    required
                                    value="<?= htmlspecialchars($producto['precio']) ?>"
                                >
                            </div>
                            <div class="invalid-feedback">El precio debe ser mayor a 0.</div>
                        </div>

                        <!-- Stock -->
                        <div class="col-md-3 mb-3">
                            <label for="stock" class="form-label fw-semibold">
                                <i class="bi bi-boxes"></i> Stock *
                            </label>
                            <input
                                type="number"
                                class="form-control"
                                id="stock"
                                name="stock"
                                min="0"
                                required
                                value="<?= htmlspecialchars($producto['stock']) ?>"
                            >
                            <div class="invalid-feedback">El stock no puede ser negativo.</div>
                        </div>

                        <!-- Descripcion -->
                        <div class="col-12 mb-3">
                            <label for="descripcion" class="form-label fw-semibold">
                                <i class="bi bi-text-paragraph"></i> Descripcion
                            </label>
                            <textarea
                                class="form-control"
                                id="descripcion"
                                name="descripcion"
                                rows="3"
                            ><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
                        </div>

                        <!-- Imagen -->
                        <div class="col-12 mb-3">
                            <label for="imagen" class="form-label fw-semibold">
                                <i class="bi bi-image"></i> URL de imagen (opcional)
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="imagen"
                                name="imagen"
                                value="<?= htmlspecialchars($producto['imagen'] ?? '') ?>"
                            >
                            <!-- Preview de imagen actual -->
                            <?php if (!empty($producto['imagen'])): ?>
                                <div class="mt-2">
                                    <small class="text-muted">Imagen actual:</small>
                                    <img src="<?= htmlspecialchars($producto['imagen']) ?>"
                                        alt="Preview"
                                        style="height: 80px; object-fit: cover; border-radius: 6px; display: block; margin-top: 4px;">
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <p class="text-muted small">* Campos obligatorios</p>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dorado btn-lg">
                            <i class="bi bi-check-circle"></i> Guardar Cambios
                        </button>
                        <a href="/sweet-dreams/public/index.php?accion=listarProductos" class="btn btn-cafe btn-lg">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>