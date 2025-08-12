<?php
$host = '82.197.82.15'; 
$usuario = 'u379047759_estudiosatya';
$contrasena = 'Satya2025?';
$base_de_datos = 'u379047759_satya';

$conn = new mysqli($host, $usuario, $contrasena, $base_de_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "Conexión exitosa";
?>
