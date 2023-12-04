<?php

include('../scripts/conexionBD.php');

//Comprobar si los campos están vacíos o no
if(isset($_POST['registro'])) {
    if(!empty($_POST['nombre']) && !empty($_POST['pass'])) {
        registerUser($cadenaConexion);
    } else {
        echo '<div class="mensaje rojo">Faltan datos</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>

    <div class="wrapper">
        <form class="form" method="POST">
            <h1 class="title">Registro</h1>
            <div cLass="inp">
                <input type="text" name="nombre" class="input" placeholder="Nombre">
            </div>
            <div cLass="inp">
                <input type="text" name="user" class="input" placeholder="Usuario">
            </div>
            <div class="inp">
                <input type="password" name="pass" class="input" placeholder="Contraseña">
            </div>
            <button name="registro" cLass="submit">Registrarse</button>
            <p class="footer">Si ya tienes cuenta<a href="../index.php" class="link"> Por favor, Inicia Sesión</a></p>
        </form>
        <div></div>
        <div class="banner">
            <h1 class="wel_text">BIENVENID@<br></h1>
            <p class="para">Registrate para iniciar en la aplicación</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>