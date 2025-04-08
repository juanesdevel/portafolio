<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';

$sql = "SELECT MAX(factura_venta) AS ultimo_id FROM ventas";
$resultado = $conexion->query($sql);
$ultimoId = $resultado->fetch_assoc()['ultimo_id'];

echo $ultimoId;

$conexion->close();
?>