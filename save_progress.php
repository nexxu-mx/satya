<?php
// Configurar cabeceras para respuesta JSON
header('Content-Type: application/json');
session_start();
date_default_timezone_set('America/Mexico_City');
include './db.php';

// Verificar que sea una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// Obtener y verificar el contenido JSON
$json_data = file_get_contents('php://input');

if ($json_data === false || empty($json_data)) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos JSON no recibidos']);
    exit;
}

// Decodificar el JSON
$data = json_decode($json_data, true);

// Verificar errores en la decodificación
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'JSON inválido: ' . json_last_error_msg()]);
    exit;
}

// Verificar campos requeridos
$required_fields = ['video_id', 'progress', 'current_time', 'duration'];
foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Campo requerido faltante: $field"]);
        exit;
    }
}

// Almacenar en variables con validación de tipos
$user_id = $_SESSION['idUser'];
if(empty($user_id)){
    http_response_code(401);
    echo json_encode(['error' => 'Usuario sin Log']);
    exit;
}
$video_id = (string)$data['video_id'];
$progress = (float)$data['progress'];
$current_time = (float)$data['current_time'];
$duration = (float)$data['duration'];
$fechastamp = time();

$fecha = date("d-m-Y H:i:s", $fechastamp);


// Validar rangos lógicos (opcional pero recomendado)
if ($progress < 0 || $progress > 100) {
    http_response_code(400);
    echo json_encode(['error' => 'Progress debe estar entre 0 y 100']);
    exit;
}

if ($current_time < 0 || $current_time > $duration) {
    http_response_code(400);
    echo json_encode(['error' => 'Tiempo actual inválido']);
    exit;
}

// **PROCESAMIENTO EXITOSO**
$sql = ("SELECT id FROM progress_elearning WHERE userID = ? AND video_id = ?");
$smt = $conn->prepare($sql);
$smt->bind_param("ii", $user_id, $video_id);
$smt->execute();
$result = $smt->get_result();
if ($result->num_rows > 0) {
    // Ya existe
    $sqlU = "UPDATE progress_elearning SET currentTime = ?, duration = ?, progress = ?, fecha = ? WHERE userID = ? AND video_id = ?";
    $stmtU = $conn->prepare($sqlU);
    $stmtU->bind_param("ssssss", $current_time, $duration, $progress, $fecha, $user_id, $video_id); 
    $stmtU->execute();
    if ($stmtU->affected_rows > 0) {
    echo json_encode([
    'success' => true,
        'message' => 'Datos actualizados correctamente',
        'data' => [
            'video_id' => $video_id,
            'progress' => $progress,
            'current_time' => $current_time,
            'duration' => $duration
        ]
    ]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Error al actualizar registro']);
        exit;
    }


} else {
    $sqlU = "INSERT INTO progress_elearning (userID, currentTime, duration, progress, video_id, fecha) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmtU = $conn->prepare($sqlU);
    $stmtU->bind_param("ssssss", $user_id, $current_time, $duration, $progress, $video_id, $fecha); // iid = int, int, decimal
    $stmtU->execute();

    if ($stmtU->affected_rows > 0) {
        echo json_encode([
        'success' => true,
            'message' => 'Datos creados correctamente',
            'data' => [
                'video_id' => $video_id,
                'progress' => $progress,
                'current_time' => $current_time,
                'duration' => $duration
            ]
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Error al crear registro']);
        exit;
    }
    // No existe
}


?>