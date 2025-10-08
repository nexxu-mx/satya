<?php
header('Content-Type: application/json');
date_default_timezone_set('America/Mexico_City');
include 'error_log.php';
include 'db.php';
session_start();
if(isset($_SESSION['idUser'])){
    $idUser = $_SESSION['idUser'];
}

$day = $_GET['day'] ?? '';
$busqueda = $_GET['ssa'] ?? '';
if ($day) {
    // Separar el día y el mes
    list($d, $mesTexto) = explode("-", strtolower($day));

    // Mapeo manual de meses en español a números 
    $meses = [
        "enero" => "01",
        "febrero" => "02",
        "marzo" => "03",
        "abril" => "04",
        "mayo" => "05",
        "junio" => "06",
        "julio" => "07",
        "agosto" => "08",
        "septiembre" => "09",
        "octubre" => "10",
        "noviembre" => "11",
        "diciembre" => "12"
    ];

    // Obtener el número del mes
    $mesNumero = $meses[$mesTexto] ?? "00"; // por si no coincide
    // Armar la fecha completa
    $fecha = "2025-$mesNumero-" . str_pad($d, 2, "0", STR_PAD_LEFT);
    $dia = "$fecha%";

        // 3. Construir la consulta SQL
        if($busqueda){
                $sql = "SELECT id, id_coach, hora_inicio, hora_fin, aforo, reservados, id_disciplina, evento, estatus 
                FROM clases 
                WHERE hora_inicio LIKE ?
                AND id_disciplina = $busqueda
                ORDER BY hora_inicio ASC";   
        }else{
        $sql = "SELECT id, id_coach, hora_inicio, hora_fin, aforo, reservados, id_disciplina, evento, estatus 
                FROM clases 
                WHERE hora_inicio LIKE ?
                ORDER BY hora_inicio ASC";
        }
        // 4. Preparar la consulta
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error en la consulta: " . $conn->error);
        }

        $stmt->bind_param("s", $dia);
        // 8. Ejecutar
        if (!$stmt->execute()) {
            die("Error al ejecutar: " . $stmt->error);
        }
    $result = $stmt->get_result();
    $stmtC = $conn->prepare("SELECT nombre_coach FROM coaches WHERE id = ?");
    $stmtD = $conn->prepare("SELECT nombre_disciplina, esp FROM disciplinas WHERE id = ?");
    $stmtU = $conn->prepare("SELECT activo FROM reservaciones WHERE alumno = ? AND idClase = ?");
    $clases = [];
    while ($row = $result->fetch_assoc()) {
        
        $id_coach = $row['id_coach'];
        $stmtC->bind_param("i", $id_coach);
        $stmtC->execute();
        $resultC = $stmtC->get_result();
    
        if ($coach = $resultC->fetch_assoc()) {
            $nombre_coach =  $coach['nombre_coach'];
        } else {
            $nombre_coach = "-";
        }

        $id_disciplina = $row['id_disciplina'];
        $stmtD->bind_param("i", $id_disciplina);
        $stmtD->execute();
        $resultD = $stmtD->get_result();
    
       
        if ($disciplina = $resultD->fetch_assoc()) {
            
                $nombre_disciplina =  $disciplina['nombre_disciplina'];
                $especial_disciplina =  $disciplina['esp'];
            
            
        } else {
            $nombre_disciplina = "-";
            $nombre_disciplina =  "-";
            $especial_disciplina =  null;
        }
        
    
   
        $abierta = 1;
        
            //estatus clase en abierta para reserva
            $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                viewBox="0 0 512 512">
                <defs>
                    <style>
                        .ionicon {
                            fill:rgb(0, 175, 6);
                        }
                    </style>
                </defs>
                <title>Ellipse</title>
                <path
                    d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
            </svg>';
        
        $aforo = $row['reservados'] . '/' . $row['aforo'];

        if($row['aforo'] <= $row['reservados']){
            //estatus clase cerrada para reserva por cupo completo
            $estatus = '<img class="icono-reserva" src="assets/images/svg/full_class.svg" alt="Clase llena ícono">';
            $abierta = 0;
        }
        // Crear objetos DateTime
        $start = new DateTime($row['hora_inicio']);
        $end = new DateTime($row['hora_fin']);
        $now = new DateTime();
   
        // Calcular diferencia
        $diff = $start->diff($end);
        $duracionMin = ($diff->h * 60) + $diff->i;

        // Mostrar duración en formato deseado
        if ($duracionMin <= 60) {
            $duracionTexto = "$duracionMin min";
        } else {
            $horas = floor($duracionMin / 60);
            $minutos = $duracionMin % 60;
            $duracionTexto = $minutos > 0 ? "$horas:$minutos h" : "$horas:00 h";
        }

        $esPasado = $start < $now;
        if ($now >= $start && $now <= $end) {
            //estatus clase en curso
            $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto" viewBox="0 0 512 512"><defs></defs> <title>Ellipse</title> <path style="fill: #986C5D" d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" /> </svg>';
        } elseif ($now < $start) {
            if($abierta == 1){
                //estatus clase en abierta para reserva
                    $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                        
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #00D52B;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>';
            }
        }elseif ($start < $now){
            $estatus = '<svg xmlns="http://www.w3.org/2000/svg" class="ionicon clase-en-curso-punto"
                    viewBox="0 0 512 512">
                    <defs>
                    </defs>
                    <title>Ellipse</title>
                    <path style="fill: #ACACAC;"
                        d="M256 464c-114.69 0-208-93.31-208-208S141.31 48 256 48s208 93.31 208 208-93.31 208-208 208z" />
                </svg>';
                $abierta = 0;
                continue;
        }

        

        // Formatear horario en formato AM/PM
        $horario = $start->format("g:i A") . " - " . $end->format("g:i A");
        $duracion = $duracionTexto;

        if(isset($idUser)){
            //validara la reserva del usuario
            $idClase = $row['id'];
            $stmtU->bind_param("ii", $idUser, $idClase);
            $stmtU->execute();
            $resultU = $stmtU->get_result();
        
            if ($Alumno = $resultU->fetch_assoc()) {
                $estatus = '<img class="icono-reserva" src="assets/images/svg/reservado.svg" alt="Clase reservada ícono">';
                $abierta = 0;
                continue;
            }
        }
        if($row['estatus'] == 2){
            //estatus clase en lista de espera
            $estatus = '<img class="icono-reserva" src="assets/images/svg/waiting_list.svg" alt="Wait List ícono">';
        }

        $pathimg = './assets/images/coaches/pro/' . $row['id_coach'] . '.png';

        if(!file_exists($pathimg)){
            $pathimg = "./assets/images/coaches/pro/unknow.jpg";
        }else{
            $pathimg = $pathimg . "?v=" . time();
        }
        
        if($abierta == 1){
            ///Anticipacion para reservar
                $hoy = new DateTime('today');
                $manana = new DateTime('tomorrow');
                $resw = "";
                // Caso 1: $start es mañana antes de las 12:00pm
                $limite1 = (clone $hoy)->setTime(22, 0); // hoy a las 10:00pm
                if ($start->format('Y-m-d') === $manana->format('Y-m-d') && $start->format('H') < 12) {
                    if ($now <= $limite1) {
                    }else{
                        if($row['reservados'] < 1){
                            $abierta = 0;
                            $resw = "*Puedes reservar por WhatsApp.1";
                        }
                    }
                }

                // Caso 2: $start es hoy después de las 12:00pm
                $limite2 = (clone $hoy)->setTime(12, 0); // hoy a las 12:00pm
                if ($start->format('Y-m-d') === $hoy->format('Y-m-d') && $start->format('H') >= 12) {
                    if ($now <= $limite2) {
                       $openclsa = true;
                    }else{
                        if($row['reservados'] < 1){
                            $abierta = 0;
                            $resw = "*Puedes reservar por WhatsApp.2";
                        }
                        
                    }
                }
                // Caso 3: si es hoy antes de las 12:00 pm 
                    $limite3 = (clone $hoy)->setTime(12, 0); // hoy a las 12:00pm

                    if ($start->format('Y-m-d') === $hoy->format('Y-m-d')) {
                        if ($now < $limite3) {
                            // 🔴 Antes de las 12:00 -> siempre cerrado
                            if($row['reservados'] < 1){
                                $abierta = 0;
                                $resw = "*Puedes reservar por WhatsApp.3";
                            }
                        }
                    }


        }
        ///manejo eventos especiales
        if(!empty($row['evento'])){
            $sqe = ("SELECT nombre, lugar FROM eventos WHERE id = ?");
            $sme = $conn->prepare($sqe);
            $sme->bind_param("i", $row['evento']);
            $sme->execute();
            $rese = $sme->get_result();
            if($rese->num_rows > 0){
                $ree = $rese->fetch_assoc();
            }
            $nameEvent = $ree['nombre'];
            $idDisc = $row['evento'];
            $nombre_coach = $ree['lugar'];

            $pathimg = "./assets/images/events/1.png";

            $event = true;
        }else{
            $idDisc = $row['id_disciplina'];
            $event = false;
            $nameEvent = false;
        }
        $clases[] = [
            "id" => $row['id'],
            "id_coach" => $row['id_coach'],
            "nombre_coach" => $nombre_coach,
            "horario" => $horario,
            "duracion" => $duracion,
            "pathimg" => $pathimg,
            "aforo" => $aforo,
            "estatus" => $estatus,
            "disciplina" => $nombre_disciplina,
            "id_disciplina" => $idDisc,
            "esp_disciplina" => $especial_disciplina,
            "abierta" => $abierta,
            "nota" => $resw,
            "evento" => $event,
            "name" => $nameEvent
        ];
        
    }
    $stmtC->close();
    $stmtD->close();
    echo json_encode($clases);
} else {
    echo json_encode([]);
}
?>
