<?php
session_start();

// Eliminar las cookies de sesión
setcookie('user_name', '', time() - 3600, "/"); // Elimina la cookie 'user_name'
setcookie('user_id', '', time() - 3600, "/");   // Elimina la cookie 'user_id'
setcookie('user_img', '', time() - 3600, "/");   // Elimina la cookie 'user_img'
setcookie('user_role', '', time() - 3600, "/"); // Elimina la cookie 'user_role'


session_destroy();

// Redirigir al usuario al login o a la página principal
header('Location:../LogIn.php'); 
exit();
?>
