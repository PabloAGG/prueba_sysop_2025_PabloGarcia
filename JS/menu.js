document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const body = document.body;

    // Función para alternar el menú
    function toggleMenu() {
        hamburger.classList.toggle('activo');
        navLinks.classList.toggle('activo');
        
        // Prevenir scroll del body cuando el menú está abierto
        if (navLinks.classList.contains('activo')) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = 'auto';
        }
    }

    // Event listener para el botón hamburguesa
    if (hamburger) {
        hamburger.addEventListener('click', toggleMenu);
    }

    // Cerrar menú al hacer clic en un enlace
    const menuLinks = document.querySelectorAll('.nav-link');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('activo');
            navLinks.classList.remove('activo');
            body.style.overflow = 'auto';
        });
    });

    // Cerrar menú al hacer clic fuera de él
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = navLinks.contains(event.target);
        const isClickOnHamburger = hamburger.contains(event.target);
        
        if (!isClickInsideMenu && !isClickOnHamburger && navLinks.classList.contains('activo')) {
            hamburger.classList.remove('activo');
            navLinks.classList.remove('activo');
            body.style.overflow = 'auto';
        }
    });

    // Cerrar menú con la tecla Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && navLinks.classList.contains('activo')) {
            hamburger.classList.remove('activo');
            navLinks.classList.remove('activo');
            body.style.overflow = 'auto';
        }
    });

    // Manejar redimensionamiento de ventana
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            hamburger.classList.remove('activo');
            navLinks.classList.remove('activo');
            body.style.overflow = 'auto';
        }
    });
});

