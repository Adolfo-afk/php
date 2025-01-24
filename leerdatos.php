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

// Mostrar la primera tabla (todos los registros)
echo "<h3>Todos los registros</h3>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Curso</th>
        </tr>";

// Recorrer y mostrar todos los resultados
while ($row = mysqli_fetch_assoc($resultado)) {
    echo "<tr>
            <td>" . $row['id'] . "</td>
            <td>" . $row['nombre'] . "</td>
            <td>" . $row['edad'] . "</td>
            <td>" . $row['curso'] . "</td>
        </tr>";
}
echo "</table>";

// Reiniciar el puntero del resultado para reutilizarlo
mysqli_data_seek($resultado, 0);

// Mostrar la segunda tabla (filtrada por edad > 20)
echo "<h3>Registros con edad mayor a 20</h3>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Curso</th>
        </tr>";

// Recorrer y mostrar resultados filtrados
while ($row = mysqli_fetch_assoc($resultado)) {
    if ($row['edad'] > 20) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['edad'] . "</td>
                <td>" . $row['curso'] . "</td>
            </tr>";
    }
}
echo "</table>";
// Cerrar la conexión a la base de datos (opcional si no lo necesitas aquí)
// mysqli_close($conexion);
?>