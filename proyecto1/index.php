<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <title>Login - Sistema de Ventas y Facturación</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* Define una imagen de fondo para la página */
            background-image: url('img/fondo1.jpg'); /* Reemplaza con la ruta de tu imagen */
            background-size: cover; /* Hace que la imagen cubra todo el fondo */
            background-position: center; /* Centra la imagen */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
       
        
        .custom-background {
            /* Estilo para contenedores personalizados */
            background-color: rgb(93, 173, 226); /* Color de fondo celeste */
            padding: 2rem; /* Espaciado interno de 2rem */
            border-radius: 20px; /* Bordes redondeados */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); /* Sombra suave */
            opacity: 0.8; /* Opacidad del 80% para el contenedor */
        }
        .form-style {
            /* Estilo específico para el formulario */
            background-color: rgba(133, 193, 233); /* Fondo blanco con 90% de opacidad */
            border-radius: 20px; /* Bordes redondeados */
            padding: 2rem; /* Espaciado interno */
        }
        .footer {
            /* Estilo para el pie de página */
            position: fixed; /* Fija el footer en la parte inferior */
            left: 0; /* Alinea a la izquierda */
            bottom: 0; /* Fija en la parte inferior de la pantalla */
            width: 100%; /* Ocupa todo el ancho */
            background-color:rgb(93, 173, 226); /* Color de fondo celeste */
            color: white; /* Texto blanco */
            text-align: center; /* Centra el texto */
            padding: 10px 0; /* Espaciado vertical */
            opacity: 0.8; /* Opacidad del 80% para el contenedor */

        }
        .logo-container {
            /* Contenedor para el logo en la esquina superior derecha */
            position: fixed; /* Posición fija en la pantalla */
            top: 20px; /* Distancia desde la parte superior */
            right: 20px; /* Distancia desde la derecha */
            z-index: 1000; /* Asegura que esté por encima de otros elementos */
        }
        .logo {
            /* Estilo para la imagen del logo */
            width: auto; /* Ancho fijo */
            height: auto; /* Altura automática para mantener proporciones */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5); /* Sombra más pronunciada */
        }
    </style>
</head>
<body>
    <!-- Contenedor para el logo en la esquina superior derecha -->
    <div class="logo-container">
        <img src="./img/logo.jpg" alt="Logo de la empresa" class="logo">
        <!-- Imagen del logo con ruta relativa y descripción alternativa -->
    </div>

    <!-- Contenedor principal para el título del sistema -->
    <div class="container mt-3">
        <div class="row ">
            <div class="col-12 custom-background text-white rounded">
                <!-- Título centrado con estilo personalizado -->
                <h1 class="text-center">ELECTRO FACT</h1>
            </div>
        </div>
    </div>

    <?php
    // Incluye el archivo de conexión a la base de datos
    include ("conexion/conexion.php");
    // Incluye el archivo que valida las credenciales del usuario
    include ("conexion/validador.php");
    ?>

    <!-- Contenedor para el formulario de inicio de sesión -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="custom-background">
                    <!-- Título del formulario centrado -->
                    <h2 class="text-center text-white mb-4">Iniciar Sesión</h2>
                    <!-- Formulario que envía datos al validador.php -->
                    <form action="conexion/validador.php" method="post" class="form-style">
                        <div class="form-group">
                            <!-- Campo para el nombre de usuario -->
                            <label for="usuario">Usuario:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                            <!-- Campo de texto obligatorio con estilo de Bootstrap -->
                        </div>
                        <div class="form-group">
                            <!-- Campo para la contraseña -->
                            <label for="contrasena">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="off" required>
                            <!-- Campo de contraseña obligatorio con autocompletado desactivado -->
                        </div>
                        <div class="text-center">
                            <!-- Botón para enviar el formulario -->
                            <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
                            <!-- Botón con estilo de Bootstrap -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie de página con información del desarrollador -->
    <footer class="footer">
        <p class="mb-0">Desarrollado por: Juan Esteban Gallego Cano. Contacto: juanesnet2016@gmail.com Celular: +57 300 8144841</p>
        <!-- Texto centrado sin márgenes inferiores -->
    </footer>

    <!-- Scripts necesarios para el funcionamiento de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Librería jQuery para manipulación del DOM -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <!-- Popper.js para tooltips y popovers -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Archivo JS de Bootstrap para componentes interactivos -->
</body>
</html>