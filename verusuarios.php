<?php
session_start();
include('conexion.php'); // Asegúrate de que este archivo contiene la conexión correcta

// Verificar conexión
if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Consulta para obtener los usuarios
$query = "SELECT id, usuario, rol FROM usuarios";
$result = mysqli_query($conexion, $query);

// Verificar si hay resultados
if (mysqli_num_rows($result) > 0) {
    // Si hay usuarios, mostrar en tabla
    echo "<h2>Lista de Usuarios</h2>";
    echo "<table border='1' cellpadding='10'>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Rol</th>
            </tr>";

    // Mostrar cada usuario en la tabla
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["usuario"] . "</td>
                <td>" . $row["rol"] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron usuarios.";
}

// Cerrar la conexión
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .table-container {
            background: #fff;
            padding: 20px;
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

<div class="container table-container">
    <h2>Usuarios Registrados</h2>
    <a href="admin.php" class="btn btn-primary mb-3">Volver al Panel Admin</a>
    
    <?php
    // El código PHP está insertando la tabla con los usuarios aquí
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
