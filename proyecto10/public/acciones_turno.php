<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include ("../conexion/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && is_numeric($_POST['id']) && isset($_POST['accion'])) {
        $id_turno = intval($_POST['id']);
        $accion = $_POST['accion'];
        $nom_asesor_sesion = $_SESSION['usuario'] ?? null; // Tomar el nombre de usuario de la sesión (asumiendo que es el asesor)
        $modulo_sesion = $_SESSION['modulo_seleccionado'] ?? null; // Tomar el módulo de la sesión
        $fecha_actualizacion = date("Y-m-d H:i:s"); // Obtener la fecha y hora actual para la actualización

        $nuevo_estado = '';
        switch ($accion) {
            case 'notificar':
                $nuevo_estado = 'Notificado';
                break;
            case 'cancelar':
                $nuevo_estado = 'Cancelado';
                break;
            case 'confirmar':
                $nuevo_estado = 'Confirmado';
                break;
            default:
                echo "Acción inválida.";
                http_response_code(400);
                exit();
        }

        $sql = "UPDATE turnos SET estado = ?, nom_asesor = ?, modulo = ?, fecha_actualizacion = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $conn->error;
            http_response_code(500);
            exit();
        }

        $stmt->bind_param("ssisi", $nuevo_estado, $nom_asesor_sesion, $modulo_sesion, $fecha_actualizacion, $id_turno);

        if ($stmt->execute()) {
            echo "Turno con ID " . $id_turno . " actualizado a " . $nuevo_estado . ".";
            http_response_code(200);
        } else {
            echo "Error al actualizar el turno: " . $stmt->error;
            http_response_code(500);
        }

        $stmt->close();

    } else {
        echo "ID de turno o acción inválida.";
        http_response_code(400);
    }
} else {
    echo "Método no permitido.";
    http_response_code(405);
}

$conn->close();
?>