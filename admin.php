<?php
session_start();
// Verifica si la sesión del usuario no está establecida o si el rol no es 'admin'
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'admin') {
    // Redirige al usuario a la página de inicio de sesión si no cumple con los requisitos
    header("Location: login.php");
    exit(); // Detiene la ejecución del script para evitar que continúe cargando la página restringida
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url('https://wallup.net/wp-content/uploads/2016/01/175043-nature-animals-baby_animals-owl-depth_of_field-leaves.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 0;
        }
        .container {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            font-weight: bold;
        }
        .btn {
            font-size: 18px;
            padding: 12px;
            transition: 0.3s;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        .btn-logout {
            background: rgba(255, 0, 0, 0.7);
            border: none;
        }
        .btn-logout:hover {
            background: red;
        }
    </style>

</head>
<body>

<div class="container">
    <div class="card text-center">
        <h2 class="text-primary">Bienvenido, <?php echo $_SESSION['usuario']; ?> (Administrador)</h2>

        <!-- Menú de navegación -->
        <nav class="mt-4">
            <div class="d-grid gap-3">
                <a href="introducirDatos.php" class="btn btn-primary">📥 Introducir Datos</a>
                <a href="leerDatos.php" class="btn btn-success">📖 Leer Datos</a>
                <a href="modificarDatos.php" class="btn btn-warning">✏️ Modificar Datos</a>
                <a href="eliminarDatos.php" class="btn btn-danger">🗑️ Eliminar Datos</a>
                <a href="insertarTrabajadores.php" class="btn btn-info">👨‍💼 Agregar Administrador</a> <!-- Nuevo botón -->
                <a href="verUsuarios.php" class="btn btn-secondary">👀 Ver Usuarios</a> <!-- Nuevo botón -->
            </div>
        </nav>

        <!-- Botón de cierre de sesión -->
        <a href="logout.php" class="btn btn-logout text-white mt-4">🚪 Cerrar sesión</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

