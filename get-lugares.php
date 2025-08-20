<?php
header('Content-Type: application/json');
include './error_log.php';
include './db.php';


$id_clase = $_GET['id'];
$especial = $_GET['especial'];

$sql = "SELECT lugar FROM reservaciones WHERE idClase = ? AND lugar IS NOT NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_clase);
$stmt->execute();
$result = $stmt->get_result();
if($especial == 1){
    $resultados[] = 8;
}else{
    $resultados = [];
}

while($row = $result->fetch_assoc()){
    $resultados[] = $row['lugar'];
}

//$resultados = [2, 7, 8];

echo json_encode(["ocupados" => $resultados]);

?>