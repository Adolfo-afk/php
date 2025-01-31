<?php
// Incluir el archivo de conexión (si es necesario)
include('conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Estudiantes Filtrado</title>
    
    <!-- Link al CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Listado de Estudiantes Filtrado</h2>

        <?php
        // Verificar si se ha enviado el formulario por POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recoger los valores de los campos
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
            $edad = isset($_POST['edad']) ? $_POST['edad'] : '';
            $curso = isset($_POST['curso']) ? $_POST['curso'] : '';
            $promociona = isset($_POST['promociona']) ? $_POST['promociona'] : '';

            // Construcción de la consulta SQL con condiciones dinámicas
            $conditions = [];

            if (!empty($nombre)) {
                $conditions[] = "nombre LIKE '%" . mysqli_real_escape_string($conexion, $nombre) . "%'";
            }
            if (!empty($edad)) {
                $conditions[] = "edad = '" . mysqli_real_escape_string($conexion, $edad) . "'";
            }
            if (!empty($curso)) {
                $conditions[] = "curso LIKE '%" . mysqli_real_escape_string($conexion, $curso) . "%'";
            }
            if (!empty($promociona)) {
                $conditions[] = "promociona = '" . mysqli_real_escape_string($conexion, $promociona) . "'";
            }

            // Si hay condiciones, generar la consulta, si no, mostrar un mensaje
            if (count($conditions) > 0) {
                $query = "SELECT id, nombre, edad, curso, promociona FROM alumnos WHERE " . implode(' AND ', $conditions);
                $resultado = mysqli_query($conexion, $query);

                // Verificar si la consulta fue exitosa
                if (mysqli_num_rows($resultado) == 0) {
                    echo "<div class='container mt-4'>
                            <h2>No se encontraron resultados con los criterios seleccionados.</h2>
                            <div class='mb-3'>
                                <a href='altaAlumno.php' class='btn btn-primary'>Introducir alumnos</a>
                            </div>
                            <div class='mb-3'>
                                <a href='leerTodos.php' class='btn btn-primary'>Ver alumnos</a>
                            </div>
                            <div class='mb-3'>
                                <a href='opciones.php' class='btn btn-primary'>Volver</a>
                            </div>
                          </div>";
                } else {
                    // Mostrar los resultados en formato de tabla
                    echo "<div class='container mt-4'>
                            <h2>Resultados para los criterios seleccionados:</h2>
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

                    // Recorrer cada fila de resultados y mostrarla
                    while ($row = mysqli_fetch_assoc($resultado)) {
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
                // Si no se proporciona ningún criterio de búsqueda
                echo "<div class='container mt-4'>
                        <h2>No se proporcionaron criterios de búsqueda.</h2>
                        <div class='mb-3'>
                            <a href='opciones.php' class='btn btn-primary'>Volver</a>
                        </div>
                      </div>";
            }
        } else {
            echo "<div class='container mt-4'>
                    <h2>Acceso no permitido. El formulario debe enviarse mediante POST.</h2>
                  </div>";
        }
        ?>

        <!-- Scripts de Bootstrap -->
        <script src="js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
