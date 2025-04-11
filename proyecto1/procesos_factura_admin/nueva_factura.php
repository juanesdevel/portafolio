<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';

if(isset($_POST['consultar_ultima_factura'])) { 
    include("conexion.php");            
    $total_venta = $_POST['total_venta'];// Verifica si se envió el formulario con el botón específico
    // Realizar la consulta para obtener todas las filas que contienen el número más alto en la columna factura_venta
    $sql_2 = "SELECT * FROM ventas WHERE factura_venta = (SELECT MAX(factura_venta) FROM ventas)";
    $resultado_2 = mysqli_query($conexion, $sql_2);

    if ($resultado_2) {
        if (mysqli_num_rows($resultado_2) > 0) {
            // Obtener la primera fila de resultados
            $fila = mysqli_fetch_assoc($resultado_2);

            // Asignar valores a variables
            $factura_venta = $fila['factura_venta'];
            $fecha_hora_venta = $fila['fecha_hora_venta'];
            $nom_cliente = $fila['nom_cliente'];
            $doc_cliente_venta = $fila['doc_cliente_venta'];
            $asesor_venta = $fila['asesor_venta'];
            $caja = $fila['caja'];
            $forma_de_pago = $fila['forma_de_pago'];
            $estado = $fila['estado'];
            
          

            $sql_insert = "INSERT INTO facturas (id_factura, no_factura,  fecha_factura, doc_cliente, nom_cliente, asesor, caja, forma_de_pago, total_venta_con_iva) VALUES ('', '$factura_venta', '$fecha_hora_venta', '$doc_cliente_venta ', '$nom_cliente', '$asesor_venta', '$caja', '$forma_de_pago', '$total_venta')";

            if ($conexion->query($sql_insert) == TRUE) {
                echo '<script>alert("Datos guardados correctamente");location.assign("../vistas/factura_borrador.php");</script>';
            } else {
                echo "<script> alert ('ERROR: Los datos no fueron ingresados a la base de datos'); location.assign ('nueva_venta.php'); </script>";
            }
               
            // Por ejemplo, puedes imprimir los valores
            echo "Factura de Venta: " . $factura_venta . "<br>";
            echo "Fecha y Hora de Venta: " . $fecha_hora_venta . "<br>";
            echo "Nombre del Cliente: " . $nom_cliente . "<br>";
            echo "Documento del Cliente: " . $doc_cliente_venta . "<br>";
            echo "Asesor de Venta: " . $asesor_venta . "<br>";
            echo "Caja: " . $caja . "<br>";
            echo "Forma de Pago: " . $forma_de_pago . "<br>";
            echo "Estado: " . $estado . "<br>";
            echo "Valor Total: " . $total_venta . "<br>";
           
           
          
        } else {
            echo "No se encontraron filas con el número de factura más alto en la tabla ventas.";
        }

     
           
        }

    } else {
        
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);

?>

