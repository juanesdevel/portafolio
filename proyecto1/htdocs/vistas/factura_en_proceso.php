<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Incluir archivos de conexión y sesión
include '../conexion/conexion.php';
include '../conexion/sesion.php';


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Factura</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- jQuery (importante: usar solo UNA versión) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../scripts/horaYfecha.js" defer></script>


</head>
<body>

    <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-info sombra">
        <div class="row">
            <div class="col-8">
               <h1>Proceso de Factura - Agregar ventas</h1>
               <button class="btn btn-dark" onclick="window.history.back();">Regresar</button>
               <span class="badge text-bg-info"><?php echo" Usuario:  "  . $_SESSION['usuario']; ?></span>
            </div>
            <div class="col-2">
              <h5> <span class="badge text-bg-info" id="fechaHora"></span> </h5>
            </div>
            <div class="col-2">
                <div class="logo-container">
                    <img src="../img/logo.png" alt="Logo de la empresa" class="logo" style="width: 200px; height: auto;">
                </div>
            </div>
        </div>
    </div>
<hr>
<?php
// Obtener el valor del número de factura desde el método GET
$no_factura = $_GET['no_factura'] ?? '';

// Verificar si se ha enviado un número de factura
if (!empty($no_factura)) {
    // Si se ha enviado un número de factura, establecerlo como el valor por defecto
    $factura_venta = htmlspecialchars($no_factura);
    ?>

    <div id="factura" class="container-fluid">
                <div class="alert alert-success" role="alert">
                    La Factura <?php echo $no_factura; ?> está en proceso!
                </div>
     </div>
<hr>

<div class="container-fluid">
    <div class="alert alert-info sombra">
            <form action='resumen_factura.php' method='GET'>
                        <input type='hidden' name='no_factura' value="<?php echo $factura_venta; ?>">
                        <button class="btn btn-primary" type='submit'>Ver factura</button>
                    </form>

<hr>
            

    <?php
} else {
    // Si no se ha enviado un número de factura, dejar el campo vacío
    $no_factura = '';
}
?>


        <?php
        // Procesar el formulario de venta
        if (isset($_POST['submit'])) {
            $factura_venta = $_POST['factura_venta'];
            $valor_total_venta = $_POST['valor_total_venta'];
            $asesor_venta = $_POST['asesor_venta'];
            $unidades_venta = $_POST['unidades_venta'];
            $producto_venta = $_POST['producto_venta'];
            $valor_producto = $_POST['valor_producto'];
            $ref_prod_venta_2 = $_POST['ref_prod_venta_2'];
            $cat_producto = $_POST['cat_producto'];
            $diferencia_producto = $_POST['diferencia_producto'];

            // Insertar datos en la tabla ventas
            $sql = "INSERT INTO ventas (factura_venta, valor_total_venta, asesor_venta, unidades_venta, producto_venta, valor_producto, ref_prod_venta) 
                    VALUES ('$factura_venta', '$valor_total_venta', '$asesor_venta', '$unidades_venta', '$producto_venta', '$valor_producto','$ref_prod_venta_2')";
            if ($conexion->query($sql) === TRUE) {
                echo '<script>
        alert("Producto agregado a la factura");
        location.assign("../vistas/factura_en_proceso.php?no_factura=' . $factura_venta . '");
    </script>';
                

                // Actualizar el stock del producto
                $sql_1 = "UPDATE productos SET ref_producto='$ref_prod_venta_2', cat_producto='$cat_producto', descripcion_producto='$producto_venta', valor_producto='$valor_producto', unidades_producto='$diferencia_producto' WHERE ref_producto='$ref_prod_venta_2'";
                $resultado = mysqli_query($conexion, $sql_1);
                if ($resultado) {
                    echo "<script> alert ('Stock actualizado'); </script>";
                } else {
                    echo "<script> alert ('ERROR: Los datos no fueron actualizados '); </script>";
                }
            }
            $conexion->close();
        } else {
            ?>
            <div class="form-container">
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" onsubmit="return validarFormulario()">
                    <div class="row">
                        <div class="col-md-6">
                                            <div class="btn-actions">
                        <button type="submit" name="submit" class="btn btn-success btn-sm" onclick="return validarCampos();">Agregar a la Factura</button>
                    </div>

                        </div>
                    </div>
<br>                    <!-- Campos del formulario -->
                    <div class="form-group">
                        <label for="ref_prod_venta">Referencia</label>
                        <input required placeholder="----"class="form-control-sm"type="text" size="5" id="ref_prod_venta" name="ref_prod_venta" oninput="if(this.value.length > 4) this.value = this.value.slice(0,4); buscarProducto();">
                        <label for="unidades_venta">Unidades</label>
                        <input required placeholder="--"class="form-control-sm"type="text" size="5" id="unidades_venta" name="unidades_venta" min="1" max="99" oninput="if(this.value.length > 2) this.value = this.value.slice(0,2); this.value = this.value.replace(/\D/g, ''); calcularDiferencia(); calcularValorTotalVenta();">
                        <label for="unidades_producto">Stock</label>
                        <input required class="form-control-sm" type="text" size="5" id="unidades_producto" name="unidades_producto" readonly>
                        <label for="diferencia_producto">Diferencia</label>
                        <input required class="form-control-sm" type="text" size="5" id="diferencia_producto" name="diferencia_producto" readonly>
                    </div>
<br>
                    <div class="form-group">
                        <label for="factura_venta">Factura de Venta</label>
                        <input required class="form-control-sm" size="6" type="text" id="factura_venta" name="factura_venta" value="<?php echo (int)$factura_venta; ?>" readonly>
                        <label for="asesor_venta">Asesor</label>
                        <input required class="form-control-sm" type="text" id="asesor_venta" name="asesor_venta" value="<?php echo $_SESSION['usuario'];?>" readonly>
                        <label for="fecha_hora_venta">Fecha y Hora de Venta</label>
                        <input required class="form-control-sm" type="datetime-local" size="15" id="fecha_hora_venta" name="fecha_hora_venta" value="<?php echo date('Y-m-d\TH:i'); ?>" readonly>
                    </div>
<br>

                   
                    <div class="form-group">
                        <label for="ref_prod_venta_2">Referencia</label>
                        <input required class="form-control-sm"type="text" size="5" id="ref_prod_venta_2" readonly name="ref_prod_venta_2">
                        <label for="producto_venta">Producto</label>
                        <input required class="form-control-sm"type="text" id="producto_venta" name="producto_venta" readonly>
                        <label  for="cat_producto">Categoría</label>
                        <input required class="form-control-sm"type="text" id="cat_producto" name="cat_producto" readonly>
                        <label for="valor_producto">Valor Unidad</label>
                        <input class="form-control-sm" type="number" step="0.01" id="valor_producto" name="valor_producto" readonly oninput="calcularValorTotalVenta()">
                        <label for="valor_total_venta">Sub Total</label>
                        <input class="form-control-sm" size="5" type="number" step="0.01" id="valor_total_venta" name="valor_total_venta" readonly>
                    </div>
<hr>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="limpiarFormulario()">Limpiar Formulario</button>

                </form>
            </div>
            <?php
        }
        ?>

    </div>
