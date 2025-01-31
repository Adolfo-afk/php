<?php
// Incluir el archivo de conexión
include('conexion.php');

// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Comprobar si el formulario envió datos correctamente
var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Estudiantes filtrado por nombre</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Listado de Estudiantes Filtrado</h2>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
                $nombre = $_POST['nombre'];
                
                // Usar consultas preparadas para evitar inyección SQL
                $stmt = $conexion->prepare("SELECT id, nombre, edad, curso, promociona FROM alumnos WHERE nombre LIKE ?");
                $search = "%$nombre%";
                $stmt->bind_param("s", $search);
                $stmt->execute();
                $resultado = $stmt->get_result();
                
                if ($resultado->num_rows == 0) {
                    echo "<div class='alert alert-warning'>No se encontraron alumnos con ese nombre.</div>";
                } else {
                    echo "<div class='container mt-4'>
                            <h2>Resultados para: " . htmlspecialchars($nombre) . "</h2>
                            <table class='table table-bordered table-striped'>
                                <thead class='thead-dark'>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Edad</th>
                                        <th>Curso</th>
                                        <th>Promociona</th>
                                    </tr>
                                </thead>
                                <tbody>";
                    
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['nombre'] . "</td>
                                <td>" . $row['edad'] . "</td>
                                <td>" . $row['curso'] . "</td>
                                <td>" . $row['promociona'] . "</td>
                              </tr>";
                    }
                    echo "</tbody></table></div>";
                }
            } else {
                echo "<div class='alert alert-danger'>No se proporcionó un nombre para la búsqueda.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Acceso no permitido. El formulario debe enviarse mediante POST.</div>";
        }
        ?>

    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
