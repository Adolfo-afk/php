<?php
// Incluir el archivo de conexión
include('conexion.php');

// Si se recibe el formulario de introducción de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Verificar y sanitizar entrada para cada campo
    $errores = [];
    if (empty($_POST['nombre_comun'])) {
        $errores[] = "El campo 'Nombre Común' es obligatorio.";
    } else {
        $nombre_comun = mysqli_real_escape_string($conexion, $_POST['nombre_comun']);
    }

    if (empty($_POST['nombre_cientifico'])) {
        $errores[] = "El campo 'Nombre Científico' es obligatorio.";
    } else {
        $nombre_cientifico = mysqli_real_escape_string($conexion, $_POST['nombre_cientifico']);
    }

    if (empty($_POST['familia'])) {
        $errores[] = "El campo 'Familia' es obligatorio.";
    } else {
        $familia = mysqli_real_escape_string($conexion, $_POST['familia']);
    }

    if (empty($_POST['clase'])) {
        $errores[] = "El campo 'Clase' es obligatorio.";
    } else {
        $clase = mysqli_real_escape_string($conexion, $_POST['clase']);
    }

    if (empty($_POST['orden'])) {
        $errores[] = "El campo 'Orden' es obligatorio.";
    } else {
        $orden = mysqli_real_escape_string($conexion, $_POST['orden']);
    }

    if (empty($_POST['estado_conservacion'])) {
        $errores[] = "El campo 'Estado de Conservación' es obligatorio.";
    } else {
        $estado_conservacion = mysqli_real_escape_string($conexion, $_POST['estado_conservacion']);
    }

    // Validar Hábitat y Región
    if (empty($_POST['nombre_habitat'])) {
        $errores[] = "El campo 'Nombre del Hábitat' es obligatorio.";
    } else {
        $nombre_habitat = mysqli_real_escape_string($conexion, $_POST['nombre_habitat']);
    }

    if (empty($_POST['ubicacion_habitat'])) {
        $errores[] = "El campo 'Ubicación del Hábitat' es obligatorio.";
    } else {
        $ubicacion_habitat = mysqli_real_escape_string($conexion, $_POST['ubicacion_habitat']);
    }

    if (empty($_POST['nombre_region'])) {
        $errores[] = "El campo 'Nombre de la Región' es obligatorio.";
    } else {
        $nombre_region = mysqli_real_escape_string($conexion, $_POST['nombre_region']);
    }

    if (empty($_POST['pais_region'])) {
        $errores[] = "El campo 'País de la Región' es obligatorio.";
    } else {
        $pais_region = mysqli_real_escape_string($conexion, $_POST['pais_region']);
    }

    // Si no hay errores, proceder a insertar los datos
    if (empty($errores)) {

        // Insertar en la tabla de Especies
        $sql_especie = "INSERT INTO Especies (nombre_comun, nombre_cientifico, familia, clase, orden, estado_conservacion)
                        VALUES ('$nombre_comun', '$nombre_cientifico', '$familia', '$clase', '$orden', '$estado_conservacion')";
        $resultado_especie = mysqli_query($conexion, $sql_especie);

        // Insertar en la tabla de Hábitats
        $sql_habitat = "INSERT INTO Habitats (nombre, ubicacion) VALUES ('$nombre_habitat', '$ubicacion_habitat')";
        $resultado_habitat = mysqli_query($conexion, $sql_habitat);

        // Insertar en la tabla de Regiones
        $sql_region = "INSERT INTO Regiones (nombre, pais) VALUES ('$nombre_region', '$pais_region')";
        $resultado_region = mysqli_query($conexion, $sql_region);

        // Comprobar si las consultas se ejecutaron correctamente
        if ($resultado_especie && $resultado_habitat && $resultado_region) {
            echo "<div class='alert alert-success' role='alert'>Datos introducidos correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al insertar los datos: " . mysqli_error($conexion) . "</div>";
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
    <title>Introducir Datos de Fauna</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<h2 class="mb-4">Introducir Datos de Fauna</h2>
<form action="IntroducirDatos.php" method="POST">
    <div class="form-group">
        <label for="nombre_comun">Nombre Común de la Especie:</label>
        <input type="text" class="form-control" id="nombre_comun" name="nombre_comun" required>
    </div>

    <div class="form-group">
        <label for="nombre_cientifico">Nombre Científico:</label>
        <input type="text" class="form-control" id="nombre_cientifico" name="nombre_cientifico" required>
    </div>

    <div class="form-group">
        <label for="familia">Familia:</label>
        <input type="text" class="form-control" id="familia" name="familia" required>
    </div>

    <div class="form-group">
        <label for="clase">Clase:</label>
        <input type="text" class="form-control" id="clase" name="clase" required>
    </div>

    <div class="form-group">
        <label for="orden">Orden:</label>
        <input type="text" class="form-control" id="orden" name="orden" required>
    </div>

    <div class="form-group">
        <label for="estado_conservacion">Estado de Conservación:</label>
        <input type="text" class="form-control" id="estado_conservacion" name="estado_conservacion" required>
    </div>

    <div class="form-group">
        <label for="nombre_habitat">Nombre del Hábitat:</label>
        <input type="text" class="form-control" id="nombre_habitat" name="nombre_habitat" required>
    </div>

    <div class="form-group">
        <label for="ubicacion_habitat">Ubicación del Hábitat:</label>
        <input type="text" class="form-control" id="ubicacion_habitat" name="ubicacion_habitat" required>
    </div>

    <div class="form-group">
        <label for="nombre_region">Nombre de la Región:</label>
        <input type="text" class="form-control" id="nombre_region" name="nombre_region" required>
    </div>

    <div class="form-group">
        <label for="pais_region">País de la Región:</label>
        <input type="text" class="form-control" id="pais_region" name="pais_region" required>
    </div>

    <button type="submit" class="btn btn-primary">Insertar Datos</button>
</form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
