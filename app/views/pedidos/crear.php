<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="titulo-pagina mb-0">
        <i class="bi bi-bag-plus"></i> Nuevo Pedido
    </h2>
    <a href="/sweet-dreams/public/index.php?accion=listarPedidos" class="btn btn-cafe">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="alerta-error">
        <i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form method="POST" action="/sweet-dreams/public/index.php?accion=crearPedido" id="formPedido" novalidate>

    <div class="row g-4">

        <!-- Datos del pedido -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <i class="bi bi-calendar"></i> Datos del Pedido
                </div>
                <div class="card-body">

                    <!-- Fecha de entrega -->
                    <div class="mb-3">
                        <label for="fecha_entrega" class="form-label fw-semibold">
                            <i class="bi bi-truck"></i> Fecha de entrega *
                        </label>
                        <input
                            type="datetime-local"
                            class="form-control"
                            id="fecha_entrega"
                            name="fecha_entrega"
                            required
                            min="<?= date('Y-m-d\TH:i') ?>"
                        >
                        <div class="invalid-feedback">La fecha de entrega es obligatoria.</div>
                    </div>

                    <!-- Nota -->
                    <div class="mb-3">
                        <label for="nota" class="form-label fw-semibold">
                            <i class="bi bi-chat-text"></i> Nota especial
                        </label>
                        <textarea
                            class="form-control"
                            id="nota"
                            name="nota"
                            rows="3"
                            placeholder="Ej: Sin azucar, decoracion especial..."
                        ></textarea>
                    </div>

                </div>
            </div>
        </div>

        <!-- Seleccionar productos -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-cake2"></i> Seleccionar Productos</span>
                    <button type="button" class="btn btn-dorado btn-sm" id="btnAgregarProducto">
                        <i class="bi bi-plus-circle"></i> Agregar Producto
                    </button>
                </div>
                <div class="card-body">

                    <div id="listaProductos">
                        <!-- Fila inicial de producto -->
                        <div class="fila-producto row g-2 mb-3 align-items-end">
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Producto</label>
                                <select name="producto_id[]" class="form-select" required>
                                    <option value="">-- Selecciona un producto --</option>
                                    <?php foreach ($productos as $p): ?>
                                        <?php if ($p['stock'] > 0): ?>
                                            <option value="<?= $p['id'] ?>" data-precio="<?= $p['precio'] ?>" data-stock="<?= $p['stock'] ?>">
                                                <?= htmlspecialchars($p['nombre']) ?> - $<?= number_format($p['precio'], 2) ?> (Stock: <?= $p['stock'] ?>)
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Cantidad</label>
                                <input type="number" name="cantidad[]" class="form-control cantidad-input" min="1" value="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-eliminar-fila w-100">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Total estimado -->
                    <hr>
                    <div class="text-end">
                        <span class="fs-5 fw-bold">Total estimado: </span>
                        <span class="fs-4 fw-bold" style="color: var(--dorado);" id="totalEstimado">$0.00</span>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Botones -->
    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-dorado btn-lg">
            <i class="bi bi-check-circle"></i> Confirmar Pedido
        </button>
        <a href="/sweet-dreams/public/index.php?accion=listarPedidos" class="btn btn-cafe btn-lg">
            <i class="bi bi-x-circle"></i> Cancelar
        </a>
    </div>

</form>

<script>
// Template de fila de producto
function crearFilaProducto() {
    const opciones = document.querySelector('select[name="producto_id[]"]').innerHTML;
    return `
        <div class="fila-producto row g-2 mb-3 align-items-end">
            <div class="col-md-7">
                <label class="form-label fw-semibold">Producto</label>
                <select name="producto_id[]" class="form-select" required>
                    ${opciones}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Cantidad</label>
                <input type="number" name="cantidad[]" class="form-control cantidad-input" min="1" value="1" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-eliminar-fila w-100">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
}

// Agregar nueva fila de producto
document.getElementById('btnAgregarProducto').addEventListener('click', function() {
    document.getElementById('listaProductos').insertAdjacentHTML('beforeend', crearFilaProducto());
    actualizarEventos();
});

// Eliminar fila de producto
function actualizarEventos() {
    document.querySelectorAll('.btn-eliminar-fila').forEach(function(btn) {
        btn.onclick = function() {
            const filas = document.querySelectorAll('.fila-producto');
            if (filas.length > 1) {
                btn.closest('.fila-producto').remove();
                calcularTotal();
            }
        };
    });

    document.querySelectorAll('select[name="producto_id[]"]').forEach(function(select) {
        select.onchange = calcularTotal;
    });

    document.querySelectorAll('.cantidad-input').forEach(function(input) {
        input.oninput = calcularTotal;
    });
}

// Calcular total estimado
function calcularTotal() {
    let total = 0;
    document.querySelectorAll('.fila-producto').forEach(function(fila) {
        const select = fila.querySelector('select[name="producto_id[]"]');
        const cantidad = parseInt(fila.querySelector('.cantidad-input').value) || 0;
        const opcion = select.options[select.selectedIndex];
        const precio = parseFloat(opcion?.dataset?.precio) || 0;
        total += precio * cantidad;
    });
    document.getElementById('totalEstimado').textContent = '$' + total.toFixed(2);
}

// Inicializar eventos
actualizarEventos();
</script>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>