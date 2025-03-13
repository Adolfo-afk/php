<?php
// Incluir el archivo de conexión a la base de datos.
include('conexion.php');

// Obtener las ubicaciones desde la base de datos para llenar el select de ubicaciones.
$query_ubicaciones = "SELECT DISTINCT ubicacion FROM habitats";
$resultado_ubicaciones = mysqli_query($conexion, $query_ubicaciones);

// Obtener los países desde la base de datos para llenar el select de países.
$query_paises = "SELECT DISTINCT pais FROM regiones";
$resultado_paises = mysqli_query($conexion, $query_paises);

// Modificación para obtener solo los tipos de alimento: 'omnivoro', 'carnivoro' y 'herbivoro'.
$query_alimentos = "SELECT DISTINCT tipo_alimento FROM alimentacion WHERE tipo_alimento IN ('omnivoro', 'carnivoro', 'herbivoro')";
$resultado_alimentos = mysqli_query($conexion, $query_alimentos);

// Verificar si el formulario se ha enviado por POST (es decir, si el usuario ha hecho clic en el botón "Insertar").
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger todos los valores enviados desde el formulario.
    $nombre_comun = $_POST['nombre_comun'];
    $nombre_cientifico = $_POST['nombre_cientifico'];
    $familia = $_POST['familia'];
    $clase = $_POST['clase'];
    $orden = $_POST['orden'];
    $estado_conservacion = $_POST['estado_conservacion'];
    $ubicacion = $_POST['ubicacion'];
    $pais = $_POST['pais'];
    $tipo_alimento = $_POST['tipo_alimento'];
    $descripcion_alimento = $_POST['descripcion_alimento'];
    $nombre_habitat = $_POST['nombre_habitat'];
    $tipo_habitat = $_POST['tipo_habitat'];
    $nombre_region = $_POST['nombre_region'];
    
    // Insertar la nueva especie en la tabla `especies`.
    $query_insert_especie = "INSERT INTO especies (nombre_comun, nombre_cientifico, familia, clase, orden, estado_conservacion) 
                              VALUES ('$nombre_comun', '$nombre_cientifico', '$familia', '$clase', '$orden', '$estado_conservacion')";
    mysqli_query($conexion, $query_insert_especie);
    
    // Obtener el ID de la especie recién insertada (esto es necesario para relacionarla con otras tablas).
    $id_especie = mysqli_insert_id($conexion);
    
    // Insertar los datos de hábitat relacionados con esta especie en la tabla `habitats`.
    $query_insert_habitat = "INSERT INTO habitats (id_especie, nombre, tipo, ubicacion) 
                             VALUES ('$id_especie', '$nombre_habitat', '$tipo_habitat', '$ubicacion')";
    mysqli_query($conexion, $query_insert_habitat);
    
    // Insertar los datos de la región relacionada con esta especie en la tabla `regiones`.
    $query_insert_region = "INSERT INTO regiones (id_especie, nombre, pais) 
                            VALUES ('$id_especie', '$nombre_region', '$pais')";
    mysqli_query($conexion, $query_insert_region);
    
    // Insertar los datos sobre la alimentación de la especie en la tabla `alimentacion`.
    $query_insert_alimentacion = "INSERT INTO alimentacion (id_especie, tipo_alimento, descripcion) 
                                  VALUES ('$id_especie', '$tipo_alimento', '$descripcion_alimento')";
    mysqli_query($conexion, $query_insert_alimentacion);
    
    // Mensaje de éxito si todo se insertó correctamente.
    echo "<div class='alert alert-success'>Datos insertados correctamente.</div>";
}
// para coger los datos se coge del formulario que esta mas abajo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Insertar Nueva Especie</h2>
    <!-- Formulario que permite ingresar los datos de una nueva especie -->
    <form method="POST" action="">
        <!-- Campos de texto para ingresar los datos de la especie -->
        <input type="text" name="nombre_comun" class="form-control" placeholder="Nombre Común" required><br>
        <input type="text" name="nombre_cientifico" class="form-control" placeholder="Nombre Científico" required><br>
        <input type="text" name="familia" class="form-control" placeholder="Familia" required><br>
        <input type="text" name="clase" class="form-control" placeholder="Clase" required><br>
        <input type="text" name="orden" class="form-control" placeholder="Orden" required><br>
        <input type="text" name="estado_conservacion" class="form-control" placeholder="Estado de Conservación" required><br>
        
        <!-- Select de Ubicación (obtenido de la base de datos) -->
        <select name="ubicacion" class="form-control" required>
            <option value="">Seleccione Ubicación</option>
            <?php 
            // Mostrar todas las ubicaciones obtenidas desde la base de datos
            //se usa en PHP para obtener una fila de resultados de una consulta SQL en MySQL y devolverla como un array asociativo
            while ($row = mysqli_fetch_assoc($resultado_ubicaciones)) { 
                echo "<option value='{$row['ubicacion']}'>{$row['ubicacion']}</option>"; 
            }
            ?>
        </select><br>
        
        <!-- Campos de texto para ingresar los datos del hábitat -->
        <input type="text" name="nombre_habitat" class="form-control" placeholder="Nombre del Hábitat" required><br>
        <input type="text" name="tipo_habitat" class="form-control" placeholder="Tipo de Hábitat" required><br>
        
        <!-- Select de País (obtenido de la base de datos) -->
        <select name="pais" class="form-control" required>
            <option value="">Seleccione País</option>
            <?php 
            // Mostrar todos los países obtenidos desde la base de datos
            // //se usa en PHP para obtener una fila de resultados de una consulta SQL en MySQL y devolverla como un array asociativo
            while ($row = mysqli_fetch_assoc($resultado_paises)) { 
                echo "<option value='{$row['pais']}'>{$row['pais']}</option>"; 
            }
            ?>
        </select><br>
        
        <!-- Campo de texto para el nombre de la región -->
        <input type="text" name="nombre_region" class="form-control" placeholder="Nombre de la Región" required><br>
        
        <!-- Select de Tipo de Alimento (obtenido de la base de datos) -->
        <select name="tipo_alimento" class="form-control" required>
            <option value="">Seleccione Tipo de Alimento</option>
            <?php 
            // Mostrar los tipos de alimentos obtenidos desde la base de datos
            while ($row = mysqli_fetch_assoc($resultado_alimentos)) { 
                echo "<option value='{$row['tipo_alimento']}'>{$row['tipo_alimento']}</option>"; 
            }
            ?>
        </select><br>
        
        <!-- Campo de texto para describir el tipo de alimento -->
        <input type="text" name="descripcion_alimento" class="form-control" placeholder="Descripción del Alimento" required><br>
        
        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-primary">Insertar</button>
    </form>
</div>
<br>
 <!-- Botón para regresar al panel de administración -->
 <a href="admin.php" class="btn btn-primary mb-3">Volver al Panel Admin</a>
</body>
</html>
