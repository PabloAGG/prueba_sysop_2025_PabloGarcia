<?php

 $user = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
 $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$tipo= isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StaffHub</title>
    <link rel="icon" href="./img/icon.png" type="image/png">
    <link rel="stylesheet" href="CSS/estilos_main.css">
    <link rel="stylesheet" href="CSS/estilos_perfil.css">
     <script src="https://kit.fontawesome.com/093074d40c.js" crossorigin="anonymous"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body class=""> 
    <header class="main-header">
        <?php if($tipo == 'administrador'): ?>
            <button
        class="hamburger
        onClick="toggleMenu()"
        aria-label="Menú de navegación"
        title="Menú"
      >
        <span />
        <span />
        <span />
      </button>
<nav  class="nav-links">
     <a class="nav-link" href="Index.php"><i class="fa-solid fa-user"></i> Mi perfil</a>
            <a class="nav-link" href="Consulta.php"><i class="fa-solid fa-list-check"></i> Gestion de Empleados</a>
             <a class="nav-link" href="Backend/LogOut.php"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
        <?php endif; ?>
        <div class="logo-container">
            <?php if($user_id): ?>
                <a href="Index.php" class="logo-link">
            
            <?php else: ?>
            <a href="LogIn.php" class="logo-link">
            <?php endif; ?>
                <img src="img/staffhub.png" alt="StaffHub Logo" class="logo-img">
            </a>
        </div>

        <div class="theme-switcher-container">
            <button id="theme-toggle" class="theme-toggle-btn">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </header>