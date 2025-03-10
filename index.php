<?php
session_start();

// Si el usuario no está autenticado, lo redirige al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Incluir la conexión a la base de datos
include('conexion.php');

// Definir variables
$error = "";
$server = "localhost:3307";
$db_name = "faunacompleja";

// Verificar conexión
if ($conexion) {
    $conexion_msg = "Conexión exitosa a la base de datos '$db_name' en el servidor '$server'";
} else {
    $conexion_msg = "Error al conectar a la base de datos '$db_name'";
}

// Cierre de sesión
if (isset($_POST['logout'])) {
    session_unset();  
    session_destroy(); 
    setcookie(session_name(), '', time() - 3600, '/'); 
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fauna Compleja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e1e1e, #333);
            font-family: 'Arial', sans-serif;
            color: #fff;
            text-align: center;
        }

        .navbar {
            background: #222;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .navbar a {
            color: white;
            font-size: 20px;
            padding: 10px 15px;
            text-decoration: none;
            transition: 0.3s;
        }

        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .titulo {
            font-size: 35px;
            font-weight: bold;
            color: #ffcc00;
            margin-left: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .navbar .logout-container {
            margin-left: auto;
        }

        .btn-logout {
            background-color: #ff5555;
            border: none;
            padding: 12px 18px;
            color: white;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
        }

        .btn-logout:hover {
            background-color: #cc4444;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .row {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            border-radius: 8px;
        }

        .card h3 {
            margin-top: 15px;
            color: #ffcc00;
        }

        .card p {
            font-size: 14px;
        }

        iframe {
            border-radius: 10px;
            width: 100%;
            height: 400px;
        }

    </style>
</head>
<body>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand titulo" href="#">Fauna Compleja 🦁🌿</a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Cambiar "Especies" por "Animales" y hacer que apunte a leerDatos.php -->
                <li class="nav-item"><a class="nav-link" href="leerDatos.php">Animales Disponibles en el recorrido</a></li>
                <li class="nav-item"><a class="nav-link" href="#mapa">Mapa</a></li>
            </ul>

            <div class="logout-container">
                <form method="post" class="d-flex">
                    <button type="submit" name="logout" class="btn-logout">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container">
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?> 👋</h2>

    <!-- Sección de Especies -->
    <div id="section1">
        <h1>Especies de Fauna</h1>
        <div class="row">
            <!-- Ejemplo de tarjeta de animal -->
            <div class="card">
                <img src="https://placekitten.com/500/300" alt="Tigre de Bengala">
                <h3>🐯 Tigre de Bengala</h3>
                <p>El tigre de Bengala es una de las especies más icónicas de la fauna asiática.</p>
                <h4>Alimentación:</h4>
                <p>Son carnívoros estrictos, se alimentan de grandes mamíferos como ciervos, jabalíes y búfalos.</p>
            </div>

            <div class="card">
                <img src="https://placekitten.com/501/301" alt="Elefante Africano">
                <h3>🐘 Elefante Africano</h3>
                <p>El elefante africano es el mamífero terrestre más grande del planeta.</p>
                <h4>Alimentación:</h4>
                <p>Son herbívoros y comen hierbas, cortezas de árboles, frutas y plantas acuáticas.</p>
            </div>

            <div class="card">
                <img src="https://placekitten.com/502/302" alt="Águila Real">
                <h3>🦅 Águila Real</h3>
                <p>El águila real es un ave rapaz conocida por su aguda visión.</p>
                <h4>Alimentación:</h4>
                <p>Se alimenta principalmente de mamíferos pequeños como liebres y conejos, así como de aves y reptiles.</p>
            </div>

            <!-- Más animales -->
            <div class="card">
                <img src="https://placekitten.com/503/303" alt="León">
                <h3>🦁 León</h3>
                <p>El león es conocido como el rey de la selva debido a su gran fuerza y su melena característica.</p>
                <h4>Alimentación:</h4>
                <p>Son carnívoros y cazan animales como cebras, antílopes y jabalíes.</p>
            </div>

            <div class="card">
                <img src="https://placekitten.com/504/304" alt="Oso Polar">
                <h3>🐻‍❄️ Oso Polar</h3>
                <p>El oso polar es una de las especies más icónicas del Ártico.</p>
                <h4>Alimentación:</h4>
                <p>Son carnívoros, su dieta principal consiste en focas.</p>
            </div>

            <div class="card">
                <img src="https://placekitten.com/505/305" alt="Gorila">
                <h3>🦍 Gorila</h3>
                <p>Los gorilas son grandes primates que viven en las selvas de África.</p>
                <h4>Alimentación:</h4>
                <p>Son herbívoros, su dieta consiste en frutas, hojas, tallos y plantas.</p>
            </div>

            <div class="card">
                <img src="https://placekitten.com/506/306" alt="Cebra">
                <h3>🦓 Cebra</h3>
                <p>Las cebras son conocidas por sus rayas blancas y negras.</p>
                <h4>Alimentación:</h4>
                <p>Son herbívoras, su dieta incluye pasto y hierbas.</p>
            </div>

            <div class="card">
                <img src="https://placekitten.com/507/307" alt="Koala">
                <h3>🐨 Koala</h3>
                <p>El koala es un marsupial nativo de Australia.</p>
                <h4>Alimentación:</h4>
                <p>Se alimentan principalmente de hojas de eucalipto.</p>
            </div>

            <div class="card">
                <img src="https://placekitten.com/508/308" alt="Cocodrilo">
                <h3>🐊 Cocodrilo</h3>
                <p>El cocodrilo es un gran reptil que vive en aguas tropicales.</p>
                <h4>Alimentación:</h4>
                <p>Son carnívoros y cazan peces, aves y mamíferos pequeños.</p>
            </div>

            <div class="card">
                <img src="https://placekitten.com/509/309" alt="Jirafa">
                <h3>🦒 Jirafa</h3>
                <p>La jirafa es el animal terrestre más alto del mundo.</p>
                <h4>Alimentación:</h4>
                <p>Son herbívoras, se alimentan principalmente de hojas de acacia.</p>
            </div>

            <!-- Sigue agregando más animales aquí... -->

            <!-- Total 23 animales más -->
        </div>
    </div>

    <!-- Sección de Mapa -->
    <div id="mapa" style="margin-top: 40px;">
        <h1>🌎 Mapa de Recorrido</h1>
        <iframe src="https://www.google.com/maps/d/u/0/embed?mid=18UEYOrgJiW-FU6-AydQHElqI-Hs&ll=42.936342999999994%2C-5.327181999999997&z=10"></iframe>
    </div>

</div>

<!-- Mensaje de conexión -->
<div class="text-center mt-4">
    <small><?php echo $conexion_msg; ?></small>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
