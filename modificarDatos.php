<?php
include('conexion.php');

$especie = $habitat = $region = $alimentacion = null;
$errores = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_especie = $_POST['id_especie'] ?? null;

    if (empty($id_especie)) {
        $errores[] = "El campo 'ID de la especie' es obligatorio.";
    } else {
        // Obtener todos los datos de la especie
        $query = "
            SELECT e.*, h.nombre AS nombre_habitat, h.tipo AS tipo_habitat, h.ubicacion AS ubicacion_habitat,
                   r.nombre AS nombre_region, r.pais AS pais_region,
                   a.tipo_alimento, a.descripcion AS descripcion_alimento
            FROM especies e
            LEFT JOIN habitats h ON e.id_especie = h.id_especie
            LEFT JOIN regiones r ON e.id_especie = r.id_especie
            LEFT JOIN alimentacion a ON e.id_especie = a.id_especie
            WHERE e.id_especie = '$id_especie'
        ";
        $resultado = mysqli_query($conexion, $query);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $especie = mysqli_fetch_assoc($resultado);
        } else {
            $errores[] = "No se encontró la especie con ID '$id_especie'.";
        }
    }

    if (!empty($especie) && isset($_POST['nombre_comun'])) {
        // Sanitizar datos
        $datos = [];
        $campos = [
            'nombre_comun', 'nombre_cientifico', 'familia', 'clase', 'orden', 'estado_conservacion',
            'nombre_habitat', 'tipo_habitat', 'ubicacion_habitat',
            'nombre_region', 'pais_region',
            'tipo_alimento', 'descripcion_alimento'
        ];

        foreach ($campos as $campo) {
            $datos[$campo] = mysqli_real_escape_string($conexion, trim($_POST[$campo] ?? ''));
        }

        // Actualizar datos en la base de datos
        mysqli_begin_transaction($conexion);
        try {
            $sql_especie = "UPDATE especies SET 
                nombre_comun = '{$datos['nombre_comun']}', 
                nombre_cientifico = '{$datos['nombre_cientifico']}', 
                familia = '{$datos['familia']}', 
                clase = '{$datos['clase']}', 
                orden = '{$datos['orden']}', 
                estado_conservacion = '{$datos['estado_conservacion']}'
                WHERE id_especie = '$id_especie'";
            mysqli_query($conexion, $sql_especie);

            $sql_habitat = "UPDATE habitats SET 
                nombre = '{$datos['nombre_habitat']}', 
                tipo = '{$datos['tipo_habitat']}', 
                ubicacion = '{$datos['ubicacion_habitat']}'
                WHERE id_especie = '$id_especie'";
            mysqli_query($conexion, $sql_habitat);

            $sql_region = "UPDATE regiones SET 
                nombre = '{$datos['nombre_region']}', 
                pais = '{$datos['pais_region']}'
                WHERE id_especie = '$id_especie'";
            mysqli_query($conexion, $sql_region);

            $sql_alimentacion = "UPDATE alimentacion SET 
                tipo_alimento = '{$datos['tipo_alimento']}', 
                descripcion = '{$datos['descripcion_alimento']}'
                WHERE id_especie = '$id_especie'";
            mysqli_query($conexion, $sql_alimentacion);

            mysqli_commit($conexion);
            echo "<div class='alert alert-success'>Datos modificados correctamente.</div>";
        } catch (Exception $e) {
            mysqli_rollback($conexion);
            echo "<div class='alert alert-danger'>Error al modificar los datos: " . mysqli_error($conexion) . "</div>";
        }
    }
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Especie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Modificar Datos de la Especie</h2>
    
    <form action="modificarDatos.php" method="POST">
        <div class="form-group">
            <label for="id_especie">ID de la Especie:</label>
            <input type="text" class="form-control" id="id_especie" name="id_especie" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Buscar</button>
    </form>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-warning mt-4">
            <?php echo implode("<br>", $errores); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($especie)): ?>
        <h3 class="mt-5">Modificar Especie: <?php echo $especie['nombre_comun']; ?></h3>

        <form action="modificarDatos.php" method="POST">
            <input type="hidden" name="id_especie" value="<?php echo $especie['id_especie']; ?>">

            <?php
            $labels = [
                'nombre_comun' => 'Nombre Común',
                'nombre_cientifico' => 'Nombre Científico',
                'familia' => 'Familia',
                'clase' => 'Clase',
                'orden' => 'Orden',
                'estado_conservacion' => 'Estado de Conservación',
                'nombre_habitat' => 'Nombre del Hábitat',
                'tipo_habitat' => 'Tipo de Hábitat',
                'ubicacion_habitat' => 'Ubicación del Hábitat',
                'nombre_region' => 'Nombre de la Región',
                'pais_region' => 'País de la Región',
                'tipo_alimento' => 'Tipo de Alimento',
                'descripcion_alimento' => 'Descripción del Alimento'
            ];

            foreach ($labels as $name => $label) {
                $value = htmlspecialchars($especie[$name] ?? '');
                echo "<div class='form-group'>
                        <label for='$name'>$label:</label>
                        <input type='text' class='form-control' id='$name' name='$name' value='$value' required>
                      </div>";
            }
            ?>
            <button type="submit" class="btn btn-primary mt-3">Modificar</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
