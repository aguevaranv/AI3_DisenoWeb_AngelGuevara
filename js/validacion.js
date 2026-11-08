// Validación en el cliente: avisa antes de enviar el formulario.
// El servidor (crear.php) vuelve a validar todo, porque esta parte se puede saltar.
const formulario = document.querySelector('#form-producto');

function validarCampo(campo) {
    const mensaje = campo.parentElement.querySelector('.error-campo');
    const esValido = campo.checkValidity();

    campo.classList.toggle('invalido', !esValido);
    mensaje.textContent = esValido ? '' : campo.dataset.error;

    return esValido;
}

formulario.addEventListener('submit', (evento) => {
    const campos = formulario.querySelectorAll('input, select, textarea');
    let todoValido = true;

    campos.forEach((campo) => {
        if (!validarCampo(campo)) {
            todoValido = false;
        }
    });

    if (!todoValido) {
        evento.preventDefault();
        formulario.querySelector('.invalido').focus();
    }
});

// Revisa cada campo mientras el usuario escribe.
formulario.addEventListener('input', (evento) => {
    const campo = evento.target;

    if (campo.name === 'codigo') {
        campo.value = campo.value.toUpperCase();
    }

    validarCampo(campo);
});

// Al limpiar el formulario también se borran los mensajes de error.
formulario.addEventListener('reset', () => {
    formulario.querySelectorAll('.invalido').forEach((campo) => campo.classList.remove('invalido'));
    formulario.querySelectorAll('.error-campo').forEach((mensaje) => {
        mensaje.textContent = '';
    });
});
