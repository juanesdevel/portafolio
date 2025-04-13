<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <title>Login - Sistema de Ventas y Facturación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            
    background-image: url('img/Fondo1.png'); /* Reemplaza con la ruta de tu imagen */
    background-size: cover; /* Hace que la imagen cubra todo el fondo */
    background-position: center; /* Centra la imagen */
    background-repeat: no-repeat; /* Evita que la imagen se repita */
    }

        body {
            background-color: #f8f9fa;
            
        }
        .custom-background {
            background-color:#95d2df;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            opacity: 0.8; /* 70% de opacidad en todo el contenedor */
        }
        .form-style {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 2rem;
        }
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #95d2df;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .logo-container {
            
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .logo {
            width: 150px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="./img/presentacion.png" alt="Logo de la empresa" class="logo">
    </div>

    <div class="container mt-5">
        <div class="row ">
            <div class="col-12 custom-background text-white rounded">
                <h1 class="text-center">ELECTRO AI VENTAS Y FACTURACIÓN</h1>
            </div>
        </div>
    </div>

    <?php
    include ("conexion/conexion.php");
    include ("conexion/validador.php");
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="custom-background">
                    <h2 class="text-center text-white mb-4">Iniciar Sesión</h2>
                    <form action="conexion/validador.php" method="post" class="form-style">
                        <div class="form-group">
                            <label for="usuario">Usuario:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="off" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-info btn-lg">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p class="mb-0">Desarrollado por: Juan Esteban Gallego Cano. Contacto: juanesnet2016@gmail.com </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>