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
    <title>Buscar Cliente</title>
    <!DOCTYPE html>
<html>
<head>
    <!-- Script para confirmar la eliminación de usuarios -->
    <script>
    /**
     * Función que muestra un cuadro de diálogo de confirmación
     * @return {boolean} True si el usuario confirma, False si cancela
     */
    function confirmar(){
        return confirm('¿Esta seguro de elimininar el usuario de la base de datos?');
    }
    </script>
    
    <!-- Estilos CSS personalizados -->
    <style>
        /* CSS para establecer el color de fondo de la página */
        body {
            background-color: #f5f5dc; /* Color beige claro (similar a "bisque") */
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
<link rel="stylesheet" href="../style/style.css">
    <script src="librerias/jquery-3.2.1.min.js"></script>
</head>
<body>
    <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-info sombra">
        <div class="row">
            <div class="col-8">
               <h1>Buscar Cliente</h1>
                <a href="controlador_factura.php" class="btn btn-dark sombra">Regresar</a>
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
    
    
    <!-- Sección de búsqueda de clientes -->
    <section id="buscar">
<div class="container-fluid">
    <div class="alert alert-info">
        <h5>Filtrar por:</h5>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" placeholder="Documento Cliente" id="doc_cliente" name="doc_cliente" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>
    </div>
</div>            <hr>
        </div>
        
        <!-- Sección de resultados de la búsqueda -->
        <div class="container-fluid">
            <?php
            // Procesa el formulario solo cuando se envía mediante POST
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Verifica si se ha proporcionado el campo de documento del cliente
                if (isset($_POST["doc_cliente"])) {
                    // Obtiene el valor del documento del cliente
                    $doc_cliente = $_POST['doc_cliente'];
                    
                    // Consulta SQL para buscar clientes por número de documento
                    $sql = "SELECT * FROM clientes WHERE doc_cliente = '$doc_cliente'";
                    $resultado_2 = $conexion->query($sql);
                    $num_filas = $resultado_2->num_rows;
                    
                    // Verifica si se encontraron resultados
                    if ($resultado_2->num_rows > 0) {
                        // Muestra mensaje con la cantidad de resultados encontrados
                        echo '<div class="alert alert-success" role="alert">' . $num_filas . ' resultados de la búsqueda: '.$doc_cliente.'</div>';
                        
                        // Crea la tabla con los resultados
echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
echo "<tr>";
echo "<th>ID Cliente</th>";
echo "<th>Nombre Cliente</th>";
echo "<th>Documento Cliente</th>";
echo "<th>Celular 1 Cliente</th>";
echo "<th>Celular 2 Cliente</th>";
echo "<th>Dirección Cliente</th>";
echo "<th>Correo Cliente</th>";
echo "<th>Acciones</th>";
echo "</tr>";

// Recorre cada fila de resultados y la muestra en la tabla
while ($fila = $resultado_2->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $fila["id_cliente"] . "</td>";
    echo "<td>" . $fila["nom_cliente"] . "</td>";
    echo "<td>" . $fila["doc_cliente"] . "</td>";
    echo "<td>" . $fila["cel1_cliente"] . "</td>";
    echo "<td>" . $fila["cel2_cliente"] . "</td>";
    echo "<td>" . $fila["direccion_cliente"] . "</td>";
    echo "<td>" . $fila["correo_cliente"] . "</td>";
    echo "<td>";
    // Botón para actualizar datos del cliente
    echo "<a href='editar_cliente_factura.php?id_cliente=" . $fila['id_cliente'] . "' class='btn btn-primary'>Actualizar</a>";
    echo "</td>";
    echo "</tr>";                        }
                        echo "</table>";
                    } else {
                        // Mensaje cuando no se encuentran resultados
                        echo '<div class="alert alert-danger">No se encontraron resultados de la búsqueda.</div>';
                    }
                    // Cierra la conexión a la base de datos
                    $conexion->close();
                }
            }
            ?>
        </div>
    </section>
</body>
</html>

<script>
        function copiarTexto() {
            // Obtener el elemento de entrada
            var campo = document.getElementById("doc_cliente");
            
            // Seleccionar el texto dentro del campo
            campo.select();
            
            // Copiar el texto seleccionado al portapapeles
            document.execCommand("copy");
            
            // Deseleccionar el texto
            window.getSelection().removeAllRanges();
        }
    </script>