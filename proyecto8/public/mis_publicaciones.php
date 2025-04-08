<?php
session_start();
include '../includes/conexion.php';
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT p.*, (SELECT ruta_imagen FROM producto_imagenes WHERE id_producto = p.id LIMIT 1) AS imagen_principal FROM productos p WHERE p.id_usuario = '$id_usuario'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Publicaciones</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Mi Plataforma</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categorias
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Inmuebles</a></li>
                            <li><a class="dropdown-item" href="#">Productos</a></li>
                            <li><a class="dropdown-item" href="#">Servicios</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex me-3">
                    <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
                    <button class="btn btn-outline-light" type="submit">Buscar</button>
                </form>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['id_usuario'])) { ?>
                        <li class="nav-item">
                            <span class="nav-link">Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mis_publicaciones.php">Mis Publicaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="publicar_producto.php">Publicar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cerrar_sesion.php">Cerrar Sesión</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="registro.php">Registro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Ingreso</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="bg-dark text-white">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Mis Publicaciones</h2>
            <?php if ($result->num_rows > 0) { ?>
                <div class="row">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-secondary text-white">

                                <img src="<?php echo $row['imagen_principal']; ?>" class="card-img-top" alt="<?php echo $row['nombre']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                    <p class="card-text"><?php echo substr($row['descripcion'], 0, 100); ?>...</p>
                                    <p class="card-text">Precio: $<?php echo $row['precio']; ?></p>
                                    <div class="d-flex justify-content-between">
                                        <a href="ver_producto.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Ver detalles</a>
                                        <a href="editar_producto.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                        <a href="eliminar_producto.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta publicación?')">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p class="text-center">No tienes publicaciones.</p>
            <?php } ?>
        </div>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
<?php $conn->close(); ?>