<?php
// Incluir el archivo de conexión
include('conexion.php');

// Si se recibe el formulario de eliminación de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errores = [];

    // Verificar y sanitizar las entradas
    $id_especie = !empty($_POST['id_especie']) ? mysqli_real_escape_string($conexion, $_POST['id_especie']) : null;
    $id_habitat = !empty($_POST['id_habitat']) ? mysqli_real_escape_string($conexion, $_POST['id_habitat']) : null;
    $id_region = !empty($_POST['id_region']) ? mysqli_real_escape_string($conexion, $_POST['id_region']) : null;

    // Eliminar registros según los IDs proporcionados
    if ($id_especie) {
        $sql_observaciones = "DELETE FROM Observaciones WHERE id_especie = '$id_especie'";
        $sql_alimentacion = "DELETE FROM Alimentacion WHERE id_especie = '$id_especie'";
        $sql_especie = "DELETE FROM Especies WHERE id_especie = '$id_especie'";

        mysqli_query($conexion, $sql_observaciones);
        mysqli_query($conexion, $sql_alimentacion);
        $resultado_especie = mysqli_query($conexion, $sql_especie);

        if ($resultado_especie) {
            echo "<div class='alert alert-success'>Especie eliminada correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar la especie: " . mysqli_error($conexion) . "</div>";
        }
    }

    if ($id_habitat) {
        $sql_habitat = "DELETE FROM Habitats WHERE id_habitat = '$id_habitat'";
        $resultado_habitat = mysqli_query($conexion, $sql_habitat);

        if ($resultado_habitat) {
            echo "<div class='alert alert-success'>Hábitat eliminado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el hábitat: " . mysqli_error($conexion) . "</div>";
        }
    }

    if ($id_region) {
        $sql_region = "DELETE FROM Regiones WHERE id_region = '$id_region'";
        $resultado_region = mysqli_query($conexion, $sql_region);

        if ($resultado_region) {
            echo "<div class='alert alert-success'>Región eliminada correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar la región: " . mysqli_error($conexion) . "</div>";
        }
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
    <title>Eliminar Datos</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Eliminar Datos de Fauna</h2>
    <form action="eliminarDatos.php" method="POST">
        <!-- Campo para ID de la Especie -->
        <div class="form-group">
            <label for="id_especie">ID de la Especie a Eliminar:</label>
            <input type="number" class="form-control" id="id_especie" name="id_especie">
        </div>

        <!-- Campo para ID del Hábitat -->
        <div class="form-group">
            <label for="id_habitat">ID del Hábitat a Eliminar:</label>
            <input type="number" class="form-control" id="id_habitat" name="id_habitat">
        </div>

        <!-- Campo para ID de la Región -->
        <div class="form-group">
            <label for="id_region">ID de la Región a Eliminar:</label>
            <input type="number" class="form-control" id="id_region" name="id_region">
        </div>

        <button type="submit" class="btn btn-danger mt-3">Eliminar Datos</button>
    </form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

