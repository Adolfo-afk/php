<?php
// Incluir el archivo de conexión
include('conexion.php'); // Asegúrate de que el archivo 'conexion.php' esté en el mismo directorio o ajusta la ruta

// Consulta para obtener los datos de la tabla "alumnos"
$query = "SELECT id, nombre, edad, curso FROM alumnos";
$resultado = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Mostrar los resultados en formato de tabla
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Curso</th>
        </tr>";

// Recorrer cada fila de resultados y mostrarla
while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<tr>
            <td>" . $row['id'] . "</td>
            <td>" . $row['nombre'] . "</td>
            <td>" . $row['edad'] . "</td>
            <td>" . $row['curso'] . "</td>
        </tr>";
}

// Cerrar la tabla HTML
echo "</table>";



// Recorrer cada fila y mostrar solo las que tengan 'edad' mayor a 20
while ($row = mysqli_fetch_assoc($resultado)) {
    if ($row['edad'] > 20) { // Condición para filtrar por edad mayor a 20
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['edad'] . "</td>
                <td>" . $row['curso'] . "</td>
            </tr>";
    }
}

// Cerrar la tabla HTML
echo "</table>";


// Recorrer cada fila de resultados y mostrarla, excepto si el nombre es 'Maria'
while ($row = mysqli_fetch_assoc($resultado)) {
    if ($row['nombre'] != "Maria") { // Excluir las filas donde el nombre sea 'Maria'
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['edad'] . "</td>
                <td>" . $row['curso'] . "</td>
            </tr>";
    }
}

// Cerrar la tabla HTML
echo "</table>";


// Cerrar la conexión a la base de datos (opcional si no lo necesitas aquí)
// mysqli_close($conexion);
?>