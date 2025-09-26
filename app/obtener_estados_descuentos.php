<?php
header('Content-Type: application/json');
require '../db.php'; // aquí está $conn

$result = $conn->query("SELECT id, activo FROM descuentos");

$estados = [];
while ($row = $result->fetch_assoc()) {
    $estados[] = [
        "id" => $row['id'],
        "activo" => ($row['activo'] == 1 ? 1 : 0) // 1 si está activo, 0 si es null
    ];
}

echo json_encode($estados);
