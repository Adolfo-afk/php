<?php
session_start();
include('conexion.php'); // Asegúrate de que este archivo contiene la conexión correcta

// Verificar conexión
if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Variable para manejo de errores
$error = "";

// Insertar nuevo trabajador
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_trabajador'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = md5($_POST['password']); // Cifrar la contraseña con MD5
    $rol = $_POST['rol'];

    // Verificar si el usuario ya existe
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($resultado) > 0) {
        $error = "El nombre de usuario ya está registrado.";
    } else {
        // Insertar nuevo trabajador en la base de datos
        $query = "INSERT INTO usuarios (usuario, password, rol) VALUES ('$usuario', '$password', '$rol')";
        if (mysqli_query($conexion, $query)) {
            $error = "Trabajador registrado exitosamente.";
        } else {
            $error = "Error al registrar el trabajador. Intenta de nuevo.";
        }
    }
}

// Consulta para obtener los trabajadores
$query = "SELECT id, usuario, rol FROM usuarios";
$result = mysqli_query($conexion, $query);

// Verificar si hay resultados
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Trabajadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 1200px;
        }
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        .form-container {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #667eea;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registrar Nuevo Trabajador</h2>
    <a href="admin.php" class="btn btn-primary mb-3">Volver al Panel Admin</a>

    <div class="form-container">
        <h3>Agregar Nuevo Trabajador</h3>
        <?php if ($error): ?>
            <div class="alert alert-warning"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre de Usuario:</label>
                <input type="text" name="usuario" class="form-control" id="usuario" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol:</label>
                <select name="rol" class="form-control" id="rol" required>
                    <option value="admin">Administrador</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>

            <button type="submit" name="add_trabajador" class="btn btn-success">Agregar Trabajador</button>
        </form>
    </div>

    <div class="table-container">
        <h3>Trabajadores Registrados</h3>
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Mostrar cada trabajador en la tabla
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["usuario"] . "</td>
                        <td>" . $row["rol"] . "</td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "No se encontraron trabajadores.";
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
