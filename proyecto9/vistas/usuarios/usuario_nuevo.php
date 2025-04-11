<?php
include ("../../conexion/conexion.php");
include ("../../conexion/sesion.php");

$errors = [];
$formData = [
    'codigoUsuario' => '',
    'rolUsuario' => 'bloqueado',
    'nombreUsuario' => ''
];

if(isset($_POST['submit'])){
    // Recoger y limpiar datos del formulario
    $formData['codigoUsuario'] = filter_input(INPUT_POST, 'codigoUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $formData['rolUsuario'] = filter_input(INPUT_POST, 'rolUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $formData['nombreUsuario'] = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW); // Raw for validation, will be hashed

    // Validar datos
    if (!preg_match('/^\d{4}$/', $formData['codigoUsuario'])) {
        $errors['codigoUsuario'] = "El código debe ser un número de 4 dígitos.";
    }
    
    if (!in_array($formData['rolUsuario'], ['bloqueado', 'asesor', 'admin'])) {
        $errors['rolUsuario'] = "Rol de usuario no válido.";
    }
    
    if (!preg_match('/^[A-Za-z\s]{1,40}$/', $formData['nombreUsuario'])) {
        $errors['nombreUsuario'] = "El nombre no debe contener números, ni caracteres especiales y debe tener máximo 40 caracteres.";
    }
    
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,12}$/', $password)) {
        $errors['password'] = "La contraseña debe contener entre 4 y 12 caracteres, incluyendo números y letras.";
    }

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Store hashed password
        $sql_insertar = "INSERT INTO usuarios2 (codigo_usuario, rol_usuario, nombre_usuario, contrasena_usuario) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql_insertar);
        $stmt->bind_param("ssss", $formData['codigoUsuario'], $formData['rolUsuario'], $formData['nombreUsuario'], $hashed_password);

        try {
            if ($stmt->execute()) {
                header("Location: usuarios.php?success=1");
                exit;
            } else {
                $errors['db'] = "ERROR: Los datos no fueron ingresados a la base de datos.";
            }
        } catch (Exception $e) {
            $errors['db'] = "Error en la base de datos: " . $e->getMessage();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body { background-color: #121212; color: #e0e0e0; }
        .form-control { background-color: #333; color: #e0e0e0; border: 1px solid #555; }
        .form-control:focus { background-color: #444; color: #e0e0e0; border-color: #666; }
        label { color: #bdbdbd; }
        .alert-success, .alert-danger { background-color: #333; color: #e0e0e0; border-color: #424242; }
        .error-message { color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem; }
    </style>
</head>
<body>
    <hr>
    <div class="container mt-2">
        <a class="btn btn-dark" href="usuarios.php">Regresar</a>
    </div>
    <hr>
    <div class="container mt-5">
        <h2 style="color: #198754;">Agregar Registro</h2>
        <hr>
        
        <?php if (!empty($errors['db'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($errors['db']); ?>
        </div>
        <?php endif; ?>
        
        <div class="container mt-5">
            <form id="formulario" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                <div class="form-group mb-3">
                    <label for="nombreUsuario">Nombre de Usuario:</label>
                    <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" 
                           value="<?= htmlspecialchars($formData['nombreUsuario']) ?>"
                           placeholder="Nombre de usuario" autocomplete="off" required>
                    <?php if (!empty($errors['nombreUsuario'])): ?>
                        <div class="error-message"><?= htmlspecialchars($errors['nombreUsuario']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group mb-3">
                    <label for="codigoUsuario">Código de Usuario:</label>
                    <input type="text" class="form-control" id="codigoUsuario" name="codigoUsuario" 
                           value="<?= htmlspecialchars($formData['codigoUsuario']) ?>"
                           placeholder="0000" autocomplete="off" required>
                    <?php if (!empty($errors['codigoUsuario'])): ?>
                        <div class="error-message"><?= htmlspecialchars($errors['codigoUsuario']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group mb-3">
                    <label for="rolUsuario">Rol de Usuario:</label>
                    <select class="form-control" id="rolUsuario" name="rolUsuario" required>
                        <option value="bloqueado" <?= $formData['rolUsuario'] === 'bloqueado' ? 'selected' : '' ?>>Bloqueado</option>
                        <option value="asesor" <?= $formData['rolUsuario'] === 'asesor' ? 'selected' : '' ?>>Asesor</option>
                        <option value="admin" <?= $formData['rolUsuario'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                    <?php if (!empty($errors['rolUsuario'])): ?>
                        <div class="error-message"><?= htmlspecialchars($errors['rolUsuario']) ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group mb-3">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Contraseña" autocomplete="off" required>
                    <?php if (!empty($errors['password'])): ?>
                        <div class="error-message"><?= htmlspecialchars($errors['password']) ?></div>
                    <?php endif; ?>
                    <small class="form-text text-muted">La contraseña debe contener entre 4 y 12 caracteres, incluyendo números y letras.</small>
                </div>
                
                <button type="submit" class="btn btn-success" name="submit">Crear Usuario</button>
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
    </div>
</body>
</html>