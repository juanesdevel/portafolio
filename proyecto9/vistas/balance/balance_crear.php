<?php
// Incluir el archivo de conexión a la base de datos
include("../../conexion/conexion.php");
include("../../conexion/sesion.php");

// Variables para almacenar los mensajes de éxito o error
$mensaje = '';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $movimiento = $conexion->real_escape_string($_POST['movimiento']);
    $tipo_mov = $conexion->real_escape_string($_POST['tipo_mov']);
    $valor = $conexion->real_escape_string($_POST['valor']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);

    $sql = "INSERT INTO balance (movimiento, tipo_mov, valor, descripcion) VALUES ('$movimiento', '$tipo_mov', '$valor', '$descripcion')";

    if ($conexion->query($sql) === TRUE) {
        echo '<script>alert("Datos del balance guardados correctamente"); location.assign("balance.php");</script>';
    } else {
        echo "<script>alert('ERROR: Los datos del balance no fueron ingresados a la base de datos'); location.assign('balance.php');</script>";
    }
}

// Cerrar la conexión al final
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Balance</title>
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
        <h2 style="color: #198754;">Agregar Balance</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert <?php echo strpos($mensaje, 'correctamente') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="movimiento" class="form-label">Movimiento:</label>
                <input type="text" class="form-control" id="movimiento" name="movimiento" required>
            </div>
            <div class="mb-3">
                <label for="tipo_mov" class="form-label">Tipo Movimiento:</label>
                <input type="text" class="form-control" id="tipo_mov" name="tipo_mov" required>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor:</label>
                <input type="number" class="form-control" id="valor" name="valor" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>