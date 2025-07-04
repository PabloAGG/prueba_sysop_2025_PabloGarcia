<?php
session_start();
require_once 'Config/Db_conn.php';

$id_userExt= isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$id_userExt) {
    header("Location: Consulta.php");
    exit();
}
$query = "SELECT * FROM usuarios WHERE idUser = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_userExt);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) === 0) {
    header("Location: Consulta.php");
    exit(); 
} else {
    $row = mysqli_fetch_assoc($result);
    $nombre = $row['nombre'];
    $telefono = $row['telefeno'];   
    $fechaNac = $row['fechaNac'];
    $rfc = $row['rfc'];
    $email = $row['correo'];
    $tipo_ext = $row['tipo'];
    $img = $row['imgPath'];
}

 require_once'Components/Header.php'
?>

<main>
     <div id="notification-area" class="notification-area" style="display: none;">
    </div>
<div class="form-container">
 <h2>Actualiza Datos - <?php echo $nombre;?></h2>

        <form action="Backend/BackEditar.php" method="post" enctype="multipart/form-data" >

        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-signature"></i></span>
            <input type="text" name="nombre_completo" placeholder="" value="<?php echo $nombre;?>" required>
            <label for="nombre_completo">Nombre completo</label>
        </div>

        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-phone"></i></span>
            <input type="tel" name="telefono_usuario" placeholder="" value="<?php echo $telefono;?>" required pattern="[0-9]{10}">
            <label for="telefono">Teléfono</label>
        </div>
        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-id-card"></i></span>
            <input type="text" name="rfc_usuario" placeholder="" required value="<?php echo $rfc;?>" pattern="[A-Z]{4}[0-9]{6}[A-Z0-9]{3}">
            <label for="rfc_usuario">RFC</label>
        </div>

        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-cake-candles"></i></span>
            <input type="date" name="fecha_usuario" placeholder="" value="<?php echo $fechaNac;?>" required>
            <label for="fecha_usuario">Fecha de nacimiento</label>
        </div>
        
  <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" name="email_usuario" placeholder="" value="<?php echo $email;?>"required>
            <label for="email_usuario">Correo</label>
        </div>

        <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-lock"></i></span>
            <input type="password" name="contraseña_usuario" placeholder="">
            <label for="contraseña_usuario">Nueva Contraseña (dejar vacío para mantener la actual)</label>
        </div>

        <div class="contenedor-input">
    <span class="icono"><i class="fa-solid fa-user-group"></i></span>
    <select name="rol_usuario" id="rol_usuario" required>
        <option value="" disabled hidden>Selecciona un rol</option>
        <option value="empleado" <?php echo ($tipo_ext == 'empleado') ? 'selected' : ''; ?>>Empleado</option>
        <option value="ejecutivo" <?php echo ($tipo_ext == 'Ejecutivo') ? 'selected' : ''; ?>>Ejecutivo</option>
        <option value="administrador" <?php echo ($tipo_ext == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
    </select>
    <label for="rol_usuario">Rol de usuario</label>
</div>

        <div class="contenedor-input image-upload">
             <span class="icono"><i class="fa-solid fa-image"></i></span>
               
             <br>
             <div class="current-image-container">
                 <h5>Imagen actual:</h5>
                 <img src="<?php echo $img; ?>" alt="Imagen actual" class="current-image" onerror="this.src='img/default.webp'">
             </div>
             <div class="image-preview-container">
                <img id="imgPerfil" src="#" alt="Vista previa de la nueva imagen" style="display: none;">
             </div>
             <input class="inputImgPerfil" type="file" id="imgRuta" name="imgRuta" accept="image/*" onchange="previewImage()">
        <label for="imgRuta">Foto de Perfil:</label>
            </div>
        <input type="hidden" name="id_usuario" value="<?php echo $id_userExt; ?>">
        <div class="btn-container">
            <button type="submit" class="btnStaff base">Actualizar</button>
        </div>
  
        </form>

</div>

</main>


<script src="JS/validacionesED.js"></script>
<?php require_once'Components/termino.php'?>