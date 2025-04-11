<?php
// Incluir el archivo de conexión a la base de datos
include '../conexion/conexion.php';
// Incluir el archivo de gestión de sesión para la seguridad del acceso
include '../conexion/sesion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Clientes</title>
    
    <!-- Bibliotecas necesarias para Bootstrap -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Función para confirmar la eliminación de un cliente
        function confirmar(event) {
            if (!confirm('¿Está seguro de eliminar el Cliente de la base de datos?')) {
                event.preventDefault(); // Evita que se ejecute la acción si el usuario cancela
            }
        }
    </script>
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

</head>
<body>

    <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-info sombra">
        <div class="row">
            <div class="col-8">
               <h1>Gestión de Clientes</h1>
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

<!-- Botones de acciones -->
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <a href="#" class="btn btn-primary" onclick="location.reload();">Actualizar página</a>
            <a href="nuevo_cliente.php" class="btn btn-success">Nuevo Cliente</a>
        </div>
    </div>
</div>
<hr>

<!-- Sección de búsqueda de clientes -->
<section id="buscar">
<div class="container-fluid">
    <div class="alert alert-info">
        <div class="row">
            <div class="col">
                <h5>Filtrar por:</h5>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <input type="text" placeholder="Documento Cliente" id="doc_cliente" name="doc_cliente" class="form-control form-control-sm">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                </form>
            </div>
            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="todos">Consultar todos los Clientes</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" name="consultar_todos">Consultar</button>
                </form>
            </div>
        </div>
    </div>
</div></section>
<hr>

<!-- Sección para mostrar los resultados de la búsqueda -->
<div class="container-fluid">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["doc_cliente"])) {
            include '../conexion/conexion.php';
            // Evitar inyección SQL sanitizando la entrada del usuario
            $doc_cliente = $conexion->real_escape_string($_POST['doc_cliente']); 

            // Consulta SQL para buscar clientes por documento
            $sql = "SELECT * FROM clientes WHERE doc_cliente = '$doc_cliente'";
            $resultado_2 = $conexion->query($sql);

            if ($resultado_2->num_rows > 0) {
                echo '<div class="alert alert-success">' . $resultado_2->num_rows . ' resultados encontrados para: ' . htmlspecialchars($doc_cliente) . '</div>';
                
                echo "<table class='table table-bordered table-striped tabla-con-bordes'>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Documento</th><th>Celular 1</th><th>Celular 2</th><th>Dirección</th><th>Correo</th><th>Acciones</th></tr>";
                while ($fila = $resultado_2->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fila["id_cliente"]) . "</td>";
                    echo "<td>" . htmlspecialchars($fila["nom_cliente"]) . "</td>";
                    echo "<td>" . htmlspecialchars($fila["doc_cliente"]) . "</td>";
                    echo "<td>" . htmlspecialchars($fila["cel1_cliente"]) . "</td>";
                    echo "<td>" . htmlspecialchars($fila["cel2_cliente"]) . "</td>";
                    echo "<td>" . htmlspecialchars($fila["direccion_cliente"]) . "</td>";
                    echo "<td>" . htmlspecialchars($fila["correo_cliente"]) . "</td>";
                    echo "<td>
                          <a href='editar_cliente.php?id_cliente=" . $fila['id_cliente'] . "' class='btn btn-primary'>Editar</a>
                          <a href='../procesos_factura_admin/eliminar_cliente.php?id_cliente=" . $fila['id_cliente'] . "' class='btn btn-danger' onclick='confirmar(event)'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo '<div class="alert alert-danger">No se encontraron resultados.</div>';
            }
        } elseif (isset($_POST['consultar_todos'])) {
            // Consulta para obtener todos los clientes
            $sql = "SELECT * FROM clientes";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                echo '<div class="alert alert-success">' . $resultado->num_rows . ' clientes encontrados</div>';
                echo "<table class='table table-bordered table-striped tabla-con-bordes'>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Documento</th><th>Celular 1</th><th>Celular 2</th><th>Dirección</th><th>Correo</th><th>Acciones</th></tr>";
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr><td>" . htmlspecialchars($fila["id_cliente"]) . "</td>
                          <td>" . htmlspecialchars($fila["nom_cliente"]) . "</td>
                          <td>" . htmlspecialchars($fila["doc_cliente"]) . "</td>
                          <td>" . htmlspecialchars($fila["cel1_cliente"]) . "</td>
                          <td>" . htmlspecialchars($fila["cel2_cliente"]) . "</td>
                          <td>" . htmlspecialchars($fila["direccion_cliente"]) . "</td>
                          <td>" . htmlspecialchars($fila["correo_cliente"]) . "</td>
                          <td>
                            <a href='editar_cliente.php?id_cliente=" . $fila['id_cliente'] . "' class='btn btn-primary'>Editar</a>
                            <a href='../procesos_factura_admin/eliminar_cliente.php?id_cliente=" . $fila['id_cliente'] . "' class='btn btn-danger' onclick='confirmar(event)'>Eliminar</a>
                          </td></tr>";
                }
                echo "</table>";
            }
        }
        $conexion->close();
    }
    ?>
</div>
</body>
</html>
