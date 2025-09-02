<?php
header('Content-Type: application/json');
session_start();

// Incluir la conexión a la base de datos
require_once 'db.php';

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener y validar datos
$postId = $_POST['post_id'] ?? null;
$action = $_POST['action'] ?? '';

if (!$postId || !in_array($action, ['like', 'unlike'])) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

// Sanitizar el post_id
$postId = filter_var($postId, FILTER_SANITIZE_NUMBER_INT);

// Verificar si el usuario está logueado
$userId = $_SESSION['idUser'] ?? null;

if ($userId) {
    // Usuario logueado - manejar en base de datos
    try {
        if ($action === 'like') {
            // Insertar like en la base de datos
            $stmt = $conn->prepare("INSERT INTO likes (post_id, user_id, created_at) VALUES (?, ?, NOW())");
            $stmt->bind_param("ii", $postId, $userId);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Like agregado', 'in_db' => true]);
            } else {
                // Verificar si es un duplicado (ya existe el like)
                if ($conn->errno === 1062) { // Código de error para duplicados
                    echo json_encode(['success' => true, 'message' => 'Like ya existente', 'in_db' => true]);
                } else {
                    throw new Exception('Error al insertar like: ' . $conn->error);
                }
            }
            
        } else { // unlike
            // Eliminar like de la base de datos
            $stmt = $conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
            $stmt->bind_param("ii", $postId, $userId);
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo json_encode(['success' => true, 'message' => 'Like eliminado', 'in_db' => true]);
                } else {
                    echo json_encode(['success' => true, 'message' => 'Like no existía', 'in_db' => true]);
                }
            } else {
                throw new Exception('Error al eliminar like: ' . $conn->error);
            }
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        error_log('Error en like_handler: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error del servidor: ' . $e->getMessage()]);
    }
    
} else {
    // Usuario no logueado - solo manejar en localStorage
    echo json_encode([
        'success' => true, 
        'message' => 'Like manejado localmente', 
        'usr' => $_SESSION['idUser'],
        'in_db' => false,
        'action' => $action
    ]);
}

// Cerrar conexión
if (isset($conn)) {
    $conn->close();
}
?>