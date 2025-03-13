<?php
// Iniciar la sesión para permitir el manejo de variables de sesión.
session_start();

// Incluir el archivo de conexión a la base de datos. Asegúrate de tener un archivo 'conexion.php' que configure la conexión correctamente.
include('conexion.php'); // Asegúrate de que este archivo contiene la conexión correcta

// Verificar si la conexión a la base de datos fue exitosa.
if ($conexion->connect_error) {
    // Si hay un error en la conexión, se detiene la ejecución y muestra el error.
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}

// Variable para manejar los posibles errores o mensajes de éxito.
$error = "";

// Este bloque de código se ejecuta solo si el método de solicitud es POST y se ha enviado el formulario para agregar un nuevo trabajador.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_trabajador'])) {
    // Sanear y obtener los datos enviados desde el formulario.
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = md5($_POST['password']); // Cifrar la contraseña utilizando MD5.
    // se usa para autenticar mensajes y verificar el contenido y las firmas digitales
    $rol = $_POST['rol'];

    // Verificar si el usuario ya está registrado en la base de datos.
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $query);
    
    // Si ya existe un usuario con el mismo nombre, mostrar un mensaje de error.
    if (mysqli_num_rows($resultado) > 0) {
        $error = "El nombre de usuario ya está registrado.";
    } else {
        // Si el usuario no existe, insertar los datos del nuevo trabajador en la base de datos.
        $query = "INSERT INTO usuarios (usuario, password, rol) VALUES ('$usuario', '$password', '$rol')";
        if (mysqli_query($conexion, $query)) {
            // Si la inserción fue exitosa, mostrar un mensaje de éxito.
            $error = "Trabajador registrado exitosamente.";
        } else {
            // Si hubo un error al insertar el trabajador, mostrar un mensaje de error.
            $error = "Error al registrar el trabajador. Intenta de nuevo.";
        }
    }
}

// Consulta para obtener todos los trabajadores registrados en la base de datos.
$query = "SELECT id, usuario, rol FROM usuarios";
$result = mysqli_query($conexion, $query);

// Verificar si hay resultados de la consulta (es decir, si existen trabajadores registrados).
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Trabajadores</title>
    <!-- Enlazar el archivo CSS de Bootstrap para dar estilo a la página. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilo personalizado para la página */
        body {
            background-color: #f8f9fa; /* Color de fondo */
            padding: 20px; /* Espaciado interno */
            font-family: Arial, sans-serif; /* Fuente de la página */
        }
        .container {
            max-width: 1200px; /* Limitar el tamaño máximo de la página */
        }
        .table-container {
            background: #fff; /* Fondo blanco para la tabla */
            padding: 20px; /* Espaciado interno */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }
        .form-container {
            background: #fff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%; /* Asegura que la tabla ocupe todo el ancho */
            margin-top: 20px; /* Espacio superior */
            border-collapse: collapse; /* Eliminar espacio entre celdas */
        }
        th, td {
            text-align: left; /* Alineación a la izquierda del texto en las celdas */
            padding: 8px; /* Espaciado dentro de las celdas */
        }
        th {
            background-color: #667eea; /* Color de fondo de las cabeceras */
            color: white; /* Color de texto blanco en las cabeceras */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Color alternativo de fondo para filas pares */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registrar Nuevo Trabajador</h2>
    <!-- Botón para regresar al panel de administración -->
    <a href="admin.php" class="btn btn-primary mb-3">Volver al Panel Admin</a>

    <div class="form-container">
        <h3>Agregar Nuevo Trabajador</h3>
        <!-- Mostrar errores o mensajes de éxito -->
        <?php if ($error): ?>
            <div class="alert alert-warning"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Formulario para agregar un nuevo trabajador -->
        <form method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre de Usuario:</label>
                <input type="text" name="usuario" class="form-control" id="usuario" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol:</label>
                <select name="rol" class="form-control" id="rol" required>
                    <option value="admin">Administrador</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>

            <button type="submit" name="add_trabajador" class="btn btn-success">Agregar Trabajador</button>
        </form>
    </div>

    <div class="table-container">
        <h3>Trabajadores Registrados</h3>
        <?php
        // Si la consulta devolvió resultados, se muestra una tabla con los trabajadores registrados.
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>";

            // Mostrar cada trabajador en la tabla.
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["usuario"] . "</td>
                        <td>" . $row["rol"] . "</td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            // Si no hay trabajadores registrados, mostrar un mensaje.
            echo "No se encontraron trabajadores.";
        }
        ?>
    </div>
</div>

<!-- Incluir el archivo JavaScript de Bootstrap para funcionalidades interactivas (como el formulario). -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
