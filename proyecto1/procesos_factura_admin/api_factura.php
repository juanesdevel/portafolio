<?php
// api_factura.php - Coloca este archivo en tu directorio raíz o donde sea apropiado
include '../conexion/conexion.php';

// Establecer cabeceras para respuestas API
header('Content-Type: application/json');

// Manejar CORS si es necesario
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Si es una solicitud preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Función para obtener la última factura
function obtenerUltimaFactura() {
    global $conexion;
    
    // Consulta para obtener elementos con el número de factura más alto
    $sql = "SELECT * FROM ventas WHERE factura_venta = (SELECT MAX(factura_venta) FROM ventas)";
    $resultado = mysqli_query($conexion, $sql);
    
    if (!$resultado) {
        return [
            'estado' => 'error',
            'mensaje' => 'Error en la consulta: ' . mysqli_error($conexion)
        ];
    }
    
    $items = [];
    $total_venta = 0;
    $numero_factura = null;
    
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $subtotal = floatval($fila['valor_total_venta']);
        $total_venta += $subtotal;
        $numero_factura = $fila['factura_venta'];
        
        $items[] = [
            'id_venta' => $fila['id_venta'],
            'referencia' => $fila['ref_prod_venta'],
            'producto' => $fila['producto_venta'],
            'valor_unitario' => floatval($fila['valor_producto']),
            'unidades' => intval($fila['unidades_venta']),
            'subtotal' => $subtotal,
            'estado' => $fila['estado']
        ];
    }
    
    // Calcular valores de impuestos
    $iva = $total_venta * 0.19;
    $subtotal_sin_iva = $total_venta - $iva;
    
    return [
        'estado' => 'exito',
        'datos' => [
            'numero_factura' => $numero_factura,
            'items' => $items,
            'totales' => [
                'subtotal_sin_iva' => $subtotal_sin_iva,
                'iva' => $iva,
                'total_con_iva' => $total_venta
            ]
        ]
    ];
}

// Función para obtener una factura específica por número
function obtenerFacturaPorNumero($numero_factura) {
    global $conexion;
    
    // Validar que el número de factura sea numérico
    if (!is_numeric($numero_factura)) {
        return [
            'estado' => 'error',
            'mensaje' => 'El número de factura debe ser un valor numérico'
        ];
    }
    
    // Consulta para obtener elementos de una factura específica
    $sql = "SELECT * FROM ventas WHERE factura_venta = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $numero_factura);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if (!$resultado) {
        return [
            'estado' => 'error',
            'mensaje' => 'Error en la consulta: ' . $conexion->error
        ];
    }
    
    $items = [];
    $total_venta = 0;
    
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $subtotal = floatval($fila['valor_total_venta']);
        $total_venta += $subtotal;
        
        $items[] = [
            'id_venta' => $fila['id_venta'],
            'referencia' => $fila['ref_prod_venta'],
            'producto' => $fila['producto_venta'],
            'valor_unitario' => floatval($fila['valor_producto']),
            'unidades' => intval($fila['unidades_venta']),
            'subtotal' => $subtotal,
            'estado' => $fila['estado']
        ];
    }
    
    // Si no se encontraron elementos para este número de factura
    if (count($items) === 0) {
        return [
            'estado' => 'error',
            'mensaje' => 'No se encontró ninguna factura con el número especificado'
        ];
    }
    
    // Calcular valores de impuestos
    $iva = $total_venta * 0.19;
    $subtotal_sin_iva = $total_venta - $iva;
    
    return [
        'estado' => 'exito',
        'datos' => [
            'numero_factura' => $numero_factura,
            'items' => $items,
            'totales' => [
                'subtotal_sin_iva' => $subtotal_sin_iva,
                'iva' => $iva,
                'total_con_iva' => $total_venta
            ]
        ]
    ];
}

// Procesar la solicitud recibida
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        // Verificar si se solicita una factura específica
        if (isset($_GET['factura'])) {
            $numero_factura = $_GET['factura'];
            $respuesta = obtenerFacturaPorNumero($numero_factura);
        } else {
            // Si no se especifica número, devolver la última factura
            $respuesta = obtenerUltimaFactura();
        }
        break;
        
    default:
        $respuesta = [
            'estado' => 'error',
            'mensaje' => 'Método no permitido'
        ];
        http_response_code(405);
        break;
}

