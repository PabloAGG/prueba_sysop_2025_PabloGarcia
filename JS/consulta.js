document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="consulta_empleado"]');
    const tableBody = document.querySelector('.table tbody');
    const loadingMessage = '<tr><td colspan="6" class="text-center">Cargando empleados...</td></tr>';
    const noResultsMessage = '<tr><td colspan="6" class="text-center">No se encontraron empleados.</td></tr>';
    
    let searchTimeout;
    let allEmpleados = []; // Almacenar todos los empleados
    let currentPage = 1;
    let pageSize = 5;
    let filteredEmpleados = []; // Empleados filtrados por búsqueda

    // Función para realizar la búsqueda AJAX
    function searchEmpleados(searchTerm = '') {
        // Mostrar mensaje de carga
        if (tableBody) {
            tableBody.innerHTML = loadingMessage;
        }

        // Crear la URL con el parámetro de búsqueda
        const url = `Backend/BackConsultaAjax.php${searchTerm ? `?search=${encodeURIComponent(searchTerm)}` : ''}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    allEmpleados = data.empleados;
                    filteredEmpleados = allEmpleados;
                    currentPage = 1; // Resetear a la primera página
                    renderPaginatedEmpleados();
                } else {
                    console.error('Error en la respuesta:', data.error);
                    showError('Error al cargar los empleados.');
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                showError('Error de conexión. Intenta nuevamente.');
            });
    }

    // Función para renderizar empleados con paginación
    function renderPaginatedEmpleados() {
        if (!tableBody) return;

        if (filteredEmpleados.length === 0) {
            tableBody.innerHTML = noResultsMessage;
            updatePaginationInfo();
            return;
        }

        // Calcular índices para la paginación
        const startIndex = (currentPage - 1) * pageSize;
        const endIndex = startIndex + pageSize;
        const paginatedEmpleados = filteredEmpleados.slice(startIndex, endIndex);

        let html = '';
        paginatedEmpleados.forEach(empleado => {
            html += `
                <tr>
                    <td>
                        <img src="${empleado.imgPath}" 
                             alt="Foto de ${empleado.nombre}" 
                             class="profile-img-small"
                             onerror="this.src='IMG/default.webp'">
                    </td>
                    <td>${empleado.nombre}</td>
                    <td>${empleado.rfc}</td>
                    <td>
                        <span class="badge-tipo ${empleado.tipo.toLowerCase()}">${empleado.tipo}</span>
                    </td>
                    <td>
                        <button class="btn-action edit" 
                                onclick="editarEmpleado(${empleado.id})" 
                                title="Editar empleado">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button class="btn-action delete" 
                                onclick="eliminarEmpleado(${empleado.id})" 
                                title="Eliminar empleado">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                    <td>
                        <button class="btn-action view" 
                                onclick="verEmpleado(${empleado.id})" 
                                title="Ver detalles">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = html;
        updatePaginationInfo();
    }

    // Función para actualizar la información de paginación
    function updatePaginationInfo() {
        const totalEmployees = filteredEmpleados.length;
        const totalPages = Math.ceil(totalEmployees / pageSize);
        const startIndex = (currentPage - 1) * pageSize + 1;
        const endIndex = Math.min(currentPage * pageSize, totalEmployees);

        // Actualizar información
        const paginationInfo = document.getElementById('pagination-info');
        if (paginationInfo) {
            paginationInfo.textContent = `${totalEmployees > 0 ? startIndex : 0} a ${endIndex} de ${totalEmployees} empleados`;
        }

        const pageInfo = document.getElementById('page-info');
        if (pageInfo) {
            pageInfo.textContent = ` ${totalEmployees > 0 ? currentPage : 0} de ${totalPages}`;
        }

        // Actualizar botones
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        
        if (prevBtn) {
            prevBtn.disabled = currentPage <= 1;
        }
        
        if (nextBtn) {
            nextBtn.disabled = currentPage >= totalPages;
        }
    }

    // Función antigua para compatibilidad
    function renderEmpleados(empleados) {
        allEmpleados = empleados;
        filteredEmpleados = empleados;
        currentPage = 1;
        renderPaginatedEmpleados();
    }

    // Función para mostrar errores
    function showError(message) {
        if (tableBody) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger">${message}</td></tr>`;
        }
    }

    // Event listener para el input de búsqueda
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.trim();
            
            // Limpiar el timeout anterior
            clearTimeout(searchTimeout);
            
            // Establecer un nuevo timeout para evitar demasiadas peticiones
            searchTimeout = setTimeout(() => {
                searchEmpleados(searchTerm);
            }, 300); // Esperar 300ms después de que el usuario deje de escribir
        });

        // Prevenir el envío del formulario
        const form = searchInput.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                searchEmpleados(searchInput.value.trim());
            });
        }
    }

    // Cargar empleados al cargar la página
    searchEmpleados();

    // Exponer funciones globalmente para que puedan ser llamadas desde otros archivos
    window.searchEmpleados = searchEmpleados;
    window.renderPaginatedEmpleados = renderPaginatedEmpleados;

    // Event listeners para los controles de paginación
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const pageSizeSelect = document.getElementById('page-size');

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                renderPaginatedEmpleados();
            }
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            const totalPages = Math.ceil(filteredEmpleados.length / pageSize);
            if (currentPage < totalPages) {
                currentPage++;
                renderPaginatedEmpleados();
            }
        });
    }

    if (pageSizeSelect) {
        pageSizeSelect.addEventListener('change', function() {
            pageSize = parseInt(this.value);
            currentPage = 1; // Resetear a la primera página
            renderPaginatedEmpleados();
        });
    }
});

// Funciones para las acciones de los botones
function editarEmpleado(id) {
    window.location.href = `EditUser.php?id=${id}`;
}

function eliminarEmpleado(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este empleado?')) {
        fetch(`Backend/BackEliminarEmpleado.php?id=${id}`, {
            method: 'Get'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recargar la lista después de eliminar
                const searchInput = document.querySelector('input[name="consulta_empleado"]');
                const searchTerm = searchInput ? searchInput.value.trim() : '';
                searchEmpleados(searchTerm);
                
                // Mostrar mensaje de éxito
                if (typeof showNotification === 'function') {
                    showNotification('Empleado eliminado correctamente.', 'success');
                }
            } else {
                if (typeof showNotification === 'function') {
                    showNotification('Error al eliminar el empleado.', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof showNotification === 'function') {
                showNotification('Error de conexión.', 'error');
            }
        });
    }
}

function verEmpleado(id) {
    window.location.href = `PerfilExt.php?id=${id}`;
}

// function recargarEmpleados() {
//     const searchInput = document.querySelector('input[name="consulta_empleado"]');
//     const searchTerm = searchInput ? searchInput.value.trim() : '';
//     searchEmpleados(searchTerm);
// }