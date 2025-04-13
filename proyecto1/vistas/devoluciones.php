<?php
//seguridad de sesion
include '../conexion/conexion.php';
include '../conexion/sesion.php';


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion de usuarios</title>
    <!-- Bibliotecas necesarias para Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/css.css">
    
    <script>function confirmar(){
        return confirm ('¿Esta seguro de elimininar el item seleccionado?')}
    
    </script>

</head>
<body>
        <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-danger sombra">
        <div class="row">
            <div class="col-10">
               <h1>Devoluciones <i class="fas fa-exchange-alt"></i></h1>
                <a href="ventas.php"class="btn btn-dark btn-sm">Regresar</a>
               <span class="badge text-bg-info"><?php echo" Usuario:  "  . $_SESSION['usuario']; ?></span>
            </div>
           
            <div class="col-2">
                <div class="logo-container">
                    <img src="../img/logo.jpg" alt="Logo de la empresa" class="logo" style="width: 200px; height: auto;">
                </div>
            </div>
        </div>
    </div>
<hr>

<div class="container-fluid">
    <a href="#" class="btn btn-primary"onclick="location.reload();">Actualizar página</a> 
</div>
    </div>
</div><hr>
<div class="container-fluid">
    <div class="alert alert-danger">
        <h5>Filtrar por:</h5>
        <div class="row">
            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="fecha_venta">Fecha de Devolución:</label>
                        <input type="date" id="fecha_venta" name="fecha_venta" class="form-control form-control-sm">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                </form>
            </div>

            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="factura_venta">Número de Factura:</label>
                        <input type="text" id="factura_venta" name="factura_venta_consulta" class="form-control form-control-sm">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                </form>
            </div>

            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="ref_producto">Referencia de producto:</label>
                        <input type="text" id="ref_producto" name="ref_producto" class="form-control form-control-sm">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                </form>
            </div>

            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="todos">Consultar todas las Devoluciones</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" name="consultar_todos">Consultar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<hr>

<!-- // seccion de devoluciones// -->
<div class="container-fluid">

<section id="porFactura">

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["factura_venta_consulta"])) { // Verifica si el campo específico está presente
            include '../conexion/conexion.php';

            $factura_venta = $_POST['factura_venta_consulta'];

            $sql = "SELECT * FROM devoluciones WHERE factura_devo = '$factura_venta'";
            $resultado = $conexion->query($sql);
            $num_filas = $resultado->num_rows;
            if ($resultado->num_rows > 0) {

                                        echo '<div class="alert alert-success" role="alert">';
        echo "$num_filas Resultados de la Devolución por Factura No: $factura_venta";
        echo '</div>';

            echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
            echo "<tr>";
            echo "<th>ID Devolucion</th>";
            echo "<th>Fecha Devolución</th>";
            echo "<th>Asesor Usuario Devolucion</th>";
            echo "<th>Id de Venta </th>";
            echo "<th>Referencia Producto</th>";
            echo "<th>Unidades Venta</th>";
            echo "<th>Factura Devolución</th>";
            echo "<th>Valor Total Venta</th>";
            echo "<th>Tipo de Devolucion Venta</th>";
            echo "<th>Descripción</th>";
            echo "</tr>";

            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila["id_devolucion"] . "</td>";
                echo "<td>" . $fila["fecha_devo"] . "</td>";
                echo "<td>" . $fila["usuario_devo"] . "</td>";
                echo "<td>" . $fila["id_venta"] . "</td>";
                echo "<td>" . $fila["ref_producto"] . "</td>";
                echo "<td>" . $fila["unidades_pro"] . "</td>";
                echo "<td>" . $fila["factura_devo"] . "</td>";
                echo "<td>" . $fila["valor_devo"] . "</td>";
                echo "<td>" . $fila["tipo_devo"] . "</td>";
                echo "<td>" . $fila["descripcion_devo"] . "</td>";
                echo "</tr>";                }
                echo "</table>";
            } else {
                echo '<div class="alert alert-danger">No se encontraron Devoluciones para la Factura especificada!.</div>';

            }
            $conexion->close();
        }
    }
    ?>
</section>
</div>

<div class="container-fluid">

