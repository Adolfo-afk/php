<?php
// Incluir el archivo de conexión
include('conexion.php'); // Asegúrate de que el archivo 'conexion.php' esté en el mismo directorio o ajusta la ruta

// Consulta para obtener los datos de la tabla "Especies"
$query = "SELECT id_especie, nombre_comun, nombre_cientifico, familia, clase, orden, estado_conservacion FROM especies";
$resultado = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Mostrar los resultados en formato de tabla con Bootstrap
echo "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Listado de Especies, Hábitats, Regiones y Alimentación</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>

<div class='container mt-5'>
<h2 class='mb-4'>Listado de Especies</h2>
<table class='table table-striped'>
    <thead>
        <tr>
            <th>ID Especie</th>
            <th>Nombre Común</th>
            <th>Nombre Científico</th>
            <th>Familia</th>
            <th>Clase</th>
            <th>Orden</th>
            <th>Estado de Conservación</th>
        </tr>
    </thead>
    <tbody>";

// Recorrer cada fila de resultados y mostrarla
while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<tr>
            <td>" . $row['id_especie'] . "</td>
            <td>" . $row['nombre_comun'] . "</td>
            <td>" . $row['nombre_cientifico'] . "</td>
            <td>" . $row['familia'] . "</td>
            <td>" . $row['clase'] . "</td>
            <td>" . $row['orden'] . "</td>
            <td>" . $row['estado_conservacion'] . "</td>
        </tr>";
}

// Cerrar la tabla HTML
echo "</tbody>
</table>";

// Consulta para obtener los datos de la tabla "Alimentación"
$query = "SELECT a.id_alimentacion, a.tipo_alimento, a.descripcion, e.nombre_comun AS especie
FROM alimentacion a
JOIN especies e ON a.id_especie = e.id_especie";
$resultadoAlimentacion = mysqli_query($conexion, $query);
echo "
<h2 class='mb-4'>Listado de Alimentación</h2>
<table class='table table-striped'>
    <thead>
        <tr>
            <th>ID Alimentación</th>
            <th>Tipo de Alimento</th>
            <th>Descripción</th>
            <th>Especie</th>
        </tr>
    </thead>
    <tbody>";

// Recorrer cada fila de resultados y mostrarla
while ($row = mysqli_fetch_assoc($resultadoAlimentacion)) {
    echo "<tr>
            <td>" . $row['id_alimentacion'] . "</td>
            <td>" . $row['tipo_alimento'] . "</td>
            <td>" . $row['descripcion'] . "</td>
            <td>" . $row['especie'] . "</td>
        </tr>";
}

// Cerrar la tabla HTML
echo "</tbody>
</table>";

// Consulta para obtener los datos de la tabla "Hábitats"
$query = "SELECT h.id_habitat, h.nombre, h.tipo, h.ubicacion, e.nombre_comun AS especie
FROM habitats h
JOIN especies e ON h.id_especie = e.id_especie";
$resultadoHabitat = mysqli_query($conexion, $query);
echo "
<h2 class='mb-4'>Listado de Hábitats</h2>
<table class='table table-striped'>
    <thead>
        <tr>
            <th>ID Hábitat</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Ubicación</th>
            <th>Especie</th>
        </tr>
    </thead>
    <tbody>";

// Recorrer cada fila de resultados y mostrarla
while ($row = mysqli_fetch_assoc($resultadoHabitat)) {
    echo "<tr>
            <td>" . $row['id_habitat'] . "</td>
            <td>" . $row['nombre'] . "</td>
            <td>" . $row['tipo'] . "</td>
            <td>" . $row['ubicacion'] . "</td>
            <td>" . $row['especie'] . "</td>
        </tr>";
}

// Cerrar la tabla HTML
echo "</tbody>
</table>";

// Consulta para obtener los datos de la tabla "Regiones"
$query = "SELECT r.id_region, r.nombre, r.pais, e.nombre_comun AS especie
FROM regiones r
JOIN especies e ON r.id_especie = e.id_especie";
$resultadoRegiones = mysqli_query($conexion, $query);
echo "
<h2 class='mb-4'>Listado de Regiones</h2>
<table class='table table-striped'>
    <thead>
        <tr>
            <th>ID Región</th>
            <th>Nombre</th>
            <th>País</th>
            <th>Especie</th>
        </tr>
    </thead>
    <tbody>";

// Recorrer cada fila de resultados y mostrarla
while ($row = mysqli_fetch_assoc($resultadoRegiones)) {
    echo "<tr>
            <td>" . $row['id_region'] . "</td>
            <td>" . $row['nombre'] . "</td>
            <td>" . $row['pais'] . "</td>
            <td>" . $row['especie'] . "</td>
        </tr>";
}

// Cerrar la tabla HTML
echo "</tbody>
</table>";

echo "</div>";

echo "</body>
</html>";

// Cerrar la conexión a la base de datos (opcional si no lo necesitas aquí)
// mysqli_close($conexion);
?>
