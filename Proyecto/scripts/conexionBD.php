<?php

$cadenaConexion = 'mysql:dbname=biblioteca;host=127.0.0.1';

/**
 * Función para iniciar sesión y comprobar que se ha iniciado correctamente
 */
function iniciarSesion($cadenaConexion) {
    $user = $_POST['user'];
    $clave = $_POST['pass'];

    $bd = new PDO($cadenaConexion, 'root', '');

    $ini = $bd->prepare('select * from usuarios where Nombre = ? and Contraseña = sha1(?)');
    $ini->bindParam(1, $user);
    $ini->bindParam(2, $clave);
    $ini->execute();

    if($ini->rowCount() === 1) {
        $_SESSION['user'] = $user;

        foreach($ini as $rol) {
            $_SESSION["Rol"] = $rol["Rol"];
        }
    }
}

?>