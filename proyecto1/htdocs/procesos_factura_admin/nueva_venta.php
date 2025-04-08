<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Factura</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
       
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

      
 
    
     <style>
           @media print {
            .no-print {
                display: none;
            }
        }
        /* CSS para cambiar el color de fondo */
        p {
    text-align: center;
    font-size: 22px; /* Tamaño de letra */
    font-family: "Times New Roman", Times, serif; /* Fuente */
}
    </style>
  
</head>

<body>
<div class="container">
    <div class="row">
        <div class="container-fluid alert alert-info sombra">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div class="alert alert-info no-print">
                    <h1>Factura</h1>
                    <a href="../vistas/factura_borrador.php" class="btn btn-dark">Regresar</a>
                </div>
                <div class="logo-container">
                    <img src="../img/logo.png" alt="Logo de la empresa" class="logo" style="width: 200px; height: auto;">
                </div>
            </div>
        </div>
    </div>
</div>
    <hr>
      <div class="container no-print">
<div class="row">
    <div class="col">
      
        <a href="#" class="btn btn-primary" onclick="location.reload();">Actualizar página</a> 
        
      
    </div>
  </div>
</div>
<p>www.ELECTROAI.com</p>
<p>ELECTROAI S.A.</p>
<p>Nit. 890900943-1</p>
<p>Factura Electrónica de Venta: H0591054945</p>
<p>Local: Sede Itagüí</p>

<div class= "container">
  <iframe src="factura_encabezado.php" width="100%" height="180px" frameborder="0"></iframe>
</div>

<section>
<div class="container">
  <div class="row">
    <div class="col-md-12">

   
    <?php
include '../conexion/conexion.php';

// Realizar la consulta para obtener todas las filas que contienen el número más alto en la columna factura_venta
$sql_2 = "SELECT * FROM ventas WHERE factura_venta = (SELECT MAX(factura_venta) FROM ventas)";
$resultado_2 = mysqli_query($conexion, $sql_2);

if ($resultado_2) {
    if (mysqli_num_rows($resultado_2) > 0) {
        $total_venta = 0;
?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">REFERENCIA PRODUCTO</th>
                        <th scope="col">DESCRIPCION PRODUCTO</th>
                        <th scope="col">VALOR PRODUCTO</th>
                        <th scope="col">UNIDADES VENDIDAS</th>
                        <th scope="col">SUBTOTAL VENTA</th>
                        <th scope="col">ESTADO</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($filas = mysqli_fetch_assoc($resultado_2)) {
                        $subtotal = $filas['valor_total_venta'];
                        $total_venta += $subtotal;
                    ?>
                        <tr>
                            <td><?php echo $filas['ref_prod_venta'] ?></td>
                            <td><?php echo $filas['producto_venta'] ?></td>
                            <td><?php echo $filas['valor_producto'] ?></td>
                            <td><?php echo $filas['unidades_venta'] ?></td>
                            <td><?php echo $filas['valor_total_venta'] ?></td>
                            <td><?php echo $filas['estado'] ?></td>
                            <td>
    <?php echo "<div class='container mt-6 no-print'>
        <div class='row'>
            <div class='col-auto'>
                <a href='../procesos_factura_admin/eliminar_venta.php?id_venta=" . $filas['id_venta'] . "' class='btn btn-danger' onclick='return confirmar()'>ELIMINAR</a>
            </div>
        </div>
    </div>"; ?>
</td>
 
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Mostrar el total de venta y el 19% del total -->
        <div id="total_venta">
            <p>Total SIN IVA (19%): <?php echo $total_venta - ($total_venta * 0.19); ?></p>
            <p>Total IVA: <?php echo $total_venta * 0.19; ?></p>
            <p>Total con IVA: <?php echo $total_venta; ?></p>
            
        </div>
       
<?php

    } else {
        echo "No se encontraron filas con el número de factura más alto en la tabla ventas.";
    }
} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
}
mysqli_close($conexion);

?>
<?php echo "
<div class='container mt-3 no-print' >
 <form action='nueva_factura.php' method='post'>
 <input type='hidden' name='total_venta' value='" . $total_venta . "'>
 <button class='btn btn-success ' type='submit' name='consultar_ultima_factura'>Cerrar Factura de Venta</button>
 </form>
</div>"; ?>


    </form>
</div>
<script>
    // Función para confirmar la eliminación
    function confirmar() {
        return confirm('¿Está seguro de eliminar el item seleccionado?');
    }

    // Esta función se ejecutará al cargar la página
    window.onload = function() {
        // Recalcular total de venta, IVA y total con IVA
        var totalVenta = <?php echo $total_venta; ?>;
        document.getElementById('total_venta').innerHTML = `
            
            <p>Total IVA (19%): ${totalVenta * 0.19}</p>
            <p>Total sin IVA: ${totalVenta - (totalVenta * 0.19)}</p>
            <p>Total con IVA: ${totalVenta}</p>
        `;
    }
   
</script>

<script>
   // Función para manejar el cierre de factura
document.addEventListener('DOMContentLoaded', function() {
  // Obtener el formulario
  const formulario = document.querySelector('form[action="nueva_factura.php"]');
  
  // Agregar listener al formulario
  if (formulario) {
    formulario.addEventListener('submit', function(event) {
      // Prevenir el envío del formulario por defecto
      event.preventDefault();
      
      // Preguntar confirmación al usuario
      const confirmacion = confirm("¿Está seguro que desea cerrar la factura de venta?");
      
      // Si el usuario confirma, continuar con el proceso
      if (confirmacion) {
        // Almacenar los datos del formulario para enviarlos después
        const formData = new FormData(formulario);
        const totalVenta = formData.get('total_venta');
        
        // Iniciar la impresión
        window.print();
        
        // Usar un timeout para asegurar que los datos se envíen después de que la impresión haya iniciado
        setTimeout(function() {
          // Crear una solicitud AJAX para enviar los datos sin recargar la página
          const xhr = new XMLHttpRequest();
          xhr.open('POST', 'nueva_factura.php', true);
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          
          xhr.onload = function() {
            if (xhr.status === 200) {
              // Redirigir o mostrar mensaje de éxito
              alert('Factura cerrada correctamente');
              window.location.href = '../vistas/factura_borrador.php'; // Redirigir
            } else {
              alert('Error al cerrar la factura');
            }
          };
          
          // Enviar los datos
          xhr.send('total_venta=' + encodeURIComponent(totalVenta) + '&consultar_ultima_factura=1');
        }, 1500); // Esperar 1.5 segundos para dar tiempo a la impresión
      }
    });
  }
});

</script>