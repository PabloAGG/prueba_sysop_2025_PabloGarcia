document.addEventListener('DOMContentLoaded', function() {
     const btnVerContra = document.getElementById('vercontraBtn');
     const contraseñaInput = document.getElementById('password_user');
    // Evento para mostrar/ocultar la contraseña
    if (btnVerContra) {
        btnVerContra.addEventListener('click', (event) => {
            event.preventDefault(); // Prevenir el envío del formulario
            const passwordField = contraseñaInput;
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            btnVerContra.querySelector('i').classList.toggle('fa-eye');
            btnVerContra.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
});

