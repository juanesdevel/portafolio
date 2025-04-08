<?php
 include ("../../conexion/conexion.php");
    include ("../../conexion/sesion.php");

// Inicializar variables
$entidad = $propietario = $usuario = $contrasena = $nota = '';

if (isset($_POST['submit'])) {
    // Procesar el formulario enviado
    $id = $_POST['id']; // Asegúrate de que el campo oculto se llame 'id'
    $entidad = $_POST['entidad'];
    $propietario = $_POST['propietario'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nota = $_POST['nota'];

    // Escapar valores para prevenir inyección SQL
    $entidad = mysqli_real_escape_string($conexion, $entidad);
    $propietario = mysqli_real_escape_string($conexion, $propietario);
    $usuario = mysqli_real_escape_string($conexion, $usuario);
    $contrasena = mysqli_real_escape_string($conexion, $contrasena);
    $nota = mysqli_real_escape_string($conexion, $nota);

    // Consulta SQL para actualizar el registro
    $sql = "UPDATE servicios SET entidad='$entidad', propietario='$propietario', usuario='$usuario', contrasena='$contrasena', nota='$nota' WHERE id='$id'";

    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        echo "<script> alert ('Los datos fueron actualizados en la base de datos correctamente'); location.assign ('registros.php'); </script>";
    } else {
        echo "<script> alert ('ERROR: Los datos no fueron actualizados en la base de datos: " . mysqli_error($conexion) . "'); location.assign ('registros.php'); </script>";
    }
} else {
    // Obtener datos del registro a editar
    $id = $_GET['id'];

    // Escapar el ID para prevenir inyección SQL
    $id = mysqli_real_escape_string($conexion, $id);

    $sql = "SELECT * FROM servicios WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila) {
        $entidad = $fila["entidad"];
        $propietario = $fila["propietario"];
        $usuario = $fila["usuario"];
        $contrasena = $fila["contrasena"];
        $nota = $fila["nota"];
    } else {
        echo "<script> alert ('Registro no encontrado.'); location.assign ('registros.php'); </script>";
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
    <title>Editar Servicio</title>
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
        <a class="btn btn-dark" href="registros.php">Regresar</a></div>
<hr>
    <div class="container mt-5">
        <h2 style="color: #419cc7;">Actualizar Registro</h2>
    
        <section>
            <div class="container">
                <form id="formulario" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="form-group">
                        <label for="entidad">Entidad:</label>
                        <input type="text" class="form-control" id="entidad" name="entidad" placeholder="Entidad" autocomplete="off" value="<?php echo $entidad; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="propietario">Propietario:</label>
                        <input type="text" class="form-control" id="propietario" name="propietario" placeholder="Propietario" autocomplete="off" value="<?php echo $propietario; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" autocomplete="off" value="<?php echo $usuario; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contrasena">Contraseña:</label>
                        <input type="text" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" autocomplete="off" value="<?php echo $contrasena; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nota">Nota:</label>
                        <textarea class="form-control" id="nota" name="nota" placeholder="Nota" autocomplete="off"><?php echo $nota; ?></textarea>
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