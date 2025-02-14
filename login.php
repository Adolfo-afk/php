<?php
session_start();
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];

    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $contraseña = mysqli_real_escape_string($conexion, $_POST['contraseña']);

    if (empty($email) || empty($contraseña)) {
        $errores[] = 'Ambos campos son obligatorios.';
    }

    if (empty($errores)) {
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($resultado) == 1) {
            $usuario = mysqli_fetch_assoc($resultado);

            // Verificar la contraseña
            if (password_verify($contraseña, $usuario['contraseña'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                header('Location: index.php'); // Redirige a la página principal (ajusta según lo que quieras)
                exit();
            } else {
                $errores[] = 'Contraseña incorrecta.';
            }
        } else {
            $errores[] = 'Usuario no encontrado.';
        }
    }

    if (!empty($errores)) {
        echo "<div class='alert alert-warning'>" . implode("<br>", $errores) . "</div>";
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Iniciar Sesión</h2>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="contraseña">Contraseña:</label>
            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>
    <p class="mt-3">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
