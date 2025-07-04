<?php
session_start();
require_once '../Config/Db_conn.php';

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autenticado']);
    exit();
}

// Verificar que sea administrador
if ($_SESSION['user_role'] !== 'Administrador') {
    http_response_code(403);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

// Verificar que se haya enviado un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de empleado requerido']);
    exit();
}

$empleado_id = intval($_GET['id']);

// Verificar que el empleado exista y esté activo
$check_query = "SELECT idUser FROM usuarios WHERE idUser = ? AND estado = 1";
$check_stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($check_stmt, "i", $empleado_id);
mysqli_stmt_execute($check_stmt);
mysqli_stmt_store_result($check_stmt);

if (mysqli_stmt_num_rows($check_stmt) === 0) {
    mysqli_stmt_close($check_stmt);
    http_response_code(404);
    echo json_encode(['error' => 'Empleado no encontrado']);
    exit();
}

mysqli_stmt_close($check_stmt);

// Eliminar empleado (cambiar estado a 0)
$delete_query = "UPDATE usuarios SET estado = 0 WHERE idUser = ?";
$delete_stmt = mysqli_prepare($conn, $delete_query);
mysqli_stmt_bind_param($delete_stmt, "i", $empleado_id);

if (mysqli_stmt_execute($delete_stmt)) {
    mysqli_stmt_close($delete_stmt);
    mysqli_close($conn);
    
    echo json_encode([
        'success' => true,
        'message' => 'Empleado eliminado correctamente'
    ]);
} else {
    mysqli_stmt_close($delete_stmt);
    mysqli_close($conn);
    
    http_response_code(500);
    echo json_encode(['error' => 'Error al eliminar el empleado']);
}
?>
