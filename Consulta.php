<?php
session_start();
require_once 'Config/Db_conn.php';

require_once'Components/Header.php'?>
<main>
    <div id="notification-area" class="notification-area" style="display: none;">
    </div>
    <div class="search-container">
        <form action="Backend/BackConsulta.php" method="post" class="form-consulta">

            <div class="contenedor-input">
                <input type="text" name="consulta_empleado" placeholder="" required>
                <label for="consulta_empleado">Consulta de Empleado</label>
            </div>
<!-- 
            <div class="btn-container">
                <button type="submit" class="btnStaff base" title="Buscar"><i class="fa-solid fa-search"></i></button>
            </div> -->

        </form>
    </div>
<div class="lista_users container mt-4">
    <h2>Empelados activos</h2>
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle ">
        <thead>
            <tr>
                <th>Foto de Perfil</th>
                <th>Nombre</th>
                <th>RFC</th>
                <th>Tipo de Usuario</th>
                <th>Acciones</th>
                <th> Ver mas</th>
                
            </tr>
        </thead>
        <tbody>
          
        </tbody>
    </table>
    
    <!-- Controles de paginación -->
    <div class="pagination-container d-flex justify-content-between align-items-center mt-3">
        <div class="pagination-info">
            <span id="pagination-info">Mostrando 0 de 0 empleados</span>
        </div>
        <div class="pagination-controls">
            <button id="prev-btn" class="btn btn-outline-primary btn-sm" disabled>
                <i class="fa-solid fa-chevron-left"></i> 
            </button>
            <span id="page-info" class="mx-3"> 1 de 1</span>
            <button id="next-btn" class="btn btn-outline-primary btn-sm" disabled>
                 <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
        <div class="pagination-size">
            <select id="page-size" class="form-select form-select-sm" style="width: auto;">
                <option value="5">5 por página</option>
                <option value="10">10 por página</option>
                <option value="25">25 por página</option>
                <option value="50">50 por página</option>
            </select>
        </div>
    </div>
</div>
</div>

</main>

<script src="JS/consulta.js"></script>
<script src="JS/Alerts.js"></script>
<?php require_once'Components/termino.php'?>