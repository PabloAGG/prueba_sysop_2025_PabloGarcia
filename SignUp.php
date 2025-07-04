<?php require_once'Components/Header.php'?>

<main>
     <div id="notification-area" class="notification-area" style="display: none;">
    </div>
<div class="form-container">
 <h2>Registra Nuevos Empleados</h2>

        <form action="Backend/BackSignup.php" method="post" enctype="multipart/form-data" >

        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-signature"></i></span>
            <input type="text" name="nombre_completo" placeholder="" required>
            <label for="nombre_completo">Nombre completo</label>
        </div>

        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-phone"></i></span>
            <input type="tel" name="telefono_usuario" placeholder="" required pattern="[0-9]{10}">
            <label for="telefono">Teléfono</label>
        </div>
        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-id-card"></i></span>
            <input type="text" name="rfc_usuario" placeholder="" required pattern="[A-Z]{4}[0-9]{6}[A-Z0-9]{3}">
            <label for="rfc_usuario">RFC</label>
        </div>

        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-cake-candles"></i></span>
            <input type="date" name="fecha_usuario" placeholder="" required>
            <label for="fecha_usuario">Fecha de nacimiento</label>
        </div>
        
  <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" name="email_usuario" placeholder="" required>
            <label for="email_usuario">Correo</label>
        </div>

        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-lock"></i></span>
            <input type="password" name="contraseña_usuario" placeholder="" required>
            <label for="contraseña_usuario">Contraseña</label>
        </div>

        <div class="contenedor-input">
    <span class="icono"><i class="fa-solid fa-user-group"></i></span>
    <select name="rol_usuario" id="rol_usuario" required>
        <option value="" disabled selected hidden></option>
        <option value="empleado">Empleado</option>
        <option value="ejecutivo">Ejecutivo</option>
        <option value="administrador">Administrador</option>s
    </select>
    <label for="rol_usuario">Rol de usuario</label>
</div>

        <div class="contenedor-input image-upload">
             <span class="icono"><i class="fa-solid fa-image"></i></span>
             <label for="imgRuta">Foto de Perfil:</label>  
             <br>
             <div class="image-preview-container">
                <img id="imgPerfil" src="#" alt="Vista previa de la imagen" style="display: none;">
             </div>
             <input class="inputImgPerfil" type="file" id="imgRuta" name="imgRuta" accept="image/*" onchange="previewImage()">
        </div>
        
        <div class="btn-container">
            <button type="submit" class="btnStaff base">Registrarme</button>
        </div>
  
        </form>

</div>

</main>

<script src="JS/validaciones.js"></script>
<?php require_once'Components/footer.php'?>