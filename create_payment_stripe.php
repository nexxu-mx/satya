<?php
include './db.php';
include './error_log.php';
require 'vendor/autoload.php';
session_start();
$idusrv = $_SESSION['idUser'] ?? null;
$paquete = $_SESSION['paquete'] ?? null;

/// carga key

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad(); // lee el archivo .env

// Detecta el entorno (test o live)
$stripeMode = $_ENV['STRIPE_MODE'] ?? 'test';

if ($stripeMode === 'live') {
    $stripeSecret = $_ENV['STRIPE_LIVE_SECRET'];
    $stripePublishable = $_ENV['STRIPE_LIVE_PUBLISHABLE'];
} else {
    $stripeSecret = $_ENV['STRIPE_TEST_SECRET'];
    $stripePublishable = $_ENV['STRIPE_TEST_PUBLISHABLE'];
}

// Obtener información del paquete
$sqlP = "SELECT clases, costo, vigencia, invitados, descuento FROM paquetes WHERE id = ?";
$stmtP = $conn->prepare($sqlP);
$stmtP->bind_param("i", $paquete);
$stmtP->execute();
$resultP = $stmtP->get_result();

if ($resultP->num_rows === 0) {
    ob_end_clean();
    http_response_code(400);
    die(json_encode(['error' => 'Paquete no encontrado']));
}

$rowP = $resultP->fetch_assoc();
$credits = $rowP['clases'];
$vigencia = $rowP['vigencia'];
$invitados = $rowP['invitados'];
       


    if(!empty($rowP['descuento'])){
        $costo1 = ($rowP['costo'] / 100) * $rowP['descuento'];
        $costo2 = $rowP['costo'] - $costo1;
        $cargo1 = (float) $costo2;
    }elseif(!empty($_SESSION['codeD'])){
        $costo1 = ($rowP['costo'] / 100) * $_SESSION['codeD'];
        $costo2 = $rowP['costo'] - $costo1;
        $cargo1 = (float) $costo2;
    }else{
        $cargo1 = (float) $rowP['costo'];
    }

    $cargo_stripe = $cargo1 * 100;
\Stripe\Stripe::setApiKey($stripeSecret); 
// TEST:::::
header('Content-Type: application/json');

// Obtener el monto del frontend (en centavos) 

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $cargo_stripe,
        'currency' => 'mxn', // o 'usd'
        'payment_method_types' => ['card'],
    ]);

    echo json_encode(['clientSecret' => $paymentIntent->client_secret]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
