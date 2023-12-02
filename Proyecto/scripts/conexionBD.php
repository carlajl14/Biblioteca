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

/**
 * Mostrar las tarjetas con los libros
 */

function cardBook($cadenaConexion) {
    $libros = ["1.jpg", "2.jpg", "3.jpg", "4.jpg", "5.jpg", "6.jpg", "7.jpg", "8.jpg", "9.jpg", "10.jpg", "11.jpg", "12.jpg"];

    $bd = new PDO($cadenaConexion, 'root', '');

    $mos = 'SELECT l.Id, l.Titulo, l.Autor, l.Editorial, l.ISBN, b.Nombre, lb.disponibilidad FROM libros_bibliotecas lb JOIN libros l ON (lb.Id_libro = l.Id) JOIN bibliotecas b ON (lb.Id_biblioteca = b.Id) ORDER BY lb.Id_libro';

    $cards = $bd->query($mos);

    foreach($cards as $card) {
        echo '<div class="card">';
        echo '<div class="box">';
        foreach($libros as $libro) {
            $foto = substr($libro, 0, 1);
            $image = substr($libro, 0, 2);
            if ($foto < 10 && $foto == $card['Id']) {
                echo '<img class="image" src="./../assets/images/' .$card['Id']. '.jpg">';
            } else {
                if ($image > 9 && $image == $card['Id']) {
                    echo '<img class="image" src="./../assets/images/' .$card['Id']. '.jpg">';
                }
            }
        }
        echo '<div class="box__container">';
        echo '<p class="box__title">Título: '.$card['Titulo']. '</p>';
        echo '<p class="box__title">Autor: '.$card['Autor']. '</p>';
        echo '<p class="box__title">Editorial: '.$card['Editorial']. '</p>';
        echo '<p class="box__title">ISBN: '.$card['ISBN']. '</p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="box__content">';
        echo '<p class="box__title">Nombre: '.$card['Nombre']. '</p>';
        echo '<div class="box__text">';
        echo '<h3 class="box__dis">Disponibilidad: '.$card['disponibilidad'].'</h3>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}


/**
 * Función para mostrar que libro y en que biblioteca esta disponible y el numero de ejemplares
 */
function getBooksLibrary($cadenaConexion) {
    $bd = new PDO($cadenaConexion, 'root', '');

    $ini = 'SELECT lb.Id_libro, l.Titulo, lb.Id_biblioteca, b.Nombre, lb.disponibilidad
                            FROM libros_bibliotecas lb 
                            JOIN libros l 
                            ON (lb.Id_libro = l.Id) JOIN bibliotecas b
                            ON (lb.Id_biblioteca = b.Id)
                            ORDER BY lb.Id_libro';
    $books_libraries = $bd->query($ini);

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

function FormInsertBookLibraries($cadenaConexion) {
    $bd = new PDO($cadenaConexion, 'root', '');

    $ini = $bd->prepare('SELECT * FROM LIBROS');
    $ls = $bd->query($ini);

    $lib = $bd->prepare('SELECT * FROM BIBLIOTECAS');
    $bs = $bd->query($lib);

    echo '<label for="exampleInputPassword1" class="form-label">Selecciona ID del Libro: </label>
          <select class="form-select" aria-label="Default select example" name="libro">';
    foreach ($ls as $l) {
        echo '<option value="' . $l['Id'] . '">' . $l['Id'] . ' - ' . $l['Titulo'] . '</option>';
    }
    echo '</select>'
    . '<label for="exampleInputPassword1" class="form-label">Selecciona ID de la Biblioteca: </label>
          <select class="form-select" aria-label="Default select example" name="biblioteca">';
    foreach ($bs as $b) {
        echo '<option value="' . $b['Id'] . '">' . $b['Id'] . ' - ' . $b['Nombre'] . '</option>';
    }
    echo '</select>';
    echo '<label for="exampleInputPassword1" class="form-label">Ejemplares disponibles: </label>'
    . '<input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="disponibilidad">'
    . '<button class="btn btn-outline-success" id="insertar" type="submit" name="insertar">Insertar Registro</button>';

    if (isset($_POST['insertar'])) {
        $id_Libro = $_POST['libro'];
        $id_Biblioteca = $_POST['biblioteca'];
        $disponibilidad = $_POST['disponibilidad'];
        InsertBookLibraries($cadenaConexion, $id_Libro, $id_Biblioteca, $disponibilidad);
    }
}

function InsertBookLibraries($cadenaConexion, $id_Libro, $id_Biblioteca, $disponibilidad) {
    $bd = new PDO($cadenaConexion, 'root', '');

    $inset = $bd->prepare('INSERT INTO libros_bibliotecas (id_libro, id_biblioteca, disponibilidad) VALUES (?,?,?);');
    $inset->bindParam(1, $id_Libro);
    $inset->bindParam(2, $id_Biblioteca);
    $inset->bindParam(3, $disponibilidad);
    $inset->execute();

    if ($inset->rowCount() == 1) {
        echo '<div class="mensaje">Registro Insertado</div>';
    } else {
        echo '<div class="mensaje rojo">Registro no insertado</div>';
    }
}

function FormUpdateBookLibraries(){
    echo '<form method="POST" action="../pages/admin.php">
    <label class="form-label">Selecciona ID del Libro: </label>
    <input type="number" class="form-control" name="libro">
    <label class="form-label">Selecciona ID de la Biblioteca: </label>
    <input type="number" class="form-control" name="biblioteca">
    <label class="form-label">Ejemplares disponibles: </label>
    <input type="number" class="form-control" name="disponibilidad">
    <button class="btn btn-outline-success boton" id="enviar" type="submit" name="enviar">Modificar</button>
        </form>';
}

function UpdateBookLibraries($cadenaConexion, $disponibilidad, $id_Libro, $id_Biblioteca){
    $bd = new PDO($cadenaConexion, 'root', '');
    
    $update = $bd->prepare('UPDATE libros_bibliotecas SET Disponibilidad = ? 
                            WHERE Id_libro = ? AND Id_biblioteca = ?;');
    $update->bindParam(1, $disponibilidad);
    $update->bindParam(2, $id_Libro);
    $update->bindParam(3, $id_Biblioteca);
    $update->execute();   

    if ($update->rowCount() == 1) {
        echo '<div class="mensaje">Registro modificado</div>';
    } else {
        echo '<div class="mensaje rojo">Registro No modificado</div>';
    }
}

?>