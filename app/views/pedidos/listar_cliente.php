<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-bag"></i> Mis Pedidos
    </h2>
    <a href="/sweet-dreams/public/index.php?accion=crearPedido" class="btn btn-dorado">
        <i class="bi bi-plus-circle"></i> Nuevo Pedido
    </a>
</div>

<?php if (empty($pedidos)): ?>
    <div class="alert text-center" style="background-color: #f3e5dc; border-left: 4px solid var(--cafe-oscuro);">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <strong>Aun no tienes pedidos.</strong>
        <br>
        <a href="/sweet-dreams/public/index.php?accion=crearPedido" class="btn btn-cafe btn-sm mt-2">
            <i class="bi bi-plus-circle"></i> Hacer mi primer pedido
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($pedidos as $pedido): ?>
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-bag"></i> Pedido #<?= $pedido['id'] ?></span>
                        <span class="badge badge-<?= $pedido['estado'] ?> px-2 py-1">
                            <?= ucfirst($pedido['estado']) ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <i class="bi bi-calendar"></i>
                            <strong>Pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?>
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-truck"></i>
                            <strong>Entrega:</strong> <?= $pedido['fecha_entrega'] ? date('d/m/Y H:i', strtotime($pedido['fecha_entrega'])) : 'Por definir' ?>
                        </p>
                        <?php if ($pedido['empleado_nombre']): ?>
                            <p class="mb-1">
                                <i class="bi bi-person"></i>
                                <strong>Preparado por:</strong> <?= htmlspecialchars($pedido['empleado_nombre']) ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($pedido['nota']): ?>
                            <p class="mb-1">
                                <i class="bi bi-chat-text"></i>
                                <strong>Nota:</strong> <?= htmlspecialchars($pedido['nota']) ?>
                            </p>
                        <?php endif; ?>
                        <p class="mb-0 mt-2">
                            <strong style="color: var(--dorado); font-size: 1.2rem;">
                                Total: $<?= number_format($pedido['total'], 2) ?>
                            </strong>
                        </p>
                    </div>
                    <div class="card-footer bg-transparent d-flex gap-2">
                        <a href="/sweet-dreams/public/index.php?accion=verPedido&id=<?= $pedido['id'] ?>"
                           class="btn btn-cafe btn-sm flex-fill">
                            <i class="bi bi-eye"></i> Ver Detalle
                        </a>
                        <?php if ($pedido['estado'] === 'pendiente'): ?>
                            <a href="/sweet-dreams/public/index.php?accion=cancelarPedido&id=<?= $pedido['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Cancelar este pedido?')">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>