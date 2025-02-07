<?php
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $curso = $_POST['curso'];
    $promocionar = $_POST['promocionar'] === 'si' ? 1 : 0;

    // Actualización usando la variable $conexion
    $sql = "UPDATE alumnos SET nombre = ?, edad = ?, curso = ?, promociona = ? WHERE id = ?";

    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("sisii", $nombre, $edad, $curso, $promocionar, $id);

        if ($stmt->execute()) {
            echo "Alumno actualizado correctamente.";
        } else {
            echo "Error al actualizar: " . $stmt->error;
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
