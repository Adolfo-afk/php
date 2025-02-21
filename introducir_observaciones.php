<?php
// Incluir el archivo de conexión
include('conexion.php');

// Si se recibe el formulario de introducción de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar y sanitizar entrada para cada campo
    $errores = [];

    // Validación de campo para la Fecha
    if (empty($_POST['fecha'])) {
        $errores[] = "El campo 'Fecha' es obligatorio.";
    } else {
        $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    }

    // Validación de campo para la Descripción
    if (empty($_POST['descripcion'])) {
        $errores[] = "El campo 'Descripción' es obligatorio.";
    } else {
        $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    }

    // Validación de campo para Especie
    if (empty($_POST['id_especie'])) {
        $errores[] = "El campo 'Especie' es obligatorio.";
    } else {
        $id_especie = mysqli_real_escape_string($conexion, $_POST['id_especie']);
    }

    // Validación de campo para Fauna
    if (empty($_POST['id_fauna'])) {
        $errores[] = "El campo 'Fauna' es obligatorio.";
    } else {
        $id_fauna = mysqli_real_escape_string($conexion, $_POST['id_fauna']);
    }

    // Validación de campo para Región
    if (empty($_POST['id_region'])) {
        $errores[] = "El campo 'Región' es obligatorio.";
    } else {
        $id_region = mysqli_real_escape_string($conexion, $_POST['id_region']);
    }

    // Si no hay errores, proceder a insertar los datos
    if (empty($errores)) {
        // Insertar en la tabla de Observaciones
        $sql_observacion = "INSERT INTO Observaciones (fecha, comentarios, id_especie, id_habitat, id_region)
                            VALUES ('$fecha', '$descripcion', '$id_especie', '$id_fauna', '$id_region')";
        $resultado_observacion = mysqli_query($conexion, $sql_observacion);

        // Comprobar si la consulta se ejecutó correctamente
        if ($resultado_observacion) {
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
    <title>Introducir Datos de Observación</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/introducirDatos.css" rel="stylesheet"> <!-- Enlace al archivo CSS -->
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Introducir Datos de Observación</h2>
    <form action="introducir_observaciones.php" method="POST">
        <!-- Campos de Observación -->
        <div class="form-group">
            <label for="fecha">Fecha de la Observación:</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
        </div>

        <!-- Campos de Especie, Fauna y Región -->
        <div class="form-group">
            <label for="id_especie">Especie:</label>
            <select class="form-control" id="id_especie" name="id_especie" required>
                <?php
                $sql_especies = "SELECT id_especie, nombre_comun FROM Especies";
                $resultado_especies = mysqli_query($conexion, $sql_especies);
                while ($row = mysqli_fetch_assoc($resultado_especies)) {
                    echo "<option value='" . $row['id_especie'] . "'>" . $row['nombre_comun'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_fauna">Fauna:</label>
            <select class="form-control" id="id_fauna" name="id_fauna" required>
                <?php
                $sql_fauna = "SELECT id_fauna, nombre FROM Fauna";
                $resultado_fauna = mysqli_query($conexion, $sql_fauna);
                while ($row = mysqli_fetch_assoc($resultado_fauna)) {
                    echo "<option value='" . $row['id_fauna'] . "'>" . $row['nombre'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="id_region">Región:</label>
            <select class="form-control" id="id_region" name="id_region" required>
                <?php
                $sql_regiones = "SELECT id_region, nombre FROM Regiones";
                $resultado_regiones = mysqli_query($conexion, $sql_regiones);
                while ($row = mysqli_fetch_assoc($resultado_regiones)) {
                    echo "<option value='" . $row['id_region'] . "'>" . $row['nombre'] . "</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Insertar Observación</button>
    </form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
