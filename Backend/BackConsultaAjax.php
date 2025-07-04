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

// Obtener el término de búsqueda
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Construir la consulta SQL
$query = "SELECT idUser, nombre, telefeno, rfc, correo, tipo, imgPath, fechaNac FROM usuarios WHERE estado = 1";
$params = [];
$types = "";

if (!empty($search)) {
    $query .= " AND (nombre LIKE ? OR rfc LIKE ? OR correo LIKE ? OR tipo LIKE ?)";
    $searchTerm = "%" . $search . "%";
    $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
    $types = "ssss";
}

$query .= " ORDER BY nombre ASC";

// Preparar y ejecutar la consulta
$stmt = mysqli_prepare($conn, $query);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$empleados = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Verificar si la imagen existe, si no usar una por defecto
    $imgPath = $row['imgPath'];
    if (!file_exists('../' . $imgPath) || empty($imgPath)) {
        $imgPath = 'img/default.webp';
    }
    
    $empleados[] = [
        'id' => $row['idUser'],
        'nombre' => $row['nombre'],
        'telefono' => $row['telefeno'],
        'rfc' => $row['rfc'],
        'correo' => $row['correo'],
        'tipo' => $row['tipo'],
        'imgPath' => $imgPath,
        'fechaNac' => $row['fechaNac']
    ];
}

// Cerrar la conexión
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Devolver los datos como JSON
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'empleados' => $empleados,
    'total' => count($empleados)
]);
?>
