<?php
// Incluir archivo de conexión
include '../conexion/conexion.php';

// Función para obtener y mostrar todos los registros de una tabla
function mostrarRegistrosTabla($conexion, $nombreTabla) {
    echo "<h2>Tabla: $nombreTabla</h2>";
    
    // Obtener los nombres de columnas
    $columnasQuery = "SHOW COLUMNS FROM $nombreTabla";
    $columnasResult = $conexion->query($columnasQuery);
    
    // Obtener registros de la tabla
    $registrosQuery = "SELECT * FROM $nombreTabla";
    $registrosResult = $conexion->query($registrosQuery);
    
    if ($registrosResult->num_rows > 0) {
        // Imprimir encabezados de columnas
        echo "<table border='1' style='width:100%; border-collapse: collapse;'>";
        echo "<thead><tr>";
        while ($columna = $columnasResult->fetch_assoc()) {
            echo "<th style='padding:5px;'>" . htmlspecialchars($columna['Field']) . "</th>";
        }
        echo "</tr></thead>";
        
        // Imprimir registros
        echo "<tbody>";
        // Reiniciar el puntero de resultados de columnas
        $columnasResult->data_seek(0);
        while ($fila = $registrosResult->fetch_assoc()) {
            echo "<tr>";
            foreach ($fila as $valor) {
                echo "<td style='padding:5px;'>" . htmlspecialchars($valor) . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        
        // Mostrar total de registros
        echo "<p>Total de registros: " . $registrosResult->num_rows . "</p>";
    } else {
        echo "<p>No hay registros en la tabla $nombreTabla</p>";
    }
}

// Obtener todas las tablas de la base de datos
$tablas_query = "SHOW TABLES";
$tablas_result = $conexion->query($tablas_query);

// Verificar si hay tablas
if ($tablas_result->num_rows > 0) {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Explorador de Base de Datos</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px; }
            h1 { color: #333; }
            table { margin-bottom: 20px; }
            th { background-color: #f2f2f2; }
        </style>
    </head>
    <body>";
    
    echo "<h1>Explorador de Base de Datos</h1>";
    
    // Iterar sobre todas las tablas
    while ($tabla = $tablas_result->fetch_array()) {
        $nombreTabla = $tabla[0];
        mostrarRegistrosTabla($conexion, $nombreTabla);
    }
    
    echo "</body></html>";
} else {
    echo "No se encontraron tablas en la base de datos.";
}

// Cerrar conexión
$conexion->close();
?>