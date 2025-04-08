<?php
// Incluir el archivo de conexión a la base de datos
include("../../conexion/conexion.php");
include("../../conexion/sesion.php");

$result = null;

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['buscar'])) {
    // Inicializar la consulta base
    $sql = "SELECT * FROM eventos WHERE 1";

    // Construir la consulta dinámicamente según los filtros
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $conexion->real_escape_string($_GET['id']);
        $sql .= " AND id = '$id'";
    }

    if (isset($_GET['fecha']) && !empty($_GET['fecha'])) {
        $fecha = $conexion->real_escape_string($_GET['fecha']);
        $sql .= " AND fecha = '$fecha'";
    }

    if (isset($_GET['nombre']) && !empty($_GET['nombre'])) {
        $nombre = $conexion->real_escape_string($_GET['nombre']);
        $sql .= " AND nombre LIKE '%$nombre%'";
    }

    if (isset($_GET['descripcion']) && !empty($_GET['descripcion'])) {
        $descripcion = $conexion->real_escape_string($_GET['descripcion']);
        $sql .= " AND descripcion LIKE '%$descripcion%'";
    }

    if (isset($_GET['direccion']) && !empty($_GET['direccion'])) {
        $direccion = $conexion->real_escape_string($_GET['direccion']);
        $sql .= " AND direccion LIKE '%$direccion%'";
    }

    // Añadir ORDER BY fecha ASC para ordenar por fecha ascendente
    $sql .= " ORDER BY fecha ASC";

    // Ejecutar la consulta
    $result = $conexion->query($sql);
}

// Cerrar la conexión al final
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../scripts/horaYfecha.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body { background-color: #121212; color: #e0e0e0; }
        .table-dark { color: #e0e0e0; }
        .table-dark th, .table-dark td { border-color: #424242; }
        .form-control { background-color: #333; color: #e0e0e0; border: 1px solid #555; }
        .form-control:focus { background-color: #444; color: #e0e0e0; border-color: #666; }
        label { color: #bdbdbd; }
        .alert-info { background-color: #333; color: #e0e0e0; border-color: #424242; }
        th:nth-child(2), /* Selecciona la segunda columna (Fecha) en la cabecera */
        td:nth-child(2) { /* Selecciona la segunda columna (Fecha) en las celdas de datos */
            width: 100px; /* Ajusta este valor según sea necesario */
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="container-fluid alert alert-black sombra">
            <div class="row">
                <div class="col-8">
                    <h1>Eventos</h1>
                    <a href="../inicio_admin.php" class="btn btn-dark sombra">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg> Home
                    </a>
                    <span class="badge text-bg-info"><?php echo "Usuario: " . $_SESSION['usuario']; ?></span>
                </div>
                <div class="col-2">
                    <h5><span class="badge text-bg-info" id="fechaHora"></span></h5>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="container-fluid">
        <div class="container">
            <a href="#" class="btn btn-primary" onclick="location.reload();">Actualizar página</a>
            <a href="evento_crear.php" class="btn btn-outline-success">Nuevo Registro</a>
        </div>
    </div>
    <hr>

    <div class="container-fluid">
        <div class="container mt-4">
            <h2 style="color:#0d6efd;">Consulta de Eventos</h2>
            <form method="GET" class="mb-4">
                <div class="form-row">
                    <?php
                    $filters = ['fecha', 'nombre', 'descripcion'];
                    foreach ($filters as $filter) {
                        echo '<div class="col-md-3 mb-6">';
                        echo '<label for="' . $filter . '">' . ucfirst($filter) . ':</label>';
                        echo '<input type="text" class="form-control" id="' . $filter . '" name="' . $filter . '" value="' . (isset($_GET[$filter]) ? $_GET[$filter] : '') . '">';
                        echo '</div>';
                    }
                    ?>
                </div>
                <button type="submit" class="btn btn-primary" name="buscar">Buscar</button>
            </form>

            <?php if ($result !== null): ?>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["fecha"] . "</td>";
                                echo "<td>" . $row["nombre"] . "</td>";
                                echo "<td>" . $row["descripcion"] . "</td>";
                                echo "<td>" . $row["direccion"] . "</td>";
                                echo "<td>
                                        <a href='evento_editar.php?id=" . $row['id'] . "' class='btn btn-primary'>Editar</a>
                                        <a href='evento_eliminar.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='confirmar(event)'>Eliminar</a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No se encontraron resultados.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function confirmar(event) {
            if (!confirm('¿Está seguro de eliminar el Evento de la base de datos?')) {
                event.preventDefault();
            }
        }
    </script>

</body>
</html>