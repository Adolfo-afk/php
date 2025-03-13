<?php
// Inicia la sesión para poder acceder a las variables de sesión
session_start();

// Destruye la sesión actual, eliminando todas las variables de sesión
session_destroy();

// Redirige al usuario a la página de inicio de sesión (login.php)
header("Location: login.php");

// Asegura que el script se detenga para evitar que se ejecute más código después de la redirección
exit();
?>