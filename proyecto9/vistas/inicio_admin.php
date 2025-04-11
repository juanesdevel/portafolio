<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';
// Verificación del rol de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    // Si no es administrador, redirigir al inicio o denegar acceso
    header("Location: inicio_operador.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../scripts/horaYfecha.js" defer></script>
    <style>
        body {
            background-color: #121212; /* Fondo oscuro */
            background-image: url('../img/fondo2.png'); /* Mantiene tu imagen de fondo */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

            color: #e0e0e0; /* Texto claro */
        }

        .sombra {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.5); /* Sombra más pronunciada */
        }

        .alert-info {
            background-color: #333; /* Fondo oscuro para alertas */
            color: #e0e0e0;
            border-color: #424242;
        }

        .btn-primary, .btn-success, .btn-info {
            background-color: #1e88e5; /* Azul primario para botones */
            border-color: #1976d2;
            color: #e0e0e0;
        }

        .btn-primary:hover, .btn-success:hover, .btn-info:hover {
            background-color: #1565c0; /* Azul más oscuro al pasar el ratón */
            border-color: #1565c0;
        }

        .badge-info {
            background-color: #424242; /* Fondo oscuro para badges */
            color: #e0e0e0;
        }

        hr {
            border-color: #424242; /* Color de la línea divisoria */
        }

        a {
            color: #90caf9; /* Color de los enlaces */
        }

        a:hover {
            color: #64b5f6; /* Color de los enlaces al pasar el ratón */
        }
    </style>
</head>

<body>
    <div class="container-fluid alert alert-black sombra">
        <div class="row">
            <div class="col-8">
                <h1>Panel de Servicios</h1>
                <a href="../conexion/cerrar_sesion.php" class="btn btn-danger btn-sm sombra" onclick="return confirmarCierreSesion()">Cerrar Sesión</a>
                <span class="badge text-bg-info"><?php echo "Usuario: " . $_SESSION['usuario']; ?></span>
            </div>
            <div class="col-2">
                <h5><span class="badge text-bg-info" id="fechaHora"></span></h5>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                
                <a href="#" class="btn btn-primary" onclick="location.reload();">Actualizar página</a><br><br>
                <a href="registros/registros.php" class="btn btn-outline-primary sombra">Keepass</a><br><br>
                <a href="mensualidades/mensualidades.php" class="btn btn-outline-primary sombra">Mensualidades</a><br><br>
                <a href="eventos/eventos.php" class="btn btn-outline-primary sombra">Eventos</a><br><br>
                <a href="usuarios/usuarios.php" class="btn btn-outline-warning sombra">Gestión de Usuarios</a><br><br>
                <a href="backup/backup.php" class="btn btn-outline-warning sombra">Backup</a><br><br>
            </div>
        </div>
    </div>
    <hr>

<div class="container-fluid alert alert-black sombra">

<?php

// Crear conexión
$conexion = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener el evento más próximo
$sql = "SELECT * FROM eventos WHERE fecha >= CURDATE() ORDER BY fecha ASC LIMIT 2";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Proximo evento:" . "<br>";
        echo "Fecha: " . '<span class="badge badge-info">' . htmlspecialchars($row["fecha"]) . '</span><br>';
        echo "Nombre: " . $row["nombre"] . "<br>";
        echo "Descripción: " . $row["descripcion"] . "<br>";
        echo "Dirección: " . $row["direccion"] . "<br>";
        echo "<hr>";
    }
} else {
    echo "No hay eventos próximos.";
}

// Cerrar conexión
$conexion->close();
?>
</div>
    <script>
        function confirmarCierreSesion() {
            return confirm("¿Está seguro de que desea cerrar la sesión?");
        }
    </script>
</body>

</html>