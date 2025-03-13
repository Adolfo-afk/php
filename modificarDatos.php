<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Inicializar variables
$especie = $habitat = $region = $alimentacion = null;
$errores = [];

// Comprobar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el ID de la especie desde el formulario
    $id_especie = $_POST['id_especie'] ?? null;

    // Verificar si el ID de la especie está vacío
    if (empty($id_especie)) {
        $errores[] = "El campo 'ID de la especie' es obligatorio.";  // Agregar error si el campo está vacío
    } else {
        // Realizar la consulta para obtener los datos de la especie junto con su hábitat, región y alimentación
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

        // Ejecutar la consulta
        $resultado = mysqli_query($conexion, $query);

        // Verificar si se encontraron datos
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            // Si se encuentra, almacenar los datos de la especie
            $especie = mysqli_fetch_assoc($resultado);
        } else {
            // Si no se encuentra la especie, agregar error
            $errores[] = "No se encontró la especie con ID '$id_especie'.";
        }
    }

    // Si se encontró la especie y el formulario tiene datos para actualizar
    if (!empty($especie) && isset($_POST['nombre_comun'])) {
        // Sanitizar los datos
        $datos = [];
        $campos = [
            'nombre_comun', 'nombre_cientifico', 'familia', 'clase', 'orden', 'estado_conservacion',
            'nombre_habitat', 'tipo_habitat', 'ubicacion_habitat',
            'nombre_region', 'pais_region',
            'tipo_alimento', 'descripcion_alimento'
        ];

        // Sanitizar cada campo del formulario
        foreach ($campos as $campo) {
            $datos[$campo] = mysqli_real_escape_string($conexion, trim($_POST[$campo] ?? ''));
        }

        // Iniciar la transacción para actualizar los datos
        mysqli_begin_transaction($conexion);
        try {
            // Actualizar la especie
            $sql_especie = "UPDATE especies SET 
                nombre_comun = '{$datos['nombre_comun']}', 
                nombre_cientifico = '{$datos['nombre_cientifico']}', 
                familia = '{$datos['familia']}', 
                clase = '{$datos['clase']}', 
                orden = '{$datos['orden']}', 
                estado_conservacion = '{$datos['estado_conservacion']}'
                WHERE id_especie = '$id_especie'";
            mysqli_query($conexion, $sql_especie);

            // Actualizar el hábitat
            $sql_habitat = "UPDATE habitats SET 
                nombre = '{$datos['nombre_habitat']}', 
                tipo = '{$datos['tipo_habitat']}', 
                ubicacion = '{$datos['ubicacion_habitat']}'
                WHERE id_especie = '$id_especie'";
            mysqli_query($conexion, $sql_habitat);

            // Actualizar la región
            $sql_region = "UPDATE regiones SET 
                nombre = '{$datos['nombre_region']}', 
                pais = '{$datos['pais_region']}'
                WHERE id_especie = '$id_especie'";
            mysqli_query($conexion, $sql_region);

            // Actualizar la alimentación
            $sql_alimentacion = "UPDATE alimentacion SET 
                tipo_alimento = '{$datos['tipo_alimento']}', 
                descripcion = '{$datos['descripcion_alimento']}'
                WHERE id_especie = '$id_especie'";
            mysqli_query($conexion, $sql_alimentacion);

            // Confirmar los cambios
            mysqli_commit($conexion);
            echo "<div class='alert alert-success'>Datos modificados correctamente.</div>";
        } catch (Exception $e) {
            // Si ocurre un error, revertir la transacción
            mysqli_rollback($conexion);
            echo "<div class='alert alert-danger'>Error al modificar los datos: " . mysqli_error($conexion) . "</div>";
        }
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Especie</title>
    <!-- Enlazar a Bootstrap para el diseño -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Modificar Datos de la Especie</h2>
    
    <!-- Formulario para buscar una especie por su ID -->
    <form action="modificarDatos.php" method="POST">
        <div class="form-group">
            <label for="id_especie">ID de la Especie:</label>
            <input type="text" class="form-control" id="id_especie" name="id_especie" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Buscar</button>
    </form>

    <!-- Mostrar errores si los hay -->
    <?php if (!empty($errores)): ?>
        <div class="alert alert-warning mt-4">
            <?php echo implode("<br>", $errores); ?>
        </div>
    <?php endif; ?>

    <!-- Si la especie fue encontrada, mostrar los campos para modificarla -->
    <?php if (!empty($especie)): ?>
        <h3 class="mt-5">Modificar Especie: <?php echo $especie['nombre_comun']; ?></h3>

        <form action="modificarDatos.php" method="POST">
            <input type="hidden" name="id_especie" value="<?php echo $especie['id_especie']; ?>">

            <?php
            // Definir los campos a mostrar en el formulario
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

            // Crear un formulario con los datos existentes para que el usuario los pueda modificar
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
