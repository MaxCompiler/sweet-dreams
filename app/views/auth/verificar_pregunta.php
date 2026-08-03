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
                <i class="bi bi-shield-lock fs-1"></i>
                <h3 class="mt-2 mb-0" style="font-family: 'Playfair Display', serif;">Verificar Identidad</h3>
                <p class="mb-0 opacity-75">Responde tu pregunta de seguridad</p>
            </div>

            <div class="card-body p-4">

                <?php if (isset($error)): ?>
                    <div class="alerta-error">
                        <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <!-- Mostrar la pregunta de seguridad del usuario -->
                <div class="alert alert-light border mb-4">
                    <i class="bi bi-question-circle" style="color: var(--cafe-oscuro);"></i>
                    <strong><?= htmlspecialchars($pregunta ?? '') ?></strong>
                </div>

                <form method="POST" action="/sweet-dreams/public/index.php?accion=recuperarCuenta" novalidate>

                    <div class="mb-3">
                        <label for="respuesta_seguridad" class="form-label fw-semibold">
                            <i class="bi bi-chat-text"></i> Tu respuesta
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="respuesta_seguridad"
                            name="respuesta_seguridad"
                            placeholder="Escribe tu respuesta"
                            required
                        >
                        <div class="form-text text-muted">La respuesta no distingue mayusculas/minusculas.</div>
                        <div class="invalid-feedback">La respuesta es obligatoria.</div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-cafe btn-lg">
                            <i class="bi bi-shield-check"></i> Verificar
                        </button>
                    </div>

                </form>

            </div>

            <div class="card-footer text-center py-3 bg-transparent">
                <a href="/sweet-dreams/public/index.php?accion=recuperarCuenta"
                style="color: var(--cafe-medio);">
                    <i class="bi bi-arrow-left"></i> Ingresar otro correo
                </a>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>