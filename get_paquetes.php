<?php
include 'db.php';
session_start();
//Consulta Founder 

    if(!empty($_SESSION['idUser'])){
       $idUsr = $_SESSION['idUser'];

        $sqlU = ("SELECT founder FROM users WHERE id = ?");
        $smt = $conn->prepare($sqlU);
        $smt->bind_param("i", $idUsr);
        $smt->execute();
        $resultU = $smt->get_result();
        if($resultU->num_rows === 0){
            $founder = null;
        }
        $rowU = $resultU->fetch_assoc();
        $founder = $rowU['founder'];
        
    }else{
        $founder = null;
    }
$search = $_GET['search'] ?? '';
$clases = $_GET['clases'] ?? '';
$disciplina = $_GET['disciplina'] ?? '';

$sql = "SELECT * FROM paquetes WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND nombre LIKE ?";
    $params[] = "%$search%";
}
if (!empty($clases) && $clases !== 'CLASES POR SEMANA') {
    $sql .= " AND nombre = ?";
    $params[] = $clases;
}
if (!empty($disciplina) && $disciplina !== 'DISCIPLINA') {
    $sql .= " AND nombre = ?";
    $params[] = $disciplina;
}

// Agregar ORDER BY para ordenar por costo de menor a mayor
$sql .= " ORDER BY CAST(costo AS DECIMAL(10,2)) ASC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$paquetes = [];

while ($row = $result->fetch_assoc()) {
    if($row['activo'] !== 1){
        continue;
    }
    //logica costo fundador
        if($founder == 1){
            switch ($row['id']) {
                case 2:
                    $row['costo'] = 859;
                    break;
                case 3:
                    $row['costo'] = 1129;
                    break;
                case 4:
                    $row['costo'] = 1449;
                    break;
                case 5:
                    $row['costo'] = 16999;
                    break;
                case 6:
                    $row['costo'] = 999;
                    break;
                case 7:
                    $row['costo'] = 1299;
                    break;
                case 8:
                    $row['costo'] = 1599;
                    break;
                case 9:
                    $row['costo'] = 17999;
                    break;
                case 10:
                    $row['costo'] = 1129;
                    break;
                case 11:
                    $row['costo'] = 1479;
                    break;
                case 12:
                    $row['costo'] = 1799;
                    break;
                case 13:
                    $row['costo'] = 20999;
                    break;
                default:
                    $row['costo'] = $row['costo'];
                    break;
            }
        }
    $paquetes[] = $row;
}
echo json_encode($paquetes);
?>