<?php
include("../../conexion/conexion.php");
include("../../conexion/sesion.php");

// Inicializar variables
$fecha = $nombre = $descripcion = $direccion = '';

if (isset($_POST['submit'])) {
    // Procesar el formulario enviado
    $id = $_POST['id']; // Asegúrate de que el campo oculto se llame 'id'
    $fecha = $_POST['fecha'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $direccion = $_POST['direccion'];

    // Escapar valores para prevenir inyección SQL
    $fecha = mysqli_real_escape_string($conexion, $fecha);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);
    $direccion = mysqli_real_escape_string($conexion, $direccion);

    // Consulta SQL para actualizar el registro
    $sql = "UPDATE eventos SET fecha='$fecha', nombre='$nombre', descripcion='$descripcion', direccion='$direccion' WHERE id='$id'";

    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        echo "<script> alert ('Los datos del evento fueron actualizados en la base de datos correctamente'); location.assign ('eventos.php'); </script>";
    } else {
        echo "<script> alert ('ERROR: Los datos del evento no fueron actualizados en la base de datos: " . mysqli_error($conexion) . "'); location.assign ('eventos.php'); </script>";
    }
} else {
    // Obtener datos del registro a editar
    $id = $_GET['id'];

    // Escapar el ID para prevenir inyección SQL
    $id = mysqli_real_escape_string($conexion, $id);

    $sql = "SELECT * FROM eventos WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila) {
        $fecha = $fila["fecha"];
        $nombre = $fila["nombre"];
        $descripcion = $fila["descripcion"];
        $direccion = $fila["direccion"];
    } else {
        echo "<script> alert ('Registro no encontrado.'); location.assign ('eventos.php'); </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body { background-color: #121212; color: #e0e0e0; }
        .form-control { background-color: #333; color: #e0e0e0; border: 1px solid #555; }
        .form-control:focus { background-color: #444; color: #e0e0e0; border-color: #666; }
        label { color: #bdbdbd; }
        .alert-success, .alert-danger { background-color: #333; color: #e0e0e0; border-color: #424242; }
    </style>
</head>
<body>
    <hr>
    <div class="container mt-2">
        <a class="btn btn-dark" href="eventos.php">Regresar</a>
    </div>
    <hr>
    <div class="container mt-5">
        <h2 style="color: #419cc7;">Actualizar Evento</h2>

        <section>
            <div class="container">
                <form id="formulario" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $fecha; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" autocomplete="off" value="<?php echo $nombre; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción" autocomplete="off"><?php echo $descripcion; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" autocomplete="off" value="<?php echo $direccion; ?>" required>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary" name="submit">Actualizar</button>
                </form>
            </div>
        </section>
    </div>

    <script>
        // ... (Tu código JavaScript) ...
    </script>
</body>
</html>

<?php
mysqli_close($conexion); // Cerrar la conexión aquí
?>