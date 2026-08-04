<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-person-gear"></i> Editar Perfil
    </h2>
    <?php if ($_SESSION['rol'] === 'admin'): ?>
        <a href="/sweet-dreams/public/index.php?accion=listarUsuarios" class="btn btn-cafe">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    <?php else: ?>
        <a href="/sweet-dreams/public/index.php?accion=dashboard<?= ucfirst($_SESSION['rol']) ?>" class="btn btn-cafe">
            <i class="bi bi-arrow-left"></i> Volver al Dashboard
        </a>
    <?php endif; ?>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header">
                <i class="bi bi-person-circle"></i> <?= htmlspecialchars($usuario['nombre']) ?>
                <span class="badge badge-<?= $usuario['rol'] === 'admin' ? 'entregado' : ($usuario['rol'] === 'empleado' ? 'preparacion' : 'pendiente') ?> ms-2">
                    <?= ucfirst($usuario['rol']) ?>
                </span>
            </div>
            <div class="card-body p-4">

                <?php if (isset($exito)): ?>
                    <div class="alerta-exito">
                        <i class="bi bi-check-circle"></i> <?= htmlspecialchars($exito) ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alerta-error">
                        <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/sweet-dreams/public/index.php?accion=editarUsuario&id=<?= $usuario['id'] ?>" novalidate>

                    <div class="row">

                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label fw-semibold">
                                <i class="bi bi-person"></i> Nombre completo *
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="nombre"
                                name="nombre"
                                required
                                value="<?= htmlspecialchars($usuario['nombre']) ?>"
                            >
                            <div class="invalid-feedback">El nombre es obligatorio.</div>
                        </div>

                        <!-- Email (solo lectura) -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-envelope"></i> Correo electronico
                            </label>
                            <input
                                type="email"
                                class="form-control"
                                value="<?= htmlspecialchars($usuario['email']) ?>"
                                disabled
                            >
                            <div class="form-text text-muted">El correo no se puede cambiar.</div>
                        </div>

                        <!-- Telefono -->
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label fw-semibold">
                                <i class="bi bi-telephone"></i> Telefono
                            </label>
                            <input
                                type="tel"
                                class="form-control"
                                id="telefono"
                                name="telefono"
                                placeholder="0999999999"
                                value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>"
                            >
                        </div>

                        <!-- Direccion -->
                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt"></i> Direccion
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="direccion"
                                name="direccion"
                                placeholder="Tu direccion"
                                value="<?= htmlspecialchars($usuario['direccion'] ?? '') ?>"
                            >
                        </div>

                    </div>

                    <!-- Info adicional -->
                    <div class="alert" style="background-color: #f3e5dc; border-left: 4px solid var(--cafe-oscuro);">
                        <small>
                            <i class="bi bi-info-circle"></i>
                            <strong>Fecha de registro:</strong> <?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?>
                            &nbsp;|&nbsp;
                            <strong>Pregunta de seguridad:</strong> <?= htmlspecialchars($usuario['pregunta_seguridad'] ?? 'No configurada') ?>
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dorado btn-lg">
                            <i class="bi bi-check-circle"></i> Guardar Cambios
                        </button>
                        <a href="/sweet-dreams/public/index.php?accion=recuperarCuenta"
                           class="btn btn-cafe btn-lg">
                            <i class="bi bi-key"></i> Cambiar Contrasena
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>