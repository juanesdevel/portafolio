<?php
session_start();
include '../includes/conexion.php';

// Tiempo de inactividad (sin cambios aquí)
$tiempo_inactividad = 600;
if (isset($_SESSION['ultima_actividad']) && (time() - $_SESSION['ultima_actividad'] > $tiempo_inactividad)) {
    session_unset();
    session_destroy();
    setcookie("session_closed", "true", time() + 3600, "/");
    header("Location: index.php");
    exit();
}
$_SESSION['ultima_actividad'] = time();

// Obtener todas las publicaciones de forma aleatoria
$sql = "SELECT p.*, (SELECT ruta_imagen FROM producto_imagenes WHERE id_producto = p.id LIMIT 1) AS imagen_principal FROM productos p ORDER BY RAND()";
$result = $conn->query($sql);

$publicaciones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $publicaciones[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Plataforma de Compra y Venta</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <style>
        /* Estilos personalizados para el modo oscuro */
body.bg-dark {
    background-color: #121212 !important;
    color: #fff;
}

.card.bg-secondary {
    background-color: #333 !important;
}

/* Para establecer una altura mínima en la tarjeta completa */
.card {
    min-height: 450px; /* Ajusta este valor según necesites */
}

/* Opcionalmente, si prefieres controlar la altura del contenido dentro de la tarjeta */
.card-body {
    min-height: 250px; /* Ajusta este valor según necesites */
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Para espaciar el contenido y el botón */
}
/* Fin del bloque opcional */

.card-body .btn {
    margin-top: auto; /* Para empujar el botón hacia abajo si usas flexbox en .card-body */
}
    </style>
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Mi Plataforma</a>
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

    <div class="container mt-4">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img_productos/publi1.jpg" class="d-block w-100" alt="Publicidad 1">
                </div>
                <div class="carousel-item">
                    <img src="img_productos/publi2.jpg" class="d-block w-100" alt="Publicidad 2">
                </div>
                <div class="carousel-item">
                    <img src="img_productos/publi3.jpg" class="d-block w-100" alt="Publicidad 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

        <div class="row mt-4">
            <?php if (!empty($publicaciones)): ?>
                <?php $count = 0; ?>
                <?php foreach ($publicaciones as $publicacion): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-secondary text-white">
                            <img src="<?php echo $publicacion['imagen_principal'] ? $publicacion['imagen_principal'] : 'img/placeholder.png'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($publicacion['nombre']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($publicacion['nombre']); ?></h5>
                                <p class="card-text"><?php echo substr(htmlspecialchars($publicacion['descripcion']), 0, 100); ?>...</p>
                                <p class="card-text">Precio: $<?php echo htmlspecialchars($publicacion['precio']); ?></p>
                                <a href="ver_producto.php?id=<?php echo $publicacion['id']; ?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                    <?php $count++; ?>
                    <?php if ($count % 3 == 0): ?>
                        </div><div class="row mt-4">
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($count % 3 != 0): ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-center">No hay publicaciones cargadas.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>