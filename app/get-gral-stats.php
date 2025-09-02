<?php
require_once('../db.php');

header('Content-Type: application/json');

try {
    // 1. Total de visitas (visitas únicas por IP)
    $query_visitas = "
        SELECT COUNT(*) as total
        FROM reservaciones
        
    ";
    $stmt = $conn->prepare($query_visitas);
    $stmt->execute();
    $Tvisitas = $stmt->get_result()->fetch_assoc()['total'];

    // 2. Total de leads (paymentusrs con idpago NULL y skus academy)
    $query_leads = "
        SELECT COUNT(*) as total
        FROM transacciones
    ";
    $stmt = $conn->prepare($query_leads);
    $stmt->execute();
    $Tleads = $stmt->get_result()->fetch_assoc()['total'];

    // 3. Total de cursos y recursos
    $query_cursos = "SELECT COUNT(*) as total FROM coaches";
    $stmt = $conn->prepare($query_cursos);
    $stmt->execute();
    $cursos = $stmt->get_result()->fetch_assoc()['total'];

    $Tcyc = $cursos;

    // 4. Total de clientes (paymentusrs con idpago NOT NULL y skus academy)
    $query_clientes = "
        SELECT COUNT(DISTINCT mail) as total
        FROM users WHERE tipoUser = 1
    ";
    $stmt = $conn->prepare($query_clientes);
    $stmt->execute();
    $Tclientes = $stmt->get_result()->fetch_assoc()['total'];

    echo json_encode([
        'visitas' => $Tvisitas,
        'leads' => $Tleads,
        'cyc' => $Tcyc,
        'clientes' => $Tclientes
    ]);

} catch (Exception $e) {
    echo json_encode([
        'error' => true,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
