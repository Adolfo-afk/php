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
    
    // //$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    //$confirm_password = $_POST['confirm_password']; // No ciframos aquí todavía
    

    

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

        if ($user['rol'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// Manejo del formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    //tiene la función de sanitizar(limpiar o modificar) el dato ingresado por el usuario antes de insertarlo en una consulta SQL
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = md5($_POST['password']); // Cifrar la contraseña con MD5
    $confirm_password = md5($_POST['confirm_password']);
//password_verify($confirm_password, $password);  
    // Verificar si el usuario ya existe
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($resultado) > 0) {
        $error = "El nombre de usuario ya está registrado.";
    } else {
        if ($password === $confirm_password) {
            // Insertar nuevo usuario en la base de datos
            $query = "INSERT INTO usuarios (usuario, password, rol) VALUES ('$usuario', '$password', 'user')";
            if (mysqli_query($conexion, $query)) {
                $error = "Usuario registrado exitosamente. Puedes iniciar sesión ahora.";
            } else {
                $error = "Error al registrar el usuario. Intenta de nuevo.";
            }
        } else {
            $error = "Las contraseñas no coinciden.";
        }
    }
}

// Si el usuario ya tiene cookies, se autologea
//La función isset() se usa para verificar si una variable está definida y no es NULL
if (isset($_COOKIE['usuario']) && isset($_COOKIE['rol'])) {
    $_SESSION['usuario'] = $_COOKIE['usuario'];
    $_SESSION['rol'] = $_COOKIE['rol'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos similares a los anteriores */
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
            box-shadow: none;
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

        .conexion-msg {
            position: fixed;
            bottom: 20px;
            left: 20px;
            font-size: 14px;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 8px 12px;
            border-radius: 5px;
        }

        .forgot-password, .register-link {
            color: #667eea;
            font-size: 14px;
            text-decoration: none;
            margin-top: 10px;
            display: block;
        }

        .forgot-password:hover, .register-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 25px;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="text-center">Iniciar Sesión</h2>

    <?php if (!isset($_POST['register'])): ?>
        <!-- Formulario de login -->
        <form method="POST">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" name="usuario" class="form-control" id="usuario" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <div class="mb-3">
                <label for="remember" class="form-check-label">
                    <input type="checkbox" name="remember" id="remember"> Recordarme
                </label>
            </div>

            <button type="submit" name="login" class="btn btn-primary">Ingresar</button>

            
            <a href="?register=true" class="register-link">¿No tienes cuenta? Regístrate</a>
        </form>
    <?php endif; ?>

    <?php if (isset($_POST['register']) || isset($_GET['register'])): ?>
        <!-- Formulario de registro -->
        <form method="POST">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <h2 class="text-center">Registrar Cuenta</h2>

            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" name="usuario" class="form-control" id="usuario" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Contraseña:</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
            </div>

            <button type="submit" name="register" class="btn btn-primary">Registrar</button>

            
            <a href="?login=true" class="register-link">¿Ya tienes cuenta? Inicia sesión</a>
        </form>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
