<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    <script src="librerias/jquery-3.2.1.min.js"></script>
</head>
<body>
    
</body>
</html>

<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';


// Realizar la consulta para obtener todas las filas que contienen el número más alto en la columna factura_venta
$sql_1 = "SELECT * FROM facturas WHERE no_factura = (SELECT MAX(no_factura) FROM facturas)";
$sql_2 = "SELECT * FROM ventas WHERE factura_venta = (SELECT MAX(factura_venta) FROM ventas)";
$resultado_1 = mysqli_query($conexion, $sql_1);
$resultado_2 = mysqli_query($conexion, $sql_2);


    if (mysqli_num_rows($resultado_1) > 0 && mysqli_num_rows($resultado_2) > 0) {
        // Obtener la primera fila de resultados
        $fila_1 = mysqli_fetch_assoc($resultado_1);
        $fila_2 = mysqli_fetch_assoc($resultado_2);

        echo $fila_1['no_factura']; 
        echo $fila_2['factura_venta']; 
        $no_factura = $fila_1['no_factura'];
        if ($fila_1['no_factura'] == $fila_2['factura_venta']) {
            // Si los valores son iguales
            echo '<script>alert("La factura actual, no tiene ventas cargadas!"); location.assign("../vistas/factura_borrador.php");</script>';
            return false;
        } else {
            // Si los valores son diferentes
            header("Location: nueva_venta.php"); 
        }
    } else {
        echo "No se encontraron filas con el número de factura más alto en la tabla ventas.";

} 
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
