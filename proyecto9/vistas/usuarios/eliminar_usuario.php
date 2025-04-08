<?php
$id_usuario=$_GET['id_usuario'];
include ("../../conexion/conexion.php");
$sql="delete from usuarios2 where id_usuario='".$id_usuario."'";$resultado=mysqli_query($conexion,$sql);

if($resultado){
    echo '<script>alert("!El Usuario fue eliminado correctamente¡");location.assign("usuarios.php");</script>';
} else {
 echo "<script> alert ('ERROR: Los datos no fueron eliminados a la base de datos'); location.assign ('usuarios.php'); </script>";
}
?>