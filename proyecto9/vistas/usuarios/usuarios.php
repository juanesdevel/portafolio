<?php
// Incluir el archivo de conexión a la base de datos y el archivo de seguridad de sesión
 include ("../../conexion/conexion.php");
    include ("../../conexion/sesion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="icon" href="../../img/victoria.png" type="image/png">

    <!-- Bibliotecas necesarias para Bootstrap -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   
        <style>
        body { background-color: #121212; color: #e0e0e0; }
        .table-dark { color: #e0e0e0; }
        .table-dark th, .table-dark td { border-color: #424242; }
        .form-control { background-color: #333; color: #e0e0e0; border: 1px solid #555; }
        .form-control:focus { background-color: #444; color: #e0e0e0; border-color: #666; }
        label { color: #bdbdbd; }
        .alert-info { background-color: #333; color: #e0e0e0; border-color: #424242; }
        .password-toggle { cursor: pointer; }
    </style>

</head>
<body>
<?php
// Consulta SQL para obtener todos los usuarios
$sql = "SELECT * FROM usuarios2";
$resultado = mysqli_query($conexion, $sql);
?>
    <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-black sombra">
        <div class="row">
            <div class="col-8">
               <h1>Gestión de Usuarios</h1>
                <a href="../panel_inicio/inicio_admin.php" class="btn btn-dark sombra"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
  <polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg> Home</a>
               <span class="badge text-bg-info"><?php echo" Usuario:  "  . $_SESSION['usuario']; ?></span>
            </div>
            <div class="col-2">
              <h5> <span class="badge text-bg-info" id="fechaHora"></span> </h5>
            </div>
        </div>
    </div>
<hr>

<!-- Botones de acción -->
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <a href="#" class="btn btn-primary" onclick="location.reload();">Actualizar página</a>
            <a href="usuario_nuevo.php" class="btn btn-outline-success">Nuevo Usuario</a>
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
                        <label for="codigo_usuario">Código Usuario:</label>
                        <input type="text" id="codigo_usuario" name="codigo_usuario" class="form-control form-control-sm">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Consultar</button>
                </form>
            </div>
            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="todos">Consultar todos los Usuarios</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" name="consultar_todos">Consultar</button>
                </form>
            </div>
        </div>
    </div>
</div><hr>

<!-- Sección para mostrar resultados de la búsqueda por código de usuario -->
<section id="codigo_usuario">
    <div class="container-fluid">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["codigo_usuario"])) {
                // Obtener el código de usuario del formulario
                $codigo_usuario = $_POST['codigo_usuario'];

                // Consulta SQL para buscar el usuario por código
                $sql = "SELECT * FROM usuarios2 WHERE codigo_usuario = '$codigo_usuario'";
                $resultado = $conexion->query($sql);
                $num_filas = $resultado->num_rows;

                if ($resultado->num_rows > 0) {
                    echo '<div class="alert alert-dark" role="alert">' . $num_filas . ' resultados de la búsqueda: ' . $codigo_usuario . '</div>';
                    // Mostrar los resultados en una tabla
echo "<table class='table table-dark' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
echo "<tr>";
echo "<th>ID Usuario</th>";
echo "<th>Código Usuario</th>";
echo "<th>Rol Usuario</th>";
echo "<th>Nombre Usuario</th>";
echo "<th>Acción</th>";
echo "</tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $fila["id_usuario"] . "</td>";
    echo "<td>" . $fila["codigo_usuario"] . "</td>";
    echo "<td>" . $fila["rol_usuario"] . "</td>";
    echo "<td>" . $fila["nombre_usuario"] . "</td>";
    echo "<td>";
    echo "<a href='usuario_editar.php?id_usuario=" . $fila['id_usuario'] . "' class='btn btn-primary'>Editar</a>";
    echo "<a href='eliminar_usuario.php?id_usuario=" . $fila['id_usuario'] . "' class='btn btn-danger' onclick='return confirmar()'>Eliminar</a>";
    echo "</td>";
    echo "</tr>";                    }
                    echo "</table>";
                } else {
                    echo '<div class="alert alert-danger">No se encontraron resultados de la búsqueda.</div>';
                }
            }
        }
        ?>
    </div>
</section>

<!-- Sección para mostrar todos los usuarios -->
<section id="usuarios">
    <div class="container-fluid">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['consultar_todos'])) {
            // Consulta SQL para obtener todos los usuarios
            $sql = "SELECT * FROM usuarios2";
            $resultado = $conexion->query($sql);
            $num_filas = $resultado->num_rows;

            if ($resultado->num_rows > 0) {
                echo '<div class="alert alert-dark" role="alert">' . $num_filas . ' resultados de la búsqueda</div>';
                // Mostrar los resultados en una tabla
echo "<table class='table table-dark' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
echo "<tr>";
echo "<th>ID Usuario</th>";
echo "<th>Código Usuario</th>";
echo "<th>Rol Usuario</th>";
echo "<th>Nombre Usuario</th>";
echo "<th>Acción</th>";
echo "</tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $fila["id_usuario"] . "</td>";
    echo "<td>" . $fila["codigo_usuario"] . "</td>";
    echo "<td>" . $fila["rol_usuario"] . "</td>";
    echo "<td>" . $fila["nombre_usuario"] . "</td>";
    echo "<td>";
    echo "<a href='usuario_editar.php?id_usuario=" . $fila['id_usuario'] . "' class='btn btn-primary'>Editar</a>";
    echo "<a href='eliminar_usuario.php?id_usuario=" . $fila['id_usuario'] . "' class='btn btn-danger' onclick='return confirmar()'>Eliminar</a>";
    echo "</td>";
    echo "</tr>";                }
                echo "</table>";
            } else {
                echo '<div class="alert alert-dark">No se encontraron resultados de la búsqueda.</div>';
            }
            $conexion->close();
        }
        ?>
    </div>
</section>

<!-- Script para mostrar/ocultar la contraseña -->
<script>
    function togglePassword(id) {
        const passwordSpan = document.getElementById('password_' + id);
        const icon = document.querySelector('#password_' + id).nextElementSibling;

        if (passwordSpan.style.display === 'none') {
            passwordSpan.style.display = 'inline';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordSpan.style.display = 'none';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>