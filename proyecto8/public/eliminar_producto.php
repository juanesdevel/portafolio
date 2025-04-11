<?php
session_start();
include '../includes/conexion.php';
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
$id_producto = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];

// Verificar que la publicación pertenece al usuario
$check_sql = "SELECT id FROM productos WHERE id = '$id_producto' AND id_usuario = '$id_usuario'";
$check_result = $conn->query($check_sql);
if ($check_result->num_rows == 0) {
        echo "<script> alert ('Publicación no encontrada o no te pertenece.'); location.assign ('mis_publicaciones.php'); </script>";
    exit();
}

// Obtener todas las rutas de las imágenes asociadas al producto
$sql_imagenes = "SELECT ruta_imagen FROM producto_imagenes WHERE id_producto = '$id_producto'";
$result_imagenes = $conn->query($sql_imagenes);

// Eliminar las imágenes del servidor
while ($row_imagen = $result_imagenes->fetch_assoc()) {
    $ruta_a_eliminar = $row_imagen['ruta_imagen'];
    if (file_exists($ruta_a_eliminar)) {
        unlink($ruta_a_eliminar);
    }
}

// Eliminar las entradas de la tabla producto_imagenes
$sql_eliminar_imagenes = "DELETE FROM producto_imagenes WHERE id_producto = '$id_producto'";
$conn->query($sql_eliminar_imagenes);

// Eliminar la publicación de la tabla productos
$sql_eliminar_producto = "DELETE FROM productos WHERE id = '$id_producto' AND id_usuario = '$id_usuario'";
if ($conn->query($sql_eliminar_producto) === TRUE) {
echo "<script> alert ('¡Publicación eliminada con éxito!.'); location.assign ('mis_publicaciones.php'); </script>";
    exit();
} else {
    echo "Error al eliminar la publicación: " . $conn->error;
    echo "<script> alert ('Error al eliminar la publicación.'); location.assign ('mis_publicaciones.php'); </script>";

}

$conn->close();
?>