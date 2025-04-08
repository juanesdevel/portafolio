<?php
// Incluye el archivo de conexión a la base de datos
include '../includes/conexion.php';

// Verifica si se han recibido el token y el ID por GET
if (isset($_GET['token']) && isset($_GET['id'])) {
    $token = $_GET['token'];
    $user_id = $_GET['id'];

    // Aquí podrías opcionalmente verificar la validez del token si lo implementaste en el paso anterior
    // Por ahora, asumiremos que el token es válido si está presente.

    // Procesa el formulario si se ha enviado por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nueva_contrasena = $_POST['nueva_contrasena'];
        $confirmar_contrasena = $_POST['confirmar_contrasena'];

        // Verifica si las contraseñas coinciden
        if ($nueva_contrasena === $confirmar_contrasena) {
            // Hashea la nueva contraseña de forma segura
            $contrasena_hasheada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

            // Prepara la consulta SQL para actualizar la contraseña del usuario
            $sql = "UPDATE usuarios SET password = ? WHERE id = ?";

            // Prepara la sentencia
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Vincula los parámetros
                $stmt->bind_param("si", $contrasena_hasheada, $user_id);

                // Ejecuta la consulta
                if ($stmt->execute()) {
                    // Contraseña actualizada correctamente, redirige al login
                    echo '<script>alert("Contraseña actualizada correctamente."); window.location.href = "login.php";</script>';
                    exit();
                } else {
                    echo "<p style='color: #ff6b6b;'>Error al actualizar la contraseña: " . $stmt->error . "</p>";
                }

                // Cierra la sentencia
                $stmt->close();
            } else {
                echo "<p style='color: #ff6b6b;'>Error al preparar la consulta: " . $conn->error . "</p>";
            }
        } else {
            $error_contrasena = "Las contraseñas no coinciden.";
        }
    }
} else {
    // Si no se reciben el token o el ID, muestra un mensaje de error o redirige
    echo "<p style='color: #ff6b6b;'>Enlace de recuperación inválido.</p>";
    // Puedes redirigir a la página principal o a una página de error
    // header("Location: index.php");
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #1e1e1e; /* Fondo oscuro */
            color: #dcdcdc; /* Texto claro */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #333; /* Contenedor más oscuro */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Sombra más pronunciada */
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #f0f0f0; /* Título claro */
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #a9a9a9; /* Etiqueta gris claro */
            font-weight: bold;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #555; /* Borde gris oscuro */
            border-radius: 4px;
            box-sizing: border-box;
            background-color: #444; /* Fondo del input oscuro */
            color: #f0f0f0; /* Texto del input claro */
        }

        .error-message {
            color: #ff6b6b; /* Mensaje de error rojo */
            margin-top: 5px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Crear Nueva Contraseña</h2>
        <form method="post">
            <div class="form-group">
                <label for="nueva_contrasena">Nueva Contraseña:</label>
                <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
            </div>
            <div class="form-group">
                <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
                <?php if (isset($error_contrasena)): ?>
                    <p class="error-message"><?php echo $error_contrasena; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit">Guardar Nueva Contraseña</button>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        </form>
    </div>
</body>
</html>