<section id="porReferencia">

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["ref_producto"])) { // Verifica si el campo específico está presente
            include '../conexion/conexion.php';

            $ref_producto = $_POST['ref_producto'];

            $sql = "SELECT * FROM devoluciones WHERE ref_producto = '$ref_producto'";
            $resultado = $conexion->query($sql);
            $num_filas = $resultado->num_rows;
            if ($resultado->num_rows > 0) {

                        echo '<div class="alert alert-success" role="alert">';
        echo "$num_filas Resultados de la búsqueda por Referencia: $ref_producto";
        echo '</div>';

            echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
                echo "<tr>";
                echo "<th>ID Devolicion</th>";
                echo "<th>Fecha Devolución</th>";
                echo "<th>Asesor Usuario Devolucion</th>";
                echo "<th>Id de Venta </th>";
                echo "<th>Referencia Producto</th>";
                echo "<th>Unidades Venta</th>";
                echo "<th>Factura Devolución</th>";
                echo "<th>Valor Total Venta</th>";
                echo "<th>Tipo de Devolucion Venta</th>";
                echo "<th>Descripción</th>";
                echo "</tr>";
                
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila["id_devolucion"] . "</td>";
                    echo "<td>" . $fila["fecha_devo"] . "</td>";
                    echo "<td>" . $fila["usuario_devo"] . "</td>";
                    echo "<td>" . $fila["id_venta"] . "</td>";
                    echo "<td>" . $fila["ref_producto"] . "</td>";
                    echo "<td>" . $fila["unidades_pro"] . "</td>";
                    echo "<td>" . $fila["factura_devo"] . "</td>";
                    echo "<td>" . $fila["valor_devo"] . "</td>";
                    echo "<td>" . $fila["tipo_devo"] . "</td>";
                    echo "<td>" . $fila["descripcion_devo"] . "</td>";
                                      
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo '<div class="alert alert-danger">No se encontraron Devoluciones para la Referencia especificada!.</h5></div>';

            }
            $conexion->close();
        }
    }
    ?>
</section>
</div>


<div class="container-fluid">

<section id="porFecha">

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["fecha_venta"])) { // Verifica si el campo específico está presente
            include '../conexion/conexion.php';

            $fecha_venta = $_POST['fecha_venta'];

            $sql = "SELECT * FROM devoluciones WHERE DATE(fecha_devo) = '$fecha_venta'";

            $resultado = $conexion->query($sql);
            $num_filas = $resultado->num_rows;
            if ($resultado->num_rows > 0) {
                                        echo '<div class="alert alert-success" role="alert">';
        echo "$num_filas Resultados de la búsqueda por Fecha: $fecha_venta";
        echo '</div>';

echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
echo "<tr>";
echo "<th>ID Devolucion</th>";
echo "<th>Fecha Devolución</th>";
echo "<th>Asesor Usuario Devolucion</th>";
echo "<th>Id de Venta </th>";
echo "<th>Referencia Producto</th>";
echo "<th>Unidades Venta</th>";
echo "<th>Factura Devolución</th>";
echo "<th>Valor Total Venta</th>";
echo "<th>Tipo de Devolucion Venta</th>";
echo "<th>Descripción</th>";
echo "</tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $fila["id_devolucion"] . "</td>";
    echo "<td>" . $fila["fecha_devo"] . "</td>";
    echo "<td>" . $fila["usuario_devo"] . "</td>";
    echo "<td>" . $fila["id_venta"] . "</td>";
    echo "<td>" . $fila["ref_producto"] . "</td>";
    echo "<td>" . $fila["unidades_pro"] . "</td>";
    echo "<td>" . $fila["factura_devo"] . "</td>";
    echo "<td>" . $fila["valor_devo"] . "</td>";
    echo "<td>" . $fila["tipo_devo"] . "</td>";
    echo "<td>" . $fila["descripcion_devo"] . "</td>";
    echo "</tr>";                }
                echo "</table>";
            } else {
                echo '<div class="alert alert-danger">No se encontraron Devoluciones para la Fecha especificada!.</h5></div>';

            }
            $conexion->close();
        }
    }
    ?>
</section>
</div>

<div class="container-fluid">

<section id="todos">

    <?php
     if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar_todos'])) {
         // Verifica si el campo específico está presente
         include '../conexion/conexion.php';
         
            $sql = "SELECT * FROM devoluciones";

            $resultado = $conexion->query($sql);
            $num_filas = $resultado->num_rows;
            if ($resultado->num_rows > 0) {
                                                        echo '<div class="alert alert-success" role="alert">';
        echo "$num_filas Resultados de la búsqueda ";
        echo '</div>';

echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
                echo "<tr>";
                echo "<th>ID Devolicion</th>";
                echo "<th>Fecha Devolución</th>";
                echo "<th>Asesor Usuario Devolucion</th>";
                echo "<th>Id de Venta </th>";
                echo "<th>Referencia Producto</th>";
                echo "<th>Unidades Venta</th>";
                echo "<th>Factura Devolución</th>";
                echo "<th>Valor Total Venta</th>";
                echo "<th>Tipo de Devolucion Venta</th>";
                echo "<th>Descripción</th>";
                echo "</tr>";
                
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila["id_devolucion"] . "</td>";
                    echo "<td>" . $fila["fecha_devo"] . "</td>";
                    echo "<td>" . $fila["usuario_devo"] . "</td>";
                    echo "<td>" . $fila["id_venta"] . "</td>";
                    echo "<td>" . $fila["ref_producto"] . "</td>";
                    echo "<td>" . $fila["unidades_pro"] . "</td>";
                    echo "<td>" . $fila["factura_devo"] . "</td>";
                    echo "<td>" . $fila["valor_devo"] . "</td>";
                    echo "<td>" . $fila["tipo_devo"] . "</td>";
                    echo "<td>" . $fila["descripcion_devo"] . "</td>";
                                      
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo '<div class="alert alert-danger">No se encontraron Devoluciones!.</h5></div>';

            }
            $conexion->close();
        }
    
    ?>
</section>
</div>
</body>
</html>