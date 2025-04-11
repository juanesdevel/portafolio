<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexion/conexion.php'; // Conexión a la base de datos
include '../conexion/sesion.php'; // Inicio de sesión

// Verificar si la sesión está iniciada y el usuario está definido
if (!isset($_SESSION['usuario'])) {
    die("Error: Usuario no autenticado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doc_cliente = $_POST['doc_cliente_venta_2'] ?? '';
    $nom_cliente = $_POST['nom_cliente'] ?? '';

   // echo "Cédula Cliente: " . htmlspecialchars($doc_cliente) . "<br>";
   //echo "Nombre Cliente: " . htmlspecialchars($nom_cliente) . "<br>";

    // Obtener el último número de factura registrado
    $sql_max = "SELECT MAX(no_factura) AS max_factura FROM facturas";
    $result = $conexion->query($sql_max);

    if ($result) {
        $row = $result->fetch_assoc();
        $max_factura = ($row['max_factura'] ?? 0) + 1; // Si no hay facturas, empieza desde 1
    } else {
        die("Error al obtener el número de factura: " . $conexion->error);
    }

    // Obtener el usuario de la sesión
    $usuario = $_SESSION['usuario'];

    // Insertar un nuevo registro en la tabla 'facturas'
    $sql_insert = "INSERT INTO facturas (no_factura, asesor, estado, doc_cliente, nom_cliente) 
                   VALUES ('$max_factura', '$usuario', 'Abierta', '$doc_cliente', '$nom_cliente')";

    if ($conexion->query($sql_insert) === TRUE) {
        // Redirigir a factura_en_proceso.php con el número de factura
        echo "<script>location.assign('../vistas/factura_en_proceso.php?no_factura=" . json_encode($max_factura) . "');</script>";

        
    } else {
        echo "Error al crear la factura: " . $conexion->error;
    }

    $conexion->close();
}
?>
