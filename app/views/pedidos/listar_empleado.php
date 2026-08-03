<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-bag"></i> Mis Pedidos Asignados
    </h2>
</div>

<?php if (empty($pedidos)): ?>
    <div class="alert text-center" style="background-color: #f3e5dc; border-left: 4px solid var(--cafe-oscuro);">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <strong>No tienes pedidos asignados por el momento.</strong>
    </div>
<?php else: ?>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Telefono</th>
                            <th>Fecha Entrega</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= $pedido['id'] ?></td>
                                <td><strong><?= htmlspecialchars($pedido['cliente_nombre']) ?></strong></td>
                                <td><?= htmlspecialchars($pedido['cliente_telefono'] ?? '-') ?></td>
                                <td><?= $pedido['fecha_entrega'] ? date('d/m/Y H:i', strtotime($pedido['fecha_entrega'])) : '-' ?></td>
                                <td><strong style="color: var(--dorado);">$<?= number_format($pedido['total'], 2) ?></strong></td>
                                <td>
                                    <span class="badge badge-<?= $pedido['estado'] ?> px-2 py-1">
                                        <?= ucfirst($pedido['estado']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/sweet-dreams/public/index.php?accion=verPedido&id=<?= $pedido['id'] ?>"
                                       class="btn btn-cafe btn-sm">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>