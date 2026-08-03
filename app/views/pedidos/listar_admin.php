<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-bag"></i> Todos los Pedidos
    </h2>
</div>

<?php if (empty($pedidos)): ?>
    <div class="alert text-center" style="background-color: #f3e5dc; border-left: 4px solid var(--cafe-oscuro);">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <strong>No hay pedidos registrados.</strong>
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
                            <th>Empleado</th>
                            <th>Fecha Pedido</th>
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
                                <td>
                                    <strong><?= htmlspecialchars($pedido['cliente_nombre']) ?></strong>
                                    <br><small class="text-muted"><?= htmlspecialchars($pedido['cliente_email']) ?></small>
                                </td>
                                <td>
                                    <?= $pedido['empleado_nombre'] 
                                        ? htmlspecialchars($pedido['empleado_nombre']) 
                                        : '<span class="text-muted">Sin asignar</span>' ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></td>
                                <td><?= $pedido['fecha_entrega'] ? date('d/m/Y H:i', strtotime($pedido['fecha_entrega'])) : '-' ?></td>
                                <td><strong style="color: var(--dorado);">$<?= number_format($pedido['total'], 2) ?></strong></td>
                                <td>
                                    <span class="badge badge-<?= $pedido['estado'] ?> px-2 py-1">
                                        <?= ucfirst($pedido['estado']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="/sweet-dreams/public/index.php?accion=verPedido&id=<?= $pedido['id'] ?>"
                                           class="btn btn-cafe btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/sweet-dreams/public/index.php?accion=editarPedido&id=<?= $pedido['id'] ?>"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="/sweet-dreams/public/index.php?accion=eliminarPedido&id=<?= $pedido['id'] ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('¿Eliminar este pedido?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
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