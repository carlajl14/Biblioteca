<?php

// Iniciar o reanudar la sesión
session_start();

// Verificar si se ha enviado el formulario de cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    // Destruir todas las variables de sesión
    session_unset();

    // Destruir la sesión
    session_destroy();

    // Establecer la cookie de sesión con una fecha de expiración pasada (eliminando la cookie)
    setcookie(session_name(), '', time() - 3600, '/');

    // Redirigir al usuario a la página indicada (index.php en este caso)
    header('Location: ../index.php');
    exit();
}
?>
