<?php
include('conexion.php');

// Verificamos si se ha enviado el ID de la especie
if (isset($_GET['id_especie'])) {
    $id_especie = $_GET['id_especie'];

    // Eliminar los datos en la tabla alimentacion
    $query_delete_alimentacion = "DELETE FROM alimentacion WHERE id_especie = '$id_especie'";
    mysqli_query($conexion, $query_delete_alimentacion);
    
    // Eliminar los datos en la tabla regiones
    $query_delete_region = "DELETE FROM regiones WHERE id_especie = '$id_especie'";
    mysqli_query($conexion, $query_delete_region);

    // Eliminar los datos en la tabla habitats
    $query_delete_habitat = "DELETE FROM habitats WHERE id_especie = '$id_especie'";
    mysqli_query($conexion, $query_delete_habitat);
    
    // Eliminar la especie en la tabla especies
    $query_delete_especie = "DELETE FROM especies WHERE id_especie = '$id_especie'";
    mysqli_query($conexion, $query_delete_especie);

    // Mensaje de éxito
    echo "<div class='alert alert-success'>Datos eliminados correctamente.</div>";
} else {
    // Si no se recibe el id_especie
    echo "<div class='alert alert-danger'>No se ha especificado el ID de la especie.</div>";
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
        <input type="number" name="id_especie" class="form-control" placeholder="ID de la Especie" required><br>
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
</div>
</body>
</html>
