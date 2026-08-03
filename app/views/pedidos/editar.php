<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-pencil"></i> Editar Pedido #<?= $pedido['id'] ?>
    </h2>
    <a href="/sweet-dreams/public/index.php?accion=verPedido&id=<?= $pedido['id'] ?>" class="btn btn-cafe">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <i class="bi bi-bag"></i> Editar datos del pedido
            </div>
            <div class="card-body p-4">

                <?php if (isset($error)): ?>
                    <div class="alerta-error">
                        <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/sweet-dreams/public/index.php?accion=editarPedido&id=<?= $pedido['id'] ?>" novalidate>

                    <!-- Fecha de entrega -->
                    <div class="mb-3">
                        <label for="fecha_entrega" class="form-label fw-semibold">
                            <i class="bi bi-truck"></i> Fecha de entrega *
                        </label>
                        <input
                            type="datetime-local"
                            class="form-control"
                            id="fecha_entrega"
                            name="fecha_entrega"
                            required
                            value="<?= $pedido['fecha_entrega'] ? date('Y-m-d\TH:i', strtotime($pedido['fecha_entrega'])) : '' ?>"
                        >
                        <div class="invalid-feedback">La fecha de entrega es obligatoria.</div>
                    </div>

                    <!-- Nota -->
                    <div class="mb-3">
                        <label for="nota" class="form-label fw-semibold">
                            <i class="bi bi-chat-text"></i> Nota especial
                        </label>
                        <textarea
                            class="form-control"
                            id="nota"
                            name="nota"
                            rows="3"
                            placeholder="Ej: Sin azucar, decoracion especial..."
                        ><?= htmlspecialchars($pedido['nota'] ?? '') ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dorado btn-lg">
                            <i class="bi bi-check-circle"></i> Guardar Cambios
                        </button>
                        <a href="/sweet-dreams/public/index.php?accion=verPedido&id=<?= $pedido['id'] ?>"
                           class="btn btn-cafe btn-lg">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>