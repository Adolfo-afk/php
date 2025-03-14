<?php
session_start();
include('conexion.php'); // Asegúrate de que este archivo contiene la conexión correcta

$error = ""; // Variable para manejar errores

// Verificar conexión
$server = "localhost:3307";
$db_name = "faunacompleja";
if ($conexion) {
    $conexion_msg = "Conexión exitosa a la base de datos '$db_name' en el servidor '$server'";
} else {
    $conexion_msg = "Error al conectar a la base de datos '$db_name'";
}

// Manejo del formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = md5($_POST['password']); // Cifrar la contraseña con MD5 

    // Consulta SQL para verificar usuario
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
    $resultado = mysqli_query($conexion, $query);
    $user = mysqli_fetch_assoc($resultado);

    if ($user) {
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];

        // Establecer cookies para recordar al usuario (opcional)
        if (isset($_POST['remember'])) {
            setcookie('usuario', $user['usuario'], time() + (86400 * 30), "/"); // Expira en 30 días
            setcookie('rol', $user['rol'], time() + (86400 * 30), "/");
        }

        header("Location: " . ($user['rol'] == 'admin' ? "admin.php" : "index.php"));
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// Manejo del formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = md5($_POST['password']); // Cifrar la contraseña con MD5
    $confirm_password = md5($_POST['confirm_password']);

    // Verificar si el usuario ya existe
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($resultado) > 0) {
        $error = "El nombre de usuario ya está registrado.";
    } else {
        if ($password === $confirm_password) {
            // Asignar un rol por defecto 'user' al momento de registrar
            $rol = 'user'; // O puedes personalizarlo dependiendo de los requisitos
            
            // Consulta de inserción
            $query = "INSERT INTO usuarios (usuario, password, rol) VALUES ('$usuario', '$password', '$rol')";
            if (mysqli_query($conexion, $query)) {
                // Obtener el último ID insertado y verificar que el rol se insertó correctamente
                $last_id = mysqli_insert_id($conexion);  // Obtener el último ID insertado
                $query = "SELECT usuario, rol FROM usuarios WHERE id = '$last_id'";  // Asegurarse de obtener el rol correctamente
                $resultado = mysqli_query($conexion, $query);
                $user = mysqli_fetch_assoc($resultado);
                
                // Mostrar el rol del nuevo usuario para confirmar que se insertó
                $_SESSION['usuario'] = $usuario;
                $_SESSION['rol'] = $user['rol']; // Guardar el rol del usuario registrado

                // Mostrar el rol del nuevo usuario para confirmar que se insertó
                $success_message = "Usuario registrado exitosamente con el rol: " . $user['rol'];

                header("Location: index.php?message=registered"); // Redirigir tras registro exitoso
                exit();
            } else {
                $error = "Error al registrar el usuario. Intenta de nuevo.";
            }
        } else {
            $error = "Las contraseñas no coinciden.";
        }
    }
}

// Si el usuario ya tiene cookies, se autologea
if (isset($_COOKIE['usuario']) && isset($_COOKIE['rol'])) {
    $_SESSION['usuario'] = $_COOKIE['usuario'];
    $_SESSION['rol'] = $_COOKIE['rol'];
}

$showRegisterForm = isset($_GET['register']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            transition: transform 0.3s ease-in-out;
        }
        .login-container:hover {
            transform: scale(1.05);
        }
        .login-container h2 {
            font-size: 30px;
            color: #667eea;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .form-control {
            border-radius: 5px;
            border-color: #ddd;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
        }
        .btn-primary {
            width: 100%;
            font-size: 18px;
            padding: 12px;
            border-radius: 5px;
            background: #667eea;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #4c6ce2;
        }
        .alert {
            margin-top: 15px;
        }
        .register-link {
            color: #667eea;
            font-size: 14px;
            text-decoration: none;
            margin-top: 10px;
            display: block;
        }
        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <?php if ($showRegisterForm): ?>
        <h2 class="text-center">Registrar Cuenta</h2>
        <form method="POST">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Contraseña:</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary">Registrar</button>
            <a href="index.php" class="register-link">¿Ya tienes cuenta? Inicia sesión</a>
        </form>
    <?php else: ?>
        <h2 class="text-center">Iniciar Sesión</h2>
        <form method="POST">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Ingresar</button>
            <a href="?register=true" class="register-link">¿No tienes cuenta? Regístrate</a>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
