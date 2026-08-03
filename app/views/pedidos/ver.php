<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-bag"></i> Detalle del Pedido #<?= $pedido['id'] ?>
    </h2>
    <a href="/sweet-dreams/public/index.php?accion=listarPedidos" class="btn btn-cafe">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row g-4">

    <!-- Info del pedido -->
    <div class="col-md-5">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Informacion del Pedido
            </div>
            <div class="card-body">

                <p><i class="bi bi-person"></i> <strong>Cliente:</strong> <?= htmlspecialchars($pedido['cliente_nombre']) ?></p>
                <p><i class="bi bi-envelope"></i> <strong>Email:</strong> <?= htmlspecialchars($pedido['cliente_email']) ?></p>
                <p><i class="bi bi-calendar"></i> <strong>Fecha pedido:</strong> <?= date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])) ?></p>
                <p><i class="bi bi-truck"></i> <strong>Fecha entrega:</strong> <?= $pedido['fecha_entrega'] ? date('d/m/Y H:i', strtotime($pedido['fecha_entrega'])) : 'Por definir' ?></p>
                <p>
                    <i class="bi bi-circle-fill"></i> <strong>Estado:</strong>
                    <span class="badge badge-<?= $pedido['estado'] ?> px-2 py-1 ms-1">
                        <?= ucfirst($pedido['estado']) ?>
                    </span>
                </p>
                <p><i class="bi bi-person-badge"></i> <strong>Empleado:</strong> <?= $pedido['empleado_nombre'] ? htmlspecialchars($pedido['empleado_nombre']) : '<span class="text-muted">Sin asignar</span>' ?></p>
                <?php if ($pedido['nota']): ?>
                    <p><i class="bi bi-chat-text"></i> <strong>Nota:</strong> <?= htmlspecialchars($pedido['nota']) ?></p>
                <?php endif; ?>

                <hr>
                <p class="fs-5 mb-0">
                    <strong>Total: </strong>
                    <span style="color: var(--dorado); font-weight: bold;">
                        $<?= number_format($pedido['total'], 2) ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Acciones segun rol -->
    <div class="col-md-7">

        <!-- Detalle de productos -->
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <i class="bi bi-cake2"></i> Productos del Pedido
            </div>
            <div class="card-body p-0">
                <?php if (empty($detalle)): ?>
                    <p class="text-muted text-center p-3">No hay productos en este pedido.</p>
                <?php else: ?>
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detalle as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['producto_nombre']) ?></td>
                                    <td><?= $item['cantidad'] ?></td>
                                    <td>$<?= number_format($item['precio_unitario'], 2) ?></td>
                                    <td><strong style="color: var(--dorado);">$<?= number_format($item['subtotal'], 2) ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td><strong style="color: var(--dorado);">$<?= number_format($pedido['total'], 2) ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cambiar estado (admin y empleado) -->
        <?php if ($_SESSION['rol'] !== 'cliente'): ?>
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <i class="bi bi-arrow-repeat"></i> Cambiar Estado
                </div>
                <div class="card-body">
                    <form method="POST" action="/sweet-dreams/public/index.php?accion=cambiarEstadoPedido">
                        <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
                        <div class="d-flex gap-2">
                            <select name="estado" class="form-select">
                                <?php
                                $estados = ['pendiente', 'preparacion', 'listo', 'entregado', 'cancelado'];
                                foreach ($estados as $estado):
                                ?>
                                    <option value="<?= $estado ?>" <?= $pedido['estado'] === $estado ? 'selected' : '' ?>>
                                        <?= ucfirst($estado) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-cafe">
                                <i class="bi bi-check"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Asignar empleado (solo admin) -->
        <?php if ($_SESSION['rol'] === 'admin'): ?>
            <div class="card shadow-sm">
                <div class="card-header">
                    <i class="bi bi-person-check"></i> Asignar Empleado
                </div>
                <div class="card-body">
                    <form method="POST" action="/sweet-dreams/public/index.php?accion=asignarEmpleado">
                        <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
                        <div class="d-flex gap-2">
                            <select name="empleado_id" class="form-select">
                                <option value="">-- Sin asignar --</option>
                                <?php
                                $modeloUsuario = new Usuario();
                                $empleados = $modeloUsuario->obtenerTodos();
                                foreach ($empleados as $emp):
                                    if ($emp['rol'] === 'empleado'):
                                ?>
                                    <option value="<?= $emp['id'] ?>" <?= $pedido['empleado_id'] == $emp['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($emp['nombre']) ?>
                                    </option>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </select>
                            <button type="submit" class="btn btn-cafe">
                                <i class="bi bi-check"></i> Asignar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>