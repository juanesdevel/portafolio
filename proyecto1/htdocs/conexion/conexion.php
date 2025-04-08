<?php
// Mostrar errores en caso de problemas (Útil solo en desarrollo, no en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$dbname = "if0_38580523_usuarios";  // Nombre de la base de datos
$dbuser = "if0_38580523";           // Usuario de la base de datos
$dbpass = "074sbSkxl1qMI";          // Contraseña de la base de datos
$dbhost = "sql203.infinityfree.com"; // Host de la base de datos

// Activar el reporte de errores de MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Crear conexión con MySQLi
    $conexion = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    $conexion->set_charset("utf8"); // Establecer UTF-8 para evitar problemas con caracteres especiales
} catch (mysqli_sql_exception $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
