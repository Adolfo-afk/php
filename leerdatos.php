<?php
// Incluir el archivo de conexión
include('conexion.php');

// Consultar los datos de las tablas
$query_especies = "SELECT * FROM especies";
$resultado_especies = mysqli_query($conexion, $query_especies);

$query_alimentacion = "SELECT * FROM alimentacion";
$resultado_alimentacion = mysqli_query($conexion, $query_alimentacion);

$query_habitats = "SELECT * FROM habitats";
$resultado_habitats = mysqli_query($conexion, $query_habitats);

$query_regiones = "SELECT * FROM regiones";
$resultado_regiones = mysqli_query($conexion, $query_regiones);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leer Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Datos Ingresados</h2>

    <!-- Mostrar especies -->
    <h3>Especies</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Común</th>
                <th>Nombre Científico</th>
                <th>Familia</th>
                <th>Clase</th>
                <th>Orden</th>
                <th>Estado Conservación</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado_especies)): ?>
                <tr>
                    <td><?php echo $row['id_especie']; ?></td>
                    <td><?php echo $row['nombre_comun']; ?></td>
                    <td><?php echo $row['nombre_cientifico']; ?></td>
                    <td><?php echo $row['familia']; ?></td>
                    <td><?php echo $row['clase']; ?></td>
                    <td><?php echo $row['orden']; ?></td>
                    <td><?php echo $row['estado_conservacion']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Mostrar alimentación -->
    <h3>Alimentación</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Especie</th>
                <th>Tipo de Alimento</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado_alimentacion)): ?>
                <tr>
                    <td><?php echo $row['id_especie']; ?></td>
                    <td><?php echo $row['tipo_alimento']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Mostrar hábitats -->
    <h3>Hábitats</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Especie</th>
                <th>Nombre del Hábitat</th>
                <th>Tipo de Hábitat</th>
                <th>Ubicación</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado_habitats)): ?>
                <tr>
                    <td><?php echo $row['id_especie']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['tipo']; ?></td>
                    <td><?php echo $row['ubicacion']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Mostrar regiones -->
    <h3>Regiones</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Especie</th>
                <th>Nombre de la Región</th>
                <th>País</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado_regiones)): ?>
                <tr>
                    <td><?php echo $row['id_especie']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['pais']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
