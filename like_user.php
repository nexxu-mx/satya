<?php
header('Content-Type: application/json'); // importante
session_start();
// Conexión a la BD
include './db.php';

// Leer JSON enviado
$data = json_decode(file_get_contents("php://input"), true);
$postId = intval($data['postId'] ?? 0);

// Usuario logueado (ejemplo: de la sesión o token)
$userId = $_SESSION['idUser'] ?? null;

if(!empty($userId)){
    if ($postId > 0) {
        $stmt = $conn->prepare("SELECT 1 FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            echo json_encode([
                "success" => true,
                "response" => true,   // ya dio like
                "message" => "El usuario ya dio like a este post"
            ]);
        } else {
            echo json_encode([
                "success" => true,
                "response" => false,  // no ha dado like
                "user" => $userId,
                "message" => "El usuario no ha dado like todavía"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "response" => false,
            "message" => "ID de post inválido"
        ]);
    }
}else {
        echo json_encode([
            "success" => false,
            "response" => false,
            "user" => $userId,
            "message" => "user no log"
        ]);
    }
