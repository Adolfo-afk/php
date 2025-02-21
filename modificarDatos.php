<?php
// Incluir el archivo de conexión
include('conexion.php');

// Si se recibe el formulario de modificación de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Verificar y sanitizar entrada para cada campo
    $errores = [];
    
    // Verificación de los campos de modificación
    if (empty($_POST['id_especie'])) {
        $errores[] = "El campo 'ID de Especie' es obligatorio para modificar.";
    } else {
        // Sanitización del ID de especie
        $id_especie = (int) $_POST['id_especie'];
    }

    // Sanitización de los campos
    $nombre_comun = !empty($_POST['nombre_comun']) ? mysqli_real_escape_string($conexion, $_POST['nombre_comun']) : null;
    $nombre_cientifico = !empty($_POST['nombre_cientifico']) ? mysqli_real_escape_string($conexion, $_POST['nombre_cientifico']) : null;
    $familia = !empty($_POST['familia']) ? mysqli_real_escape_string($conexion, $_POST['familia']) : null;
    $clase = !empty($_POST['clase']) ? mysqli_real_escape_string($conexion, $_POST['clase']) : null;
    $orden = !empty($_POST['orden']) ? mysqli_real_escape_string($conexion, $_POST['orden']) : null;
    $estado_conservacion = !empty($_POST['estado_conservacion']) ? mysqli_real_escape_string($conexion, $_POST['estado_conservacion']) : null;

    // Si no hay errores, proceder a modificar los datos
    if (empty($errores)) {

        // Consulta SQL para actualizar los datos de la especie
        $sql_especie = "UPDATE Especies SET 
                        nombre_comun = IFNULL('$nombre_comun', nombre_comun),
                        nombre_cientifico = IFNULL('$nombre_cientifico', nombre_cientifico),
                        familia = IFNULL('$familia', familia),
                        clase = IFNULL('$clase', clase),
                        orden = IFNULL('$orden', orden),
                        estado_conservacion = IFNULL('$estado_conservacion', estado_conservacion)
                        WHERE id_especie = $id_especie";

        // Ejecutar la consulta de modificación de la especie
        $resultado_especie = mysqli_query($conexion, $sql_especie);

        // Comprobar si la consulta se ejecutó correctamente
        if ($resultado_especie) {
            echo "<div class='alert alert-success' role='alert'>Especie modificada correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al modificar la especie: " . mysqli_error($conexion) . "</div>";
        }
    } else {
        // Mostrar errores de validación
        echo "<div class='alert alert-warning' role='alert'>" . implode("<br>", $errores) . "</div>";
    }

    // Cerrar conexión
    mysqli_close($conexion);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Datos de Fauna</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Modificar Datos de Fauna</h2>
    <form action="modificarDatos.php" method="POST">
        <div class="form-group">
            <label for="id_especie">ID de la Especie a Modificar:</label>
            <input type="number" class="form-control" id="id_especie" name="id_especie" required>
        </div>

        <div class="form-group">
            <label for="nombre_comun">Nombre Común de la Especie:</label>
            <input type="text" class="form-control" id="nombre_comun" name="nombre_comun">
        </div>

        <div class="form-group">
            <label for="nombre_cientifico">Nombre Científico de la Especie:</label>
            <input type="text" class="form-control" id="nombre_cientifico" name="nombre_cientifico">
        </div>

        <div class="form-group">
            <label for="familia">Familia de la Especie:</label>
            <input type="text" class="form-control" id="familia" name="familia">
        </div>

        <div class="form-group">
            <label for="clase">Clase de la Especie:</label>
            <input type="text" class="form-control" id="clase" name="clase">
        </div>

        <div class="form-group">
            <label for="orden">Orden de la Especie:</label>
            <input type="text" class="form-control" id="orden" name="orden">
        </div>

        <div class="form-group">
            <label for="estado_conservacion">Estado de Conservación:</label>
            <input type="text" class="form-control" id="estado_conservacion" name="estado_conservacion">
        </div>

        <button type="submit" class="btn btn-primary">Modificar Datos</button>
    </form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>


