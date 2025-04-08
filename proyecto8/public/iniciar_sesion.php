<?php
session_start(); // Inicia la sesión

include '../includes/conexion.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["usuario"] = $row["usuario"];
            $rol = $row["rol_usuario"];
            $_SESSION['id_usuario'] = $row['id']; // Guarda el ID del usuario en la sesión
            $_SESSION['nombre_usuario'] = $row['nombre']; // Guarda el nombre del usuario en la sesión
            $_SESSION['ultima_actividad'] = time(); // Guarda la hora de la última actividad

            if ($rol == "admin") {
                $_SESSION["rol"] = "admin";
                echo '<script>alert("Bienvenido, Administrador"); location.assign("../admin/index.php");</script>';
                exit();
            } elseif ($rol == "user") {
                $_SESSION["rol"] = "user";
                echo '<script>alert("Bienvenido, ' . htmlspecialchars($_SESSION['nombre_usuario']) . '"); location.assign("index.php");</script>';
                exit();
            } else {
                session_start(); // Inicia la sesi贸n
                session_destroy(); // Destruye la sesi贸n
                echo '<script>alert("Usuario sin autorización de ingreso, requiere activar cuenta."); location.assign("index.php");</script>';
                exit();
            }
        } else 
                 session_start(); // Inicia la sesi贸n
                session_destroy(); // Destruye la sesi贸n
            echo '<script>alert("Acceso denegado: Usuario o contraseña incorrecta."); location.assign("login.php");</script>';
        }
    } else {
                 session_start(); // Inicia la sesi贸n
                session_destroy(); // Destruye la sesi贸n
        echo '<script>alert("Acceso denegado: Usuario o contraseña incorrecta."); location.assign("login.php");</script>';
    }

    $conn->close();

?>

