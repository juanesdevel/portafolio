<?php
// Incluir archivo de conexión
include '../conexion/conexion.php';

// Habilitar reporte de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar que se recibió el parámetro
if (isset($_POST['ref_prod_venta'])) {
    $ref_producto = trim($_POST['ref_prod_venta']);

    // Validar que no esté vacío
    if (empty($ref_producto)) {
        echo json_encode(array('error' => 'Referencia vacía'));
        exit;
    }

    try {
        // Preparar consulta segura
        $sql = "SELECT ref_producto, descripcion_producto, valor_producto, unidades_producto, cat_producto 
                FROM productos 
                WHERE ref_producto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $ref_producto);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $producto = $resultado->fetch_assoc();

            // Crear respuesta JSON
            $respuesta = array(
                'ref_producto' => $producto['ref_producto'],
                'descripcion_producto' => $producto['descripcion_producto'],
                'valor_producto' => $producto['valor_producto'],
                'unidades_producto' => $producto['unidades_producto'],
                'cat_producto' => $producto['cat_producto']
            );

            echo json_encode($respuesta);
        } else {
            echo json_encode(array('error' => 'Producto no encontrado'));
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(array('error' => 'Error en la consulta: ' . $e->getMessage()));
    }
} else {
    echo json_encode(array('error' => 'Parámetro no recibido'));
}

// Cerrar conexión
$conexion->close();
?>
