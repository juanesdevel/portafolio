<?php
// Incluir el archivo de seguridad de sesión
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

</head>

<body>

    <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-info sombra">
        <div class="row">
            <div class="col-8">
               <h1>Gestión de Productos</h1>
                <a href="inicio_admin.php" class="btn btn-dark sombra"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
  <polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg> Home</a>
               <span class="badge text-bg-info"><?php echo" Usuario:  "  . $_SESSION['usuario']; ?></span>
            </div>
            <div class="col-2">
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
        <div class="row">
            <div class="col">

                <a href="#" class="btn btn-primary" onclick="location.reload();">Actualizar página</a>
                <a href="nuevo_producto.php" class="btn btn-success">Nuevo Producto</a>

            </div>
        </div>
    </div>
    <hr>

<div class="container-fluid">
    <div class="alert alert-info">
        <h5>Filtrar por:</h5>
        <div class="row">
            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="ref_producto">Referencia de Producto:</label>
                        <input type="text" id="ref_producto" name="ref_producto" class="form-control form-control-sm">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                </form>
            </div>
            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="todos">Consultar todos los Productos</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" name="consultar_todos">Consultar</button>
                </form>
            </div>
        </div>
    </div>
</div>    <hr>
    <div class="container-fluid">
        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["ref_producto"])) { // Verifica si el campo específico está presente
include '../conexion/conexion.php';
           
            $ref_producto = $_POST['ref_producto'];

            $sql_1 = "SELECT * FROM productos WHERE ref_producto = '$ref_producto'";
            $resultado_1 = $conexion->query($sql_1);
            $num_filas = $resultado_1->num_rows;
            if ($resultado_1->num_rows > 0) {
                echo '<div class="alert alert-success" role="alert">' . $num_filas . ' resultados de la búsqueda: '. $ref_producto .'</div>';
                
  // Quitar los estilos de borde de la tabla
                echo "<table class='table table-bordered table-striped' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr>"; // Quitar style='border: 1px solid #000;'
                echo "<th>ID Producto</th>"; // Quitar style='border: 1px solid #000;'
                echo "<th>Referencia Producto</th>"; // Quitar style='border: 1px solid #000;'
                echo "<th>Descripción Producto</th>"; // Quitar style='border: 1px solid #000;'
                echo "<th>Categoría Producto</th>"; // Quitar style='border: 1px solid #000;'
                echo "<th>Valor Producto</th>"; // Quitar style='border: 1px solid #000;'
                echo "<th>Unidades Producto</th>"; // Quitar style='border: 1px solid #000;'
                echo "<th>Acciones</th>"; // Quitar style='border: 1px solid #000;'
                echo "</tr>";
                
                while ($fila = $resultado_1->fetch_assoc()) {
                    echo "<tr>"; // Quitar style='border: 1px solid #000;'
                    echo "<td>" . $fila["id_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
                    echo "<td>" . $fila["ref_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
                    echo "<td>" . $fila["descripcion_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
                    echo "<td>" . $fila["cat_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
                    echo "<td>" . $fila["valor_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
                    echo "<td>" . $fila["unidades_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
                    echo "<td>"; // Quitar style='border: 1px solid #000;'
echo "<a href='editar_producto.php?id_producto=" . $fila['id_producto'] . "' class='btn btn-primary'>Editar</a>";
echo "<a href='eliminar_producto.php?id_producto=" . $fila['id_producto'] . "' class='btn btn-danger' onclick='return confirmar()'>Eliminar</a>";
echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo '<div class="alert alert-danger">No se encontraron resultados de la búsqueda.</div>';
            }
            $conexion->close();
        }
    }
// Genera la tabla con las consultas
?>
        </section>

        <section id="todos">
            <div class="container-fluid">
                <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar_todos'])) {
   include '../conexion/conexion.php';

            $sql = "SELECT * FROM productos";
            $resultado = $conexion->query($sql);
            $num_filas = $resultado->num_rows;
            if ($resultado->num_rows > 0) {
                echo '<div class="alert alert-success" role="alert">' . $num_filas . ' resultados de la búsqueda</div>';
                
echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
echo "<tr>"; // Quitar style='border: 1px solid #000;'
echo "<th>ID Producto</th>"; // Quitar style='border: 1px solid #000;'
echo "<th>Referencia Producto</th>"; // Quitar style='border: 1px solid #000;'
echo "<th>Descripción Producto</th>"; // Quitar style='border: 1px solid #000;'
echo "<th>Categoría Producto</th>"; // Quitar style='border: 1px solid #000;'
echo "<th>Valor Producto</th>"; // Quitar style='border: 1px solid #000;'
echo "<th>Unidades Producto</th>"; // Quitar style='border: 1px solid #000;'
echo "<th>Acciones</th>"; // Quitar style='border: 1px solid #000;'
echo "</tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>"; // Quitar style='border: 1px solid #000;'
    echo "<td>" . $fila["id_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
    echo "<td>" . $fila["ref_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
    echo "<td>" . $fila["descripcion_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
    echo "<td>" . $fila["cat_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
    echo "<td>" . $fila["valor_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
    echo "<td>" . $fila["unidades_producto"] . "</td>"; // Quitar style='border: 1px solid #000;'
    echo "<td>"; // Quitar style='border: 1px solid #000;'
    echo "<a href='editar_producto.php?id_producto=" . $fila['id_producto'] . "' class='btn btn-primary'>Editar</a>";
    echo "<a href='eliminar_producto.php?id_producto=" . $fila['id_producto'] . "' class='btn btn-danger' onclick='return confirmar()'>Eliminar</a>";
    echo "</td>";                    echo "</tr>";
                }
                echo "</table>";
                
            } else {
                echo '<div class="alert alert-danger">No se encontraron resultados de la búsqueda.</div>';
            }
            $conexion->close();
        }
    ?>
            </div>
        </section>

    </div>


</body>

</html>