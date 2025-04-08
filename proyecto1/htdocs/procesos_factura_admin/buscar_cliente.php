<?php
// Incluir archivo de conexión
include '../conexion/conexion.php';

// Habilitar reporte de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar que se recibió el parámetro
if (isset($_POST['doc_cliente_venta'])) {
    $doc_cliente = $_POST['doc_cliente_venta'];
    
    // Limpiar y validar la entrada
    $doc_cliente = trim($doc_cliente);
    
    // Si está vacío, devolver error
    if (empty($doc_cliente)) {
        echo json_encode(array('error' => 'Documento vacío'));
        exit;
    }
    
    try {
        // Preparar la consulta para buscar el cliente
        $sql = "SELECT * FROM clientes WHERE doc_cliente = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $doc_cliente);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        // Verificar si encontró al cliente
        if ($resultado->num_rows > 0) {
            $cliente = $resultado->fetch_assoc();
            
            // Crear el array de respuesta con todos los campos necesarios
            $respuesta = array(
                'id_cliente' => $cliente['id_cliente'],
                'doc_cliente' => $cliente['doc_cliente'],
                'nom_cliente' => $cliente['nom_cliente'],
                'cel1_cliente' => isset($cliente['cel1_cliente']) ? $cliente['cel1_cliente'] : '',
                'cel2_cliente' => isset($cliente['cel2_cliente']) ? $cliente['cel2_cliente'] : '',
                'direccion_cliente' => isset($cliente['direccion_cliente']) ? $cliente['direccion_cliente'] : '',
                'correo_cliente' => isset($cliente['correo_cliente']) ? $cliente['correo_cliente'] : ''
            );
            
            // Devolver la respuesta como JSON
            echo json_encode($respuesta);
        } else {
            // Si no encuentra cliente, devolver objeto vacío
            echo json_encode(array('error' => 'Cliente no encontrado'));
        }
        
        // Cerrar la conexión
        $stmt->close();
    } catch (Exception $e) {
        // En caso de error, devolver mensaje
        echo json_encode(array('error' => 'Error en la consulta: ' . $e->getMessage()));
    }
} else {
    // Si no se recibió el parámetro
    echo json_encode(array('error' => 'Parámetro no recibido'));
}

// Cerrar la conexión
$conexion->close();
?>