<?php
session_start();
include('conexion.php'); // Conexión a la BD

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // se utiliza para sanitizar (limpiar) los datos ingresados por el usuario antes de ser usados en una consulta SQL
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = $_POST['password'];

    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $query);
//  devuelve el número de filas en un conjunto de resultados.
// Es especialmente útil cuando quieres saber cuántos registros han sido retornados por una consulta
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $user = mysqli_fetch_assoc($resultado);

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['rol'] = $user['rol'];

            // Redirigir según el rol
            if ($user['rol'] == 'admin') {
                // La función header() en PHP permite enviar encabezados HTTP al navegador,
                // antes de que se envíe cualquier tipo de salida (como texto, HTML, o incluso espacios en blanco).
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "<div class='alert alert-danger'>Contraseña incorrecta</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Usuario no encontrado</div>";
    }
}

mysqli_close($conexion);
?>

