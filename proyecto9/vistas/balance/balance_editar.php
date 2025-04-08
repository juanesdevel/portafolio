<?php
include("../../conexion/conexion.php");
include("../../conexion/sesion.php");

// Inicializar variables
$movimiento = $tipo_mov = $valor = $descripcion = '';

if (isset($_POST['submit'])) {
    // Procesar el formulario enviado
    $id = $_POST['id']; // Asegúrate de que el campo oculto se llame 'id'
    $movimiento = $_POST['movimiento'];
    $tipo_mov = $_POST['tipo_mov'];
    $valor = $_POST['valor'];
    $descripcion = $_POST['descripcion'];

    // Escapar valores para prevenir inyección SQL
    $movimiento = mysqli_real_escape_string($conexion, $movimiento);
    $tipo_mov = mysqli_real_escape_string($conexion, $tipo_mov);
    $valor = mysqli_real_escape_string($conexion, $valor);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);

    // Consulta SQL para actualizar el registro
    $sql = "UPDATE balance SET movimiento='$movimiento', tipo_mov='$tipo_mov', valor='$valor', descripcion='$descripcion' WHERE id='$id'";

    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        echo "<script> alert ('Los datos del balance fueron actualizados en la base de datos correctamente'); location.assign ('balance.php'); </script>";
    } else {
        echo "<script> alert ('ERROR: Los datos del balance no fueron actualizados en la base de datos: " . mysqli_error($conexion) . "'); location.assign ('balance.php'); </script>";
    }
} else {
    // Obtener datos del registro a editar
    $id = $_GET['id'];

    // Escapar el ID para prevenir inyección SQL
    $id = mysqli_real_escape_string($conexion, $id);

    $sql = "SELECT * FROM balance WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila) {
        $movimiento = $fila["movimiento"];
        $tipo_mov = $fila["tipo_mov"];
        $valor = $fila["valor"];
        $descripcion = $fila["descripcion"];
    } else {
        echo "<script> alert ('Registro no encontrado.'); location.assign ('balance.php'); </script>";
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
    <title>Editar Balance</title>
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
        <a class="btn btn-dark" href="balance.php">Regresar</a>
    </div>
    <hr>
    <div class="container mt-5">
        <h2 style="color: #419cc7;">Actualizar Balance</h2>

        <section>
            <div class="container">
                <form id="formulario" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="form-group">
                        <label for="movimiento">Movimiento:</label>
                        <input type="text" class="form-control" id="movimiento" name="movimiento" value="<?php echo $movimiento; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo_mov">Tipo Movimiento:</label>
                        <input type="text" class="form-control" id="tipo_mov" name="tipo_mov" placeholder="Tipo Movimiento" autocomplete="off" value="<?php echo $tipo_mov; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor:</label>
                        <input type="number" class="form-control" id="valor" name="valor" placeholder="Valor" autocomplete="off" value="<?php echo $valor; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción" autocomplete="off"><?php echo $descripcion; ?></textarea>
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