<?php
$servername = "shared28.hostgator.co";
$username = "juanest2_compraventa";
$password = "compraventa2025";
$dbname = "juanest2_compraventa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

