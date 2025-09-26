
    <?php
header('Content-Type: application/json');
session_start();
date_default_timezone_set('America/Mexico_City');
include 'db.php';
include 'error_log.php';

$status = $_POST['status'] ?? '';
$payment_id = $_POST['id'] ?? '';

if($status === 'succeeded'){
    $payment_status = 'approved';
   

$idusrv = $_SESSION['idUser'] ?? null;
$paquete = $_SESSION['paquete'] ?? null;



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
        $net_received_amount = $cargo1;
        
        // Datos del usuario
        $sql = "SELECT founder, nombre, apellido, mail, numero, credit, claseBienvenida, customer_id FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idusrv);
        $stmt->execute();
        $result = $stmt->get_result();
        

        if ($result->num_rows === 0) {
            ob_end_clean();
            http_response_code(404);
            die(json_encode(['error' => 'Usuario no encontrado']));
        }

        $row = $result->fetch_assoc();
        if($row['claseBienvenida'] == 1 && $paquete == 1){
            ob_end_clean();
            echo json_encode(['error' => "CLASE BIENVENIDA UTILIZADA"]);
            exit;
        }


        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        if(empty($apellido)){
            $apellido = "lópez";
        }
        $numero = $row['numero'];
        $creditos = $row['credit'];
        $mail = $row['mail'];
        $customer_id = $row['customer_id'];
        $founder = $row['founder'];

        $clases = $credits;

        if($credits == "ILIMITADO" || $credits == "ilimitado"){  
                $credits = 30;
        }elseif($credits == "ANUALIDAD" || $credits == "anualidad"){
                $credits = 365;
        }
        $new_credit = $credits;
         $net_received_amount = $cargo1;

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
        $payment_id,
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
    $stmt_trans->bind_param("ssssssss", $idusrv, $cargo1, $credits, $numero, $method, $payment_id, $net_received_amount, $dateNow);
    $stmt_trans->execute();


    ///confirmacion por email
        $mail_mailing = $_SESSION['email'];
        $mail_asunto = "Gracias por tu compra";
        $mail_motivo = "Confirmación de compra";
        $mail_motivo2 = "Adquiriste un nuevo paquete con $clases clases";
        $mail_descripcion = "Tu compra se procesó correctamente, ahora tienes $clases créditos, y expiran el $vence. Puedes revistar los detalles de tus créditos en tu perfil.";
        $mail_tabla = "Tu ID de aprobación es el $payment_id";
        include 'success_mail.php';

    echo json_encode([
        'pass' => true,
        'payment_id' => $payment_id,
        'payment_status' => "approved"
        
    ]);

    $_SESSION['codeD'] = null;
 
}else{
    

     echo json_encode([
        'pass' => false,
        'payment_status' => "rejected",
        'payment_id' => $payment_id
    ]);
    exit;
}