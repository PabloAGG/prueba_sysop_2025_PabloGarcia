<?php
$host = "localhost";
$user = "root"; // Ajusta esto si tienes otro usuario
$password = ""; // Ajusta esto si tienes contraseña
$database = "SysOp_Prueba";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>
