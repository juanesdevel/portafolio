<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ("../conexion/conexion.php");

if ($conn->connect_error) {
    die(json_encode(array("error" => "Error de conexión a la base de datos: " . $conn->connect_error)));
}

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->servicio) &&
    !empty($data->documento) &&
    !empty($data->atencion)
) {
    $servicio = mysqli_real_escape_string($conn, trim($data->servicio));
    $documento = mysqli_real_escape_string($conn, trim($data->documento));
    $atencion = mysqli_real_escape_string($conn, trim($data->atencion));
    $fecha_actual = date("Y-m-d H:i:s");

    // Lógica para generar el número de turno basado en la categoría del servicio
    $sql_ultimo_turno_categoria = "SELECT MAX(turno) AS ultimo_turno FROM turnos WHERE servicio = '$servicio'";
    $result_ultimo_turno_categoria = $conn->query($sql_ultimo_turno_categoria);
    $ultimo_turno_categoria = 0;

    if ($result_ultimo_turno_categoria->num_rows > 0) {
        $row_ultimo_turno_categoria = $result_ultimo_turno_categoria->fetch_assoc();
        $ultimo_turno_categoria = intval($row_ultimo_turno_categoria['ultimo_turno']);
    }

    $nuevo_turno = ($ultimo_turno_categoria % 99) + 1;
    $turno_formateado = sprintf("%02d", $nuevo_turno);

    $sql_insert = "INSERT INTO turnos (fecha, entidad, servicio, turno, doc_usuario, atencion, estado)
                    VALUES ('$fecha_actual', '{$_SERVER['HTTP_HOST']}', '$servicio', '$turno_formateado', '$documento', '$atencion', 'Pendiente')";

    if ($conn->query($sql_insert) === TRUE) {
        echo json_encode(array("mensaje" => "Turno registrado exitosamente", "turno" => $turno_formateado));
    } else {
        echo json_encode(array("error" => "Error al registrar el turno: " . $conn->error));
    }
} else {
    echo json_encode(array("error" => "Por favor, proporcione todos los datos necesarios (servicio, documento, atención)."));
}

$conn->close();
?>