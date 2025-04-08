<?php
// Mostrar errores en caso de problemas (Útil solo en desarrollo, no en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$dbname = "juanest2_keepass";  // Nombre de la base de datos
$dbuser = "juanest2_keepass";           // Usuario de la base de datos
$dbpass = "Developer.2026";          // Contraseña de la base de datos
$dbhost = "shared28.hostgator.co"; // Host de la base de datos

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
