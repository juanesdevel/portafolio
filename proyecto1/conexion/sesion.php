<?php
// Iniciar la sesión
session_start();

// Tiempo de inactividad permitido (en segundos)
$tiempo_inactividad = 600; // 10 minutos

// Verificar si la variable de sesión 'LAST_ACTIVITY' está definida
if (isset($_SESSION['LAST_ACTIVITY'])) {
    // Calcular el tiempo de inactividad
    $tiempo_transcurrido = time() - $_SESSION['LAST_ACTIVITY'];
    
    // Si el tiempo transcurrido es mayor que el tiempo de inactividad permitido
    if ($tiempo_transcurrido > $tiempo_inactividad) {
        // Primero, guardar la información de que la sesión fue cerrada por inactividad
        // en una cookie que sobrevivirá al cierre de sesión
        setcookie("session_closed", "true", time() + 60, "/");
        
        // Destruir la sesión
        session_unset();
        session_destroy();
        
        // Redirige al usuario con JavaScript para garantizar que se muestre el alert
        echo '<script>
            alert("Su sesión se ha cerrado por inactividad.");
            window.location.href = "../index.php";
        </script>';
        exit();
    }
}

// Actualizar el tiempo de actividad
$_SESSION['LAST_ACTIVITY'] = time();

// Verificar si la variable de sesión 'usuario' está definida y es válida
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] == '') {
    // Guardar un mensaje de acceso no autorizado
    $_SESSION['mensaje'] = "No tiene acceso.";
    
    // Redirigir al usuario a la página de inicio
    header("Location: ../index.php");
    exit();
}
?>

<script>
    // Tiempo de inactividad en milisegundos (10 minutos)
    var tiempoInactividad = 600000;

    // Declarar el temporizador globalmente
    var temporizador;

    // Función para mostrar el alert y redirigir
    function cerrarSesion() {
        alert("Su sesión se ha cerrado por inactividad.");
        window.location.href = "../index.php";
    }

    // Establecer el temporizador inicial
    temporizador = setTimeout(cerrarSesion, tiempoInactividad);

    // Reiniciar el temporizador cada vez que hay actividad del usuario
    window.addEventListener('mousemove', function() {
        clearTimeout(temporizador);
        temporizador = setTimeout(cerrarSesion, tiempoInactividad);
    });

    window.addEventListener('keypress', function() {
        clearTimeout(temporizador);
        temporizador = setTimeout(cerrarSesion, tiempoInactividad);
    });
</script>
