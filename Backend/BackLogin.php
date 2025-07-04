<?php
// Conexión a la base de datos
require '../Config/Db_conn.php';
session_start(); // Iniciar la sesión para manejar la autenticación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtenemos los datos del formulario de inicio de sesión
    $Email = mysqli_real_escape_string($conn, $_POST['user_mail']);
    $password = trim($_POST['password_user']);
if(empty($Email) || empty($password)) {
        header('Location: ../LogIn.php?error=empty_fields');
        exit(); 
    }
    // Consulta para buscar el usuario por nombre de usuario o correo electrónico
    $query = "SELECT * FROM usuarios WHERE correo = ? AND estado=1"; // Aseguramos que el usuario esté activo (estado=1)
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $Email);
mysqli_stmt_execute($stmt);

// 2. Obtener resultados
$resultado = mysqli_stmt_get_result($stmt);


    if (mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
    
        if (password_verify($password, $row['contraseña'])) {
            $_SESSION['user_id'] = $row['idUser'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_role'] = $row['tipo'];
        
            if ($row['tipo'] === 'administrador') {
                header("Location: ../Consulta.php?success=login_success&username=" . urlencode($_SESSION['user_name']));
            }else{
                header("Location: ../Index.php?success=login_success&username=" . urlencode($_SESSION['user_name']));
            }
            exit(); 
        }
         else {
            header('Location: ../LogIn.php?error=password');
          exit(); 
        }
    } else {
        // Usuario o correo no encontrado
        header('Location: ../LogIn.php?error=user_not_found');
        exit(); 
    }
}

mysqli_close($conn);
?>
