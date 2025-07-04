<?php
session_start();
require_once 'Config/Db_conn.php';

echo "<h2>Debug de Imágenes</h2>";

// Verificar imágenes en la base de datos
$query = "SELECT idUser, nombre, imgPath FROM usuarios WHERE estado = 1";
$result = mysqli_query($conn, $query);

echo "<h3>Imágenes en la Base de Datos:</h3>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Ruta en BD</th><th>Archivo Existe</th><th>Vista Previa</th></tr>";

while($row = mysqli_fetch_assoc($result)) {
    $exists = file_exists($row['imgPath']) ? "✅ Sí" : "❌ No";
    $preview = file_exists($row['imgPath']) ? "<img src='{$row['imgPath']}' width='50' height='50' style='border-radius: 50%;'>" : "Sin imagen";
    
    echo "<tr>";
    echo "<td>{$row['idUser']}</td>";
    echo "<td>{$row['nombre']}</td>";
    echo "<td>{$row['imgPath']}</td>";
    echo "<td>{$exists}</td>";
    echo "<td>{$preview}</td>";
    echo "</tr>";
}
echo "</table>";

// Verificar archivos en el directorio
echo "<h3>Archivos en el Directorio img/:</h3>";
$files = scandir('img');
foreach($files as $file) {
    if($file != '.' && $file != '..') {
        $fullPath = 'img/' . $file;
        $fileSize = filesize($fullPath);
        echo "<p>{$file} - Tamaño: {$fileSize} bytes - <img src='{$fullPath}' width='50' height='50' style='border-radius: 50%;'></p>";
    }
}
?>
