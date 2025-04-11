<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';

// Verificar si se ha enviado el formulario
if(isset($_POST['fecha_devo'])){
    // Recibir los datos del formulario
    $fecha_devo = $_POST['fecha_devo'];
    $id_venta = $_POST['id_venta'];
    $factura_devo = $_POST['factura_devo'];
    $ref_producto = $_POST['ref-pro'];
    $unidades_pro = $_POST['unds'];
    $valor_devo = $_POST['valor_devo'];
    $tipo_devo = $_POST['tipo_devo'];
    $descripcion_devo = $_POST['descripcion_devo'];
    $usuario_devo = $_POST['usuario_devo'];

    $sql1 = "SELECT unidades_producto FROM productos WHERE ref_producto = '$ref_producto'";
    $resultado1 = mysqli_query($conexion, $sql1);

    $fila = mysqli_fetch_assoc($resultado1);
    $unidades_producto = $fila['unidades_producto'];
    $nuevostock = $unidades_producto + $unidades_pro;
    
    if ($resultado1){        
       

     if ($nuevostock >= 0) {
        // Preparar la consulta de actualización
        $sql_update = "UPDATE productos SET unidades_producto = $nuevostock WHERE ref_producto = '$ref_producto'";
        
        // Ejecutar la consulta
        $resultado_update1 = mysqli_query($conexion, $sql_update);
    
        // Verificar si la actualización fue exitosa
        if ($resultado_update1) {
            echo "<script> alert('Stock actualizado correctamente.'); location.assign('ventas.php'); </script>";
        } else {
            echo "<script> alert('Error al actualizar el stock en la base de datos.'); location.assign('ventas.php'); </script>";
        }
        } else {
        echo "<script> alert('El stock resultante no puede ser negativo.'); location.assign('ventas.php'); </script>";
    }   
    }
   

    // Realizar la inserción en la base de datos
    $sql2 = "INSERT INTO devoluciones (fecha_devo, usuario_devo, id_venta, factura_devo, ref_producto, unidades_pro, valor_devo, tipo_devo, descripcion_devo) 
            VALUES ('$fecha_devo', '$usuario_devo', '$id_venta', '$factura_devo', '$ref_producto', '$unidades_pro', '$valor_devo', '$tipo_devo', '$descripcion_devo')";

    $resultado = mysqli_query($conexion, $sql2); // Ejecutar la consulta

    // Verificar si la consulta fue exitosa
    if($resultado){
        // Actualizar el campo estado en la tabla ventas
        $sql_update = "UPDATE ventas SET estado = 'Devolución' WHERE id_venta = '$id_venta'";
        $resultado_update = mysqli_query($conexion, $sql_update);

        if($resultado_update){
            echo "<script> alert ('La factura cambió de estado y la devolución se registró con éxito'); location.assign ('ventas.php'); </script>";
        } else {
            echo "<script> alert ('ERROR: La factura cambió de estado pero hubo un error al registrar la devolución'); location.assign ('ventas.php'); </script>";
        }
    } else {
        echo "<script> alert ('ERROR: Los datos no fueron actualizados en la base de datos'); location.assign ('ventas.php'); </script>";
    }
    // Cerrar conexión
    mysqli_close($conexion);
}

?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>devoluciones de venta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="alert alert-danger">
            <h3>Devolución de Venta</h3>
            <a class="btn btn-dark" href="ventas.php">Regresar</a>
        </div>

        <?php
        // Obtener datos del formulario si no se ha enviado
        if(!isset($_POST['fecha_devo'])){
            $id_venta = $_GET['id_venta'];
            $sql = "SELECT * FROM ventas WHERE id_venta = '$id_venta'";
            $resultado = mysqli_query($conexion, $sql);
            $fila = mysqli_fetch_assoc($resultado);

            $id_venta = $fila["id_venta"];
            $factura_venta = $fila["factura_venta"];
            $fecha_hora_venta = $fila["fecha_hora_venta"];
            $valor_total_venta = $fila["valor_total_venta"];
            $asesor_venta = $fila["asesor_venta"];
            $unidades_venta = $fila["unidades_venta"];
            $ref_prod_venta = $fila["ref_prod_venta"];
            $producto_venta = $fila["producto_venta"];
            $valor_producto = $fila["valor_producto"];
            $estado = $fila["estado"];

            mysqli_close($conexion);
        ?>
        <!-- Formulario -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="fecha_devo">Fecha Devolución:</label>
                <input type="datetime-local" class="form-control" id="fecha_devo" name="fecha_devo"readonly required>
            </div>
            <div class="form-group">
                <label for="usuario_devo">Usuario Devolución:</label>
                <input type="text" class="form-control" id="usuario_devo" name="usuario_devo" readonly
                    value="<?php echo $asesor_venta; ?>">
            </div>
            <div class="form-group">
                <label for="id_venta">ID Venta:</label>
                <input type="text" class="form-control" id="id_venta" name="id_venta" readonly
                    value="<?php echo $id_venta; ?>">
            </div>
            <div class="form-group">
                <label for="factura_devo">Factura Devolución:</label>
                <input type="text" class="form-control" id="factura_devo" name="factura_devo" readonly
                    value="<?php echo $factura_venta; ?>">
            </div>
            <div class="form-group">
                <label for="ref-pro">Referencia Producto:</label>
                <input type="text" class="form-control" id="ref-pro" name="ref-pro" readonly
                    value="<?php echo $ref_prod_venta; ?>">
            </div>
            <div class="form-group">
                <label for="unds">Unidades:</label>
                <input type="text" class="form-control" id="unds" name="unds" readonly
                    value="<?php echo $unidades_venta; ?>">
            </div>
            <div class="form-group">
                <label for="valor_devo">Valor Devolución:</label>
                <input type="text" class="form-control" id="valor_devo" name="valor_devo" readonly
                    value="<?php echo $valor_total_venta; ?>">
            </div>
            <div class="form-group">
                <label for="tipo_devo">Tipo Devolución:</label>
                <select class="form-control" id="tipo_devo" name="tipo_devo">
                    <option value="Garantía">Garantía</option>
                    <option value="Desestimiento">Desestimiento</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="descripcion_devo">Descripción Devolución:</label>
                <textarea class="form-control" id="descripcion_devo" name="descripcion_devo" rows="3"
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Realizar Devolución</button>
        </form>
        <?php } ?>
    </div>
</body>

</html>

<script>
    // Función para formatear la fecha y hora al formato requerido por datetime-local
    function formatearFechaHora() {
        var ahora = new Date();
        var año = ahora.getFullYear();
        var mes = (ahora.getMonth() + 1).toString().padStart(2, '0');
        var dia = ahora.getDate().toString().padStart(2, '0');
        var hora = ahora.getHours().toString().padStart(2, '0');
        var minutos = ahora.getMinutes().toString().padStart(2, '0');
        
        return año + '-' + mes + '-' + dia + 'T' + hora + ':' + minutos;
    }
    
    // Establecer la fecha y hora actuales al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('fecha_devo').value = formatearFechaHora();
    });
</script>
