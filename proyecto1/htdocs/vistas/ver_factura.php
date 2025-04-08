<?php
//seguridad de sesion
include '../conexion/conexion.php';
include '../conexion/sesion.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion de Facturas</title>
        <style>
        /* CSS para cambiar el color de fondo */
        body {
            background-color: #f5f5dc; /* Cambia #f0f0f0 por el color deseado */
        }
    </style>
    <!-- Bibliotecas necesarias para Bootstrap -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../scripts/horaYfecha.js" defer></script>
</head>
<body>
   
    <div class="container-fluid alert alert-info sombra">

        <div class="row">
            <div class="col-8">
               <h1>Detalles de Factura</h1><a class="btn btn-dark"href="facturas.php">Regresar</a><span></span><span class="badge text-bg-info"><?php echo" Usuario:  "  . $_SESSION['usuario']; ?></span>

            </div>
            <div class="col-2">
              <h5> <span class="badge text-bg-info" id="fechaHora"></span> </h5>
            </div>
            <div class="col-2">
                <div class="logo-container">
                    <img src="../img/logo.png" alt="Logo de la empresa" class="logo"
                        style="width: 200px; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <?php
// Obtener el valor del número de factura desde el método GET
$no_factura = $_GET['no_factura'] ?? '';

// Verificar si se ha enviado un número de factura
if (!empty($no_factura)) {
    // Si se ha enviado un número de factura, establecerlo como el valor por defecto
    $valor_factura = htmlspecialchars($no_factura);
} else {
    // Si no se ha enviado un número de factura, dejar el campo vacío
    $valor_factura = '';
}

    // Preparar la consulta SQL
    $consulta = "SELECT estado FROM facturas WHERE no_factura = $valor_factura";
    $resultado_2 = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado_2) > 0) {
        // Obtener la primera fila de resultados
        $fila = mysqli_fetch_assoc($resultado_2);
        $estado = $fila['estado'];
    }
?>



<!-- Sección principal de información de factura -->
<div class="container-fluid">
    <!-- Cabecera con información básica de la factura -->
    <div class="container-fluid alert alert-info">
        <h4>Número de factura: <?php echo $valor_factura; // Muestra el número de factura ?> </h4>
        <h3>Estado de la Factura: <?php echo $estado; // Muestra el estado actual de la factura ?> </h3>
        
      
        
<div class="accordion d-print-none" id="accordion">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Anular
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordion">
      <div class="accordion-body">

        <strong>  <?php
        // Verifica si la factura está cerrada para mostrar el formulario de anulación
       if ($fila["estado"] == "Cerrada" || $fila["estado"] == "Abierta") {
            // Formulario para anular la factura que solo se muestra si la factura está cerrada
            echo '<form action="../procesos_factura_admin/validar_factura_anular.php" method="post">
                <!-- Campo oculto para enviar el número de factura -->
                <input type="hidden" size="5" id="factura" name="factura" value="' . htmlspecialchars($valor_factura) . '" readonly required>
                <div class="form-group">
                
               <!-- Campo con la fecha y hora de anulación -->
                <div class="form-group">
                    <label for="fecha_hora_anulacion">Fecha y Hora de Anulación:</label>
                    <input type="datetime-local" class="form-control" id="fecha_anulacion" name="fecha_anulacion" readonly required>
                </div>
            
                </div>
                <!-- Campo para especificar el motivo de la anulación -->
                <div class="form-group">
                    <label for="descripcion_devo">Motivo por el cual se anula:</label>
                    <textarea class="form-control" id="descripcion_anulacion" name="descripcion_anulacion" rows="3" required></textarea>
                </div>
                <!-- Botón para enviar el formulario y anular la factura -->
                <button class="btn btn-danger" type="submit" name="submit" value="Anular">ANULAR</button>
            </form>
            </div>';
            
        }
        ?>
      </div>
    </div>
  </div>
    

  
</section>

