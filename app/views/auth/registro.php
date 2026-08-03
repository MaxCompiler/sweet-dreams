<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<style>
    .contenedor-registro {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 0;
    }
</style>

<div class="contenedor-registro">
    <div class="col-md-7">
        <div class="card shadow">

            <!-- Header de la card -->
            <div class="card-header text-center py-4">
                <i class="bi bi-person-plus fs-1"></i>
                <h3 class="mt-2 mb-0" style="font-family: 'Playfair Display', serif;">Crear Cuenta</h3>
                <p class="mb-0 opacity-75">Registrate en Sweet Dreams</p>
            </div>

            <div class="card-body p-4">

                <!-- Mensaje de error -->
                <?php if (isset($error)): ?>
                    <div class="alerta-error">
                        <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario de registro -->
                <form method="POST" action="/sweet-dreams/public/index.php?accion=registro" id="formRegistro" novalidate>

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
                                placeholder="Tu nombre completo"
                                required
                                value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                            >
                            <div class="invalid-feedback">El nombre es obligatorio.</div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope"></i> Correo electronico *
                            </label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="ejemplo@correo.com"
                                required
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            >
                            <div class="invalid-feedback">Por favor ingresa un correo valido.</div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock"></i> Contrasena *
                            </label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Minimo 6 caracteres"
                                    required
                                    minlength="6"
                                >
                                <button class="btn btn-outline-secondary" type="button" id="btnVerPassword">
                                    <i class="bi bi-eye" id="iconoPassword"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">La contrasena debe tener al menos 6 caracteres.</div>
                        </div>

                        <!-- Confirmar Password -->
                        <div class="col-md-6 mb-3">
                            <label for="confirmar_password" class="form-label fw-semibold">
                                <i class="bi bi-lock-fill"></i> Confirmar contrasena *
                            </label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="confirmar_password"
                                    name="confirmar_password"
                                    placeholder="Repite tu contrasena"
                                    required
                                >
                                <button class="btn btn-outline-secondary" type="button" id="btnVerConfirmar">
                                    <i class="bi bi-eye" id="iconoConfirmar"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Las contrasenas no coinciden.</div>
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
                                value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>"
                            >
                        </div>

                        <!-- Direccion -->
                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt"></i> Direccion *
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="direccion"
                                name="direccion"
                                placeholder="Tu direccion de entrega"
                                required
                                value="<?= htmlspecialchars($_POST['direccion'] ?? '') ?>"
                            >
                            <div class="invalid-feedback">La direccion es obligatoria.</div>
                        </div>

                        <!-- Pregunta de seguridad -->
                        <div class="col-md-6 mb-3">
                            <label for="pregunta_seguridad" class="form-label fw-semibold">
                                <i class="bi bi-shield-lock"></i> Pregunta de seguridad *
                            </label>
                            <select class="form-select" id="pregunta_seguridad" name="pregunta_seguridad" required>
                                <option value="">-- Selecciona una pregunta --</option>
                                <option value="¿Cual es el nombre de tu primera mascota?" <?= (($_POST['pregunta_seguridad'] ?? '') === '¿Cual es el nombre de tu primera mascota?') ? 'selected' : '' ?>>¿Cual es el nombre de tu primera mascota?</option>
                                <option value="¿En que ciudad naciste?" <?= (($_POST['pregunta_seguridad'] ?? '') === '¿En que ciudad naciste?') ? 'selected' : '' ?>>¿En que ciudad naciste?</option>
                                <option value="¿Cual es el nombre de tu colegio?" <?= (($_POST['pregunta_seguridad'] ?? '') === '¿Cual es el nombre de tu colegio?') ? 'selected' : '' ?>>¿Cual es el nombre de tu colegio?</option>
                                <option value="¿Cual es tu pelicula favorita?" <?= (($_POST['pregunta_seguridad'] ?? '') === '¿Cual es tu pelicula favorita?') ? 'selected' : '' ?>>¿Cual es tu pelicula favorita?</option>
                                <option value="¿Cual es el apellido de tu madre?" <?= (($_POST['pregunta_seguridad'] ?? '') === '¿Cual es el apellido de tu madre?') ? 'selected' : '' ?>>¿Cual es el apellido de tu madre?</option>
                            </select>
                            <div class="invalid-feedback">Selecciona una pregunta de seguridad.</div>
                        </div>

                        <!-- Respuesta de seguridad -->
                        <div class="col-md-6 mb-3">
                            <label for="respuesta_seguridad" class="form-label fw-semibold">
                                <i class="bi bi-shield-check"></i> Respuesta de seguridad *
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="respuesta_seguridad"
                                name="respuesta_seguridad"
                                placeholder="Tu respuesta"
                                required
                                value="<?= htmlspecialchars($_POST['respuesta_seguridad'] ?? '') ?>"
                            >
                            <div class="invalid-feedback">La respuesta de seguridad es obligatoria.</div>
                        </div>

                    </div>

                    <!-- Nota campos obligatorios -->
                    <p class="text-muted small mb-3">* Campos obligatorios</p>

                    <!-- Boton submit -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-cafe btn-lg">
                            <i class="bi bi-person-check"></i> Crear Cuenta
                        </button>
                    </div>

                </form>

            </div>

            <!-- Footer de la card -->
            <div class="card-footer text-center py-3 bg-transparent">
                <p class="mb-0">
                    ¿Ya tienes cuenta?
                    <a href="/sweet-dreams/public/index.php?accion=login"
                    style="color: var(--cafe-oscuro); font-weight: 600;">
                        Inicia sesion aqui
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>

<script>
// Mostrar/ocultar password
document.getElementById('btnVerPassword').addEventListener('click', function() {
    const input = document.getElementById('password');
    const icono = document.getElementById('iconoPassword');
    if (input.type === 'password') {
        input.type = 'text';
        icono.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icono.classList.replace('bi-eye-slash', 'bi-eye');
    }
});

// Mostrar/ocultar confirmar password
document.getElementById('btnVerConfirmar').addEventListener('click', function() {
    const input = document.getElementById('confirmar_password');
    const icono = document.getElementById('iconoConfirmar');
    if (input.type === 'password') {
        input.type = 'text';
        icono.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icono.classList.replace('bi-eye-slash', 'bi-eye');
    }
});

// Validar que las contrasenas coincidan
document.getElementById('formRegistro').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmar = document.getElementById('confirmar_password').value;

    if (password !== confirmar) {
        e.preventDefault();
        document.getElementById('confirmar_password').classList.add('is-invalid');
        return;
    }
    document.getElementById('confirmar_password').classList.remove('is-invalid');
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>