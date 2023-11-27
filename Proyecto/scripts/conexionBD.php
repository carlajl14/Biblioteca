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

function getAllUsers($cadenaConexion){
    $bd = new PDO($cadenaConexion, 'root', '');
    
    $stmt = $bd->prepare('SELECT Id, Nombre, Rol FROM USUARIOS');
    $stmt ->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($users as $user){
        echo '<tr>'
        . '<th scope="row">'.$user['Id'].'</th>'
        . '<td scope="row">'.$user['Nombre'].'</td>';
        if($user['Rol'] == 1){
            echo '<td scope="row"> Administrador </td>';
        }else{
            echo '<td scope="row"> Usuario </td>';
        }
        echo '<td scope="row">'
        . '<form method="POST" action="">'
                . '<input type="text" name="Nombre"  value="' . $user['Nombre'] . '" hidden/>'
                . '<button class="btn" id="eliminar" type="submit" name="eliminar">Eliminar</button>'
        . '</form>'
        . '</td>'
        . '<td>'
        . '<a href="Modificar">Modificar</a>'
        . '</td>'
        . '</tr>';
    }
}

?>