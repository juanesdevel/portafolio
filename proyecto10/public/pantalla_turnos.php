<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Turnos</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 30px;
            padding: 30px;
            background-color: #f4f4f4;
        }

        .recientes-container {
            border: 1px solid #ccc;
            padding: 15px;
            width: 300px;
            border-radius: 8px;
            background-color: #fff;
        }

        .recientes-container h2 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333;
            font-size: 2.1em;
        }

        .reciente-turno {
            padding: 10px;
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            font-size: 1.6em;
            color: #555;
        }

        .reciente-turno:last-child {
            border-bottom: none;
        }

        .turno-actual-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
            /* Estilo inicial del borde */
            border: 5px solid transparent;
            transition: border-color 0.5s ease-in-out;
        }

        .turno-actual-container.resaltar {
            /* Clase para el efecto de marco */
            border-color: #ffc107; /* Color del marco (amarillo, puedes cambiarlo) */
        }

        .turno-actual-container h1 {
            font-size: 3.5em;
            color: #333;
            margin-bottom: 20px;
        }

        .turno-actual-container p {
            margin-bottom: 10px;
            font-size: 1em;
            color: #555;
        }

        .turno-actual-container .servicio {
            font-weight: bold;
            font-size: 1.2em;
            color: #007bff;
        }

        .turno-actual-container .numero-turno {
            font-size: 4em;
            font-weight: bold;
            color: #28a745;
            margin-top: 15px;
        }

        .ultimo-notificado-container {
            border: 1px solid #ccc;
            padding: 15px;
            width: 300px;
            border-radius: 8px;
            background-color: #fff;
        }

        .ultimo-notificado-container h2 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333;
            font-size: 1.2em;
        }

        .ultimo-turno {
            padding: 10px;
            font-size: 2.5em;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="recientes-container">
        <h2>Turnos recientes</h2>
        <?php

        include ("../conexion/conexion.php");

        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }

        $servicios = ['Consulta General', 'Odontología', 'Laboratorio', 'Imagenología'];
        foreach ($servicios as $servicio) {
            $sql_reciente = "SELECT modulo, turno, servicio, atencion FROM turnos WHERE servicio = '$servicio' AND estado = 'Notificado' ORDER BY fecha DESC LIMIT 1";
            $result_reciente = $conn->query($sql_reciente);

            if ($result_reciente && $result_reciente->num_rows > 0) {
                $fila_reciente = $result_reciente->fetch_assoc();
                $esPrioritario = ($fila_reciente['atencion'] === 'Preferencial');
                $prefijo = '';
                switch ($fila_reciente['servicio']) {
                    case 'Consulta General':
                        $prefijo = $esPrioritario ? 'PG - ' : 'CG - ';
                        break;
                    case 'Odontología':
                        $prefijo = $esPrioritario ? 'PO - ' : 'OD - ';
                        break;
                    case 'Laboratorio':
                        $prefijo = $esPrioritario ? 'PL - ' : 'LB - ';
                        break;
                    case 'Imagenología':
                        $prefijo = $esPrioritario ? 'PI - ' : 'IM - ';
                        break;
                }
                echo "<div class='reciente-turno'>";
                echo "<strong>" . htmlspecialchars($servicio) . ":</strong><br>";
                echo "Turno: " . htmlspecialchars($prefijo . sprintf("%02d", $fila_reciente['turno'])) . "<br>";
                echo "Modulo " . htmlspecialchars($fila_reciente['modulo']) . "<br>";
                echo "</div>";
            } else {
                echo "<div class='reciente-turno'><strong>" . htmlspecialchars($servicio) . ":</strong> No hay turnos notificados recientes.</div>";
            }
        }
        ?>
    </div>

<div class="turno-actual-container">
        <h1>Turno</h1>
        <?php
        $sql_ultimo_notificado_fecha_actualizacion = "SELECT modulo, turno, servicio, atencion 
                                                    FROM turnos 
                                                    WHERE estado = 'Notificado' 
                                                    ORDER BY fecha_actualizacion DESC 
                                                    LIMIT 1";
        $result_ultimo_notificado_fecha_actualizacion = $conn->query($sql_ultimo_notificado_fecha_actualizacion);

        if ($result_ultimo_notificado_fecha_actualizacion && $result_ultimo_notificado_fecha_actualizacion->num_rows > 0) {
            $fila_ultimo_notificado_fecha_actualizacion = $result_ultimo_notificado_fecha_actualizacion->fetch_assoc();
            $esPrioritarioGeneral = ($fila_ultimo_notificado_fecha_actualizacion['atencion'] === 'Preferencial');
            $prefijoGeneral = '';
            switch ($fila_ultimo_notificado_fecha_actualizacion['servicio']) {
                case 'Consulta General':
                    $prefijoGeneral = $esPrioritarioGeneral ? 'PG - ' : 'CG - ';
                    break;
                case 'Odontología':
                    $prefijoGeneral = $esPrioritarioGeneral ? 'PO - ' : 'OD - ';
                    break;
                case 'Laboratorio':
                    $prefijoGeneral = $esPrioritarioGeneral ? 'PL - ' : 'LB - ';
                    break;
                case 'Imagenología':
                    $prefijoGeneral = $esPrioritarioGeneral ? 'PI - ' : 'IM - ';
                    break;
            }
            echo "<div class='ultimo-turno'>";
            echo htmlspecialchars($prefijoGeneral . sprintf("%02d", $fila_ultimo_notificado_fecha_actualizacion['turno'])) . "<br>";
            echo "Módulo " . htmlspecialchars($fila_ultimo_notificado_fecha_actualizacion['modulo']) . "<br>";
            echo "</div>";
        } else {
            echo "<div class='ultimo-turno'>No hay turnos notificados recientemente.</div>";
        }
        ?>
    </div>
<script>
// Script para recargar la página si se recibe la señal de actualización
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('actualizar') === 'true') {
                // Recargar la página después de un breve retraso para dar tiempo a la notificación en la otra página
                setTimeout(function() {
                    window.location.reload();
                }, 1000); // 1000 milisegundos = 1 segundo de retraso (ajusta si es necesario)

                // Eliminar el parámetro 'actualizar' de la URL para evitar recargas continuas en el historial
                const newUrl = window.location.pathname;
                window.history.replaceState({}, document.title, newUrl);
            }
        });

</script>

</body>
</html>