<?php
include '../includes/conexion.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encripta la contraseña
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql = "INSERT INTO usuarios (nombre, email, password, telefono, direccion) VALUES ('$nombre', '$email', '$password', '$telefono', '$direccion')";

    if ($conn->query($sql) === TRUE) {
        echo "<script> alert ('Registro Exitoso.'); location.assign ('login.php'); </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>