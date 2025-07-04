document.addEventListener('DOMContentLoaded', () => {
  
    const select = document.getElementById("rol_usuario");
    const label = document.querySelector("label[for='rol_usuario']");



    function updateLabel(selectElement, labelElement) {
        if (selectElement.value !== "") {
            labelElement.classList.add("active");
        } else {
            labelElement.classList.remove("active");
        }
    }

    select.addEventListener("change", ()=> updateLabel(select, label));
    updateLabel(select, label);



    const nombreCompletoInput = document.querySelector("input[name='nombre_completo']");
    const contraseñaInput = document.querySelector("input[name='contraseña_usuario']");
    const fechaNacimientoInput = document.querySelector("input[name='fecha_usuario']");
    const emailInput = document.querySelector("input[name='email_usuario']");
    const telefonoInput = document.querySelector("input[name='telefono_usuario']");
    const form = document.querySelector("form");


    telefonoInput.addEventListener('input', () => {
        const telefonoRegex = /^\d{10}$/; // Asegura que el número tenga 10 digitos

        if (!telefonoRegex.test(telefonoInput.value)) {
            telefonoInput.setCustomValidity("El número de teléfono debe tener exactamente 10 dígitos.");
        }
        else {
            telefonoInput.setCustomValidity("");
        }
    });
    // Validación de Nombre Completo
    nombreCompletoInput.addEventListener('input', () => {
        const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        if (!nombreRegex.test(nombreCompletoInput.value)) {
            nombreCompletoInput.setCustomValidity("El nombre solo puede contener letras y espacios.");
        } else {
            nombreCompletoInput.setCustomValidity("");
        }
    });

    // Validación de Contraseña
    contraseñaInput.addEventListener('input', () => {
        const contraseñaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (!contraseñaRegex.test(contraseñaInput.value)) {
            contraseñaInput.setCustomValidity("La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.");
        } else {
            contraseñaInput.setCustomValidity("");
        }
    });

    // Validación de Fecha de Nacimiento
    fechaNacimientoInput.addEventListener('input', () => {
        if (!fechaNacimientoInput.value) {
            fechaNacimientoInput.setCustomValidity("Por favor, selecciona una fecha.");
            return;
        }

        const fechaSeleccionada = new Date(fechaNacimientoInput.value);
        const fechaActual = new Date();
        if (fechaSeleccionada > fechaActual) {
            fechaNacimientoInput.setCustomValidity("La fecha de nacimiento no puede ser en el futuro.");
        } else {
            fechaNacimientoInput.setCustomValidity("");
        }
    });

    // Validación de Email
    emailInput.addEventListener('input', () => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            emailInput.setCustomValidity("Por favor, ingresa un correo electrónico válido.");
        } else {
            emailInput.setCustomValidity("");
        }
    });
const fileInput = document.getElementById('imgRuta');
    // Validación al Enviar el Formulario
    form.addEventListener('submit', (event) => {
        let isValid = true;

          if (fileInput && fileInput.files.length > 0) { // Verificar si fileInput existe
                   const file = fileInput.files[0];
                   const validTypes = ["image/jpeg", "image/png", "image/webp"]; // Tipos de imagen permitidos
                   const maxSize = 10 * 1024 * 1024; // 10 MB

                   if (!validTypes.includes(file.type)) {
                      fileInput.setCustomValidity("Solo se permiten imágenes .jpg/.png");
                       event.preventDefault();
                       isValid = false;
                     return;
                   }

                   if (file.size > maxSize) {
                       fileInput.setCustomValidity("El archivo no puede superar los 10 MB.");
                       event.preventDefault();
                       isValid = false;
                       return;
                   }
                    // Limpiar custom validity si el archivo es válido
                   fileInput.setCustomValidity("");
               } else if (fileInput) {
                    // Si el campo de archivo existe pero no hay archivo seleccionado, limpiar cualquier error previo
                   fileInput.setCustomValidity("");
               }
      
        // Validar términos y condiciones
        const terminos = document.querySelector('input[type="checkbox"]');
        if (!terminos.checked) {
            alert('Debes aceptar los términos y condiciones para continuar.');
            isValid = false;
        }

        // Prevenir el envío del formulario si hay errores
        if (!form.checkValidity() || !isValid) {
            event.preventDefault();
            alert("Por favor, corrige los errores en el formulario.");
        }
    });
});


      function previewImage() {
                const file = document.getElementById('imgRuta').files[0];
                const imgPreview = document.getElementById('imgPerfil');
                const container = document.querySelector('.image-preview-container');
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgPreview.src = e.target.result;
                        
                        // Añadir clases para mostrar con transición
                        container.classList.add('show');
                        imgPreview.classList.add('show');
                        imgPreview.style.display = 'block';
                        
                        // Scroll suave hacia la imagen si es necesario
                        setTimeout(() => {
                            container.scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'center' 
                            });
                        }, 100);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Ocultar con transición
                    imgPreview.classList.remove('show');
                    container.classList.remove('show');
                    
                    setTimeout(() => {
                        imgPreview.src = '#';
                        imgPreview.style.display = 'none';
                    }, 300); // Esperar a que termine la transición
                }
            }