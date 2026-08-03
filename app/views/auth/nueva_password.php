<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<style>
    .contenedor-recuperar {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="contenedor-recuperar">
    <div class="col-md-5">
        <div class="card shadow">

            <div class="card-header text-center py-4">
                <i class="bi bi-lock-fill fs-1"></i>
                <h3 class="mt-2 mb-0" style="font-family: 'Playfair Display', serif;">Nueva Contrasena</h3>
                <p class="mb-0 opacity-75">Elige una nueva contrasena segura</p>
            </div>

            <div class="card-body p-4">

                <?php if (isset($error)): ?>
                    <div class="alerta-error">
                        <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/sweet-dreams/public/index.php?accion=recuperarCuenta" id="formNuevaPassword" novalidate>

                    <!-- Nueva password -->
                    <div class="mb-3">
                        <label for="nueva_password" class="form-label fw-semibold">
                            <i class="bi bi-lock"></i> Nueva contrasena *
                        </label>
                        <div class="input-group">
                            <input
                                type="password"
                                class="form-control"
                                id="nueva_password"
                                name="nueva_password"
                                placeholder="Minimo 6 caracteres"
                                required
                                minlength="6"
                            >
                            <button class="btn btn-outline-secondary" type="button" id="btnVerNueva">
                                <i class="bi bi-eye" id="iconoNueva"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">La contrasena debe tener al menos 6 caracteres.</div>
                    </div>

                    <!-- Confirmar nueva password -->
                    <div class="mb-3">
                        <label for="confirmar_password" class="form-label fw-semibold">
                            <i class="bi bi-lock-fill"></i> Confirmar contrasena *
                        </label>
                        <div class="input-group">
                            <input
                                type="password"
                                class="form-control"
                                id="confirmar_password"
                                name="confirmar_password"
                                placeholder="Repite tu nueva contrasena"
                                required
                            >
                            <button class="btn btn-outline-secondary" type="button" id="btnVerConfirmar">
                                <i class="bi bi-eye" id="iconoConfirmar"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Las contrasenas no coinciden.</div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-cafe btn-lg">
                            <i class="bi bi-check-circle"></i> Guardar Nueva Contrasena
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<script>
// Mostrar/ocultar nueva password
document.getElementById('btnVerNueva').addEventListener('click', function() {
    const input = document.getElementById('nueva_password');
    const icono = document.getElementById('iconoNueva');
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
document.getElementById('formNuevaPassword').addEventListener('submit', function(e) {
    const nueva = document.getElementById('nueva_password').value;
    const confirmar = document.getElementById('confirmar_password').value;

    if (nueva !== confirmar) {
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