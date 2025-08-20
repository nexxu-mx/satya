<?php

include '../db.php';
include '../error_log.php';

if (
    isset($_POST['nombre_paquete']) &&
    isset($_POST['numero_clases']) &&
    isset($_POST['costo_paquete']) &&
    isset($_POST['vigencia_paquete']) &&
    isset($_POST['invitados_paquete']) &&
    isset($_POST['personas_paquete'])
) {
    $nombrePaquete = trim(strtoupper($_POST['nombre_paquete']));
    $numeroClases = trim($_POST['numero_clases']);
    $costoPaquete = trim($_POST['costo_paquete']);
    $vigenciaPaquete = trim($_POST['vigencia_paquete']);
    $invitadosPaquete = trim($_POST['invitados_paquete']);
    $personasPaquete = trim($_POST['personas_paquete']);
    $descuento = trim($_POST['dsc']);
    $descuento = $descuento === '' ? null : $descuento;
    if(empty($descuento)){
        $finalizadsc = null;
    }else{
    $finalizadsc = trim($_POST['vigen']);
    $finalizadsc = $finalizadsc === '' ? null : $finalizadsc;
    }

    $disciplinas = $_POST['disciplinas'];

    $disciplinas = implode('|', $disciplinas);

    if (isset($_POST['id_paquete_edit'])) {
        $idPaqueteEdit = $_POST['id_paquete_edit'];

        $updatePaquete = $conn->prepare("UPDATE paquetes SET clases = ?, costo = ?, nombre = ?, vigencia = ?, disciplinas = ?, invitados = ?, persona = ?, descuento = ?, finalizadsc = ? WHERE id = ?");
        $updatePaquete->bind_param("sssssssssi", $numeroClases, $costoPaquete, $nombrePaquete, $vigenciaPaquete, $disciplinas, $invitadosPaquete, $personasPaquete, $descuento, $finalizadsc, $idPaqueteEdit); 

        $resultadoUpdatePaquete = $updatePaquete->execute();
        
        header('location: paquetes.php');
        exit;
    } else {
        $insertPaquete = $conn->prepare("INSERT INTO paquetes (clases, costo, nombre, vigencia, disciplinas, invitados, persona) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertPaquete->bind_param("sssssss", $numeroClases, $costoPaquete, $nombrePaquete, $vigenciaPaquete, $disciplinas, $invitadosPaquete, $personasPaquete);

        $resultadoInsert = $insertPaquete->execute();

        header('location: paquetes.php');
        exit;
    }

    header('location: paquetes.php');
    exit;
}
