<?php
session_start();

include '../scripts/conexionBD.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/admin.css">
        <title>Insertar Registro</title>
    </head>
    <body>
        <div class="nav">
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">EncuentraTuLibro</a>                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="admin.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="insertar.php">Insertar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="modificar" name="modificar">Modificar</a>
                            </li>
                        </ul>
                        <div class="d-flex div_boton">
                            <p class="p">Administrador: <span> <?php
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
        <div class="container-xl mt-5 text-center">
            <h1 class="m-4 display-2">Insertar un nuevo registro</h1>
            <form method="POST">
                <?php
                FormInsertBookLibraries($cadenaConexion);                
                ?>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>