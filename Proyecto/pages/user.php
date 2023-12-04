<!DOCTYPE html>

<?php

session_start();

include('../scripts/conexionBD.php');

//Comprobar si la sesión esta iniciada
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
}
?>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Cards</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/user.css">
    </head>
    <body>
    <div class="nav">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container cont">
                    <a class="navbar-brand title" href="#">EncuentraTuLibro</a>                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="d-flex div_boton">
                            <p class="p">Usuario: <span> <?php
                                    if (isset($_SESSION['user'])) {
                                        echo $_SESSION['user'];
                                    }
                                    ?></span>
                            </p>

                            <form method="POST" action="../pages/logout.php">
                                <button class="btn btn-outline-danger" name="cerrar_sesion">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    <div class="main">
        <?php
        cardBook($cadenaConexion);
        ?>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>
