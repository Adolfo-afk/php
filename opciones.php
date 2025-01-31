<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opciones - Alumnos</title>
    <!-- Link al CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Opciones de Lectura de Datos</h1>
        
        <!-- Sección Leer Datos -->
        <div class="card my-4">
            <div class="card-header">
                <h3>Leer Datos</h3>
            </div>
            <div class="card-body">
                <!-- Botón para ver todos los alumnos -->
                <div class="mb-3">
                    <a href="leerTodos.php" class="btn btn-primary">Alumnos</a>
                </div>
                
                <!-- Formulario de búsqueda -->
                <form action="leerFiltro.php" method="POST">
                    <!-- Campo Nombre -->
                    <div class="mb-3">
                        <label for="nombreAlumno" class="form-label">Nombre del alumno:</label>
                        <input type="text" class="form-control" id="nombreAlumno" name="nombre" placeholder="Introduce el nombre">
                    </div>

                    <!-- Campo Edad -->
                    <div class="mb-3">
                        <label for="edadAlumno" class="form-label">Edad:</label>
                        <input type="number" class="form-control" id="edadAlumno" name="edad" placeholder="Introduce la edad">
                    </div>

                    <!-- Campo Curso -->
                    <div class="mb-3">
                        <label for="cursoAlumno" class="form-label">Curso:</label>
                        <input type="text" class="form-control" id="cursoAlumno" name="curso" placeholder="Introduce el curso">
                    </div>

                    <!-- Campo Promociona -->
                    <div class="mb-3">
                        <label for="promocionaAlumno" class="form-label">¿Promociona?</label>
                        <select class="form-control" id="promocionaAlumno" name="promociona">
                            <option value="">Seleccione una opción</option>
                            <option value="Si">Sí</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Ver</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
