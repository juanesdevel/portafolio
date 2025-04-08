<?php
session_start(); // Iniciamos la sesión al principio de la página

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars($_POST["usuario"]); // Usaremos el 'nombre_usuario' del formulario
    $contrasena = $_POST["contrasena"]; // Obtener la contraseña sin escapar para la verificación

    // Consulta SQL para buscar al usuario por su nombre de usuario
    $sql = "SELECT id_usuario, nombre_usuario, contrasena_usuario, rol_usuario
            FROM usuarios
            WHERE nombre_usuario = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password_from_db = $row["contrasena_usuario"];

        // Verificar la contraseña ingresada con la contraseña hasheada de la base de datos
        if (password_verify($contrasena, $hashed_password_from_db)) {
            // La contraseña es correcta, crear la sesión del usuario
            $_SESSION["usuario_id"] = $row["id_usuario"];
            $_SESSION["usuario"] = $row["nombre_usuario"];
            $_SESSION["rol"] = $row["rol_usuario"];

            // Redirigir al usuario según su rol
            if ($_SESSION["rol"] == "admin") {
                echo '<script>alert("Bienvenido Administrador: ' . htmlspecialchars($_SESSION["usuario"]) . '"); window.location.href = "../public/inicio_admin.php";</script>';
                exit();
            } elseif ($_SESSION["rol"] == "asesor") {
                echo '<script>alert("Bienvenido Asesor: ' . htmlspecialchars($_SESSION["usuario"]) . '"); window.location.href = "../public/inicio_operador.php";</script>';
                exit();
            } else {
                echo '<script>alert("Bienvenido Usuario: ' . htmlspecialchars($_SESSION["usuario"]) . '"); window.location.href = "../public/inicio_usuario.php";</script>';
                exit();
            }
        } else {
            // Contraseña incorrecta
            echo '<script>alert("Error: Contraseña incorrecta."); window.location.href = "../index.php";</script>';
            exit();
        }
    } else {
        // Usuario no encontrado
        echo '<script>alert("Error: Usuario no encontrado."); window.location.href = "../index.php";</script>';
        exit();
    }

    $stmt->close();
} else {
    // Si se intenta acceder a la página sin enviar el formulario por POST
    echo '<script>alert("Acceso denegado."); window.location.href = "../index.php";</script>';
    exit();
}

$conn->close();
?>