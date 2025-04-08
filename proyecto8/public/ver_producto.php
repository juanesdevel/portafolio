<?php
session_start();

include '../includes/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
echo "<script> alert ('Inicia sesion para ver el producto.'); location.assign ('login.php'); </script>";
    exit();
}

$id_producto = $_GET['id'];

// Obtener los detalles del producto y la información del usuario que lo publicó
$sql = "SELECT p.*, u.id AS id_usuario_autor, u.nombre AS nombre_autor, u.telefono AS telefono_autor
        FROM productos p
        INNER JOIN usuarios u ON p.id_usuario = u.id
        WHERE p.id = '$id_producto'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Producto no encontrado.";
    exit();
}

// Obtener las imágenes adicionales del producto
$sql_imagenes = "SELECT ruta_imagen FROM producto_imagenes WHERE id_producto = '$id_producto'";
$result_imagenes = $conn->query($sql_imagenes);
$imagenes = [];
while ($row_imagen = $result_imagenes->fetch_assoc()) {
    $imagenes[] = $row_imagen['ruta_imagen'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['nombre']; ?></title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .producto-imagenes-adicionales img {
            max-width: 150px;
            height: auto;
            margin-right: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            padding: 5px;
        }
    </style>
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $row['nombre']; ?></h2>
                        <p class="card-text"><?php echo $row['descripcion']; ?></p>
                        <p class="card-text">Precio: $<?php echo $row['precio']; ?></p>
                        <?php if (!empty($imagenes)): ?>
                            <div class="mt-3 producto-imagenes-adicionales">
                                <h5>Otras Imágenes:</h5>
                                <?php foreach ($imagenes as $ruta): ?>
                                    <img src="<?php echo $ruta; ?>" alt="Imagen adicional del producto">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer">
                        Publicado por: <a href="ver_perfil.php?id=<?php echo $row['id_usuario_autor']; ?>" class="text-light"><?php echo $row['nombre_autor']; ?></a>
                        <br>
                        Contacto: <p class="text-light"><?php echo $row['telefono_autor']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>