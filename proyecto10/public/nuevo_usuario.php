<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../conexion/conexion.php';
include '../conexion/sesion.php';

if(isset($_POST['submit'])){
    // Recoger datos del formulario (sin limpieza agresiva aquí)
    $codigo = filter_input(INPUT_POST, 'codigoUsuario', FILTER_SANITIZE_NUMBER_INT);
    $rol = $_POST['rolUsuario'];
    $nombre = $_POST['nombreUsuario'];
    $password = $_POST['password']; // Password sin hashear AÚN

    // Validar datos
    $errors = [];
    if (!preg_match('/^\d{4}$/', $codigo)) {
        $errors[] = "El código debe ser un número de 4 dígitos.";
    }
    if (!in_array($rol, ['bloqueado', 'asesor', 'admin'])) {
        $errors[] = "Rol de usuario no válido.";
    }
    if (!preg_match('/^[A-Za-z\s]{1,40}$/', $nombre)) {
        $errors[] = "El nombre no debe contener números, ni caracteres especiales y debe tener máximo 40 caracteres.";
    }
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,12}$/', $password)) {
        $errors[] = "La contraseña debe contener entre 4 y 12 caracteres, incluyendo números y letras.";
    }

    if (empty($errors)) {
        // **Hashear la contraseña antes de guardarla**
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql_insertar = "INSERT INTO usuarios (codigo_usuario, rol_usuario, nombre_usuario, contrasena_usuario) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insertar);
        $stmt->bind_param("ssss", $codigo, $rol, $nombre, $hashedPassword);

        if ($stmt->execute()) {
            echo '<script>alert("Datos guardados correctamente"); location.assign("usuarios.php");</script>';
        } else {
            echo "<script>alert('ERROR: Los datos no fueron ingresados a la base de datos'); location.assign('usuario.php');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Errores de validación:\\n" . implode("\\n", $errors) . "');</script>";
    }

    $conn->close();
} else {

?>

<?php
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-info">
        <h3>Crear Usuario</h3>
        <a class="btn btn-dark" href="usuarios.php">Regresar</a>
    </div>
</div>

<div class="container mt-5">
    <form id="formulario" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="form-group">
            <label for="nombreUsuario">Nombre de Usuario:</label>
            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Nombre de usuario" autocomplete="off" required>
            <small id="nombreUsuarioError" class="form-text text-danger"></small>
        </div>

        <div class="form-group">
            <label for="codigoUsuario">Código de Usuario:</label>
            <input type="text" class="form-control" id="codigoUsuario" name="codigoUsuario" placeholder="0000" autocomplete="off" required>
            <small id="codigoUsuarioError" class="form-text text-danger"></small>
        </div>

        <div class="form-group">
            <label for="rolUsuario">Rol de Usuario:</label>
            <select class="form-control" id="rolUsuario" name="rolUsuario" required>
                <option value="bloqueado">Bloqueado</option>
                <option value="asesor">Asesor</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" autocomplete="off" required>
            <small id="passwordError" class="form-text text-danger"></small>
        </div>

        <button type="submit" class="btn btn-success" name="submit">Crear Usuario</button>
        <button type="reset" class="btn btn-secondary">Limpiar</button>
    </form>
</div>

<script>
document.getElementById('formulario').addEventListener('submit', function(event) {
    let isValid = true;
    const nombreUsuario = document.getElementById('nombreUsuario');
    const codigoUsuario = document.getElementById('codigoUsuario');
    const password = document.getElementById('password');

    // Validar nombre de usuario
    if (!/^[A-Za-z\s]{1,40}$/.test(nombreUsuario.value)) {
        document.getElementById('nombreUsuarioError').textContent = 'El nombre no debe contener números, ni caracteres especiales y debe tener máximo 40 caracteres.';
        isValid = false;
    } else {
        document.getElementById('nombreUsuarioError').textContent = '';
    }

    // Validar código de usuario
    if (!/^\d{4}$/.test(codigoUsuario.value)) {
        document.getElementById('codigoUsuarioError').textContent = 'El código debe ser un número de 4 dígitos.';
        isValid = false;
    } else {
        document.getElementById('codigoUsuarioError').textContent = '';
    }

    // Validar contraseña
    if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,12}$/.test(password.value)) {
        document.getElementById('passwordError').textContent = 'La contraseña debe contener entre 4 y 12 caracteres, incluyendo números y letras.';
        isValid = false;
    } else {
        document.getElementById('passwordError').textContent = '';
    }

    if (!isValid) {
        event.preventDefault();
    } else if (!confirm('¿Estás seguro de crear el nuevo usuario?')) {
        event.preventDefault();
    }
});
</script>
</body>
</html>