<!-- Sección que muestra la información detallada de la factura seleccionada -->
<section id="porfactura">
    <div class="container-fluid">
        <?php
        // Verifica si se ha enviado el formulario con el número de factura
        if(!isset($_POST['no_factura'])) {
            // Obtiene el número de factura desde la URL
            $no_factura = $_GET['no_factura'];
            
            // Consulta para obtener los datos de la factura específica
            $sql_1 = "SELECT * FROM facturas WHERE no_factura = '$no_factura'";
            $resultado_1 = $conexion->query($sql_1);
            $num_filas_2 = $resultado_1->num_rows;

            // Verifica si se encontraron resultados
            if ($resultado_1->num_rows > 0) {
                // Muestra un encabezado con el número de factura
                echo "<h4>Factura actual: No $no_factura </h4>";
                
                // Crea la tabla para mostrar los detalles de la factura
 echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; 
                echo "<tr>";
                echo "<th>ID Factura</th>";
                echo "<th>No factura</th>";
                echo "<th>Estado </th>";
                echo "<th>Fecha Factura</th>";
                echo "<th>Documento Cliente</th>";
                echo "<th>Nombre Cliente</th>";
                echo "<th>Asesor</th>";
                echo "<th>Forma de Pago</th>";
                echo "<th>Total de Venta con IVA</th>";
                echo "</tr>";
                
                // Recorre cada fila de resultados y la muestra en la tabla
                while ($fila_2 = $resultado_1->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila_2["id_factura"] . "</td>";
                    echo "<td>" . $fila_2["no_factura"] . "</td>";
                    echo "<td>" . $fila_2["estado"] . "</td>";
                    echo "<td>" . $fila_2["fecha_factura"] . "</td>";
                    echo "<td>" . $fila_2["doc_cliente"] . "</td>";
                    echo "<td>" . $fila_2["nom_cliente"] . "</td>";
                    echo "<td>" . $fila_2["asesor"] . "</td>";
                    echo "<td>" . $fila_2["forma_de_pago"] . "</td>";
                    echo "<td>" . $fila_2["total_venta_con_iva"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                // Mensaje cuando no se encuentran resultados
                echo "No se encontraron resultados para la factura de venta especificada.";
            }
        }
        ?>
    </div>
</section>

<!-- Sección que muestra las ventas individuales asociadas a la factura -->
<section>
    <div class="container-fluid">
        <?php
        // Verifica si se ha enviado el formulario con el número de factura
        if(!isset($_POST['no_factura'])) {
            // Obtiene el número de factura desde la URL
            $no_factura = $_GET['no_factura'];

            // Consulta para obtener todas las ventas asociadas a la factura
            $sql = "SELECT * FROM ventas WHERE factura_venta = '$no_factura'";
            $resultado = mysqli_query($conexion, $sql);
            $num_filas = mysqli_num_rows($resultado);
            
            // Variable para acumular el total de ventas
            $total_ventas = 0;

            // Verifica si se encontraron resultados
            if ($num_filas > 0) {
                // Muestra un encabezado con el número de ventas y el número de factura
                echo "<h4>$num_filas Ventas para la Factura <span>$no_factura</span></h4>";
                
                // Crea la tabla para mostrar los detalles de las ventas
 echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; 
                echo "<tr>";
                echo "<th>ID Venta</th>";
                echo "<th>Factura Venta</th>";
                echo "<th>Fecha/Hora Venta</th>";
                echo "<th>Valor Total Venta</th>";
                echo "<th>Asesor Venta</th>";
                echo "<th>Unidades Venta</th>";
                echo "<th>Referencia Producto</th>";
                echo "<th>Producto Venta</th>";
                echo "<th>Valor Producto</th>";
                echo "<th>Estado</th>";
                echo "</tr>";
                
                // Recorre cada fila de resultados y la muestra en la tabla
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>" . $fila["id_venta"] . "</td>";
                    echo "<td>" . $fila["factura_venta"] . "</td>";
                    echo "<td>" . $fila["fecha_hora_venta"] . "</td>";
                    echo "<td>" . $fila["valor_total_venta"] . "</td>";
                    echo "<td>" . $fila["asesor_venta"] . "</td>";
                    echo "<td>" . $fila["unidades_venta"] . "</td>";
                    echo "<td>" . $fila["ref_prod_venta"] . "</td>";
                    echo "<td>" . $fila["producto_venta"] . "</td>";
                    echo "<td>" . $fila["valor_producto"] . "</td>";
                    echo "<td>" . $fila["estado"] . "</td>";
                    echo "</tr>";
                    
                    // Acumular el valor total de la venta
                    $total_ventas += floatval($fila["valor_total_venta"]);
                }
                
                // Agregar fila para mostrar el total
                echo "<tr>";
                echo "<td>TOTAL:</td>";
                echo "<td>" . number_format($total_ventas, 2) . "</td>";
                echo "<td></td>";
                echo "</tr>";
                
                echo "</table>";
            } else {
                // Mensaje cuando no se encuentran resultados
                echo "!No se encontraron ventas, para la factura actual¡.";
            }
            // Cierra la conexión a la base de datos
            mysqli_close($conexion);
        }
        ?>
    </div>
      </div>
</section>
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
        document.getElementById('fecha_anulacion').value = formatearFechaHora();
    });
</script>