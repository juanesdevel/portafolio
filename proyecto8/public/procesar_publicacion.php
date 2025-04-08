<?php
session_start();
include '../includes/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $id_usuario = $_SESSION['id_usuario'];

    // Insertar la información principal del producto
    $sql_producto = "INSERT INTO productos (nombre, descripcion, precio, id_usuario) VALUES ('$nombre', '$descripcion', '$precio', '$id_usuario')";

    if ($conn->query($sql_producto) === TRUE) {
        $id_producto = $conn->insert_id; // Obtener el ID del producto recién insertado

        // Procesar las múltiples imágenes
        if (isset($_FILES['imagenes']) && is_array($_FILES['imagenes']['name'])) {
            $total_imagenes = count($_FILES['imagenes']['name']);
            for ($i = 0; $i < $total_imagenes; $i++) {
                $nombre_imagen = $_FILES['imagenes']['name'][$i];
                $ruta_temporal = $_FILES['imagenes']['tmp_name'][$i];
                $ruta_destino = "img_productos/" . uniqid() . "_" . $nombre_imagen; // Nombre único para cada imagen

                if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
                    // Insertar la ruta de la imagen en la tabla producto_imagenes
                    $sql_imagen = "INSERT INTO producto_imagenes (id_producto, ruta_imagen) VALUES ('$id_producto', '$ruta_destino')";
                    $conn->query($sql_imagen); // No es crucial detener todo si falla una imagen, podrías agregar manejo de errores aquí
                } else {
                    echo "Error al cargar la imagen: " . $nombre_imagen . "<br>";
                }
            }
            
            echo "<script> alert ('Producto publicado con éxito y " . $total_imagenes . " imágenes cargadas..'); location.assign ('mis_publicaciones.php'); </script>";

            exit();
        } else {
            echo "No se seleccionaron imágenes.";
        }
    } else {
        echo "Error al publicar el producto: " . $conn->error;
    }

    $conn->close();
}
?>