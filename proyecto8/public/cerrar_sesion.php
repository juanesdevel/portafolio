<?php
session_start(); // Inicia la sesión
session_destroy(); // Destruye la sesión
header("Location: index.php"); // Redirige a la página de inicio de sesión
exit();
?>