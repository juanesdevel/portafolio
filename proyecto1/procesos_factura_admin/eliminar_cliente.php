<?php
$id_cliente=$_GET['id_cliente'];
include '../conexion/conexion.php';
include '../conexion/sesion.php';
$sql="delete from clientes where id_cliente='".$id_cliente."'";
$resultado=mysqli_query($conexion,$sql);
if($resultado){
    echo '<script>alert("!El Cliente fue eliminado correctamente¡");location.assign("../vistas/clientes.php");</script>';
} else {
 echo "<script> alert ('ERROR: Los datos no fueron eliminados a la base de datos'); location.assign (cliente.php'); </script>";
}
?>
