<?php
include('conexion.php');

$usuarios = [
    ['usuario' => 'Admin', 'password' => 'admin123', 'rol' => 'admin'],
    ['usuario' => 'Usuario', 'password' => 'user123', 'rol' => 'usuario']
];

foreach ($usuarios as $user) {
    $usuario = $user['usuario'];
    $password = password_hash($user['password'], PASSWORD_DEFAULT);
    $rol = $user['rol'];

    $query = "INSERT INTO usuarios (usuario, password, rol) VALUES ('$usuario', '$password', '$rol')";
    mysqli_query($conexion, $query);
}

echo "Usuarios creados correctamente.";
mysqli_close($conexion);
?>
