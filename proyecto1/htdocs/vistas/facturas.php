<?php
// Incluir archivos de conexión y validación de sesión
include '../conexion/conexion.php';
include '../conexion/sesion.php';

/**
 * Función para mostrar una tabla de resultados de facturas
 * @param mysqli_result $resultado - Resultado de la consulta a mostrar
 * @return void
 */
function mostrarTablaFacturas($resultado) {
    $num_filas = $resultado->num_rows;

    if ($num_filas > 0) {
        echo '<div class="alert alert-success" role="alert">' . $num_filas . ' resultados encontrados</div>';

        // Iniciar tabla con estilos consistentes - AHORA USANDO LA CLASE tabla-facturas
 echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; 
         echo "<thead><tr>";
        echo "<th>ID</th>";
        echo "<th>No. Factura</th>";
        echo "<th>Fecha Factura</th>";
        echo "<th>Fecha Anulación</th>";
        echo "<th>Motivo Anulación</th>";
        echo "<th>Doc. Cliente</th>";
        echo "<th>Nombre Cliente</th>";
        echo "<th>Asesor</th>";
        echo "<th>Forma de Pago</th>";
        echo "<th>Total con IVA</th>";
        echo "<th>Estado</th>";
        echo "<th>Acción</th>";
        echo "</tr></thead><tbody>";

        // Iterar sobre los resultados
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila["id_factura"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["no_factura"]) . "</td>";

            // Mostrar el estado con un badge de Bootstrap 5
            $estado = htmlspecialchars($fila["estado"]);
            $badgeClass = '';

            switch ($estado) {
                case 'Cerrada':
                    $badgeClass = 'bg-success';
                    break;
                case 'Devolucion':
                    $badgeClass = 'bg-danger';
                    break;
                case 'Abierta':
                    $badgeClass = 'bg-warning';
                    break;
                case 'Anulada':
                    $badgeClass = 'bg-secondary';
                    break;
                default:
                    $badgeClass = 'bg-info';
            }

            echo "<td>" . htmlspecialchars($fila["fecha_factura"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["fecha_anulacion"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["descripcion_anulacion"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["doc_cliente"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["nom_cliente"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["asesor"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["forma_de_pago"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["total_venta_con_iva"]) . "</td>";
            echo "<td><span class='badge " . $badgeClass . "'>" . $estado . "</span></td>";
            echo "<td>";
            echo "<a href='ver_factura.php?no_factura=" . htmlspecialchars($fila['no_factura']) . "' class='btn btn-primary btn-sm'>Ver Factura</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo '<div class="alert alert-danger">No se encontraron resultados de la búsqueda.</div>';
    }
}

/**
 * Función para ejecutar consulta y mostrar resultados
 * @param mysqli $conexion - Objeto de conexión a la base de datos
 * @param string $sql - Consulta SQL a ejecutar
 * @param string $filtro - Descripción del filtro aplicado (opcional)
 * @return void
 */
function ejecutarConsultaYMostrar($conexion, $sql, $filtro = '') {
    $resultado = $conexion->query($sql);

    if ($filtro) {
        echo '<div class="alert alert-info">Filtro aplicado: ' . htmlspecialchars($filtro) . '</div>';
    }

    mostrarTablaFacturas($resultado);
}

// Variable para controlar si se debe cerrar la conexión al final
$cerrar_conexion = false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Facturas</title>
    <!-- Script para confirmación de eliminación -->
    <script>
        function confirmar() {
            return confirm('¿Está seguro de eliminar el ítem seleccionado?');
        }
        </script>
<link rel="stylesheet" href="../style/style.css">
    <!-- Bibliotecas necesarias para Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../scripts/horaYfecha.js" defer></script>
<link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-info sombra">
        <div class="row">
            <div class="col-8">
               <h1>Gestión de Facturas</h1>
                <a href="inicio_admin.php" class="btn btn-dark sombra"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
  <polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg> Home</a>
               <span class="badge text-bg-info"><?php echo " Usuario: " . $_SESSION['usuario']; ?></span>
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

<div class="container-fluid">
    <p>
        <button type="button" class="btn btn-primary" onclick="location.reload();">Actualizar página</button>
    </p>
</div>
<hr>

<div class="container-fluid">
    <div class="alert alert-info">
        <div class="form-group">
            <h5>Filtrar por:</h5>
            <div class="row">
                <div class="col">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="fecha_factura">Fecha de Factura:</label>
                            <input type="date" id="fecha_factura" name="fecha_factura" class="form-control form-control-sm">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                    </form>
                </div>

                <div class="col">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="no_factura">Número de Factura:</label>
                            <input type="text" id="no_factura" name="no_factura" class="form-control form-control-sm">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                    </form>
                </div>

                <div class="col">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="doc_cliente">Cédula de Cliente:</label>
                            <input type="text" id="doc_cliente" name="doc_cliente" class="form-control form-control-sm">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                    </form>
                </div>

                <div class="col">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="estado">Estado de Factura:</label>
                            <select id="estado" name="estado" class="form-control form-control-sm">
                                <option value="Abierta" selected>Abierta</option>
                                <option value="Cerrada">Cerrada</option>
                                <option value="Anulada">Anulada</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                    </form>
                </div>

                <div class="col">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="todos">Consultar todas las Facturas</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" name="consultar_todos">Consultar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    <hr>
    
    <!-- Sección de resultados -->
    <div class="container-fluid">
        <?php
        // Procesar formulario si se ha enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cerrar_conexion = true;
            
            // Filtro por fecha
            if (isset($_POST["fecha_factura"]) && !empty($_POST["fecha_factura"])) {
                $fecha_factura = $conexion->real_escape_string($_POST['fecha_factura']);
                $sql = "SELECT * FROM facturas WHERE DATE(fecha_factura) = '$fecha_factura'";
                ejecutarConsultaYMostrar($conexion, $sql, "Fecha: $fecha_factura");
            }
            
            // Filtro por número de factura
            elseif (isset($_POST["no_factura"]) && !empty($_POST["no_factura"])) {
                $no_factura = $conexion->real_escape_string($_POST['no_factura']);
                $sql = "SELECT * FROM facturas WHERE no_factura = '$no_factura'";
                ejecutarConsultaYMostrar($conexion, $sql, "Número de factura: $no_factura");
            }
            
            // Filtro por cédula de cliente
            elseif (isset($_POST["doc_cliente"]) && !empty($_POST["doc_cliente"])) {
                $doc_cliente = $conexion->real_escape_string($_POST['doc_cliente']);
                $sql = "SELECT * FROM facturas WHERE doc_cliente = '$doc_cliente'";
                ejecutarConsultaYMostrar($conexion, $sql, "Cédula del cliente: $doc_cliente");
            }
            
            // Filtro por estado
            elseif (isset($_POST["estado"]) && !empty($_POST["estado"])) {
                $estado = $conexion->real_escape_string($_POST['estado']);
                $sql = "SELECT * FROM facturas WHERE estado = '$estado'";
                ejecutarConsultaYMostrar($conexion, $sql, "Estado: $estado");
            }
            
            // Consultar todas las facturas
            elseif (isset($_POST["consultar_todos"])) {
                $sql = "SELECT * FROM facturas";
                ejecutarConsultaYMostrar($conexion, $sql, "Todas las facturas");
            }
        }
        
        // Cerrar la conexión si se ha ejecutado alguna consulta
        if ($cerrar_conexion && isset($conexion)) {
            $conexion->close();
        }
        ?>
    </div>
</body>
</html>