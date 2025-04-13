<?php
// Incluir el archivo de conexión a la base de datos
include("../../conexion/conexion.php");
include("../../conexion/sesion.php");

$result = null;
$total_valor = 0; // Inicializar el total de valores

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['buscar'])) {
    // Inicializar la consulta base
    $sql = "SELECT * FROM balance WHERE 1";

    // Construir la consulta dinámicamente según los filtros
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $conexion->real_escape_string($_GET['id']);
        $sql .= " AND id = '$id'";
    }

    if (isset($_GET['movimiento']) && !empty($_GET['movimiento'])) {
        $movimiento = $conexion->real_escape_string($_GET['movimiento']);
        $sql .= " AND movimiento LIKE '%$movimiento%'";
    }

    if (isset($_GET['tipo_mov']) && !empty($_GET['tipo_mov'])) {
        $tipo_mov = $conexion->real_escape_string($_GET['tipo_mov']);
        $sql .= " AND tipo_mov LIKE '%$tipo_mov%'";
    }

    if (isset($_GET['descripcion']) && !empty($_GET['descripcion'])) {
        $descripcion = $conexion->real_escape_string($_GET['descripcion']);
        $sql .= " AND descripcion LIKE '%$descripcion%'";
    }

    // Ejecutar la consulta
    $result = $conexion->query($sql);

    // Calcular el total de valores
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $total_valor += $row['valor'];
        }
        // Reiniciar el puntero del resultado para mostrar los datos en la tabla
        $result->data_seek(0);
    }
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
    <title>Consulta de Balance</title>
        <link rel="icon" href="../../img/victoria.png" type="image/png">

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
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="container-fluid alert alert-black sombra">
            <div class="row">
                <div class="col-8">
                    <h1>Balance</h1>
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
            <a href="balance_crear.php" class="btn btn-outline-success">Nuevo Registro</a>
        </div>
    </div>
    <hr>

    <div class="container-fluid">
        <div class="container mt-4">
            <h2 style="color:#0d6efd;">Consulta de Balance</h2>
            <form method="GET" class="mb-4">
                <div class="form-row">
                    <?php
                    $filters = ['movimiento', 'tipo_mov', 'descripcion'];
                    foreach ($filters as $filter) {
                        echo '<div class="col-md-4 mb-6">';
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
                            <th>Movimiento</th>
                            <th>Tipo Movimiento</th>
                            <th>Valor</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["movimiento"] . "</td>";
                                echo "<td>" . $row["tipo_mov"] . "</td>";
                                echo "<td>" . $row["valor"] . "</td>";
                                echo "<td>" . $row["descripcion"] . "</td>";
                                echo "<td>
                                        <a href='balance_editar.php?id=" . $row['id'] . "' class='btn btn-primary'>Editar</a>
                                        <a href='balance_eliminar.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='confirmar(event)'>Eliminar</a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No se encontraron resultados.</td></tr>";
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Total:</strong></td>
                            <td><strong><?php echo $total_valor; ?></strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function confirmar(event) {
            if (!confirm('¿Está seguro de eliminar el registro de balance de la base de datos?')) {
                event.preventDefault();
            }
        }
    </script>

</body>
</html>