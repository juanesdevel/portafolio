<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Fondo gris claro */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .logo-container {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .logo {
            width: 100px; /* Logo más pequeño para un estilo minimalista */
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .login-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-title {
            text-align: center;
            color: #343a40; /* Texto oscuro */
            margin-bottom: 30px;
            font-weight: 300; /* Más ligero */
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #6c757d; /* Texto gris */
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .footer {
            background-color: #343a40;
            color: #f8f9fa;
            text-align: center;
            padding: 15px 0;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            font-size: 0.8rem;
        }

        /* Opcional: Animación sutil al cargar */
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.5s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="./img/logo.png" alt="Logo de la empresa" class="logo fade-in">
    </div>

    <div class="login-container fade-in">
        <div class="login-card">
            <h2 class="login-title">Iniciar Sesión</h2>
            <form action="conexion/validador.php" method="post">
                <div class="form-group">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="contrasena" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="modulo" class="form-label">Seleccionar Módulo:</label>
                    <select class="form-control" id="modulo" name="modulo">
                        <option value="1">Módulo 1</option>
                        <option value="2">Módulo 2</option>
                        <option value="3">Módulo 3</option>
                        <option value="4">Módulo 4</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p class="mb-0">Desarrollado por: Juan Esteban Gallego Cano. Contacto: juanesnet2016@gmail.com Celular: +57 300 8144841</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>