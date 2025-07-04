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
} 

require_once'Components/Header.php'?>

<main>
<div class="Perfil-cont">
<h1>Perfil <?php echo $tipo;?> de <?php echo $user;?></h1>

<div class="Data_user">
    <div class="imgSecc">
    <img src="<?php echo $img;?>" alt="avatar del usuario"></div>
    <div class="info">
<h4>Nombre completo:</h4> <span><?php echo $user; ?></span>
<h4>Tipo de usuario:</h4> <span><?php echo $tipo; ?></span>
<h4>Teléfono:</h4> <span><?php echo $telefono; ?></span>
<h4>Fecha de nacimiento:</h4> <span><?php echo $fechaNac; ?></span>
<h4>RFC:</h4> <span><?php echo $rfc; ?></span>
<h4>Correo:</h4> <span><?php echo $email; ?></span>
</div>

<button class="btnStaff logout" onclick="window.location.href='Backend/LogOut.php'"><i class="fa-solid fa-right-from-bracket"></i> Salir</button>

</div></div>

</main>




<script src="JS/Modo_oscuro.js"></script>