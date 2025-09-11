<?php
include './db.php';

// Obtiene el body en bruto que envía Mercado Pago
$raw_post = file_get_contents("php://input");
$data = json_decode($raw_post, true);

// Log opcional (útil para debug)
file_put_contents("webhook_log.txt", date("Y-m-d H:i:s") . " - " . $raw_post . "\n", FILE_APPEND);

// Verificamos que sea de tipo "payment" y acción "payment.updated"
if (isset($data["type"]) && $data["type"] === "payment" && isset($data["action"]) && $data["action"] === "payment.updated") {
    $payment_id = $data["data"]["id"];
    $sqlP = "SELECT id FROM users WHERE idpago = ?";
    $smtP = $conn->prepare($sqlP);
    $smtP->bind_param("i", $payment_id); // "s" para string, "i" si es integer
    $smtP->execute();
    $resultP = $smtP->get_result();
   if($resultP->num_rows > 0){
        $rowP = $resultP->fetch_assoc();
        $idusrv = $rowP['id'];
    }else{
        http_response_code(200);
        echo "OK";
        exit;
    }
    // IMPORTANTE: Verificar que el webhook es auténtico de Mercado Pago
    // Puedes validar el header X-Signature si lo necesitas para mayor seguridad

    // Llamar a la API de MP para obtener detalles del pago
    $access_token = "APP_USR-8126254666416836-081816-26a9a0c82336250bf1ac1cec65f3ab2b-2521441034"; // tu token de producción
    $url = "https://api.mercadopago.com/v1/payments/" . $payment_id;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $access_token
    ]);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 200) {
        $payment_info = json_decode($response, true);
        
        // Obtener información adicional necesaria de tu base de datos
        // Por ejemplo: paquete, vigencia, invitados, etc.
        $sql_user = "SELECT * FROM users WHERE id = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("i", $idusrv);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        
        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            // Suponiendo que tienes estos valores en tu base de datos
            $paquete = $user['paquete'];
            $vigencia = $user['vigencia']; // o de donde corresponda
            $invitados = $user['maxInvitados']; // o de donde corresponda
            
            if (isset($payment_info["status"])) {
                $payment_status = $payment_info["status"];
                $cargo1 = $payment_info["transaction_amount"]; // monto del pago
                $credits = 0; // Definir según tu lógica de negocio
                $numero = ""; // Definir según tu lógica de negocio
                
                if ($payment_status === "approved") {
                    $fechaCredit = date('Y-m-d');
                    $dias = (int)$vigencia; // si vigencia viene como número de días
                    $vence = date('Y-m-d', strtotime("+{$dias} days"));
                    
                    // Calcular el nuevo crédito
                    $new_credit = $user['credit'] + $credits; // Ajusta según tu lógica
                    
                    $bienvenida = ($paquete == 1 || $user['claseBienvenida'] == 1) ? 1 : 0;

                    $sql_update = "UPDATE users 
                                SET credit = ?, 
                                    venceCredit = ?, 
                                    fechaCredit = ?,
                                    paquete = ?, 
                                    maxInvitados = ?, 
                                    claseBienvenida = ?, 
                                    statu = ?, 
                                    idpago = ?, 
                                    montoPagado = ? 
                                WHERE id = ?";

                    $stmt_update = $conn->prepare($sql_update);
                    if (!$stmt_update) {
                        die('Error en prepare: ' . $conn->error);
                    }

                    $stmt_update->bind_param(
                        "issiiissdi",
                        $new_credit,
                        $vence,      // venceCredit (fecha)
                        $fechaCredit, // fechaCredit
                        $paquete,
                        $invitados,
                        $bienvenida,
                        $payment_status,
                        $payment_id,
                        $cargo1,
                        $idusrv
                    );

                    if (!$stmt_update->execute()) {
                        file_put_contents("webhook_log.txt", date("Y-m-d H:i:s") . " - Error en execute: " . $stmt_update->error . "\n", FILE_APPEND);
                    }
                    
                    // Registrar transacción
                    $dateNow = date('Y-m-d H:i:s', time());
                    $method = "3"; // Método de pago (Mercado Pago)
                    
                    // Obtener monto recibido neto
                    $net_received = isset($payment_info['transaction_details']['net_received_amount']) ? 
                                    $payment_info['transaction_details']['net_received_amount'] : 0;
                    
                    $stmt_trans = $conn->prepare("INSERT INTO transacciones (user, monto, creditos, numero, metodo, idpago, mrecibido, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt_trans->bind_param("ssssssss", $idusrv, $cargo1, $credits, $numero, $method, $payment_id, $net_received, $dateNow);
                    
                    if (!$stmt_trans->execute()) {
                        file_put_contents("webhook_log.txt", date("Y-m-d H:i:s") . " - Error en transacción: " . $stmt_trans->error . "\n", FILE_APPEND);
                    }

                    // 4. Guardar tarjeta si es necesario
                    // Nota: En el webhook no viene información de tarjeta, esto deberías manejarlo
                    // en el flujo de pago inicial, no en el webhook
                } else {
                    $status_update = ($payment_status === "pending") ? $payment_status : "Rechazo por MP";
                    $stmt_update = $conn->prepare("UPDATE users SET statu = ?, idpago = ?, montoPagado = ? WHERE id = ?");
                    $stmt_update->bind_param("sssi", $status_update, $payment_id, $cargo1, $idusrv);
                    
                    if (!$stmt_update->execute()) {
                        file_put_contents("webhook_log.txt", date("Y-m-d H:i:s") . " - Error al actualizar estado: " . $stmt_update->error . "\n", FILE_APPEND);
                    }
                }
            }
        } else {
            file_put_contents("webhook_log.txt", date("Y-m-d H:i:s") . " - Usuario no encontrado: " . $idusrv . "\n", FILE_APPEND);
        }
    } else {
        file_put_contents("webhook_log.txt", date("Y-m-d H:i:s") . " - Error al consultar pago en MP: " . $http_code . "\n", FILE_APPEND);
    }
} else {
    file_put_contents("webhook_log.txt", date("Y-m-d H:i:s") . " - Webhook no es de tipo payment o acción payment.updated\n", FILE_APPEND);
}

// Responder siempre 200 para que MP no reintente infinito
http_response_code(200);
echo "OK";
?>