// Devolver la respuesta en formato JSON
echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Cerrar la conexión
mysqli_close($conexion);
?><?php
// api_factura.php - Coloca este archivo en tu directorio raíz o donde sea apropiado
include '../conexion/conexion.php';

// Establecer cabeceras para respuestas API
header('Content-Type: application/json');

// Manejar CORS si es necesario
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Si es una solicitud preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Función para obtener la última factura
function obtenerUltimaFactura() {
    global $conexion;
    
    // Consulta para obtener elementos con el número de factura más alto
    $sql = "SELECT * FROM ventas WHERE factura_venta = (SELECT MAX(factura_venta) FROM ventas)";
    $resultado = mysqli_query($conexion, $sql);
    
    if (!$resultado) {
        return [
            'estado' => 'error',
            'mensaje' => 'Error en la consulta: ' . mysqli_error($conexion)
        ];
    }
    
    $items = [];
    $total_venta = 0;
    $numero_factura = null;
    
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $subtotal = floatval($fila['valor_total_venta']);
        $total_venta += $subtotal;
        $numero_factura = $fila['factura_venta'];
        
        $items[] = [
            'id_venta' => $fila['id_venta'],
            'referencia' => $fila['ref_prod_venta'],
            'producto' => $fila['producto_venta'],
            'valor_unitario' => floatval($fila['valor_producto']),
            'unidades' => intval($fila['unidades_venta']),
            'subtotal' => $subtotal,
            'estado' => $fila['estado']
        ];
    }
    
    // Calcular valores de impuestos
    $iva = $total_venta * 0.19;
    $subtotal_sin_iva = $total_venta - $iva;
    
    return [
        'estado' => 'exito',
        'datos' => [
            'numero_factura' => $numero_factura,
            'items' => $items,
            'totales' => [
                'subtotal_sin_iva' => $subtotal_sin_iva,
                'iva' => $iva,
                'total_con_iva' => $total_venta
            ]
        ]
    ];
}

// Función para obtener una factura específica por número
function obtenerFacturaPorNumero($numero_factura) {
    global $conexion;
    
    // Validar que el número de factura sea numérico
    if (!is_numeric($numero_factura)) {
        return [
            'estado' => 'error',
            'mensaje' => 'El número de factura debe ser un valor numérico'
        ];
    }
    
    // Consulta para obtener elementos de una factura específica
    $sql = "SELECT * FROM ventas WHERE factura_venta = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $numero_factura);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if (!$resultado) {
        return [
            'estado' => 'error',
            'mensaje' => 'Error en la consulta: ' . $conexion->error
        ];
    }
    
    $items = [];
    $total_venta = 0;
    
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $subtotal = floatval($fila['valor_total_venta']);
        $total_venta += $subtotal;
        
        $items[] = [
            'id_venta' => $fila['id_venta'],
            'referencia' => $fila['ref_prod_venta'],
            'producto' => $fila['producto_venta'],
            'valor_unitario' => floatval($fila['valor_producto']),
            'unidades' => intval($fila['unidades_venta']),
            'subtotal' => $subtotal,
            'estado' => $fila['estado']
        ];
    }
    
    // Si no se encontraron elementos para este número de factura
    if (count($items) === 0) {
        return [
            'estado' => 'error',
            'mensaje' => 'No se encontró ninguna factura con el número especificado'
        ];
    }
    
    // Calcular valores de impuestos
    $iva = $total_venta * 0.19;
    $subtotal_sin_iva = $total_venta - $iva;
    
    return [
        'estado' => 'exito',
        'datos' => [
            'numero_factura' => $numero_factura,
            'items' => $items,
            'totales' => [
                'subtotal_sin_iva' => $subtotal_sin_iva,
                'iva' => $iva,
                'total_con_iva' => $total_venta
            ]
        ]
    ];
}

// Procesar la solicitud recibida
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        // Verificar si se solicita una factura específica
        if (isset($_GET['factura'])) {
            $numero_factura = $_GET['factura'];
            $respuesta = obtenerFacturaPorNumero($numero_factura);
        } else {
            // Si no se especifica número, devolver la última factura
            $respuesta = obtenerUltimaFactura();
        }
        break;
        
    default:
        $respuesta = [
            'estado' => 'error',
            'mensaje' => 'Método no permitido'
        ];
        http_response_code(405);
        break;
}

// Devolver la respuesta en formato JSON
echo json_encode($respuesta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Cerrar la conexión
mysqli_close($conexion);
?>