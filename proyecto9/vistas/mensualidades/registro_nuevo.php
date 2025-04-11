<?php
// Incluir el archivo de conexión a la base de datos
include ("../../conexion/conexion.php");
include ("../../conexion/sesion.php");

// Variables para almacenar los mensajes de éxito o error
$mensaje = '';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entidad = $conexion->real_escape_string($_POST['entidad']);
    $dia_obligacion = $conexion->real_escape_string($_POST['dia_obligacion']);
    $fecha_del_pago = $conexion->real_escape_string($_POST['fecha_del_pago']);
    $valor_fijo = $conexion->real_escape_string($_POST['valor_fijo']);
    $valor_pagado = $conexion->real_escape_string($_POST['valor_pagado']);
    $ref_contrato = $conexion->real_escape_string($_POST['ref_contrato']);
    $link_pago = $conexion->real_escape_string($_POST['link_pago']);
    $nota = $conexion->real_escape_string($_POST['nota']);

    $sql = "INSERT INTO mensualidades (entidad, dia_obligacion, fecha_del_pago, valor_fijo, valor_pagado, ref_contrato, link_pago, nota) VALUES ('$entidad', '$dia_obligacion', '$fecha_del_pago', '$valor_fijo', '$valor_pagado', '$ref_contrato', '$link_pago', '$nota')";

    if ($conexion->query($sql) === TRUE) {
        echo '<script>alert("Datos guardados correctamente"); location.assign("mensualidades.php");</script>';
    } else {
        echo "<script>alert('ERROR: Los datos no fueron ingresados a la base de datos'); location.assign('mensualidades.php');</script>";
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
    <title>Agregar Servicio</title>
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
        <a class="btn btn-dark" href="mensualidades.php">Regresar</a>
    </div>
    <hr>
    <div class="container mt-5">
        <h2 style="color: #198754;">Agregar Registro</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert <?php echo strpos($mensaje, 'correctamente') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="entidad" class="form-label">Entidad:</label>
                <input type="text" class="form-control" id="entidad" name="entidad" required>
            </div>
            <div class="mb-3">
                <label for="dia_obligacion" class="form-label">Día Obligación:</label>
                <input type="number" class="form-control" id="dia_obligacion" name="dia_obligacion" required>
            </div>
            <div class="mb-3">
                <label for="fecha_del_pago" class="form-label">Fecha del Pago:</label>
                <input type="datetime-local" class="form-control" id="fecha_del_pago" name="fecha_del_pago" required>
            </div>
            <div class="mb-3">
                <label for="valor_fijo" class="form-label">Valor Fijo:</label>
                <input type="text" class="form-control" id="valor_fijo" name="valor_fijo" required>
            </div>
            <div class="mb-3">
                <label for="valor_pagado" class="form-label">Valor Pagado:</label>
                <input type="text" class="form-control" id="valor_pagado" name="valor_pagado" required>
            </div>
            <div class="mb-3">
                <label for="ref_contrato" class="form-label">Ref Contrato:</label>
                <input type="text" class="form-control" id="ref_contrato" name="ref_contrato" required>
            </div>
            <div class="mb-3">
                <label for="link_pago" class="form-label">Link Pago:</label>
                <input type="text" class="form-control" id="link_pago" name="link_pago" required>
            </div>
            <div class="mb-3">
                <label for="nota" class="form-label">Nota:</label>
                <textarea class="form-control" id="nota" name="nota" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>