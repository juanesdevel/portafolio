<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Cliente</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';

if(isset($_POST['submit'])){
    // Recoger datos del formulario
    $nom_cliente = $_POST['nom_cliente'];
    $doc_cliente = $_POST['doc_cliente'];
    $cel1_cliente = $_POST['cel1_cliente'];
    $cel2_cliente = $_POST['cel2_cliente'];
    $direccion_cliente = $_POST['direccion_cliente'];
    $correo_cliente = $_POST['correo_cliente'];

    // SQL para insertar los datos en la tabla clientes
    $sql_insertar = "INSERT INTO clientes (nom_cliente, doc_cliente, cel1_cliente, cel2_cliente, direccion_cliente, correo_cliente) 
                     VALUES ('$nom_cliente', '$doc_cliente', '$cel1_cliente', '$cel2_cliente', '$direccion_cliente', '$correo_cliente')";

    if ($conexion->query($sql_insertar) === TRUE) {
        echo '<script>alert("Datos guardados correctamente");location.assign("clientes.php");</script>';
    } else {
        echo "<script> alert('ERROR: Los datos no fueron ingresados a la base de datos'); location.assign('clientes.php'); </script>";
    }

    // Cerrar conexión
    $conexion->close();
} else {
    // Formulario para el nuevo cliente
?>

<body>
<div class="container mt-5">
    <div class="alert alert-info">
    <h3>Crear Cliente</h3>
    <a href="clientes.php" class="btn btn-dark">Regresar</a>
</div>
</div>
<section>
    <div class="container mt-5">
        <h3>Formulario de Nuevo Cliente</h3>
        <form id="formulario" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <div class="form-group">
                <label for="nom_cliente">Nombre Cliente (SOLO MAYÚSCULAS):</label>
                <input type="text" class="form-control" id="nom_cliente" name="nom_cliente" placeholder="NOMBRE CLIENTE" autocomplete="off" required onblur="validarNombreCliente()" oninput="convertirMayusculas(this)" style="text-transform: uppercase;">
                <small id="nombreClienteError" class="text-danger error" style="display: none;">El nombre debe contener SOLO LETRAS MAYÚSCULAS, sin números, caracteres especiales y debe tener máximo 50 caracteres.</small>
            </div>

            <div class="form-group">
                <label for="doc_cliente">Documento Cliente:</label>
                <input type="text" class="form-control" id="doc_cliente" name="doc_cliente" placeholder="Documento Cliente" autocomplete="off" onblur="validarDocumentoCliente()" required>
                <small id="documentoClienteError" class="text-danger error" style="display: none;">El documento debe contener solo números y máximo 10 caracteres.</small>
            </div>

            <div class="form-group">
                <label for="cel1_cliente">Celular 1 Cliente:</label>
                <input type="text" class="form-control" id="cel1_cliente" name="cel1_cliente" placeholder="Celular 1 Cliente" autocomplete="off" onblur="validarCelularCliente('cel1_cliente', 'cel1Error')" required>
                <small id="cel1Error" class="text-danger error" style="display: none;">El celular debe contener solo 10 números.</small>
            </div>

            <div class="form-group">
                <label for="cel2_cliente">Celular 2 Cliente:</label>
                <input type="text" class="form-control" id="cel2_cliente" name="cel2_cliente" placeholder="Celular 2 Cliente" autocomplete="off" onblur="validarCelularCliente('cel2_cliente', 'cel2Error')" required>
                <small id="cel2Error" class="text-danger error" style="display: none;">El celular debe contener solo 10 números.</small>
            </div>

            <div class="form-group">
                <label for="direccion_cliente">Dirección Cliente:</label>
                <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente" placeholder="Dirección Cliente" autocomplete="off" onblur="validarDireccionCliente()" required>
                <small id="direccionClienteError" class="text-danger error" style="display: none;">La dirección no debe contener caracteres especiales y debe tener máximo 100 caracteres.</small>
            </div>

            <div class="form-group">
                <label for="correo_cliente">Correo Cliente:</label>
                <input type="email" class="form-control" id="correo_cliente" name="correo_cliente" placeholder="Correo Cliente" autocomplete="off" onblur="validarCorreoCliente()" required>
                <small id="correoClienteError" class="text-danger error" style="display: none;">El correo debe tener arroba, un punto y no debe contener espacios.</small>
            </div>

            <button type="submit" class="btn btn-success" name="submit" onclick="return validarFormulario()">Crear Cliente</button>
            <button type="button" class="btn btn-secondary" onclick="borrarDatos()">Limpiar</button>
        </form>
    </div>
</section>

<?php
}
?>

<script>
// Función para convertir texto a mayúsculas automáticamente
function convertirMayusculas(input) {
    input.value = input.value.toUpperCase();
}

// Función para validar el nombre del cliente (solo mayúsculas)
function validarNombreCliente() {
    const nombre = document.getElementById('nom_cliente').value;
    const regex = /^[A-Z\s]{1,60}$/; // Solo letras MAYÚSCULAS y espacios, máximo 60 caracteres
    const error = document.getElementById('nombreClienteError');

    if (!regex.test(nombre)) {
        error.style.display = 'block';
        return false;
    } else {
        error.style.display = 'none';
        return true;
    }
}

// Función para validar el documento del cliente
function validarDocumentoCliente() {
    const documento = document.getElementById('doc_cliente').value;
    const regex = /^\d{1,10}$/; // Solo números, máximo 10 caracteres
    const error = document.getElementById('documentoClienteError');

    if (!regex.test(documento)) {
        error.style.display = 'block';
        return false;
    } else {
        error.style.display = 'none';
        return true;
    }
}

// Función para validar los números de celular
function validarCelularCliente(campo, errorId) {
    const celular = document.getElementById(campo).value;
    const regex = /^\d{10}$/; // Solo números, exactamente 10 dígitos
    const error = document.getElementById(errorId);

    if (!regex.test(celular)) {
        error.style.display = 'block';
        return false;
    } else {
        error.style.display = 'none';
        return true;
    }
}

// Función para validar la dirección del cliente
function validarDireccionCliente() {
    const direccion = document.getElementById('direccion_cliente').value;
    const regex = /^[A-Za-z0-9\s#,-]{1,100}$/; // Letras, números, espacios, #, ,-, , máximo 100 caracteres
    const error = document.getElementById('direccionClienteError');

    if (!regex.test(direccion)) {
        error.style.display = 'block';
        return false;
    } else {
        error.style.display = 'none';
        return true;
    }
}

// Función para validar el correo del cliente
function validarCorreoCliente() {
    const correo = document.getElementById('correo_cliente').value;
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Valida correo que contenga arroba y un punto, sin espacios
    const error = document.getElementById('correoClienteError');

    if (!regex.test(correo)) {
        error.style.display = 'block';
        return false;
    } else {
        error.style.display = 'none';
        return true;
    }
}

// Función para validar el formulario completo al enviar
function validarFormulario() {
    const nombreValido = validarNombreCliente();
    const documentoValido = validarDocumentoCliente();
    const cel1Valido = validarCelularCliente('cel1_cliente', 'cel1Error');
    const cel2Valido = validarCelularCliente('cel2_cliente', 'cel2Error');
    const direccionValida = validarDireccionCliente();
    const correoValido = validarCorreoCliente();

    return nombreValido && documentoValido && cel1Valido && cel2Valido && direccionValida && correoValido;
}

// Función para limpiar los datos del formulario
function borrarDatos() {
    document.getElementById('formulario').reset();
    document.querySelectorAll('.error').forEach(error => error.style.display = 'none');
}
</script>

</body>
</html>