</div>
</div>
</div>
                  <!-- Modal de Productos -->
                    <div class="modal fade" id="productosModal" tabindex="-1" role="dialog" aria-labelledby="productosModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="productosModalLabel">Listado de Productos</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Tabla de productos -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID Producto</th>
                                                    <th>Referencia</th>
                                                    <th>Descripción</th>
                                                    <th>Categoría</th>
                                                    <th>Valor</th>
                                                    <th>Unidades</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Consulta para obtener todos los productos
                                                $consulta_productos = "SELECT id_producto, ref_producto, descripcion_producto, cat_producto, valor_producto, unidades_producto FROM productos";
                                                $resultado_productos = mysqli_query($conexion, $consulta_productos);
                                                if (mysqli_num_rows($resultado_productos) > 0) {
                                                    while ($fila_producto = mysqli_fetch_assoc($resultado_productos)) {
                                                        echo "<tr>";
                                                        echo "<td>" . $fila_producto["id_producto"] . "</td>";
                                                        echo "<td>" . $fila_producto["ref_producto"] . "</td>";
                                                        echo "<td>" . $fila_producto["descripcion_producto"] . "</td>";
                                                        echo "<td>" . $fila_producto["cat_producto"] . "</td>";
                                                        echo "<td>" . $fila_producto["valor_producto"] . "</td>";
                                                        echo "<td>" . $fila_producto["unidades_producto"] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6' class='text-center'>No hay productos disponibles</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

<script>

// Función mejorada para buscar producto automáticamente
function buscarProducto() {
    var ref_prod_venta = $('#ref_prod_venta').val().trim();

    // No buscar hasta que haya al menos 4 caracteres
    if (ref_prod_venta.length < 4) {
        return;
    }

    $.ajax({
        type: 'POST',
        url: '../procesos_factura_admin/buscar_referencia.php',
        data: { ref_prod_venta: ref_prod_venta },
        dataType: 'json',
        success: function(response) {
            if (response && !response.error) {
                // Llenar todos los campos del producto
                $('#ref_prod_venta_2').val(response.ref_producto);
                $('#producto_venta').val(response.descripcion_producto);
                $('#valor_producto').val(response.valor_producto);
                $('#unidades_producto').val(response.unidades_producto);
                $('#cat_producto').val(response.cat_producto);

                calcularDiferencia();
                calcularValorTotalVenta();
            } else {
                limpiarFormulario();
                if (response && response.error) {
                    console.error(response.error);
                    alert(response.error);
                    $('#ref_prod_venta').val('');
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("Error AJAX:", error);
            console.error("Respuesta del servidor:", xhr.responseText);
            alert('Error al buscar el producto. Por favor, revisa la consola.');
        }
    });
}

// Añadir event listener para cambios en la entrada del producto
$(document).ready(function() {
    $('#ref_prod_venta').on('input', function() {
        buscarProducto();
    });
});


function validarCampos() {
    let errores = [];

    const campos = {
        factura_venta: "Factura de venta",
        valor_total_venta: "Valor total de la venta",
        fecha_hora_venta: "Fecha y hora de la venta",
        asesor_venta: "Asesor",
        unidades_venta: "Unidades a vender",
        producto_venta: "Producto",
        valor_producto: "Valor unitario del producto",
        ref_prod_venta_2: "Referencia confirmada del producto"
    };

    let hayError = false;

    for (const id in campos) {
        const valor = document.getElementById(id).value.trim();
        const spanError = document.getElementById(`error_${id}`);
        
        if (valor === "") {
            spanError.textContent = `${campos[id]} es obligatorio.`;
            hayError = true;
        } else {
            spanError.textContent = "";
        }

        // Validación adicional para números positivos
        if ((id === "valor_total_venta" || id === "valor_producto" || id === "unidades_venta") && valor !== "") {
            if (isNaN(valor) || parseFloat(valor) <= 0) {
                spanError.textContent = `${campos[id]} debe ser un número positivo.`;
                hayError = true;
            }
        }
    }

    return !hayError && preguntarRegistrarVenta();
}

function nueva_venta() {
    $.ajax({
        url: '../procesos_factura_admin/id_factura.php',
        method: 'GET',
        success: function(response) {
            var nuevoId = parseInt(response) + 1;
            document.getElementById("factura_venta").value = nuevoId;
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}

function confirmarCancelarVenta() {
    if (confirm("¿Está seguro que desea cancelar la venta y borrar todos los datos?")) {
        location.reload();
    }
}

function preguntarRegistrarVenta() {
    return confirm("¿Desea registrar la venta?");
}

// Función para calcular la diferencia entre stock y unidades a vender
function calcularDiferencia() {
    const unidadesStock = parseInt($('#unidades_producto').val()) || 0;
    const unidadesVenta = parseInt($('#unidades_venta').val()) || 0;
    const diferencia = unidadesStock - unidadesVenta;
    
    $('#diferencia_producto').val(diferencia);
    
    // Opcionalmente, alertar si la diferencia es negativa
    if (diferencia < 0) {
        alert('¡Atención! No hay suficiente stock para esta venta.');
    }
}

// Función para calcular el valor total de la venta
function calcularValorTotalVenta() {
    const valorUnidad = parseFloat($('#valor_producto').val()) || 0;
    const unidadesVenta = parseInt($('#unidades_venta').val()) || 0;
    const valorTotal = valorUnidad * unidadesVenta;
    
    $('#valor_total_venta').val(valorTotal.toFixed(2));
}

// Función para limpiar el formulario
function limpiarFormulario() {
    // Limpia los campos relacionados con el producto
     $('#ref_prod_venta').val('');
    $('#ref_prod_venta_2').val('');
    $('#producto_venta').val('');
    $('#valor_producto').val('');
    $('#unidades_producto').val('');
    $('#cat_producto').val('');
    $('#valor_total_venta').val('');
    $('#diferencia_producto').val('');
    $('#unidades_venta').val('');
    
    // Opcionalmente, limpiar también la referencia
    // $('#ref_prod_venta').val('');
}
</script>
</body>
</html>