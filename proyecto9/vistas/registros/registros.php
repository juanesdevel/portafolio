<?php
// Incluir el archivo de conexión a la base de datos
 include ("../../conexion/conexion.php");
    include ("../../conexion/sesion.php");

$result = null;

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['buscar'])) {
    // Inicializar la consulta base
    $sql = "SELECT * FROM servicios WHERE 1";

    // Construir la consulta dinámicamente según los filtros
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $conexion->real_escape_string($_GET['id']);
        $sql .= " AND id = '$id'";
    }

    if (isset($_GET['entidad']) && !empty($_GET['entidad'])) {
        $entidad = $conexion->real_escape_string($_GET['entidad']);
        $sql .= " AND entidad LIKE '%$entidad%'";
    }

    if (isset($_GET['propietario']) && !empty($_GET['propietario'])) {
        $propietario = $conexion->real_escape_string($_GET['propietario']);
        $sql .= " AND propietario LIKE '%$propietario%'";
    }

    if (isset($_GET['usuario']) && !empty($_GET['usuario'])) {
        $usuario = $conexion->real_escape_string($_GET['usuario']);
        $sql .= " AND usuario LIKE '%$usuario%'";
    }

    if (isset($_GET['contrasena']) && !empty($_GET['contrasena'])) {
        $contrasena = $conexion->real_escape_string($_GET['contrasena']);
        $sql .= " AND contrasena LIKE '%$contrasena%'";
    }

    if (isset($_GET['nota']) && !empty($_GET['nota'])) {
        $nota = $conexion->real_escape_string($_GET['nota']);
        $sql .= " AND nota LIKE '%$nota%'";
    }

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
    <title>Consulta de Servicios</title>
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
        .password-toggle { cursor: pointer; }
        /* Añade esto a tu sección de estilos */
.copy-password {
    margin-left: 5px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.input-group {
    flex-wrap: nowrap;
}
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="container-fluid alert alert-black sombra">
            <div class="row">
                <div class="col-8">
                    <h1>Keepass</h1>
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
            <a href="registro_nuevo.php" class="btn btn-outline-success">Nuevo Registro</a>
        </div>
    </div>
    <hr>

    <div class="container-fluid">
        <div class="container mt-4">
            <h2 style="color:#0d6efd;">Consulta de Registros</h2>
            <form method="GET" class="mb-4">
                <div class="form-row">
                    <?php
                    $filters = ['entidad', 'propietario', 'usuario'];
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
                            <th>Entidad</th>
                            <th>Propietario</th>
                            <th>Usuario</th>
                            <th>Contraseña</th>
                            <th>Nota</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["entidad"] . "</td>";
                                echo "<td>" . $row["propietario"] . "</td>";
                                echo "<td>" . $row["usuario"] . "</td>";
                                echo "<td>";
                                echo "<div class='input-group'>";
                                echo "<input type='password' class='form-control password-input' value='" . $row["contrasena"] . "' id='pass-" . $row["id"] . "'>";
                                echo "<div class='input-group-append'>";
                                echo "<span class='input-group-text password-toggle'>";
                                echo "<i class='fas fa-eye'></i>";
                                echo "</span>";
                                echo "<button class='btn btn-secondary copy-password' data-id='" . $row["id"] . "' title='Copiar contraseña'>";
                                echo "<i class='fas fa-copy'></i>";
                                echo "</button>";
                                echo "</div>";
                                echo "</div>";
                                echo "</td>";   
                                echo "</td>";
                                echo "<td>" . $row["nota"] . "</td>";
                                echo "<td>
                                        <a href='registro_editar.php?id=" . $row['id'] . "' class='btn btn-primary'>Editar</a>
                                        <a href='eliminar_registro.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='confirmar(event)'>Eliminar</a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function confirmar(event) {
            if (!confirm('¿Está seguro de eliminar el Cliente de la base de datos?')) {
                event.preventDefault();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggles = document.querySelectorAll('.password-toggle');
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const passwordInput = this.parentElement.parentElement.querySelector('.password-input');
                    const icon = this.querySelector('i');
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
        
        // Añade esto dentro de tu bloque document.addEventListener('DOMContentLoaded', function() { ... })
const copyButtons = document.querySelectorAll('.copy-password');
copyButtons.forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const passwordInput = document.getElementById('pass-' + id);
        
        // Cambiar temporalmente a tipo texto para poder copiar
        const originalType = passwordInput.type;
        passwordInput.type = 'text';
        
        // Seleccionar y copiar
        passwordInput.select();
        document.execCommand('copy');
        
        // Deseleccionar el texto
        passwordInput.setSelectionRange(0, 0);
        
        // Restaurar tipo original
        passwordInput.type = originalType;
        
        // Feedback visual
        const originalColor = this.style.backgroundColor;
        this.style.backgroundColor = '#28a745';
        setTimeout(() => {
            this.style.backgroundColor = originalColor;
        }, 1000);
    });
});
    </script>

</body>
</html>