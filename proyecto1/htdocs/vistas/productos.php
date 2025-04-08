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
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../scripts/horaYfecha.js" defer></script>
<link rel="stylesheet" href="../style/style.css">
    <script>
    function confirmar() {
        return confirm('¿Esta seguro de eliminar el producto de la base de datos?')
    }
    </script>



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