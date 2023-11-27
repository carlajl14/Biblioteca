<!DOCTYPE html>

<?php

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    include './scripts/conexionBD.php';
    iniciarSesion($cadenaConexion);
}

if(isset($_SESSION['user']) && isset($_SESSION['Rol'])) {
    switch($_SESSION['Rol']){
        case 0:
            header("Location: pages/register.php");
            break;
        case 1:
            header("Location: pages/admin.php");
            break;
        }
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <div class="wrapper">
        <form action="" class="form" method="POST">
            <h1 class="title">Inicio</h1>
            <div cLass="inp">
                <input type="text" name="user" class="input" placeholder="Usuario">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="inp">
                <input type="password" name="pass" class="input" placeholder="Contraseña">
                <i class="fa-solid fa-lock"></i>
            </div>
            <button name="enviar" cLass="submit">Iniciar Sesión</button>
            <p class="footer">¿No tienes cuenta?<a href="pages/register.php" class="link"> Por favor, Registrate</a></p>
        </form>
        <div></div>
        <div class="banner">
            <h1 class="wel_text">BIENVENIDO<br/></h1>
            <p class="para">Inicia sesión</p>
        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>
