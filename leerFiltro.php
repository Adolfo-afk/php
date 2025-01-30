<?php
// Incluir el archivo de conexión (si es necesario)
include('conexion.php');

// Verificar si se ha enviado el formulario por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
        $nombre = $_POST['nombre'];

        // Consultar los datos de la base de datos filtrados por nombre
        $query = "SELECT id, nombre, edad, curso, promociona 
        FROM alumnos WHERE nombre LIKE '%$nombre%'";
        // esta linia te tira la tabla de abajo y para volver a tirar eso tenemos que usar esta antes
        $resultado = mysqli_query($conexion, $query);

        // Verificar si la consulta fue exitosa
        if (!$resultado) {
            //pongo un mensaje para explicar que no se ha encontrado un alumno con ese nombre

            //le facilito un enlace al ficherode alta de alumnos por si quiere introducirlo


            //añadir boton
           
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        // Mostrar los resultados en formato de tabla
        echo "<div class='container mt-4'>
                <h2>Resultados para: " . htmlspecialchars($nombre) . "</h2>
                <table class='table table-bordered table-striped'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Curso</th>
                            <th>Promociona</th>
                        </tr>
                    </thead>
                    <tbody>";

        // Recorrer cada fila de resultados y mostrarla
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['nombre'] . "</td>
                    <td>" . $row['edad'] . "</td>
                    <td>" . $row['curso'] . "</td>
                    <td>" . $row['promociona'] . "</td>
                </tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<div class='container mt-4'>
                <h2>No se proporcionó un nombre para la búsqueda</h2>
              </div>";
    }
} else {
    echo "<div class='container mt-4'>
            <h2>Acceso no permitido. El formulario debe enviarse mediante POST.</h2>
          </div>";
}

?>