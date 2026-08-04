document.addEventListener('DOMContentLoaded', function () {

    // VALIDACION GENERAL DE FORMULARIOS

    const formularios = document.querySelectorAll('form[novalidate]');

    formularios.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            let valido = true;

            // Verificar campos requeridos
            const camposRequeridos = form.querySelectorAll('[required]');
            camposRequeridos.forEach(function (campo) {
                if (campo.value.trim() === '') {
                    campo.classList.add('is-invalid');
                    valido = false;
                } else {
                    campo.classList.remove('is-invalid');
                    campo.classList.add('is-valid');
                }
            });

            // Verificar emails
            const camposEmail = form.querySelectorAll('input[type="email"]');
            camposEmail.forEach(function (campo) {
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!regex.test(campo.value.trim())) {
                    campo.classList.add('is-invalid');
                    valido = false;
                }
            });

            // Verificar numeros positivos (precio, stock, cantidad)
            const camposNumero = form.querySelectorAll('input[type="number"]');
            camposNumero.forEach(function (campo) {
                const min = parseFloat(campo.getAttribute('min') ?? 0);
                if (parseFloat(campo.value) < min) {
                    campo.classList.add('is-invalid');
                    valido = false;
                }
            });

            if (!valido) {
                e.preventDefault();
                // Scroll al primer campo invalido
                const primerInvalido = form.querySelector('.is-invalid');
                if (primerInvalido) {
                    primerInvalido.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    primerInvalido.focus();
                }
            }
        });

        // Limpiar validacion cuando el usuario empieza a escribir
        form.querySelectorAll('input, select, textarea').forEach(function (campo) {
            campo.addEventListener('input', function () {
                if (campo.value.trim() !== '') {
                    campo.classList.remove('is-invalid');
                    if (campo.hasAttribute('required')) {
                        campo.classList.add('is-valid');
                    }
                }
            });
        });
    });

    // VALIDACION DE CONTRASENAS COINCIDENTES
    const confirmarPassword = document.getElementById('confirmar_password');
    const password = document.getElementById('password') || document.getElementById('nueva_password');

    if (confirmarPassword && password) {
        confirmarPassword.addEventListener('input', function () {
            if (confirmarPassword.value !== password.value) {
                confirmarPassword.classList.add('is-invalid');
                confirmarPassword.classList.remove('is-valid');
            } else {
                confirmarPassword.classList.remove('is-invalid');
                confirmarPassword.classList.add('is-valid');
            }
        });
    }

    // VALIDACION DE LONGITUD DE CONTRASENA

    const inputPassword = document.getElementById('password') || document.getElementById('nueva_password');
    if (inputPassword) {
        inputPassword.addEventListener('input', function () {
            if (inputPassword.value.length < 6) {
                inputPassword.classList.add('is-invalid');
                inputPassword.classList.remove('is-valid');
            } else {
                inputPassword.classList.remove('is-invalid');
                inputPassword.classList.add('is-valid');
            }
        });
    }


    // VALIDACION DE FECHA DE ENTREGA

    const fechaEntrega = document.getElementById('fecha_entrega');
    if (fechaEntrega) {
        fechaEntrega.addEventListener('change', function () {
            const hoy = new Date();
            const fecha = new Date(fechaEntrega.value);

            if (fecha < hoy) {
                fechaEntrega.classList.add('is-invalid');
                fechaEntrega.classList.remove('is-valid');
                // Mostrar mensaje personalizado
                let feedback = fechaEntrega.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = 'La fecha de entrega no puede ser en el pasado.';
                }
            } else {
                fechaEntrega.classList.remove('is-invalid');
                fechaEntrega.classList.add('is-valid');
            }
        });
    }

    // VALIDACION DE PRECIO Y STOCK EN TIEMPO REAL
    const inputPrecio = document.getElementById('precio');
    if (inputPrecio) {
        inputPrecio.addEventListener('input', function () {
            if (parseFloat(inputPrecio.value) <= 0 || inputPrecio.value === '') {
                inputPrecio.classList.add('is-invalid');
                inputPrecio.classList.remove('is-valid');
            } else {
                inputPrecio.classList.remove('is-invalid');
                inputPrecio.classList.add('is-valid');
            }
        });
    }

    const inputStock = document.getElementById('stock');
    if (inputStock) {
        inputStock.addEventListener('input', function () {
            if (parseInt(inputStock.value) < 0 || inputStock.value === '') {
                inputStock.classList.add('is-invalid');
                inputStock.classList.remove('is-valid');
            } else {
                inputStock.classList.remove('is-invalid');
                inputStock.classList.add('is-valid');
            }
        });
    }

    // CONFIRMACION ANTES DE ELIMINAR
    // Para todos los enlaces de eliminacion
    document.querySelectorAll('a[href*="eliminar"], a[href*="cancelar"]').forEach(function (enlace) {
        if (!enlace.hasAttribute('onclick')) {
            enlace.addEventListener('click', function (e) {
                if (!confirm('¿Estas seguro de realizar esta accion? No se puede deshacer.')) {
                    e.preventDefault();
                }
            });
        }
    });

    // AUTO-CERRAR ALERTAS DESPUES DE 5 SEGUNDOS
    const alertas = document.querySelectorAll('.alerta-exito, .alerta-error');
    alertas.forEach(function (alerta) {
        setTimeout(function () {
            alerta.style.transition = 'opacity 0.5s';
            alerta.style.opacity = '0';
            setTimeout(function () {
                alerta.remove();
            }, 500);
        }, 5000);
    });

});