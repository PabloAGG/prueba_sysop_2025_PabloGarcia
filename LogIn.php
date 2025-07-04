<?php require_once'Components/Header.php'?>
<main>
    <div id="notification-area" class="notification-area" style="display: none;">
    </div>
<div class="form-login-container">
    <section class="secc-login">
     <img src="img/icon.png" alt="logo icono" class="logo-icon">
        <h2>Inicia sesión</h2>
    </section>
<form action="Backend/BackLogin.php" method="post">
   
    <p>Por favor, ingresa tus credenciales para acceder al sistema.</p>
         <div class="contenedor-input">
            <span class="icono"><i class="fa-solid fa-circle-user"></i></span>
            <input type="text" name="user_mail" id="user_mail" placeholder="" required>
            <label for="user_email">Correo</label>
        </div>
    <div class="contenedor-input">
       <span class="icono"><button type="button" title="ver contraseña" id="vercontraBtn"><i class="fa-solid fa-eye"></i></button></span>
        <input type="password" id="password_user" name="password_user" required>
         <label for="password_user">Contraseña:</label>
      
    </div>
     <div class="btn-container">
    <button type="submit" class="btnStaff base">Iniciar Sesión</button>
    </div>

</form>


</div>


</main>

<script src="JS/validarlogin.js"></script>
<?php require_once'Components/footer.php'?>