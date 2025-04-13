<?php
// Incluir archivos de conexión y sesión
include '../conexion/conexion.php';
include '../conexion/sesion.php';

// Array para almacenar errores de validación
$errors = [];

if(isset($_POST['submit'])){
    // Obtener datos del formulario
    $id_usuario = $_POST['idUsuario'];
    $codigo = $_POST['codigoUsuario'];
    $nombre = $_POST['nombreUsuario'];
    $password = $_POST['password']; // Contraseña principal
    $confirm_password = $_POST['confirm_password']; // Confirmación de contraseña
    $rol = $_POST['rolUsuario'];

    // Validación de entrada 
    if (!preg_match('/^[A-Za-z\s]{1,40}$/', $nombre)) {
        $errors[] = "El nombre no debe contener números, ni caracteres especiales y debe tener máximo 40 caracteres.";
    }
    if (!preg_match('/^\d{4}$/', $codigo)) {
        $errors[] = "El código debe ser un número de 4 dígitos.";
    }
    if (!in_array($rol, ['bloqueado', 'asesor', 'admin'])) {
        $errors[] = "Rol de usuario no válido.";
    }
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,12}$/', $password)) {
        $errors[] = "La contraseña debe contener entre 4 y 12 caracteres, incluyendo números y letras.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Las contraseñas no coinciden.";
    }

    if (empty($errors)) {
        // Hashear la contraseña usando password_hash()
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta SQL con contraseña hasheada
        $sql = "UPDATE usuarios SET nombre_usuario=?, rol_usuario=?, codigo_usuario=?, contrasena_usuario=? WHERE id_usuario=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $rol, $codigo, $hashed_password, $id_usuario);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Los datos fueron actualizados correctamente'); location.assign('usuarios.php');</script>";
        } else {
            // Mostrar error específico para depuración
            echo "<script>alert('ERROR: Los datos no fueron actualizados. Detalle: " . $stmt->error . "'); location.assign('usuarios.php');</script>";
        }
        $stmt->close();
    } else {
        // Mostrar errores de validación
        echo "<script>alert('Errores de validación:\\n" . implode("\\n", $errors) . "');</script>";
    }
} else {
    // Si no es un envío de formulario, obtenemos los datos del usuario
    $id_usuario = $_GET['id_usuario'];
    $sql = "SELECT * FROM usuarios WHERE id_usuario=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    $nombre = $fila["nombre_usuario"];
    $rol = $fila["rol_usuario"];
    $codigo = $fila["codigo_usuario"];
    $password_actual = ''; // No mostrar la contraseña hasheada
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
      <!-- Bibliotecas necesarias para Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/css.css">
</head>
<body>
    <div class="container mt-4">
        <div class="alert alert-info sombra">
            <h3>Editar Usuario</h3>
            <a href="usuarios.php" class="btn btn-dark">Regresar</a>
        </div>
        
        <form id="formulario" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form-group">
                <label for="nombreUsuario">Nombre de Usuario:</label>
                <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" value="<?= $nombre ?>" required>
                <small id="nombreUsuarioError" class="form-text text-danger"></small>
            </div>
            
            <div class="form-group">
                <label for="codigoUsuario">Código de Usuario:</label>
                <input type="text" class="form-control" id="codigoUsuario" name="codigoUsuario" value="<?= $codigo ?>" required>
                <small id="codigoUsuarioError" class="form-text text-danger"></small>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña Nueva:</label>
                <input type="password" class="form-control" id="password" name="password">
                <small id="passwordError" class="form-text text-danger"></small>
                <small class="form-text text-muted">Debe contener entre 4 y 12 caracteres, incluyendo números y letras.</small>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmar Contraseña:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                <small id="confirmPasswordError" class="form-text text-danger"></small>
            </div>
            
            <div class="form-group">
                <label for="rolUsuario">Rol de Usuario:</label>
                <select class="form-control" id="rolUsuario" name="rolUsuario" required>
                    <option value="bloqueado" <?= $rol == 'bloqueado' ? 'selected' : '' ?>>Bloqueado</option>
                    <option value="asesor" <?= $rol == 'asesor' ? 'selected' : '' ?>>Asesor</option>
                    <option value="admin" <?= $rol == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            
            <input type="hidden" name="idUsuario" value="<?= $id_usuario ?>">
            
            <button class="btn btn-primary" type="submit" name="submit">Actualizar</button>
        </form>
    </div>

    <script>
    // Script para validación del lado del cliente
    document.getElementById('formulario').addEventListener('submit', function(event) {
        let isValid = true;
        const nombreUsuario = document.getElementById('nombreUsuario');
        const codigoUsuario = document.getElementById('codigoUsuario');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');

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
        
        // Validar que las contraseñas coincidan
        if (password.value !== confirmPassword.value) {
            document.getElementById('confirmPasswordError').textContent = 'Las contraseñas no coinciden.';
            isValid = false;
        } else {
            document.getElementById('confirmPasswordError').textContent = '';
        }

        // Si hay errores, se previene el envío del formulario
        if (!isValid) {
            event.preventDefault();
        } else if (!confirm('¿Estás seguro de actualizar este usuario?')) {
            // Pedir confirmación antes de actualizar
            event.preventDefault();
        }
    });
    </script>
</body>
</html>