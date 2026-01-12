<?php
$devON = false;
if ($devON) {
    $servername = "127.0.0.1";
    $username = "u379047759_satyaestudio";
    $password = "Satya2025*";
    $database = "u379047759_satyabase";
} else {
    $servername = "db";
    $username = "root";
    $password = "root";
    $database = "satya";
}

$conn = new mysqli($servername, $username, $password, $database);
