<?php
// Incluir el archivo de conexión
include('conexion.php');

// Si se recibe el formulario de eliminación de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Verificar y sanitizar la entrada (solo ID de especie)
    if (empty($_POST['id_especie'])) {
        $errores[] = "El campo 'ID de la Especie' es obligatorio.";
    } else {
        $id_especie = mysqli_real_escape_string($conexion, $_POST['id_especie']);
    }

    // Si no hay errores, proceder a eliminar los datos
    if (empty($errores)) {

        // Eliminar de la tabla de Observaciones (relacionada con id_especie)
        $sql_observaciones = "DELETE FROM Observaciones WHERE id_especie = '$id_especie'";
        $resultado_observaciones = mysqli_query($conexion, $sql_observaciones);

        // Eliminar de la tabla de Alimentacion (relacionada con id_especie)
        $sql_alimentacion = "DELETE FROM Alimentacion WHERE id_especie = '$id_especie'";
        $resultado_alimentacion = mysqli_query($conexion, $sql_alimentacion);

        // Eliminar de la tabla de Especies
        $sql_especie = "DELETE FROM Especies WHERE id_especie = '$id_especie'";
        $resultado_especie = mysqli_query($conexion, $sql_especie);
        
        

        // Comprobar si las consultas se ejecutaron correctamente
        if ($resultado_especie && $resultado_observaciones && $resultado_alimentacion) {
            echo "<div class='alert alert-success' role='alert'>Datos eliminados correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al eliminar los datos: " . mysqli_error($conexion) . "</div>";
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
    <title>Eliminar Datos de Fauna</title>
    <!-- Enlace a un archivo CSS personalizado -->
    <link href="css/eliminarDatos.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<h2 class="mb-4">Eliminar Datos de Fauna</h2>
<form action="eliminarDatos.php" method="POST">
    <!-- Campo para ID de la Especie -->
    <div class="form-group">
        <label for="id_especie">ID de la Especie a Eliminar (Requerido):</label>
        <input type="number" class="form-control" id="id_especie" name="id_especie" required>
    </div>

    <!-- Campos adicionales (opcionales) para mostrar más información -->
    <div class="form-group">
        <label for="nombre_comun">Nombre Común de la Especie:</label>
        <input type="text" class="form-control" id="nombre_comun" name="nombre_comun">
    </div>

    <div class="form-group">
        <label for="nombre_cientifico">Nombre Científico:</label>
        <input type="text" class="form-control" id="nombre_cientifico" name="nombre_cientifico">
    </div>

    <div class="form-group">
        <label for="familia">Familia:</label>
        <input type="text" class="form-control" id="familia" name="familia">
    </div>

    <div class="form-group">
        <label for="clase">Clase:</label>
        <input type="text" class="form-control" id="clase" name="clase">
    </div>

    <div class="form-group">
        <label for="orden">Orden:</label>
        <input type="text" class="form-control" id="orden" name="orden">
    </div>

    <div class="form-group">
        <label for="estado_conservacion">Estado de Conservación:</label>
        <input type="text" class="form-control" id="estado_conservacion" name="estado_conservacion">
    </div>

    <div class="form-group">
        <label for="nombre_habitat">Nombre del Hábitat:</label>
        <input type="text" class="form-control" id="nombre_habitat" name="nombre_habitat">
    </div>

    <div class="form-group">
        <label for="ubicacion_habitat">Ubicación del Hábitat:</label>
        <input type="text" class="form-control" id="ubicacion_habitat" name="ubicacion_habitat">
    </div>

    <div class="form-group">
        <label for="nombre_region">Nombre de la Región:</label>
        <input type="text" class="form-control" id="nombre_region" name="nombre_region">
    </div>

    <div class="form-group">
        <label for="pais_region">País de la Región:</label>
        <input type="text" class="form-control" id="pais_region" name="pais_region">
    </div>

    <button type="submit" class="btn btn-danger">Eliminar Datos</button>
</form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
