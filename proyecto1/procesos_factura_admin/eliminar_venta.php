<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Venta</title>
</head>
<body>
<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';

// Obtener el ID de la venta desde la URL
$id_venta = $_GET['id_venta'];

// 1. Obtener las unidades vendidas y la referencia del producto
$sql_select = "SELECT unidades_venta, ref_prod_venta FROM ventas WHERE id_venta = ?";
$stmt_select = $conexion->prepare($sql_select);
$stmt_select->bind_param("i", $id_venta);
$stmt_select->execute();
$stmt_select->bind_result($unidades_venta, $ref_prod_venta);
$stmt_select->fetch();
$stmt_select->close();

// Verificar si se encontró la venta
if ($unidades_venta && $ref_prod_venta) {
    // 2. Actualizar el stock en la tabla de productos
    $sql_update = "UPDATE productos SET unidades_producto = unidades_producto + ? WHERE ref_producto = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("is", $unidades_venta, $ref_prod_venta);
    $stmt_update->execute();
    $stmt_update->close();

    // 3. Eliminar la venta
    $sql_delete = "DELETE FROM ventas WHERE id_venta = ?";
    $stmt_delete = $conexion->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_venta);
    $stmt_delete->execute();

    // Verificar si la eliminación fue exitosa
    if ($stmt_delete->affected_rows > 0) {
        echo '<script>alert("Datos eliminados correctamente y stock actualizado");location.assign("../vistas/factura_borrador.php");</script>';
    } else {
        echo '<script>alert("ERROR: La venta no pudo ser eliminada");location.assign("nueva_venta.php");</script>';
    }
    $stmt_delete->close();
} else {
    echo '<script>alert("ERROR: No se encontró la venta");location.assign("../vistas/factura_borrador.php");</script>';
}

// Cerrar la conexión
$conexion->close();
?></html>