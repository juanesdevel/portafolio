<?php
session_start();
include '../includes/conexion.php';
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $id_usuario = $_SESSION['id_usuario'];

    // Verificar que la publicación pertenece al usuario
    $check_sql = "SELECT id FROM productos WHERE id = '$id_producto' AND id_usuario = '$id_usuario'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows == 0) {
        echo "Error: Esta publicación no te pertenece.";
        exit();
    }

    // Actualizar la información principal del producto
    $sql_producto = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio = '$precio' WHERE id = '$id_producto'";
    if ($conn->query($sql_producto) === FALSE) {
        echo "Error al actualizar el producto: " . $conn->error;
        exit();
    }

    // Eliminar imágenes seleccionadas
    if (isset($_POST['eliminar_imagenes']) && is_array($_POST['eliminar_imagenes'])) {
        foreach ($_POST['eliminar_imagenes'] as $id_imagen_eliminar) {
            // Obtener la ruta de la imagen para eliminarla del servidor
            $sql_ruta_eliminar = "SELECT ruta_imagen FROM producto_imagenes WHERE id = '$id_imagen_eliminar' AND id_producto = '$id_producto'";
            $result_ruta_eliminar = $conn->query($sql_ruta_eliminar);
            if ($result_ruta_eliminar && $row_ruta_eliminar = $result_ruta_eliminar->fetch_assoc()) {
                $ruta_a_eliminar = $row_ruta_eliminar['ruta_imagen'];
                if (file_exists($ruta_a_eliminar)) {
                    unlink($ruta_a_eliminar);
                }
                // Eliminar la entrada de la base de datos
                $sql_eliminar_imagen = "DELETE FROM producto_imagenes WHERE id = '$id_imagen_eliminar' AND id_producto = '$id_producto'";
                $conn->query($sql_eliminar_imagen);
            }
        }
    }

    // Agregar nuevas imágenes
    if (isset($_FILES['nuevas_imagenes']) && is_array($_FILES['nuevas_imagenes']['name'])) {
        $total_nuevas_imagenes = count($_FILES['nuevas_imagenes']['name']);
        for ($i = 0; $i < $total_nuevas_imagenes; $i++) {
            if ($_FILES['nuevas_imagenes']['error'][$i] === UPLOAD_ERR_OK) {
                $nombre_nueva_imagen = $_FILES['nuevas_imagenes']['name'][$i];
                $ruta_temporal_nueva = $_FILES['nuevas_imagenes']['tmp_name'][$i];
                $ruta_destino_nueva = "img_productos/" . uniqid() . "_" . $nombre_nueva_imagen;

                if (move_uploaded_file($ruta_temporal_nueva, $ruta_destino_nueva)) {
                    $sql_nueva_imagen = "INSERT INTO producto_imagenes (id_producto, ruta_imagen) VALUES ('$id_producto', '$ruta_destino_nueva')";
                    $conn->query($sql_nueva_imagen);
                } else {
                    echo "Error al cargar la nueva imagen: " . $nombre_nueva_imagen . "<br>";
                }
            }
        }
    }

echo "<script> alert ('¡Publicación editada correctamente!.'); location.assign ('mis_publicaciones.php'); </script>";
    exit();
} else {
    echo "Error: Método no permitido.";
}
$conn->close();
?>