<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <title>Login - Sistema Personal de Datos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #121212; /* Fondo oscuro para el modo oscuro */
            color: #e0e0e0; /* Texto claro para el modo oscuro */
            background-size: cover;
            background-image: url('img/Fondo1.png'); /* Mantiene tu imagen de fondo */

            background-position: center;
            background-repeat: no-repeat;
        }

        .custom-background {
            background-color: #333; /* Fondo oscuro para contenedores */
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5); /* Sombra más pronunciada */
            opacity: 0.7; /* Ligera transparencia */
        }

        .form-style {
            background-color: #424242; /* Fondo más claro para el formulario */
            border-radius: 20px;
            padding: 2rem;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333; /* Fondo oscuro para el pie de página */
            color: #e0e0e0;
            text-align: center;
            padding: 10px 0;
            opacity: 0.7; /* Ligera transparencia */

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
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.7); /* Sombra más oscura */
        }

        .form-control {
            background-color: #5a5a5a; /* Fondo oscuro para los campos de formulario */
            color: #e0e0e0;
            border: 1px solid #757575; /* Borde más oscuro */
        }

        .form-control:focus {
            background-color: #616161; /* Fondo ligeramente más claro al enfocar */
            color: #e0e0e0;
            border-color: #90caf9; /* Borde azul claro al enfocar */
            box-shadow: 0 0 0 0.2rem rgba(144, 202, 249, 0.25); /* Sombra azul claro al enfocar */
        }

        .btn-primary {
            background-color: #1e88e5; /* Azul primario para el botón */
            border-color: #1976d2;
        }

        .btn-primary:hover {
            background-color: #1565c0; /* Azul más oscuro al pasar el ratón */
            border-color: #1565c0;
        }

        label {
            color: #bdbdbd; /* Color de etiqueta más claro */
        }
    </style>
</head>
<body>


    <?php
    include ("/proyecto9/conexion/conexion.php");
    include ("/proyecto9/conexion/validador.php");
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="custom-background">
                    <h2 class="text-center text-white mb-4">Iniciar Sesión</h2>
                    <form action="/proyecto9/conexion/validador.php" method="post" class="form-style">
                        <div class="form-group">
                            <label for="usuario">Usuario:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="off" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p class="mb-0">Desarrollado por: Juan Esteban Gallego Cano. Contacto: juanesnet2016@gmail.com Celular: +57 300 8144841</p>
    </footer>
</body>
</html>