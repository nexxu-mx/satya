<?php
include '../db.php';

header('Content-Type: application/json');

$json = file_get_contents('php://input');
$data = json_decode($json);

if ($data && isset($data->idClase) && isset($data->idInstructor)) {
    $idClase = (int) $data->idClase;
    $idInstructor = (int) $data->idInstructor;

    try {
        $query = "UPDATE clases SET id_coach = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($query);
        $stmtUpdate->bind_param("ii", $idInstructor, $idClase);

        if ($stmtUpdate->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Instructor actualizado correctamente"
            ]);
        } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
}
