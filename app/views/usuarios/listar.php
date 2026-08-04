<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-people"></i> Gestion de Usuarios
    </h2>
</div>

<?php if (empty($usuarios)): ?>
    <div class="alert text-center" style="background-color: #f3e5dc; border-left: 4px solid var(--cafe-oscuro);">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        <strong>No hay usuarios registrados.</strong>
    </div>
<?php else: ?>
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario['id'] ?></td>
                                <td><strong><?= htmlspecialchars($usuario['nombre']) ?></strong></td>
                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                                <td><?= htmlspecialchars($usuario['telefono'] ?? '-') ?></td>
                                <td>
                                    <?php
                                    $colores = [
                                        'admin'    => 'badge-entregado',
                                        'empleado' => 'badge-preparacion',
                                        'cliente'  => 'badge-pendiente'
                                    ];
                                    ?>
                                    <span class="badge <?= $colores[$usuario['rol']] ?? 'bg-secondary' ?> px-2 py-1">
                                        <?= ucfirst($usuario['rol']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $usuario['estado'] === 'activo' ? 'bg-success' : 'bg-danger' ?> px-2 py-1">
                                        <?= ucfirst($usuario['estado']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?></td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">

                                        <!-- Editar -->
                                        <a href="/sweet-dreams/public/index.php?accion=editarUsuario&id=<?= $usuario['id'] ?>"
                                           class="btn btn-warning btn-sm"
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <!-- Cambiar rol -->
                                        <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                                            <form method="POST" action="/sweet-dreams/public/index.php?accion=cambiarRolUsuario" class="d-inline">
                                                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                                <select name="rol" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                                    <option value="cliente"   <?= $usuario['rol'] === 'cliente'   ? 'selected' : '' ?>>Cliente</option>
                                                    <option value="empleado"  <?= $usuario['rol'] === 'empleado'  ? 'selected' : '' ?>>Empleado</option>
                                                    <option value="admin"     <?= $usuario['rol'] === 'admin'     ? 'selected' : '' ?>>Admin</option>
                                                </select>
                                            </form>

                                            <!-- Cambiar estado activo/inactivo -->
                                            <?php if ($usuario['estado'] === 'activo'): ?>
                                                <a href="/sweet-dreams/public/index.php?accion=cambiarEstadoUsuario&id=<?= $usuario['id'] ?>&estado=inactivo"
                                                   class="btn btn-secondary btn-sm"
                                                   title="Desactivar"
                                                   onclick="return confirm('¿Desactivar este usuario?')">
                                                    <i class="bi bi-person-dash"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="/sweet-dreams/public/index.php?accion=cambiarEstadoUsuario&id=<?= $usuario['id'] ?>&estado=activo"
                                                   class="btn btn-success btn-sm"
                                                   title="Activar">
                                                    <i class="bi bi-person-check"></i>
                                                </a>
                                            <?php endif; ?>

                                            <!-- Eliminar -->
                                            <a href="/sweet-dreams/public/index.php?accion=eliminarUsuario&id=<?= $usuario['id'] ?>"
                                               class="btn btn-danger btn-sm"
                                               title="Eliminar"
                                               onclick="return confirm('¿Eliminar este usuario? Esta accion no se puede deshacer.')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>

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