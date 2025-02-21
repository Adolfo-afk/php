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
    $id_fauna = !empty($_POST['id_fauna']) ? mysqli_real_escape_string($conexion, $_POST['id_fauna']) : null;
    $id_alimentacion = !empty($_POST['id_alimentacion']) ? mysqli_real_escape_string($conexion, $_POST['id_alimentacion']) : null;
    $id_observacion = !empty($_POST['id_observacion']) ? mysqli_real_escape_string($conexion, $_POST['id_observacion']) : null; // Nuevo campo para eliminar observación

    // Eliminar registros según los IDs proporcionados
    if ($id_especie) {
        mysqli_query($conexion, "DELETE FROM Observaciones WHERE id_especie = '$id_especie'");
        mysqli_query($conexion, "DELETE FROM Alimentacion WHERE id_especie = '$id_especie'");
        $resultado = mysqli_query($conexion, "DELETE FROM Especies WHERE id_especie = '$id_especie'");

        echo $resultado ? "<div class='alert alert-success'>Especie eliminada correctamente.</div>"
                        : "<div class='alert alert-danger'>Error al eliminar la especie: " . mysqli_error($conexion) . "</div>";
    }

    if ($id_habitat) {
        $resultado = mysqli_query($conexion, "DELETE FROM Habitats WHERE id_habitat = '$id_habitat'");

        echo $resultado ? "<div class='alert alert-success'>Hábitat eliminado correctamente.</div>"
                        : "<div class='alert alert-danger'>Error al eliminar el hábitat: " . mysqli_error($conexion) . "</div>";
    }

    if ($id_region) {
        $resultado = mysqli_query($conexion, "DELETE FROM Regiones WHERE id_region = '$id_region'");

        echo $resultado ? "<div class='alert alert-success'>Región eliminada correctamente.</div>"
                        : "<div class='alert alert-danger'>Error al eliminar la región: " . mysqli_error($conexion) . "</div>";
    }

    if ($id_fauna) {
        $resultado = mysqli_query($conexion, "DELETE FROM Fauna WHERE id_fauna = '$id_fauna'");

        echo $resultado ? "<div class='alert alert-success'>Fauna eliminada correctamente.</div>"
                        : "<div class='alert alert-danger'>Error al eliminar la fauna: " . mysqli_error($conexion) . "</div>";
    }

    if ($id_alimentacion) {
        $resultado = mysqli_query($conexion, "DELETE FROM Alimentacion WHERE id_alimentacion = '$id_alimentacion'");

        echo $resultado ? "<div class='alert alert-success'>Registro de alimentación eliminado correctamente.</div>"
                        : "<div class='alert alert-danger'>Error al eliminar la alimentación: " . mysqli_error($conexion) . "</div>";
    }

    // Eliminar observación si se recibe el ID de observación
    if ($id_observacion) {
        $resultado = mysqli_query($conexion, "DELETE FROM Observaciones WHERE id_observacion = '$id_observacion'");

        echo $resultado ? "<div class='alert alert-success'>Observación eliminada correctamente.</div>"
                        : "<div class='alert alert-danger'>Error al eliminar la observación: " . mysqli_error($conexion) . "</div>";
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
        <div class="form-group">
            <label for="id_especie">ID de la Especie a Eliminar:</label>

                <select id="cars" name="cars">
                    <?php
                    $consultaAnimales = "Select id_especie, nombre_comun from especies";
                    $resultado_especie = mysqli_query($conexion, $consultaAnimales);
                    while ($row = mysqli_fetch_assoc($resultado_especie)) {
                        echo "<option value="row['id_especie]">row['nombre_comun']</option>;
                    }
                    ?>
                    
                </select>
            <input type="number" class="form-control" id="id_especie" name="id_especie">
        </div>

        <div class="form-group">
            <label for="id_habitat">ID del Hábitat a Eliminar:</label>
            <input type="number" class="form-control" id="id_habitat" name="id_habitat">
        </div>

        <div class="form-group">
            <label for="id_region">ID de la Región a Eliminar:</label>
            <input type="number" class="form-control" id="id_region" name="id_region">
        </div>

        <div class="form-group">
            <label for="id_fauna">ID de la Fauna a Eliminar:</label>
            <input type="number" class="form-control" id="id_fauna" name="id_fauna">
        </div>

        <div class="form-group">
            <label for="id_alimentacion">ID del Registro de Alimentación a Eliminar:</label>
            <input type="number" class="form-control" id="id_alimentacion" name="id_alimentacion">
        </div>

        <div class="form-group">
            <label for="id_observacion">ID de la Observación a Eliminar:</label>
            <input type="number" class="form-control" id="id_observacion" name="id_observacion">
        </div>

        <button type="submit" class="btn btn-danger mt-3">Eliminar Datos</button>
    </form>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
