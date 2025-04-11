<?php
session_start();
include '../includes/conexion.php';
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();

echo "ID de Usuario en Sesión: " . $_SESSION['id_usuario'] . "<br>"; // <---- AGREGAR ESTA LÍNEA
$id_usuario = $_SESSION['id_usuario'];
$id_producto = $_GET['id'];
}
$id_usuario = $_SESSION['id_usuario'];
$id_producto = $_GET['id'];

// Obtener la información del producto
$sql_producto = "SELECT * FROM productos WHERE id = '$id_producto' AND id_usuario = '$id_usuario'";
$result_producto = $conn->query($sql_producto);

if ($result_producto->num_rows == 0) {
echo "<script> alert ('Publicación no encontrada o no te pertenece.'); location.assign ('mis_publicaciones.php'); </script>";
    exit();
}
$producto = $result_producto->fetch_assoc();

// Obtener las imágenes del producto
$sql_imagenes = "SELECT * FROM producto_imagenes WHERE id_producto = '$id_producto'";
$result_imagenes = $conn->query($sql_imagenes);
$imagenes = [];
while ($row_imagen = $result_imagenes->fetch_assoc()) {
    $imagenes[] = $row_imagen;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicación</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4">Editar Publicación</h2>
                <form action="procesar_edicion.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_producto" value="<?php echo $producto['id']; ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Producto</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $producto['nombre']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" required><?php echo $producto['descripcion']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" name="precio" id="precio" class="form-control" value="<?php echo $producto['precio']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Imágenes Actuales</label>
                        <div class="row">
                            <?php foreach ($imagenes as $imagen): ?>
                                <div class="col-md-3 mb-2">
                                    <img src="<?php echo $imagen['ruta_imagen']; ?>" class="img-thumbnail">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="eliminar_imagenes[]" value="<?php echo $imagen['id']; ?>">
                                        <label class="form-check-label">Eliminar</label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <label for="nuevas_imagenes" class="form-label">Agregar Nuevas Imágenes (Puedes seleccionar varias)</label>
                        <input type="file" name="nuevas_imagenes[]" id="nuevas_imagenes" class="form-control" accept="image/*" multiple>
                        <small class="form-text text-muted">Puedes agregar nuevas imágenes sin eliminar las existentes (a menos que las selecciones para eliminar arriba).</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>