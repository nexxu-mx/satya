<?php
header('Content-Type: application/json; charset=utf-8');

include './db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $classID = $_POST['id'];
    ///validacion para saber si adquirio elearning

     //Token para control de descarga
    $user_id = $_SESSION['idUser'];
    $timestamp = floor(time() / 3600);
    $token = hash_hmac('sha256', $user_id . $timestamp, '887319b0c6904b38b20d3b1dd2f147f44b4bec85119e1ab6e6db226eac56e8a1');
    ///validacion para saber si adquirio elearning

    if(!empty($user_id)){
        $usx = ("SELECT elearning FROM users WHERE id = ? ");
        $stx = $conn->prepare($usx);
        $stx->bind_param("i", $user_id);
        $stx->execute();
        $usr = $stx->get_result();
            if($usr->num_rows > 0){
                $urow = $usr->fetch_assoc();

                if($urow['elearning'] == 1){
                    $activo = true;
                }else{
                     $activo = false;
                }
                
            }else{
                $activo = false;
            }
    }else{
        $activo = false;
    }



    $sql = ("SELECT type, title, description, duration, level, equipment FROM online WHERE id = ?");
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $classID);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        $tipo = $row['type'];
        $titulo = $row['title'];
        $descripcion = $row['description'];
        $duracion = $row['duration'];
        $nivel = $row['level'];
        $equipamiento = $row['equipment'];

        ///Logica para saber si el usuario ya completo la clase
        $sqlC = ("SELECT progress FROM progress_elearning WHERE userID = ? AND video_id = ?");
        $smt = $conn->prepare($sqlC);
        $smt->bind_param("ii", $user_id, $classID);
        $smt->execute();
        $result = $smt->get_result();
        if ($result->num_rows > 0) {
            $rowC = $result->fetch_assoc();
            if($rowC['progress'] == 100){
                $completado = 'compleet';
            }else{
                $completado = "no";
            }
        }else{
            $completado = "";
        }
        
// --- Videos relacionados ---
                $sqlR = "SELECT o.id, o.title, o.description, 
                                IFNULL(p.progress, 0) AS progress
                        FROM online o
                        LEFT JOIN progress_elearning p 
                                ON o.id = p.video_id AND p.userID = ?
                        WHERE o.type = ? AND o.id <> ?
                        LIMIT 3";

                $stmtR = $conn->prepare($sqlR);
                $stmtR->bind_param("isi", $user_id, $tipo, $classID); // user_id=int, tipo=string, classID=int
                $stmtR->execute();
                $resultR = $stmtR->get_result();

                $relacionados = [];
                while ($rowR = $resultR->fetch_assoc()) {
                    $relacionados[] = $rowR;
                }

                // --- si hay menos de 3, buscar de otros tipos, evitando el actual ---
                if (count($relacionados) < 3) {
                    $faltan = 3 - count($relacionados);

                    $sqlExtra = "SELECT o.id, o.title, o.description, 
                                        IFNULL(p.progress, 0) AS progress
                                FROM online o
                                LEFT JOIN progress_elearning p 
                                        ON o.id = p.video_id AND p.userID = ?
                                WHERE o.type <> ? AND o.id <> ?
                                LIMIT ?";
                    $stmtExtra = $conn->prepare($sqlExtra);
                    $stmtExtra->bind_param("isii", $user_id, $tipo, $classID, $faltan);
                    $stmtExtra->execute();
                    $resultExtra = $stmtExtra->get_result();

                    while ($rowExtra = $resultExtra->fetch_assoc()) {
                        $relacionados[] = $rowExtra;
                    }
                }

                // --- renderizamos los relacionados ---
                $htmlRelacionados = "";

                foreach ($relacionados as $video) {
                    $progressValue = (float)$video['progress']; // asegurar numérico
                    $htmlRelacionados .= '<article class="co5" onclick="viewClassRel(' . htmlspecialchars($video['id']) . ');">
                                            <div class="co6">
                                                <img src="./online/' . htmlspecialchars($video['id']) . '.png" class="co7" alt="">
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: ' . $progressValue . '%"></div>
                                                </div>
                                                <button class="btnplay"> 
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80.04 80.04">
                                                        <g class="cls-boton-online">
                                                            <path class="cls-boton-online" d="M40,80A40,40,0,1,1,80,40,40.07,40.07,0,0,1,40,80ZM40,4.51A35.51,35.51,0,1,0,75.53,40,35.55,35.55,0,0,0,40,4.51Z"/>
                                                            <path class="cls-boton-online" d="M28,23.5v34a2.52,2.52,0,0,0,3.82,2.16L60.33,41.16a2.53,2.53,0,0,0,0-4.34L31.85,21.33A2.53,2.53,0,0,0,28,23.5Z"/>
                                                        </g>
                                                    </svg> 
                                                </button>
                                            </div>
                                            <div class="co8">
                                                <h3>' . htmlspecialchars($video['title']) . '</h3>
                                                <p>' . htmlspecialchars($video['description']) . '</p>
                                            </div>
                                        </article>';
                }



         $resultado = array(
            'id' => $classID,
            'token' => $token,
            'titulo' => $titulo,
            'duracion' => $duracion,
            'nivel' => $nivel,
            'equipamiento' => $equipamiento,
            'completado' => $completado,
            'descripcion' => $descripcion,
            'recomendados' => $htmlRelacionados,
            'activo' => $activo
        );
        
        echo json_encode($resultado);
    }else{
        echo json_encode("error de consulta");
    }

   
}else{
    echo json_encode("Invalido");
}


?>