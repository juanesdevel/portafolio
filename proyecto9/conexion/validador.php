<?php
include 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars($_POST["usuario"]);
    $contrasena = $_POST["contrasena"];

    $sql = "SELECT * FROM usuarios2 WHERE nombre_usuario = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error en la consulta: " . $conexion->error);
    }
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row["contrasena_usuario"])) {
            $_SESSION["usuario"] = $row["nombre_usuario"];
            $rol = $row["rol_usuario"];

            if ($rol == "admin") {
                $_SESSION["rol"] = "admin";
                echo '<script>alert("Bienvenido Usuario Administrador"); location.assign("/proyecto9/vistas/inicio_admin.php");</script>';
                exit();
            } elseif ($rol == "asesor") {
                $_SESSION["rol"] = "asesor";
                echo '<script>alert("Bienvenido ' . htmlspecialchars($_SESSION['usuario']) . '"); location.assign("/proyecto9/vistas/inicio_operador.php");</script>';
                exit();
            } else {
                echo '<script>alert("Usuario sin autorización de ingreso."); location.assign("/proyecto9/personal.php");</script>';
                exit();
            }
        } else {
            echo '<script>alert("Acceso denegado: Usuario o contraseña incorrecta."); location.assign("/proyecto9/personal.php");</script>';
        }
    } else {
        echo '<script>alert("Acceso denegado: Usuario o contraseña incorrecta."); location.assign("/proyecto9/personal.php");</script>';
    }

    $stmt->close();
    $conexion->close();
}
?>