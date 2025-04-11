<?php
// Inclusión de archivos de conexión y sesión
include '../conexion/conexion.php';
include '../conexion/sesion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Facturas</title>
    
    <!-- Estilos personalizados -->
    <style>
        table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1em;
}

th, td {
  padding: 0.8em;
  border: 1px solid #ddd;
  text-align: left;
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
}

/* Estilos para dispositivos móviles (ancho máximo de 600px) */
@media (max-width: 600px) {
  table, thead, tbody, th, td, tr {
    display: block;
  }

  /* Ocultar los encabezados de la tabla visualmente */
  thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  tr {
    border: 1px solid #ccc;
    margin-bottom: 1em;
  }

  td {
    /* Ahora cada celda actuará como una fila */
    border: none;
    border-bottom: 1px solid #eee;
    position: relative;
    padding-left: 50%; /* Espacio para el "encabezado" */
    white-space: normal;
    text-align: left;
  }

  td:before {
    /* Añadir el texto del encabezado como "etiqueta" */
    position: absolute;
    top: 6px;
    left: 6px;
    width: 45%;
    padding-right: 10px;
    white-space: nowrap;
    font-weight: bold;
    content: attr(data-column); /* Usar el atributo data-column */
  }
}

        /* Estilo para el logotipo */
        .logo {
            width: 150px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

          body {
        background-color: #fbfcfc;

    }

    .sombra {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .logo {
        width: 150px;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    </style>

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
    <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-info sombra">
        <div class="row">
            <div class="col-8">
               <h1>Detalles de Factura</h1>
               <button class="btn btn-dark" onclick="window.history.back();">Regresar</button>
               <span class="badge text-bg-info"><?php echo" Usuario:  "  . $_SESSION['usuario']; ?></span>
            </div>
            <div class="col-2">
              <h5> <span class="badge text-bg-info" id="fechaHora"></span> </h5>
            </div>
            <div class="col-2">
                <div class="logo-container">
                    <img src="../img/logo.jpg" alt="Logo de la empresa" class="logo" style="width: 200px; height: auto;">
                </div>
            </div>
        </div>
    </div>
<hr>
    <?php
    // Obtener el número de factura desde el método GET
    $no_factura = $_GET['no_factura'] ?? '';

    // Verificar si se ha enviado un número de factura
    if (!empty($no_factura)) {
        $valor_factura = htmlspecialchars($no_factura);

        // Consulta para calcular el total de ventas
        $sql_total = "SELECT SUM(REPLACE(REPLACE(valor_total_venta, '$', ''), ',', '')) as total_ventas 
                      FROM ventas 
                      WHERE factura_venta = '$no_factura'";
        $resultado_total = mysqli_query($conexion, $sql_total);
        $total_ventas = 0;
        if ($resultado_total) {
            $fila_total = mysqli_fetch_assoc($resultado_total);
            $total_ventas = number_format(floatval($fila_total['total_ventas']), 2, '.', '');
        }
    } else {
        $valor_factura = '';
    }

    // Consulta para obtener el estado de la factura
    $consulta = "SELECT estado, no_factura FROM facturas WHERE no_factura = '$valor_factura'";
    $resultado_2 = mysqli_query($conexion, $consulta);

    $estado = '';
    if (mysqli_num_rows($resultado_2) > 0) {
        // Obtener la primera fila de resultados
        $fila = mysqli_fetch_assoc($resultado_2);
        $estado = $fila['estado'];
        $no_factura = $fila['no_factura'];
    }
    ?>

    <!-- Sección principal de información de factura -->
    <div class="container-fluid">
        <!-- Cabecera con información básica de la factura -->
        <div class="container-fluid alert alert-info">
            <!-- Formulario para cerrar factura -->
            <form action="../procesos_factura_admin/cerrar_factura.php" id="cerrarFacturaForm" method="post" onsubmit="return validarFormulario();">
                <div class="form-group">
                   <h4>Estado de la Factura: <?php echo $estado; ?> </h4>
                                    <!-- Botón para cerrar factura -->
                    <button class="btn btn-success" type="submit">Cerrar Factura</button>
                </div>
                <hr>

                    <!-- Selección de forma de pago -->
                    <label for="forma_pago"><h5>Forma de Pago</h5></label>
                    <select class="form-control" id="forma_pago" name="forma_pago" required>
                        <option value="">Seleccione una forma de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Tarjeta Crédito">Tarjeta Crédito</option>
                        <option value="Tarjeta Débito">Tarjeta Débito</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
   <br>

                    <!-- Campos de total de ventas y número de factura -->
                    <label for="total_ventas"><h5>Total de Ventas</h5></label>
                    <input type="number" 
                           class="form-control" 
                           id="total_ventas" 
                           name="total_ventas" 
                           value="<?php echo $total_ventas; ?>" 
                           readonly 
                    >
                    <input type="number" 
                           class="form-control" 
                           id="no_factura" 
                           name="no_factura" 
                           value="<?php echo $no_factura; ?>" 
                           readonly hidden
                    >
                
            </form>
       <br>
    
        <!-- Sección que muestra la información detallada de la factura seleccionada -->
        <section id="porfactura">
            <div class="container-fluid">
                <?php
                // Obtiene el número de factura desde la URL
                $no_factura = $_GET['no_factura'];
                
                // Consulta para obtener los datos de la factura específica
                $sql_1 = "SELECT * FROM facturas WHERE no_factura = '$no_factura'";
                $resultado_1 = $conexion->query($sql_1);

                // Verifica si se encontraron resultados
                if ($resultado_1->num_rows > 0) {
                    echo "<h5>Factura actual: No. $no_factura </h5>";
                    
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
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    // Mensaje cuando no se encuentran resultados
                    echo "No se encontraron resultados para la factura de venta especificada.";
                }
                ?>
            </div>
        </section>

        <!-- Sección que muestra las ventas individuales asociadas a la factura -->
        <section>
            <div class="container-fluid">
                <?php
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
                    echo "<h5>$num_filas Ventas cargadas a la Factura No. <span>$no_factura</span></h5>";
                    
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
                    echo "</tr>";
                    
                    // Recorre cada fila de resultados y la muestra en la tabla
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $fila["id_venta"] . "</td>";
                        echo "<td>" . $fila["factura_venta"] . "</td>";
                        echo "<td>" . $fila["fecha_hora_venta"] . "</td>";
                        
                        // Parsea y acumula el total de ventas correctamente
                        $valor_total_venta = floatval(str_replace(['$', ','], '', $fila["valor_total_venta"]));
                        echo "<td>" . number_format($valor_total_venta, 2) . "</td>";
                        
                        echo "<td>" . $fila["asesor_venta"] . "</td>";
                        echo "<td>" . $fila["unidades_venta"] . "</td>";
                        echo "<td>" . $fila["ref_prod_venta"] . "</td>";
                        echo "<td>" . $fila["producto_venta"] . "</td>";
                        echo "<td>" . $fila["valor_producto"] . "</td>";
                        echo "</tr>";
                        
                        // Acumula el total de ventas
                        $total_ventas += $valor_total_venta;
                    }
                    
                    // Agregar fila para mostrar el total
                    echo "<tr>";
                    echo "<td>TOTAL VENTAS:</td>";
                    echo "<td>" . number_format($total_ventas, 2) . "</td>";
                    echo "<td></td>";
                    echo "</tr>";
                    
                    echo "</table>";
                } else {
                    // Mensaje cuando no se encuentran resultados
                    echo "¡No se encontraron Ventas, para la factura actual!.";
                }
                // Cierra la conexión a la base de datos
                mysqli_close($conexion);
                ?>
            </div>
        </section>
        </div>
    </div>


<!-- Script para obtener el total de ventas y confirmación de cierre de factura -->
<script>
    document.getElementById('cerrarFacturaForm').addEventListener('submit', function(event) {
        // Validación del campo "Total de Ventas"
        var totalVentas = document.getElementById('total_ventas').value;

        if (parseFloat(totalVentas) === 0) {
            alert('El total de ventas debe ser diferente de 0.');
            event.preventDefault(); // Evita el envío del formulario si el valor es 0
            return;
        }

        // Confirmación de cierre de factura
        if (confirm("¿Está seguro de cerrar la factura actual?")) {
            // El usuario confirmó, entonces enviamos el formulario y llamamos a la función de impresión
            imprimirVenta(); // Llama a la función que inicia la impresión
        } else {
            event.preventDefault(); // El usuario canceló, evita que el formulario se envíe
        }
    });

    function imprimirVenta() {
        // Aquí debes agregar la lógica para iniciar la impresión de la venta
        // Puedes usar window.print() para imprimir la página actual, o enviar los datos a un script PHP para generar un PDF e imprimirlo.
        window.print(); // Ejemplo simple para imprimir la página actual

        // Si necesitas enviar los datos a un script PHP para generar un PDF, puedes hacerlo aquí:
        /*
        fetch('generar_pdf_venta.php', {
            method: 'POST',
            body: new FormData(document.getElementById('cerrarFacturaForm')) // Envía los datos del formulario
        })
        .then(response => response.blob())
        .then(blob => {
            // Crea un objeto URL para el blob del PDF
            const url = window.URL.createObjectURL(blob);
            // Abre el PDF en una nueva ventana para imprimir
            window.open(url, '_blank');
        });
        */
    }
     function actualizarFechaHora() {
            const fechaHora = new Date();
            const opcionesFecha = { year: 'numeric', month: 'long', day: 'numeric' };
            const fechaFormateada = fechaHora.toLocaleDateString('es-ES', opcionesFecha);
            const horaFormateada = fechaHora.toLocaleTimeString('es-ES');
            
            document.getElementById('fechaHora').innerHTML = `${fechaFormateada} - ${horaFormateada}`;
        }

        setInterval(actualizarFechaHora, 1000); // Actualizar cada segundo
        actualizarFechaHora(); // Llamar inmediatamente para mostrar la fecha y hora al cargar la página

</script>
</body>
</html>