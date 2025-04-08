<?php
include ("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars($_POST["usuario"]);
    $contrasena = $_POST["contrasena"];

    $sql = "SELECT id_usuario, nombre_usuario, contrasena_usuario, rol_usuario FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row["contrasena_usuario"])) {
            session_start();
            $_SESSION["usuario_id"] = $row["id_usuario"]; // Guardar el ID del usuario
            $_SESSION["usuario"] = $row["nombre_usuario"];
            $_SESSION["rol"] = $row["rol_usuario"];

            // Guardar el módulo seleccionado en la sesión
            if (isset($_POST['modulo'])) {
                $_SESSION['modulo_seleccionado'] = $_POST['modulo'];
            }

            $rol = $row["rol_usuario"];

            if ($rol == "admin") {
                echo '<script>alert("Bienvenido ' . htmlspecialchars($_SESSION['usuario']) . '"); location.assign("../public/inicio_admin.php");</script>';
                exit();
            } elseif ($rol == "asesor") {
                $_SESSION["rol"] = "asesor";
                echo '<script>alert("Bienvenido ' . htmlspecialchars($_SESSION['usuario']) . '"); location.assign("../public/inicio_asesor.php");</script>';
                exit();
            } else {
                echo '<script>alert("Usuario sin autorización de ingreso."); location.assign("../index.php");</script>';
                exit();
            }
        } else {
            echo '<script>alert("Acceso denegado: Contraseña incorrecta."); location.assign("../index.php");</script>';
        }
    } else {
        echo '<script>alert("Acceso denegado: Usuario no encontrado."); location.assign("../index.php");</script>';
    }

    $stmt->close();
} else {
    echo '<script>alert("Acceso denegado: Metodo no permitido."); location.assign("../index.php");</script>';
}

$conn->close();
?>