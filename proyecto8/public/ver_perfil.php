<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../includes/conexion.php';
  


if (!isset($_GET['id'])) {
echo "<script> alert ('!perfil no encontrado¡.'); location.assign ('index.php'); </script>";
    exit();
}

$id_usuario_perfil = $_GET['id'];

// Obtener la información del usuario
$sql_usuario = "SELECT id, nombre, telefono, fecha_registro 
                FROM usuarios
                WHERE id = '$id_usuario_perfil'";
$result_usuario = $conn->query($sql_usuario);

if ($result_usuario->num_rows == 0) {
    echo "Usuario no encontrado.";
    exit();
}

$usuario_perfil = $result_usuario->fetch_assoc();

// Opcional: Obtener las publicaciones del usuario
$sql_publicaciones = "SELECT id, nombre, precio, (SELECT ruta_imagen FROM producto_imagenes WHERE id_producto = productos.id LIMIT 1) AS imagen_principal
                      FROM productos
                      WHERE id_usuario = '$id_usuario_perfil'
                      ORDER BY id DESC
                      LIMIT 10"; // Mostrar las 10 publicaciones más recientes
$result_publicaciones = $conn->query($sql_publicaciones);
$publicaciones = [];
while ($row_publicacion = $result_publicaciones->fetch_assoc()) {
    $publicaciones[] = $row_publicacion;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo htmlspecialchars($usuario_perfil['nombre']); ?></title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        .perfil-info {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #444;
            border-radius: 5px;
        }
        .publicacion-miniatura {
            max-width: 100px;
            height: auto;
            margin-right: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Mi Plataforma</a>
            </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="perfil-info">
                    <h2>Perfil de <?php echo htmlspecialchars($usuario_perfil['nombre']); ?></h2>
                    <p><strong>Telefono:</strong> <?php echo htmlspecialchars($usuario_perfil['telefono']); ?></p>
                    <p><strong>Registrado el:</strong> <?php echo date('d/m/Y', strtotime($usuario_perfil['fecha_registro'])); ?></p>
                    </div>

                <?php if (!empty($publicaciones)): ?>
                    <div class="mt-4">
                        <h3>Publicaciones Recientes de <?php echo htmlspecialchars($usuario_perfil['nombre']); ?></h3>
                        <div class="row">
                            <?php foreach ($publicaciones as $publicacion): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card bg-secondary text-white">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="<?php echo $publicacion['imagen_principal'] ? $publicacion['imagen_principal'] : 'img/placeholder.png'; ?>" class="img-fluid rounded-start publicacion-miniatura" alt="<?php echo htmlspecialchars($publicacion['nombre']); ?>">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($publicacion['nombre']); ?></h5>
                                                    <p class="card-text">Precio: $<?php echo htmlspecialchars($publicacion['precio']); ?></p>
                                                    <a href="ver_producto.php?id=<?php echo $publicacion['id']; ?>" class="btn btn-sm btn-primary">Ver detalle</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($publicaciones) >= 10): ?>
                            <p><a href="ver_todas_publicaciones.php?id_usuario=<?php echo $id_usuario_perfil; ?>">Ver todas las publicaciones de <?php echo htmlspecialchars($usuario_perfil['nombre']); ?></a></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="mt-4">
                        <p><?php echo htmlspecialchars($usuario_perfil['nombre']); ?> aún no ha publicado ningún producto.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>