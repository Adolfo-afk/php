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
                <h3>Insertar Datos</h3>
            </div>
            <div class="card-body">
                <form action="enviarDatos.php" method="POST">
                    <div class="mb-3">
                        <label for="nombreNuevo" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombreNuevo" name="nombre" placeholder="Introduce el nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="edadNuevo" class="form-label">Edad:</label>
                        <input type="number" class="form-control" id="edadNuevo" name="edad" placeholder="Introduce la edad" required>
                    </div>
                    <div class="mb-3">
                        <label for="cursoNuevo" class="form-label">Curso:</label>
                        <input type="text" class="form-control" id="cursoNuevo" name="curso" placeholder="Introduce el curso">
                    </div>
                    <div class="mb-3">
                        <label for="promocionaNuevo" class="form-label">¿Promociona?:</label>
                        <select class="form-control" id="promocionaNuevo" name="promociona">
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Scripts de Bootstrap -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>