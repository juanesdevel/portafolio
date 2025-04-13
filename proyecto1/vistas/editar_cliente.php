<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
      <!-- Bibliotecas necesarias para Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/css.css">
    <style>
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 0;
            border: 1px solid #ccc;
        }
        hr {
            border-top: 1px solid #17a2b8;
        }
    </style>
</head>
<body>
    <?php
    // condicional para consulta
    if(isset($_POST['submit'])){
        $id_cliente = $_POST['idCliente'];
        $nom_cliente = $_POST['nom_cliente'];
        $doc_cliente = $_POST['doc_cliente'];
        $cel1_cliente = $_POST['cel1_cliente'];
        $cel2_cliente = $_POST['cel2_cliente'];
        $direccion_cliente = $_POST['direccion_cliente'];
        $correo_cliente = $_POST['correo_cliente'];
    // consulta
        $sql = "UPDATE clientes SET nom_cliente='$nom_cliente', doc_cliente='$doc_cliente', cel1_cliente='$cel1_cliente', cel2_cliente='$cel2_cliente', direccion_cliente='$direccion_cliente', correo_cliente='$correo_cliente' WHERE id_cliente='$id_cliente'";

        $resultado = mysqli_query($conexion, $sql);
        if($resultado){
            echo "<script> alert ('Los datos fueron actualizados en la base de datos correctamente'); location.assign ('clientes.php'); </script>";
        } else {
            echo "<script> alert ('ERROR: Los datos no fueron actualizados en la base de datos'); location.assign ('clientes.php'); </script>";
        }
    // Cerrar conexión
    mysqli_close($conexion);

    }
    // condicional para consulta
    else{
        $id_cliente = $_GET['id_cliente'];
        $sql = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente'";
        $resultado = mysqli_query($conexion, $sql);
        $fila = mysqli_fetch_assoc($resultado);
        $nom_cliente = $fila["nom_cliente"];
        $doc_cliente = $fila["doc_cliente"];
        $cel1_cliente = $fila["cel1_cliente"];
        $cel2_cliente = $fila["cel2_cliente"];
        $direccion_cliente = $fila["direccion_cliente"];
        $correo_cliente = $fila["correo_cliente"];
        mysqli_close($conexion);
    // formulario para actualización       
    ?>

    <div class="container mt-4">
        <div class="alert alert-info sombra">
            <h3 class="mb-0">Editar Cliente</h3>
            <a href="clientes.php" class="btn btn-dark mb-3">Regresar</a>
        </div>
        <hr>
        <section>
            <div class="container">
                <form id="formulario" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                    <input type="hidden" name="idCliente" value="<?php echo $id_cliente; ?>">
                    
                    <div class="form-group">
                        <label for="nom_cliente">Nombre Cliente (SOLO MAYÚSCULAS):</label>
                        <input type="text" class="form-control" id="nom_cliente" name="nom_cliente" placeholder="NOMBRE CLIENTE" autocomplete="off" value="<?php echo $nom_cliente; ?>" required onblur="validarNombreCliente()" oninput="convertirMayusculas(this)" style="text-transform: uppercase;">
                        <div id="nombreClienteError" class="error" style="display: none;">El nombre debe contener SOLO LETRAS MAYÚSCULAS, sin números, caracteres especiales y debe tener máximo 50 caracteres.</div>
                    </div>

                    <div class="form-group">
                        <label for="doc_cliente">Documento Cliente:</label>
                        <input type="text" class="form-control" id="doc_cliente" name="doc_cliente" placeholder="Documento Cliente" autocomplete="off" onblur="validarDocumentoCliente()" required value="<?php echo $doc_cliente; ?>">
                        <div id="documentoClienteError" class="error" style="display: none;">El documento debe contener solo números y máximo 10 caracteres.</div>
                    </div>

                    <div class="form-group">
                        <label for="cel1_cliente">Celular 1 Cliente:</label>
                        <input type="text" class="form-control" id="cel1_cliente" name="cel1_cliente" placeholder="Celular 1 Cliente" autocomplete="off" onblur="validarCelularCliente('cel1_cliente', 'cel1Error')" required value="<?php echo $cel1_cliente; ?>">
                        <div id="cel1Error" class="error" style="display: none;">El celular debe contener solo 10 números.</div>
                    </div>

                    <div class="form-group">
                        <label for="cel2_cliente">Celular 2 Cliente:</label>
                        <input type="text" class="form-control" id="cel2_cliente" name="cel2_cliente" placeholder="Celular 2 Cliente" autocomplete="off" onblur="validarCelularCliente('cel2_cliente', 'cel2Error')" required value="<?php echo $cel2_cliente; ?>">
                        <div id="cel2Error" class="error" style="display: none;">El celular debe contener solo 10 números.</div>
                    </div>

                    <div class="form-group">
                        <label for="direccion_cliente">Dirección Cliente:</label>
                        <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente" placeholder="Dirección Cliente" autocomplete="off" onblur="validarDireccionCliente()" required value="<?php echo $direccion_cliente; ?>">
                        <div id="direccionClienteError" class="error" style="display: none;">La dirección no debe contener caracteres especiales y debe tener máximo 100 caracteres.</div>
                    </div>

                    <div class="form-group">
                        <label for="correo_cliente">Correo Cliente:</label>
                        <input type="email" class="form-control" id="correo_cliente" name="correo_cliente" placeholder="Correo Cliente" autocomplete="off" onblur="validarCorreoCliente()" required value="<?php echo $correo_cliente; ?>">
                        <div id="correoClienteError" class="error" style="display: none;">El correo debe tener arroba, un punto y no debe contener espacios.</div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-primary" name="submit" onclick="return validarFormulario()">ACTUALIZAR</button>
                </form>
            </div>
        </section>
    </div>
    <?php
    }
    ?>

    <script>
    // Función para convertir texto a mayúsculas automáticamente
    function convertirMayusculas(input) {
        input.value = input.value.toUpperCase();
    }

    // Función para validar el nombre del cliente
    function validarNombreCliente() {
        const nombre = document.getElementById('nom_cliente').value;
        const regex = /^[A-Z\s]{1,50}$/; // Solo letras MAYÚSCULAS y espacios, máximo 50 caracteres
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
        document.getElementById("formulario").reset();
        let errores = document.querySelectorAll('.error');
        for (let error of errores) {
            error.style.display = 'none';  // Ocultar todos los errores al limpiar el formulario
        }
    }
    </script>
</body>
</html>