<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_usuario=$_GET['id_usuario'];
include ("../conexion/conexion.php");
$sql="delete from usuarios where id_usuario='".$id_usuario."'";$resultado=mysqli_query($conexion,$sql);

if($resultado){
    echo '<script>alert("¡El Usuario fue eliminado correctamente!");location.assign("../vistas/usuarios.php");</script>';
} else {
 echo "<script> alert ('ERROR: ¡Los datos no fueron eliminados a la base de datos!'); location.assign ('usuarios.php'); </script>";
}
?>