<?php 
session_start();
require_once 'Config/Db_conn.php';

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: LogIn.php');
    exit();
}
$user_id = $_SESSION['user_id'];
// Verificar que sea administrador
if ($_SESSION['user_role'] !== 'Administrador') {
    header('Location: Index.php?error=not_authorized');
    exit();
}
// Verificar que se haya enviado un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: Consulta.php?error=missing_id');
    exit();
}

$id_user_ext = intval($_GET['id']);
if($id_user_ext == $user_id){ 
    header('Location: Index.php');
    exit();
}

$query = "SELECT * FROM usuarios WHERE idUser = ? AND estado = 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_user_ext);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) === 0) {
    header('Location: Consulta.php?error=user_not_found');
    exit();
}else{
$row = mysqli_fetch_assoc($result);
$id_user_ext = $row['idUser'];
$user_ext = $row['nombre'];
$telefono_ext = $row['telefeno'];
$fechaNac_ext = $row['fechaNac'];
$rfc_ext = $row['rfc'];
$email_ext = $row['correo'];
$tipo_ext = $row['tipo'];
$img_ext = $row['imgPath'];

// Verificar si la imagen existe, si no usar una por defecto
if (empty($img_ext) || !file_exists($img_ext)) {
    $img_ext = "IMG/default.webp";
}
}

mysqli_stmt_close($stmt);

require_once'Components/Header.php'?>





<main>
     <div id="notification-area" class="notification-area" style="display: none;">
    </div>
<div class="Perfil-cont">
<h1>Perfil <?php echo $tipo_ext;?> de <?php echo $user_ext;?></h1>

<div class="Data_user">
    <div class="imgSecc">
        <img src="<?php echo $img_ext; ?>" alt="avatar del usuario" onerror="this.src='IMG/default.webp'">
    </div>
    <div class="info">
       
 <div class="data-info"><h4>Nombre completo:</h4> <span><?php echo $user_ext; ?></span></div>
<div class="data-info"><h4>Tipo de usuario:</h4> <span><?php echo $tipo_ext; ?></span></div>
<div class="data-info"><h4>Teléfono:</h4> <span><?php echo $telefono_ext; ?></span></div>
<div class="data-info"><h4>Fecha de nacimiento: </h4> <span><?php echo $fechaNac_ext; ?></span></div>
<div class="data-info"><h4>RFC:</h4> <span><?php echo $rfc_ext; ?></span></div>
<div class="data-info"><h4>Correo:</h4> <span><?php echo $email_ext; ?></span></div>
</div>
<div class="botonesEdit">
<button class="btnStaff logout" onclick="eliminarEmpleado(<?php echo $id_user_ext; ?>)"> Baja</button>
<?php if ($_SESSION['user_role'] === 'Administrador') { ?>
<button class="btnStaff base" onclick="window.location.href='EditUser.php?id=<?php echo $id_user_ext; ?>'"><i class="fa-solid fa-user-pen"></i> Editar Perfil</button>
<?php } ?></div>
</div>
</div>

</main>
<script src="JS/Alerts.js"></script>
<script>
function eliminarEmpleado(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este empleado?')) {
        fetch(`Backend/BackEliminarEmpleado.php?id=${id}`, {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                if (typeof showNotification === 'function') {
                    showNotification('Empleado eliminado correctamente.', 'success');
                }
                // Redirigir a la página de consulta después de 2 segundos
                setTimeout(() => {
                    window.location.href = 'Consulta.php';
                }, 2000);
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
}</script>
<?php require_once 'Components/termino.php'?>