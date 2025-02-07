<?php
include('conexion.php'); // Asegúrate de que la ruta a conexion.php sea correcta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Consulta para eliminar el alumno con el ID proporcionado
    $sql = "DELETE FROM alumnos WHERE id = ?";

    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Alumno con ID $id eliminado correctamente.";
            } else {
                echo "No se encontró ningún alumno con el ID $id.";
            }
        } else {
            echo "Error al eliminar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }

    $conexion->close();
} else {
    echo "No se enviaron datos.";
}
?>
