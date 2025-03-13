<?php
include('conexion.php');

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
    <title>Datos Ingresados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2); /* Cambié el fondo aquí */
            color: white;
        }
        .container {
            max-width: 1200px;
        }
        .header {
            background: linear-gradient(135deg, #7b1fa2, #9c27b0);
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            color: black;
        }
        .table th {
            background-color: #6a1b9a;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f3e5f5;
            transition: 0.3s;
        }
        .card-header {
            font-weight: bold;
            font-size: 1.2rem;
            background-color: #8e24aa;
            color: white;
        }
        .btn-custom {
            background: #6a1b9a;
            color: white;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background: #4a148c;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="header">
        <h2>📋 Datos de la fauna</h2>
    </div>

    <!-- Especies -->
    <div class="card mt-4">
        <div class="card-header">🐾 Especies</div>
        <div class="card-body table-container">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
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
            </div>
        </div>
    </div>

    <!-- Alimentación -->
    <div class="card mt-4">
        <div class="card-header">🥩 Alimentación</div>
        <div class="card-body table-container">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
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
            </div>
        </div>
    </div>

    <!-- Hábitats -->
    <div class="card mt-4">
        <div class="card-header">🌿 Hábitats</div>
        <div class="card-body table-container">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
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
            </div>
        </div>
    </div>

    <!-- Regiones -->
    <div class="card mt-4">
        <div class="card-header">🌎 Regiones</div>
        <div class="card-body table-container">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
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
        </div>
    </div>

    <!-- Botón de Volver al Menú (ahora dirige a login.php) -->
    <div class="text-center mt-4">
        <a href="login.php" class="btn btn-custom">🔑 Volver al Login</a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

