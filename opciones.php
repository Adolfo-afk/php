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
        <h1>Opciones de Datos</h1>
        
        <!-- Sección Leer Datos -->
        <div class="card my-4">
            <div class="card-header">
                <h3>Leer Datos</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="leerTodos.php" class="btn btn-primary">Alumnos</a>
                </div>
                <form action="leerFiltro.php" method="POST">
                    <div class="mb-3">
                        <label for="nombreAlumno" class="form-label">Ver alumnos cuyo nombre sea:</label>
                        <input type="text" class="form-control" id="nombreAlumno" name="nombre" placeholder="Introduce el nombre del alumno" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ver</button>
                </form>
            </div>
        </div>
        

        <!-- Sección Insertar Datos -->
        <div class="card my-4">
            <div class="card-header">
                <h3>Insertar Datos de Alumnos</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="mb-3">
                        <a href="introducirDatos.php" class="btn btn-primary">Introducir Datos Alumnos</a>
                    </div>
                </div>
            </div>

        </div>
    </div>


     <!-- Sección Eliminar Datos -->
     <div class="card my-4">
            <div class="card-header">
                <h3>Elimnar Datos</h3>
            </div>
            <div class="card-body">
                <form action="EliminarFiltro.php" method="POST">
                    <div class="mb-3">
                        <label for="id" class="form-label">Eliminar alumnos cuyo id sea:</label>
                        <input type="text" class="form-control" id="idAlumno" name="id" placeholder="Introduce el id del alumno a eliminar:" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>

     <!-- Sección Modificar Datos -->
     <div class="card my-4">
            <div class="card-header">
                <h3>Modificar Datos</h3>
            </div>
            <div class="card-body">
                <form action="modificarFiltro.php" method="POST">
                    <div class="mb-3">
                        <label for="id" class="form-label">Modificar alumno cuyo ID sea:</label>
                        <input type="text" class="form-control" id="idAlumno" name="id" placeholder="Introduce el ID del alumno a modificar:" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nuevo nombre del alumno:</label>
                        <input type="text" class="form-control" id="nombreAlumno" name="nombre" placeholder="Introduce el nuevo nombre del alumno" required>
                    </div>
                    <div class="mb-3">
                        <label for="edad" class="form-label">Nueva edad del alumno:</label>
                        <input type="number" class="form-control" id="edadAlumno" name="edad" placeholder="Introduce la nueva edad del alumno" required>
                    </div>
                    <div class="mb-3">
                        <label for="curso" class="form-label">Nuevo curso del alumno:</label>
                        <input type="text" class="form-control" id="cursoAlumno" name="curso" placeholder="Introduce el nuevo curso del alumno" required>
                    </div>
                    <div class="mb-3">
                        <label for="promocionar" class="form-label">Promocionar alumno:</label>
                        <select class="form-control" id="promocionarAlumno" name="promocionar" required>
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Modificar</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Scripts de Bootstrap -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>