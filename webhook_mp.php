<?php
include './db.php';
// Obtiene el body en bruto que envía Mercado Pago
$raw_post = file_get_contents("php://input");
$data = json_decode($raw_post, true);

// Log opcional (útil para debug)
file_put_contents("webhook_log.txt", date("Y-m-d H:i:s") . " - " . $raw_post . "\n", FILE_APPEND);

// Verificamos que sea de tipo "payment"
if (isset($data["type"]) && $data["type"] === "payment") {
    $payment_id = $data["data"]["id"];

    // Llamar a la API de MP para obtener detalles del pago
    $access_token = "APP_USR-8424105593741503-091100-e03eeb503a13580672c58898a1578630-327557794"; // tu token de producción
    $url = "https://api.mercadopago.com/v1/payments/" . $payment_id;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $access_token
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $payment_info = json_decode($response, true);
    $idusrv = 1;
    if (isset($payment_info["status"])) {
       // 3. Si el pago fue aprobado
       $payment_status = $payment_info["status"];
            if ($payment_status === "approved") {
            

            $fechaCredit = date('Y-m-d');
            $dias = (int)$vigencia; // si vigencia viene como número de días

            $vence = date('Y-m-d', strtotime("+{$dias} days"));

            $bienvenida = ($paquete == 1 || $row['claseBienvenida'] == 1) ? 1 : 0;

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
                $dias,      // venceCredit
                $vence, // fechaCredit
                $paquete,
                $invitados,
                $bienvenida,
                $payment_status,
                $payment->id,
                $cargo1,
                $idusrv
            );

        


            if (!$stmt_update->execute()) {
            die('Error en execute: ' . $stmt_update->error);
            }
            
            // Registrar transacción
            $dateNow = date('Y-m-d H:i:s', time());
            $method = "3"; // Método de pago (Mercado Pago)
            $stmt_trans = $conn->prepare("INSERT INTO transacciones (user, monto, creditos, numero, metodo, idpago, mrecibido, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_trans->bind_param("ssssssss", $idusrv, $cargo1, $credits, $numero, $method, $payment->id, $payment->transaction_details->net_received_amount, $dateNow);
            $stmt_trans->execute();

            // 4. Guardar tarjeta si es necesario
            if ($data['save_card'] == true) {
            // $card_id = $payment->card->id;
                $card_id = $data['token'];
                // Verificar si la tarjeta ya está registrada
                $stmt_check = $conn->prepare("SELECT id FROM user_cards WHERE user_id = ? AND card_id = ?");
                $stmt_check->bind_param("is", $idusrv, $card_id);
                $stmt_check->execute();
                $stmt_check->store_result();
                
                
            }
            } else {
            $status_update = ($payment_status === "pending") ? $payment_status : "Rechazo por MP";
            $stmt_update = $conn->prepare("UPDATE users SET statu = ?, idpago = ?, montoPagado = ? WHERE id = ?");
            $stmt_update->bind_param("sssi", $status_update, $payment->id, $cargo1, $idusrv);
            $stmt_update->execute();
            }
    }
}

// Responder siempre 200 para que MP no reintente infinito
http_response_code(200);
echo "OK";
?>