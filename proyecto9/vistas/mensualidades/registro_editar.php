<?php
include ("../../conexion/conexion.php");
include ("../../conexion/sesion.php");

// Inicializar variables
$entidad = $dia_obligacion = $fecha_del_pago = $valor_fijo = $valor_pagado = $ref_contrato = $link_pago = $nota = '';

if (isset($_POST['submit'])) {
    // Procesar el formulario enviado
    $id = $_POST['id'];
    $entidad = $_POST['entidad'];
    $dia_obligacion = $_POST['dia_obligacion'];
    $fecha_del_pago = $_POST['fecha_del_pago'];
    $valor_fijo = $_POST['valor_fijo'];
    $valor_pagado = $_POST['valor_pagado'];
    $ref_contrato = $_POST['ref_contrato'];
    $link_pago = $_POST['link_pago'];
    $nota = $_POST['nota'];

    // Escapar valores para prevenir inyección SQL
    $entidad = mysqli_real_escape_string($conexion, $entidad);
    $dia_obligacion = mysqli_real_escape_string($conexion, $dia_obligacion);
    $fecha_del_pago = mysqli_real_escape_string($conexion, $fecha_del_pago);
    $valor_fijo = mysqli_real_escape_string($conexion, $valor_fijo);
    $valor_pagado = mysqli_real_escape_string($conexion, $valor_pagado);
    $ref_contrato = mysqli_real_escape_string($conexion, $ref_contrato);
    $link_pago = mysqli_real_escape_string($conexion, $link_pago);
    $nota = mysqli_real_escape_string($conexion, $nota);

    // Consulta SQL para actualizar el registro
    $sql = "UPDATE mensualidades SET entidad='$entidad', dia_obligacion='$dia_obligacion', fecha_del_pago='$fecha_del_pago', valor_fijo='$valor_fijo', valor_pagado='$valor_pagado', ref_contrato='$ref_contrato', link_pago='$link_pago', nota='$nota' WHERE id='$id'";

    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        echo "<script> alert ('Los datos fueron actualizados en la base de datos correctamente'); location.assign ('mensualidades.php'); </script>";
    } else {
        echo "<script> alert ('ERROR: Los datos no fueron actualizados en la base de datos: " . mysqli_error($conexion) . "'); location.assign ('mensualidades.php'); </script>";
    }
} else {
    // Obtener datos del registro a editar
    $id = $_GET['id'];

    // Escapar el ID para prevenir inyección SQL
    $id = mysqli_real_escape_string($conexion, $id);

    $sql = "SELECT * FROM mensualidades WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);

    if ($fila) {
        $entidad = $fila["entidad"];
        $dia_obligacion = $fila["dia_obligacion"];
        $fecha_del_pago = $fila["fecha_del_pago"];
        $valor_fijo = $fila["valor_fijo"];
        $valor_pagado = $fila["valor_pagado"];
        $ref_contrato = $fila["ref_contrato"];
        $link_pago = $fila["link_pago"];
        $nota = $fila["nota"];
    } else {
        echo "<script> alert ('Registro no encontrado.'); location.assign ('mensualidades.php'); </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mensualidad</title>
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
                        <label for="dia_obligacion">Día Obligación:</label>
                        <input type="number" class="form-control" id="dia_obligacion" name="dia_obligacion" placeholder="Día Obligación" autocomplete="off" value="<?php echo $dia_obligacion; ?>"  required>
                    </div>

                    <div class="form-group">
                        <label for="fecha_del_pago">Fecha del Pago:</label>
                        <input type="datetime-local" class="form-control" id="fecha_del_pago" name="fecha_del_pago" value="<?php echo str_replace(' ', 'T', $fecha_del_pago); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="valor_fijo">Valor Fijo:</label>
                        <input type="text" class="form-control" id="valor_fijo" name="valor_fijo" placeholder="Valor Fijo" autocomplete="off" value="<?php echo $valor_fijo; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="valor_pagado">Valor Pagado:</label>
                        <input type="text" class="form-control" id="valor_pagado" name="valor_pagado" placeholder="Valor Pagado" autocomplete="off" value="<?php echo $valor_pagado; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="ref_contrato">Ref Contrato:</label>
                        <input type="text" class="form-control" id="ref_contrato" name="ref_contrato" placeholder="Ref Contrato" autocomplete="off" value="<?php echo $ref_contrato; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="link_pago">Link Pago:</label>
                        <input type="text" class="form-control" id="link_pago" name="link_pago" placeholder="Link Pago" autocomplete="off" value="<?php echo $link_pago; ?>" required>
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