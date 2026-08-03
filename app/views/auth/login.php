<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<style>
    .contenedor-login {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="contenedor-login">
    <div class="col-md-5">
        <div class="card shadow">

            <!-- Header de la card -->
            <div class="card-header text-center py-4">
                <i class="bi bi-cake2 fs-1"></i>
                <h3 class="mt-2 mb-0" style="font-family: 'Playfair Display', serif;">Sweet Dreams</h3>
                <p class="mb-0 opacity-75">Inicia sesion en tu cuenta</p>
            </div>

            <div class="card-body p-4">

                <!-- Mensaje de exito -->
                <?php if (isset($exito)): ?>
                    <div class="alerta-exito">
                        <i class="bi bi-check-circle"></i> <?= htmlspecialchars($exito) ?>
                    </div>
                <?php endif; ?>

                <!-- Mensaje de error -->
                <?php if (isset($error)): ?>
                    <div class="alerta-error">
                        <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario de login -->
                <form method="POST" action="/sweet-dreams/public/index.php?accion=login" id="formLogin" novalidate>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            <i class="bi bi-envelope"></i> Correo electronico
                        </label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="ejemplo@correo.com"
                            required
                        >
                        <div class="invalid-feedback">Por favor ingresa un correo valido.</div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            <i class="bi bi-lock"></i> Contrasena
                        </label>
                        <div class="input-group">
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Tu contrasena"
                                required
                                minlength="6"
                            >
                            <button class="btn btn-outline-secondary" type="button" id="btnVerPassword">
                                <i class="bi bi-eye" id="iconoPassword"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">La contrasena debe tener al menos 6 caracteres.</div>
                    </div>

                    <!-- Boton submit -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-cafe btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesion
                        </button>
                    </div>

                </form>

            </div>

            <!-- Footer de la card -->
            <div class="card-footer text-center py-3 bg-transparent">
                <p class="mb-1">
                    <a href="/sweet-dreams/public/index.php?accion=recuperarCuenta"
                    style="color: var(--cafe-medio);">
                        <i class="bi bi-key"></i> Olvide mi contrasena
                    </a>
                </p>
                <p class="mb-0">
                    ¿No tienes cuenta?
                    <a href="/sweet-dreams/public/index.php?accion=registro"
                    style="color: var(--cafe-oscuro); font-weight: 600;">
                        Registrate aqui
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>

<script>
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
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>