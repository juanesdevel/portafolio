<?php
// Incluir configuración de caracteres
header('Content-Type: text/html; charset=utf-8');
// Incluir archivos de conexión y sesión
include '../conexion/conexion.php';
include '../conexion/sesion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<?php

// Verificar si la sesión está iniciada y el usuario está definido
if (!isset($_SESSION['usuario'])) {
    die("Error: Usuario no autenticado.");
}

// Crear conexión
$conexion = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Procesar el formulario si se envió mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $forma_pago = $_POST['forma_pago'] ?? '';
    $total_venta_con_iva = $_POST['total_ventas'] ?? '';
    $no_factura = $_POST['no_factura'] ?? '';

    // Validar los datos
    if (empty($forma_pago)) {
        die("Error: Debes seleccionar una forma de pago.");
    }

if (empty($total_venta_con_iva)) {
echo '<script>alert("Error: El total de ventas no puede estar vacío."); window.history.back();</script>';
    exit; // Importante: Detiene la ejecución del script después de la redirección}
}
// Validación adicional para 0 o "0,0"
if ($total_venta_con_iva == 0 || $total_venta_con_iva == "0,00") {
   echo '<script>alert("Error: El total de ventas no puede ser 0."); window.history.back();</script>';
    exit; // Importante: Detiene la ejecución del script después de la redirección
}
    if (empty($no_factura)) {
        die("Error: El número de factura no puede estar vacío.");
    }

    // Escapar los datos para evitar inyecciones SQL (opcional con mysqli_real_escape_string)
    $forma_pago = $conexion->real_escape_string($forma_pago);
    $total_venta_con_iva = $conexion->real_escape_string($total_venta_con_iva);
    $no_factura = $conexion->real_escape_string($no_factura);

    // Actualizar la tabla 'facturas' con los nuevos valores
    $sql_update = "UPDATE facturas 
                   SET forma_de_pago = '$forma_pago', total_venta_con_iva = '$total_venta_con_iva', estado = 'Cerrada' 
                   WHERE no_factura = '$no_factura'";

    if ($conexion->query($sql_update) === TRUE) {
            echo "<script> alert ('!La factura se cerró de manera exitosa¡'); location.assign ('../vistas/controlador_factura.php'); </script>";
        exit();
    } else {
        echo "Error al actualizar la factura: " . $conexion->error;

    }

    // Cerrar la conexión
    $conexion->close();
}
?>