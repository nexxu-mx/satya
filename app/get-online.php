<?php
require_once('../db.php');

header('Content-Type: application/json');

try {
    // Consulta para obtener los cursos
    $query = " SELECT id, type, title, description, duration, level, equipment FROM online ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $cursos = [];
    
    while ($row = $result->fetch_assoc()) {

        $disciplinaPath = "../online/" . $row['id'] . ".png";
        $defaultPathD = "../assets/images/disciplinas/unknow.jpg";

        if (!file_exists($disciplinaPath)) {
            $disciplinaPath = $defaultPathD;
        }
        $cursos[] = [
            'id' => $row['id'],
            'nombre' => $row['title'],
            'imagen' => $disciplinaPath,
            'descripcion' => $row['description'] ?: 'Sin descripción disponible',
            'tipo' => $row['type'],
            'duracion' => $row['duration'],
            'nivel' => $row['level'],
            'equipo' => $row['equipment']
        ];
    }

    echo json_encode(['cursos' => $cursos]);

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>