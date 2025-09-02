<?php
// get-class-online.php
header('Content-Type: application/json; charset=utf-8');
include './db.php';
session_start();
// Sanitizar parámetro
$type = isset($_GET['type']) ? $conn->real_escape_string($_GET['type']) : "";
$mode = isset($_GET['mode']) ? $conn->real_escape_string($_GET['mode']) : "";

// Consulta a la tabla
$sql = "SELECT id, title, duration, level, equipment 
        FROM online";
if ($type !== "") {

    if($mode !== ""){ 
        if($mode == 1){
            $sqlD = ("SELECT nombre_disciplina FROM disciplinas WHERE id = ?");
            $smt = $conn->prepare($sqlD);
            $smt->bind_param("i", $type);
            if(!$smt->execute()){
                echo json_encode("error de consulta");
            }
            $res = $smt->get_result();
            $roe = $res->fetch_assoc();
            $disciplina = $roe['nombre_disciplina'];

            $disciplina = strtolower($disciplina);
            $disciplina = str_replace(" ", "_", $disciplina);
            $sql .= " WHERE type = '$disciplina'";
        }else{
            $sql .= " WHERE duration = '$type'";
        }
    }
}
$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);

$classes = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if(!empty($_SESSION['idUser'])){ 
                $classID = (int)$row['id'];
                $user_id = $_SESSION['idUser'];
                $sqlC = ("SELECT progress FROM progress_elearning WHERE userID = ? AND video_id = ?");
                $smt = $conn->prepare($sqlC);
                $smt->bind_param("ii", $user_id, $classID);
                $smt->execute();
                $resultC = $smt->get_result();
                if ($resultC->num_rows > 0) {
                    $rowC = $resultC->fetch_assoc();
                    $progress = $rowC['progress'];
                    
                }else{
                    $progress = '0';
                }
        }else{
            $progress = '0';
            
        }
        $classes[] = [
            "id"       => (int)$row['id'],
            "title"    => $row['title'],
            "duration" => (int)$row['duration'],
            "level"    => $row['level'],
            "progress"    => $progress,
            "equipment"=> $row['equipment']
        ];
    }
}

echo json_encode($classes, JSON_UNESCAPED_UNICODE);

$conn->close();
