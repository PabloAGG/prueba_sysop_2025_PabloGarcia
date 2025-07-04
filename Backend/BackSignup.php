<?php
require '../Config/Db_conn.php';
//Obtenemos los datos del formulario y aplicamos seguridad
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreCompleto = mysqli_real_escape_string($conn, $_POST['nombre_completo']);
    $email = mysqli_real_escape_string($conn, $_POST['email_usuario']);
    $contraseña = password_hash($_POST['contraseña_usuario'], PASSWORD_DEFAULT);
    $fechaNacimiento = $_POST['fecha_usuario'];
    $rol = $_POST['rol_usuario'];
    $rfc = mysqli_real_escape_string($conn, $_POST['rfc_usuario']);
    $telefono = mysqli_real_escape_string($conn, $_POST['telefono_usuario']);


    $check_query = "SELECT idUser FROM usuarios WHERE correo = ? AND estado=1";
     // Verificar si el nombre de usuario o el correo electrónico ya existen
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_store_result($check_stmt);
   

    if (mysqli_stmt_num_rows($check_stmt) > 0) {
        mysqli_stmt_close($check_stmt);
        header("Location: ../SignUp.php?error=email_exists");
        exit();
    }
    
if (empty($nombreCompleto) || empty($email) || empty($contraseña) || empty($fechaNacimiento) || empty($rol) || empty($rfc) || empty($telefono)) {
        header("Location: ../SignUp.php?error=empty_fields");
        exit();
    }

    if(empty($_FILES["imgRuta"]["name"])) {
        $rutaFinal = "IMG/default.webp"; // Ruta por defecto si no se sube una imagen
    } else {
        // Crear la ruta final antes de mover el archivo
        $rutaDestino = "../IMG/";
        $nombreArchivo = basename($_FILES["imgRuta"]["name"]);
        $uniqueId = uniqid(); // Generar UNA SOLA VEZ el ID único
        $rutaCompleta = $rutaDestino . $uniqueId . "_" . $nombreArchivo;
        $rutaFinal = "IMG/" . $uniqueId . "_" . $nombreArchivo; // Ruta relativa para la BD
        
        if(move_uploaded_file($_FILES["imgRuta"]["tmp_name"], $rutaCompleta)) {
            // La imagen se ha subido correctamente
            error_log("Imagen subida correctamente a: " . $rutaCompleta);
            error_log("Ruta guardada en BD: " . $rutaFinal);
        } else {
            header("Location: ../SignUp.php?error=image_upload_error");
            exit();
        }
    }

 $query = "INSERT INTO usuarios (nombre, telefeno, fechaNac, rfc, correo, contraseña, tipo, imgPath)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ssssssss", $nombreCompleto, $telefono, $fechaNacimiento, $rfc, $email, $contraseña, $rol, $rutaFinal);
$result = mysqli_stmt_execute($stmt);
    if ($result) {
        header('Location: ../SignUp.php?success=user_created');
        exit();
    } else {
        header("Location: ../SignUp.php?error=user_not_created");
        exit();
    }

    }

// Cerramos la conexión
mysqli_close($conn);
?>


