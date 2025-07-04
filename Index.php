<?php
session_start();
require_once 'Config/Db_conn.php';
if( !isset($_SESSION['user_id'])) {
    header('Location: LogIn.php');
    exit();
}
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM usuarios WHERE idUser = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Debug temporal - borrar después
    error_log("Datos del usuario: " . print_r($row, true));
    
    $id= $row['idUser'];
    $user = $row['nombre'];
    $telefono = $row['telefeno'];
    $fechaNac = $row['fechaNac'];
    $rfc = $row['rfc'];
    $email = $row['correo'];
    $tipo = $row['tipo'];
    $img = $row['imgPath'];

    // Debug específico del nombre
    error_log("Nombre del usuario: " . $user);
    error_log("ID del usuario: " . $id);
    error_log("Ruta de imagen en BD: " . $img);
    error_log("Ruta completa: " . __DIR__ . '/' . $img);
} 

require_once'Components/Header.php'?>

<main>
     <div id="notification-area" class="notification-area" style="display: none;">
    </div>
<div class="Perfil-cont">
<h1>Perfil <?php echo $tipo;?> de <?php echo $user;?></h1>

<div class="Data_user">
    <div class="imgSecc">
        <?php 
        // Verificar si la imagen existe, si no, usar una por defecto
        $imgPath = $img;
        if (!file_exists($imgPath) || empty($imgPath)) {
            $imgPath = "IMG/default.webp";
        }
        ?>
        <img src="<?php echo $imgPath; ?>" alt="avatar del usuario" onerror="this.src='IMG/default.webp'">
    </div>
    <div class="info">
       
 <div class="data-info"><h4>Nombre completo:</h4> <span><?php echo $user; ?></span></div>
<div class="data-info"><h4>Tipo de usuario:</h4> <span><?php echo $tipo; ?></span></div>
<div class="data-info"><h4>Teléfono:</h4> <span><?php echo $telefono; ?></span></div>
<div class="data-info"><h4>Fecha de nacimiento: </h4> <span><?php echo $fechaNac; ?></span></div>
<div class="data-info"><h4>RFC:</h4> <span><?php echo $rfc; ?></span></div>
<div class="data-info"><h4>Correo:</h4> <span><?php echo $email; ?></span></div>
</div>
<div class="botonesEdit">
<button class="btnStaff logout" onclick="window.location.href='Backend/LogOut.php'"><i class="fa-solid fa-right-from-bracket"></i> Salir</button>
<?php if ($tipo === 'Administrador') { ?>
<button class="btnStaff base" onclick="window.location.href='EditUser.php?id=<?php echo $user_id; ?>'"><i class="fa-solid fa-user-pen"></i> Editar Perfil</button>
<?php } ?></div>
</div>
</div>

</main>


<?php require_once 'Components/termino.php'?>