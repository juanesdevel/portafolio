<?php

// Incluir archivos de conexión y sesión
include '../conexion/conexion.php';
include '../conexion/sesion.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Consulta para obtener facturas abiertas
$sql = "SELECT * FROM facturas WHERE estado = 'Abierta'";

$stmt = $conexion->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();

$facturas = [];

while ($fila = $resultado->fetch_assoc()) {
    $facturas[] = $fila;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Ventas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- jQuery (importante: usar solo UNA versión) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Scripts personalizados -->
    <script src="../scripts/horaYfecha.js" defer></script>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-info sombra">
        <div class="row">
            <div class="col-8">
               <h1>Proceso de Factura</h1>
               <a href="inicio_admin.php" class="btn btn-dark sombra">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                   <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                   <polyline points="9 22 9 12 15 12 15 22"></polyline>
                   </svg> Home
               </a>
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
    
    <div class="form-container">
        <div class="alert alert-info">
            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-success btn-sm" href="nuevo_cliente_factura.php">Crear Cliente</a>
                    <a class="btn btn-primary btn-sm" href="admin_cliente_factura.php">Editar Cliente</a>
                </div>
            </div>
            <hr>
            <form action="../procesos_factura_admin/crear_factura.php" method="POST" onsubmit="return validarFormulario();">
                <div class="form-group">
                    <label for="doc_cliente_venta">Buscar cliente</label>
                    <input class="form-control-sm bg-light" type="text" id="doc_cliente_venta" placeholder="Cédula" name="doc_cliente_venta" 
                           maxlength="10" pattern="[0-9]{1,10}" 
                           oninput="this.value = this.value.replace(/\D/g, '');" 
                           value="" size="10">
                    <button class="btn btn-success btn-sm" type="submit">Nueva Factura</button>
                    <br>
                    <br>

                    <label for="doc_cliente_venta_2">Cédula Cliente:</label>
                    <input class="form-control-sm bg-light" type="text" id="doc_cliente_venta_2" name="doc_cliente_venta_2" 
                           value="" readonly size="10">

                    <label for="nom_cliente">Nombre Cliente</label>
                    <input class="form-control-sm bg-light" type="text" id="nom_cliente" name="nom_cliente" 
                           value="" readonly size="40">

                    <label for="cel1_cliente">Celular 1</label>
                    <input class="form-control-sm bg-light" type="text" id="cel1_cliente" name="cel1_cliente" readonly size="10">

                    <label for="cel2_cliente">Celular 2</label>
                    <input class="form-control-sm bg-light" type="text" id="cel2_cliente" name="cel2_cliente" readonly size="10">
                    <br><br>
                    <label for="direccion_cliente">Dirección</label> 
                    <input class="form-control-sm bg-light" type="text" id="direccion_cliente" name="direccion_cliente" readonly size="40">

                    <label for="correo_cliente">Correo</label>
                    <input class="form-control-sm bg-light" type="email" id="correo_cliente" name="correo_cliente" readonly size="40">
                    <br>
                    <hr>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="limpiarCampos()">Limpiar Campos</button>
                </div>
            </form>
            <hr>
            <h4 class="my-4">Facturas Abiertas</h4>
            <?php if (!empty($facturas)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Factura</th>
                                <th>asesor</th>  
                                <th>Cédula Cliente</th>
                                <th>Nombre Cliente</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($facturas as $factura) : ?>
                                <tr>
                                <td><?= htmlspecialchars($factura['no_factura']) ?></td>
                                    <td><?= htmlspecialchars($factura['asesor']) ?></td>
                                    <td><?= htmlspecialchars($factura['doc_cliente']) ?></td>
                                    <td><?= htmlspecialchars($factura['nom_cliente']) ?></td>
                                    <td>
                                        <span class="badge 
                                            <?= $factura['estado'] == 'Abierta' ? 'bg-warning' : 
                                                ($factura['estado'] == 'Cerrada' ? 'bg-success' : 'bg-secondary') ?>">
                                            <?= htmlspecialchars($factura['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="factura_en_proceso.php?no_factura=<?= urlencode($factura['no_factura']) ?>" class="btn btn-sm btn-info">
                                            Continuar
                                        </a>     
                                        <a href="resumen_factura.php?no_factura=<?= urlencode($factura['no_factura']) ?>" class="btn btn-sm btn-primary">
                                            Ver Factura
                                        </a>                               
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i> No se encontraron facturas abiertas.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $stmt->close();
    $conexion->close();
    ?>

<script>
function validarFormulario() {
    let cedulaCliente = document.getElementById("doc_cliente_venta_2").value.trim();
    let nombreCliente = document.getElementById("nom_cliente").value.trim();

    if (cedulaCliente === "" || nombreCliente === "") {
        alert("Debe ingresar la cédula y el nombre del cliente.");
        return false;
    }
    return true;
}

function limpiarCampos() {
    document.getElementById("doc_cliente_venta").value = "";
    document.getElementById("doc_cliente_venta_2").value = "";
    document.getElementById("nom_cliente").value = "";
    document.getElementById("cel1_cliente").value = "";
    document.getElementById("cel2_cliente").value = "";
    document.getElementById("direccion_cliente").value = "";
    document.getElementById("correo_cliente").value = "";
}

// Función buscarCliente mejorada que cargará automáticamente todos los campos
function buscarCliente() {
    var doc_cliente_venta = $('#doc_cliente_venta').val();
    
// No buscar hasta que haya al menos 10 dígitos numéricos
if (!/^\d{10,}$/.test(doc_cliente_venta.trim())) {
    return;
}

    $.ajax({
        type: 'POST',
        url: '../procesos_factura_admin/buscar_cliente.php',
        data: { doc_cliente_venta: doc_cliente_venta },
        dataType: 'json',
        success: function(response) {
            if (response && !response.error) {
                // Almacenar el ID del cliente para posible acción de edición
                var idCliente = response.id_cliente;

                // Llenar todos los campos del cliente
                $('#nom_cliente').val(response.nom_cliente);
                $('#doc_cliente_venta_2').val(response.doc_cliente);
                $('#cel1_cliente').val(response.cel1_cliente);
                $('#cel2_cliente').val(response.cel2_cliente);
                $('#direccion_cliente').val(response.direccion_cliente);
                $('#correo_cliente').val(response.correo_cliente);
            } else {
                // Si no se encuentra el cliente, limpiar los campos
                limpiarCampos();
                if (response && response.error) {
                    console.error(response.error);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("Error AJAX:", error);
            alert('Error al buscar el cliente. Por favor intente de nuevo.');
        }
    });
}

// Añadir event listener para cambios en la entrada - esto activará la búsqueda mientras el usuario escribe
$(document).ready(function() {
    $('#doc_cliente_venta').on('input', function() {
        buscarCliente();
    });
});
</script>
</body>
</html>