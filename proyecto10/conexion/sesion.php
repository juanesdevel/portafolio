<?php
session_start();

// Verificar si la sesión está activa y si existen las variables de usuario
if (isset($_SESSION["usuario_id"]) && isset($_SESSION["usuario"]) && isset($_SESSION["rol"])) {
    // La sesión está activa y las variables de usuario están configuradas
    // Puedes opcionalmente realizar aquí otras verificaciones, como la última actividad del usuario
    // o la validez de la sesión en la base de datos (para mayor seguridad).
} else {
    // La sesión no está activa o faltan variables de usuario
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: index.php"); // Reemplaza "index.php" con la ruta a tu página de login
    exit();
}

// Ahora, en esta página, tienes acceso a las variables de sesión:
// $_SESSION["usuario_id"]
// $_SESSION["usuario"]
// $_SESSION["rol"]

// Puedes realizar acciones basadas en el rol del usuario si es necesario:
// if ($_SESSION["rol"] == "admin") {
//     // Permitir acceso a funcionalidades de administrador
// } elseif ($_SESSION["rol"] == "asesor") {
//     // Permitir acceso a funcionalidades de asesor
// } else {
//     // Permitir acceso a funcionalidades de usuario সাধারণ
// }
?>