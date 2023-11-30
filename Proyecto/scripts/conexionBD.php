<?php

$cadenaConexion = 'mysql:dbname=biblioteca;host=127.0.0.1';

/**
 * Iniciar sesión solo si no está activa
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Función para establecer la cookie de último acceso
 */
function establecerCookie() {
    if (!isset($_SESSION['user'])) {
        // Establecer la cookie si el usuario no tiene una sesión activa
        setcookie('ultimoAcceso', time(), time() + 86400); // Caduca en 24 horas
    }
}

/**
 *  Llamar a la función para establecer la cookie
 */
establecerCookie();

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

    if ($ini->rowCount() === 1) {
        $_SESSION['user'] = $user;

        foreach ($ini as $rol) {
            $_SESSION["Rol"] = $rol["Rol"];
        }
    } else {
        echo '<div class="mensaje rojo">Usuario o contraseña incorrectos</div>';
    }
}

/**
 * Función para recoger todos los usuarios y mostrarlos en una tabla
 */
function getAllUsers($cadenaConexion) {
    $bd = new PDO($cadenaConexion, 'root', '');

    $ini = $bd->prepare('SELECT * FROM USUARIOS');
    $ini->execute();
    $users = $ini->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        echo '<tr class="fs-5">'
        . '<th scope="row">' . $user['Id'] . '</th>'
        . '<td>' . $user['Nombre'] . '</td>';
        if ($user['Rol'] == 1) {
            echo '<td> Administrador </td>';
        } else {
            echo '<td> Usuario </td>';
        }
        echo '</tr>';
    }
}

/**
 * Función para mostrar todos los libros
 */
function getAllBooks($cadenaConexion) {
    $bd = new PDO($cadenaConexion, 'root', '');

    $ini = $bd->prepare('SELECT * FROM LIBROS');
    $ini->execute();
    $books = $ini->fetchAll(PDO::FETCH_ASSOC);

    foreach ($books as $book) {
        echo '<tr class="fs-5">'
        . '<th scope="row">' . $book['Id'] . '</th>'
        . '<td>' . $book['Titulo'] . '</td>'
        . '<td>' . $book['Autor'] . '</td>'
        . '<td>' . $book['Editorial'] . '</td>'
        . '<td>' . $book['ISBN'] . '</td>'
        . '</tr>';
    }
}

/**
 * Función para mostrar todas las bibliotecas
 */
function getAllLibrary($cadenaConexion) {
    $bd = new PDO($cadenaConexion, 'root', '');

    $ini = $bd->prepare('SELECT * FROM BIBLIOTECAS');
    $ini->execute();
    $libraries = $ini->fetchAll(PDO::FETCH_ASSOC);

    foreach ($libraries as $library) {
        echo '<tr class="fs-5">'
        . '<th scope="row">' . $library['Id'] . '</th>'
        . '<td>' . $library['Nombre'] . '</td>'
        . '<td>' . $library['Direccion'] . '</td>'
        . '<td>' . $library['Telefono'] . '</td>'
        . '</tr>';
    }
}

/**
 * Función para mostrar que libro y en que biblioteca esta disponible y el numero de ejemplares
 */
function getBooksLibrary($cadenaConexion) {
    $bd = new PDO($cadenaConexion, 'root', '');

    $ini = $bd->prepare('SELECT lb.Id_libro, l.Titulo, lb.Id_biblioteca, b.Nombre, lb.disponibilidad
                            FROM libros_bibliotecas lb 
                            JOIN libros l 
                            ON (lb.Id_libro = l.Id) JOIN bibliotecas b
                            ON (lb.Id_biblioteca = b.Id)
                            ORDER BY lb.Id_libro;');
    $ini->execute();
    $books_libraries = $ini->fetchAll(PDO::FETCH_ASSOC);

    foreach ($books_libraries as $book_library) {
        echo '<tr class="fs-5">'
        . '<th scope="row">' . $book_library['Id_libro'] . '</th>'
        . '<td>' . $book_library['Titulo'] . '</td>'
        . '<td>' . $book_library['Id_biblioteca'] . '</td>'
        . '<td>' . $book_library['Nombre'] . '</td>'
        . '<td>' . $book_library['disponibilidad'] . '</td>'
        . '<td>'
        . '<form method="POST" action="">'
        . '<input type="text" name="Id_libro"  value="' . $book_library['Id_libro'] . '" hidden/>'
        . '<input type="text" name="Id_biblioteca"  value="' . $book_library['Id_biblioteca'] . '" hidden/>'
        . '<button class="btn btn-outline-danger" id="eliminar" type="submit" name="eliminar">Eliminar</button>'
        . '</form>'
        . '</td>'
        . '</tr>';
    }
}

/**
 * Función para eliminar un registro de libro y biblioteca
 */
function deleteBooksLibraries($cadenaConexion, $IdLibro, $IdBiblioteca) {
    $bd = new PDO($cadenaConexion, 'root', '');

    /* echo '<div class="modal" tabindex="-1">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Modal title</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
      <form method="POST" action="">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      <button type="button" class="btn btn-primary" name="aceptar">Aceptar</button>
      </form>
      </div>
      </div>
      </div>
      </div>'; */

    $del = $bd->prepare('DELETE FROM LIBROS_BIBLIOTECAS WHERE Id_libro = ? AND id_biblioteca = ?');
    $del->bindParam(1, $IdLibro);
    $del->bindParam(2, $IdBiblioteca);
    $del->execute();

    if ($del->rowCount() === 0) {
        echo 'Registro eliminado';
    } else {
        echo 'Registro No eliminado';
    }
}

/**
 * Registro de usuario
 */
function registerUser($cadenaConexion) {
    $nombre = $_POST['nombre'];
    $contraseña = $_POST['pass'];

    $bd = new PDO($cadenaConexion, 'root', '');
    
    $ins = $bd->prepare('insert into usuarios (Nombre, Contraseña, Rol) VALUES (?, sha1(?), 0);');
    $ins->bindParam(1, $nombre);
    $ins->bindParam(2, $contraseña);
    $ins ->execute();

    if($ins->rowCount() == 1) {
        echo '<div class="mensaje">Usuario registrado</div>';
    } else {
        echo '<div class="mensaje rojo">Usuario no registrado</div>';
    }
}

?>