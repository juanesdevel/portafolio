<?php
$servername = "shared28.hostgator.co";
$username = "juanest2_turnos";
$password = "Turnos2025";
$dbname = "juanest2_turnos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>