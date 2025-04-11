<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';

// Asegurarse de que se recibieron todos los datos necesarios
if (!isset($_POST['factura']) || !isset($_POST['fecha_anulacion']) || !isset($_POST['descripcion_anulacion'])) {
    die("Error: No se proporcionaron todos los datos necesarios.");
}

$factura = mysqli_real_escape_string($conexion, $_POST['factura']);
$fecha_anulacion = mysqli_real_escape_string($conexion, $_POST['fecha_anulacion']);
$descripcion_anulacion = mysqli_real_escape_string($conexion, $_POST['descripcion_anulacion']);

// Verificar si existen ventas asociadas a la factura
$sql_ventas = "SELECT estado FROM ventas WHERE factura_venta = '$factura'";
$resultado_ventas = mysqli_query($conexion, $sql_ventas);

if (!$resultado_ventas) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$puede_anular = true;
while ($fila = mysqli_fetch_assoc($resultado_ventas)) {
    if ($fila['estado'] == 'Realizada') {
        $puede_anular = false;
        break;
    }
}

if (!$puede_anular) {
    echo "<script>
        alert('No se puede anular la factura hasta no devolver todas las ventas.');
        window.location.href = '../vistas/facturas.php';
    </script>";
} else {
    // Verificar el estado actual de la factura
    $sql_factura = "SELECT estado FROM facturas WHERE no_factura = '$factura'";
    $resultado_factura = mysqli_query($conexion, $sql_factura);

    if (!$resultado_factura) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    if (mysqli_num_rows($resultado_factura) > 0) {
        $fila_factura = mysqli_fetch_assoc($resultado_factura);
        if ($fila_factura['estado'] == 'Anulada') {
            echo "<script>
                alert('¡Atención! No se puede anular una factura ya anulada.');
                window.location.href = '../vistas/facturas.php';
            </script>";
        } else {
            // Verificar la existencia de las columnas
            $result = mysqli_query($conexion, "SHOW COLUMNS FROM facturas LIKE 'fecha_anulacion'");
            $fecha_anulacion_exists = (mysqli_num_rows($result)) ? TRUE : FALSE;
            
            $result = mysqli_query($conexion, "SHOW COLUMNS FROM facturas LIKE 'descripcion_anulacion'");
            $descripcion_anulacion_exists = (mysqli_num_rows($result)) ? TRUE : FALSE;

            // Construir la consulta de actualización basada en las columnas existentes
            $query_update_factura = "UPDATE facturas SET estado = 'Anulada'";
            if ($fecha_anulacion_exists) {
                $query_update_factura .= ", fecha_anulacion = '$fecha_anulacion'";
            }
            if ($descripcion_anulacion_exists) {
                $query_update_factura .= ", descripcion_anulacion = '$descripcion_anulacion'";
            }
            $query_update_factura .= " WHERE no_factura = '$factura'";

            if (mysqli_query($conexion, $query_update_factura)) {
                echo "<script>
                    alert('La factura ha sido anulada correctamente.');
                    window.location.href = '../vistas/facturas.php';
                </script>";
            } else {
                echo "<script>
                    alert('Error al anular la factura: " . mysqli_error($conexion) . "');
                    window.location.href = '../vistas/facturas.php';
                </script>";
            }
        }
    } else {
        echo "<script>
            alert('No se encontró la factura con el número proporcionado.');
            window.location.href = '../vistas/facturas.php';
        </script>";
    }
}

mysqli_close($conexion);
?>