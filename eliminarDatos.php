<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificamos si se ha enviado el ID de la especie a través de la URL
if (isset($_GET['id_especie'])) {//isset comprobar que no sea nulo
    // limpiamos o modificamos la entrada para evitar inyección SQL
    $id_especie = intval($_GET['id_especie']); // Convertimos a número entero

    // Verificamos que la conexión a la base de datos sea válida
    if ($conexion) {
        // Eliminar los datos relacionados en otras tablas antes de eliminar la especie
        $query_delete_alimentacion = "DELETE FROM alimentacion WHERE id_especie = '$id_especie'";
        $query_delete_region = "DELETE FROM regiones WHERE id_especie = '$id_especie'";
        $query_delete_habitat = "DELETE FROM habitats WHERE id_especie = '$id_especie'";
        $query_delete_especie = "DELETE FROM especies WHERE id_especie = '$id_especie'";

        // Ejecutar las consultas y verificar si tuvieron éxito
        if (
            // mysqli_query utilizada para ejecutar consultas en una base de datos MySQL utilizando la extensión MySQLi
            mysqli_query($conexion, $query_delete_alimentacion) &&
            mysqli_query($conexion, $query_delete_region) &&
            mysqli_query($conexion, $query_delete_habitat) &&
            mysqli_query($conexion, $query_delete_especie)
        ) {
            echo "<div class='alert alert-success'>Datos eliminados correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar los datos: " . mysqli_error($conexion) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error de conexión a la base de datos.</div>";
    }
} else {
    // Si no se recibe el ID de la especie, mostramos un mensaje de error
    echo "<div class='alert alert-warning'>No se ha especificado el ID de la especie.</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Eliminar Especie</h2>
    <form method="GET" action="">
        <!-- Campo para ingresar el ID de la especie a eliminar -->
        <input type="number" name="id_especie" class="form-control" placeholder="ID de la Especie" required><br>
        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
</div>
</body>
</html>
