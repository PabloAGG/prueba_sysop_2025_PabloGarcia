<?php
session_start();
require_once '../Config/Db_conn.php';

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../LogIn.php');
    exit();
}

// Verificar que sea administrador
if ($_SESSION['user_role'] !== 'Administrador') {
    header('Location: ../Index.php?error=not_authorized');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $id_usuario = intval($_POST['id_usuario']);
    $nombreCompleto = mysqli_real_escape_string($conn, $_POST['nombre_completo']);
    $email = mysqli_real_escape_string($conn, $_POST['email_usuario']);
    $nuevaContraseña = $_POST['contraseña_usuario'];
    $fechaNacimiento = $_POST['fecha_usuario'];
    $rol = $_POST['rol_usuario'];
    $rfc = mysqli_real_escape_string($conn, $_POST['rfc_usuario']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono_usuario']);

    // Verificar que el usuario existe y obtener datos actuales
    $check_query = "SELECT * FROM usuarios WHERE idUser = ? AND estado = 1";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $id_usuario);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) === 0) {
        header("Location: ../Consulta.php?error=user_not_found");
        exit();
    }
    
    $current_user = mysqli_fetch_assoc($check_result);
    mysqli_stmt_close($check_stmt);

    // Validar campos obligatorios
    if (empty($nombreCompleto) || empty($email) || empty($fechaNacimiento) || empty($rol) || empty($rfc) || empty($telefono)) {
        header("Location: ../editUser.php?id=$id_usuario&error=empty_fields");
        exit();
    }

    // Verificar si el correo ya existe en otro usuario
    $email_check = "SELECT idUser FROM usuarios WHERE correo = ? AND idUser != ? AND estado = 1";
    $email_stmt = mysqli_prepare($conn, $email_check);
    mysqli_stmt_bind_param($email_stmt, "si", $email, $id_usuario);
    mysqli_stmt_execute($email_stmt);
    mysqli_stmt_store_result($email_stmt);

    if (mysqli_stmt_num_rows($email_stmt) > 0) {
        mysqli_stmt_close($email_stmt);
        header("Location: ../editUser.php?id=$id_usuario&error=email_exists");
        exit();
    }
    mysqli_stmt_close($email_stmt);

    // Preparar la actualización - usar valores actuales si no se cambian
    $contraseñaFinal = $current_user['contraseña']; // Mantener la actual
    $rutaFinal = $current_user['imgPath']; // Mantener la actual

    // Solo cambiar contraseña si se proporciona una nueva
    if (!empty($nuevaContraseña)) {
        $contraseñaFinal = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
    }

    // Solo cambiar imagen si se sube una nueva
    if (!empty($_FILES["imgRuta"]["name"])) {
        $rutaDestino = "../IMG/";
        $nombreArchivo = basename($_FILES["imgRuta"]["name"]);
        $uniqueId = uniqid(); // Generar UNA SOLA VEZ el ID único
        $rutaCompleta = $rutaDestino . $uniqueId . "_" . $nombreArchivo;
        $rutaFinalNueva = "IMG/" . $uniqueId . "_" . $nombreArchivo;

        // Verificar que es una imagen válida
        $imageFileType = strtolower(pathinfo($rutaCompleta, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (!in_array($imageFileType, $allowedTypes)) {
            header("Location: ../editUser.php?id=$id_usuario&error=invalid_image_type");
            exit();
        }

        if (move_uploaded_file($_FILES["imgRuta"]["tmp_name"], $rutaCompleta)) {
            // Eliminar imagen anterior si no es la imagen por defecto
            if ($current_user['imgPath'] !== 'IMG/default.webp' && file_exists('../' . $current_user['imgPath'])) {
                unlink('../' . $current_user['imgPath']);
            }
            $rutaFinal = $rutaFinalNueva;
        } else {
            header("Location: ../editUser.php?id=$id_usuario&error=image_upload_error");
            exit();
        }
    }

    // Actualizar usuario
    $query = "UPDATE usuarios SET nombre=?, telefeno=?, fechaNac=?, rfc=?, correo=?, contraseña=?, tipo=?, imgPath=? WHERE idUser=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssssi", $nombreCompleto, $telefono, $fechaNacimiento, $rfc, $email, $contraseñaFinal, $rol, $rutaFinal, $id_usuario);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: ../Consulta.php?success=user_updated");
        exit();
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: ../editUser.php?id=$id_usuario&error=update_failed");
        exit();
    }

} else {
    header("Location: ../Consulta.php");
    exit();
}
?>


