<?php
$devON = false;
if($devON == false){
    $servername = "127.0.0.1";
    $username = "u379047759_satyaestudio";
    $password = "Satya2025*";
    $database = "u379047759_satyabase";
}else{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "satya";
}

$conn = new mysqli($servername, $username, $password, $database);

?>