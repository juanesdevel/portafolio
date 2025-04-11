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

if ($resultado_2) {
    if (mysqli_num_rows($resultado_2) > 0) {
        // Obtener la primera fila de resultados
        $fila = mysqli_fetch_assoc($resultado_2);
?>

<form action="procesar_formulario.php" method="POST">
    <label for="factura_venta">Factura de Venta:</label>
    <input type="text" id="factura_venta" name="factura_venta" value="<?php echo $fila['factura_venta']; ?>" readonly>

    <label for="fecha_hora_venta">Fecha y Hora de Venta:</label>
    <input type="text" id="fecha_hora_venta" name="fecha_hora_venta" value="<?php echo $fila['fecha_hora_venta']; ?>" readonly>

    <label for="nom_cliente">Nombre del Cliente:</label>
    <input type="text" id="nom_cliente" name="nom_cliente" value="<?php echo $fila['nom_cliente']; ?>"readonly>

    <label for="doc_cliente_venta">Documento del Cliente:</label>
    <input type="text" id="doc_cliente_venta" name="doc_cliente_venta" value="<?php echo $fila['doc_cliente_venta']; ?>"readonly>

    <label for="asesor_venta">Asesor de Venta:</label>
    <input type="text" id="asesor_venta" name="asesor_venta" value="<?php echo $fila['asesor_venta']; ?>"readonly>

    <label for="caja">Caja:</label>
    <input type="text" id="caja" name="caja" value="<?php echo $fila['caja']; ?>"readonly><br>

    <label for="forma_de_pago">Forma de Pago:</label>
    <input type="text" id="forma_de_pago" name="forma_de_pago" value="<?php echo $fila['forma_de_pago']; ?>"readonly>

    

   
</form>

<?php
    } else {
        echo "No se encontraron filas con el número de factura más alto en la tabla ventas.";
    }
} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}


// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
