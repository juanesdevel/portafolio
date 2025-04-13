<?php
// Incluir el archivo de conexión a la base de datos y el archivo de seguridad de sesión
include '../conexion/conexion.php';
include '../conexion/sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <!-- Bibliotecas necesarias para Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/css.css">

</head>
<body>
<?php
// Consulta SQL para obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexion, $sql);
?>
    <!-- Encabezado de la página -->
    <div class="container-fluid alert alert-info sombra">
        <div class="row">
            <div class="col-8">
               <h1>Gestión de Usuarios</h1>
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

<!-- Botones de acción -->
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <a href="#" class="btn btn-primary" onclick="location.reload();">Actualizar página</a>
            <a href="nuevo_usuario.php" class="btn btn-success">Nuevo Usuario</a>
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
                $sql = "SELECT * FROM usuarios WHERE codigo_usuario = '$codigo_usuario'";
                $resultado = $conexion->query($sql);
                $num_filas = $resultado->num_rows;

                if ($resultado->num_rows > 0) {
                    echo '<div class="alert alert-success" role="alert">' . $num_filas . ' resultados de la búsqueda: ' . $codigo_usuario . '</div>';
                    // Mostrar los resultados en una tabla
echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
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
    echo "<a href='editar_usuario.php?id_usuario=" . $fila['id_usuario'] . "' class='btn btn-primary'>Editar</a>";
    echo "<a href='../procesos_factura_admin/eliminar_usuario.php?id_usuario=" . $fila['id_usuario'] . "' class='btn btn-danger' onclick='return confirmar()'>Eliminar</a>";
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
            $sql = "SELECT * FROM usuarios";
            $resultado = $conexion->query($sql);
            $num_filas = $resultado->num_rows;

            if ($resultado->num_rows > 0) {
                echo '<div class="alert alert-success" role="alert">' . $num_filas . ' resultados de la búsqueda</div>';
                // Mostrar los resultados en una tabla
echo "<table class='table table-striped' style='border-collapse: collapse; width: 100%;'>"; // Quitar table-bordered y style='border: 1px solid #000;'
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
    echo "<a href='editar_usuario.php?id_usuario=" . $fila['id_usuario'] . "' class='btn btn-primary'>Editar</a>";
    echo "<a href='../procesos_factura_admin/eliminar_usuario.php?id_usuario=" . $fila['id_usuario'] . "' class='btn btn-danger' onclick='return confirmar()'>Eliminar</a>";
    echo "</td>";
    echo "</tr>";                }
                echo "</table>";
            } else {
                echo '<div class="alert alert-danger">No se encontraron resultados de la búsqueda.</div>';
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