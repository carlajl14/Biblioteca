<?php

$cadenaConexion = 'mysql:dbname=biblioteca;host=127.0.0.1';

/**
 * Función para iniciar sesión y comprobar que se ha iniciado correctamente
 */
function iniciarSesion($cadenaConexion) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $bd = new PDO($cadenaConexion, 'root', '');

    $ini = $bd->prepare('select * from usuarios where Nombre = ? and Contraseña = sha1(?)');
    $ini->execute(array($user, $pass));

    if($ini->rowCount() === 1) {
        $_SESSION['user'] = $user;

        foreach($ini as $Rol) {
            if($Rol === 1) {
                header('Location: ./pages/admin.php');
            } else {
                header('Location: ./pages/inicio.php');
            }
        }
    }
}

?>