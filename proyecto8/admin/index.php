<?php
session_start();

// Tiempo de inactividad permitido en segundos (ejemplo: 600 segundos = 10 minutos)
$tiempo_inactividad = 60;

// Verifica si la sesión está activa y si ha pasado el tiempo de inactividad
if (isset($_SESSION['ultima_actividad']) && (time() - $_SESSION['ultima_actividad'] > $tiempo_inactividad)) {
    session_unset();     // Elimina las variables de sesión
    session_destroy();   // Destruye la sesión
    // Puedes opcionalmente establecer una cookie para mostrar un mensaje después de la redirección
    setcookie("session_closed", "true", time() + 3600, "/");
    header("Location: public/login.php"); // Redirige a la página de inicio de sesión
    exit();
}

// Actualiza la última actividad al cargar la página
$_SESSION['ultima_actividad'] = time();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Plataforma de Compra y Venta</title>
    <link rel="stylesheet" href="../public/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/estilos.css">
</head>
<body 

class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Mi Plataforma Administrador</a>
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
                    <img src="img/publi1.jpg" class="d-block w-100" alt="Publicidad 1">
                </div>
                <div class="carousel-item">
                    <img src="img/publi2.jpg" class="d-block w-100" alt="Publicidad 2">
                </div>
                <div class="carousel-item">
                    <img src="img/publi3.jpg" class="d-block w-100" alt="Publicidad 3">
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
            <div class="col-md-4 mb-4">
                <div class="card bg-secondary text-white">
                    <img src="public/img/producto1.jpg" class="card-img-top" alt="Producto 1">
                    <div class="card-body">
                        <h5 class="card-title">Producto 1</h5>
                        <p class="card-text">Descripci車n del producto 1.</p>
                        <a href="#" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-secondary text-white">
                    <img src="public/img/producto2.jpg" class="card-img-top" alt="Producto 2">
                    <div class="card-body">
                        <h5 class="card-title">Producto 2</h5>
                        <p class="card-text">Descripci車n del producto 2.</p>
                        <a href="#" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-secondary text-white">
                    <img src="public/img/producto3.jpg" class="card-img-top" alt="Producto 3">
                    <div class="card-body">
                        <h5 class="card-title">Producto 3</h5>
                        <p class="card-text">Descripci車n del producto 3.</p>
                        <a href="#" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>