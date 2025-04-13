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
    <title>Editar Producto</title>
  <!-- Bibliotecas necesarias para Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/css.css">
</head>

<body>
    <?php
    // Función para validar datos
    function validarDatos($ref, $cat, $desc, $valor, $unidades) {
        $errores = [];
        
        // Validar referencia (máximo 4 caracteres, números y letras en mayúsculas)
        if (!preg_match('/^[A-Z0-9]{1,4}$/', $ref)) {
            $errores[] = "La referencia debe tener máximo 4 caracteres (números y letras en mayúsculas)";
        }
        
        // Validar categoría (solo TECNOLOGIA o SOFTWARE)
        if ($cat != "TECNOLOGIA" && $cat != "SOFTWARE") {
            $errores[] = "La categoría debe ser TECNOLOGIA o SOFTWARE";
        }
        
        // Validar descripción (máximo 200 caracteres)
        if (strlen($desc) > 200) {
            $errores[] = "La descripción no debe superar los 200 caracteres";
        }
        
        // Validar valor (máximo 7 caracteres numéricos)
        if (!preg_match('/^[0-9]{1,7}$/', $valor)) {
            $errores[] = "El valor debe contener máximo 7 dígitos numéricos sin puntos ni comas";
        }
        
        // Validar unidades (máximo 2 caracteres numéricos)
        if (!preg_match('/^[0-9]{1,2}$/', $unidades)) {
            $errores[] = "Las unidades deben ser máximo 2 dígitos numéricos";
        }
        
        return $errores;
    }
     
    //consulta lo enviado 
    if(isset($_POST['submit'])){
        $id_producto = $_POST['id_producto'];
        $ref_producto = strtoupper($_POST['ref_producto']); // Convertir a mayúsculas
        $cat_producto = $_POST['cat_producto'];
        $descripcion_producto = $_POST['descripcion_producto'];
        $valor_producto = $_POST['valor_producto'];
        $unidades_producto = $_POST['unidades_producto'];
        
        // Validar los datos antes de actualizar
        $errores = validarDatos($ref_producto, $cat_producto, $descripcion_producto, $valor_producto, $unidades_producto);
        
        if (empty($errores)) {
            $sql = "UPDATE productos SET ref_producto='$ref_producto', cat_producto='$cat_producto', descripcion_producto='$descripcion_producto', valor_producto='$valor_producto', unidades_producto='$unidades_producto' WHERE id_producto='$id_producto'";
            
            $resultado = mysqli_query($conexion, $sql);
            if($resultado){
                echo "<script> alert ('Los datos fueron actualizados en la base de datos correctamente'); location.assign ('productos.php'); </script>";
            } else {
                echo "<script> alert ('ERROR: Los datos no fueron actualizados en la base de datos'); location.assign ('productos.php'); </script>";
            }

            // Cerrar conexión 
            mysqli_close($conexion);
        }
    }
    else{
        $id_producto = $_GET['id_producto'];
        $sql = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
        $resultado = mysqli_query($conexion, $sql);
        $fila = mysqli_fetch_assoc($resultado);
        $ref_producto = $fila["ref_producto"];
        $cat_producto = $fila["cat_producto"];
        $descripcion_producto = $fila["descripcion_producto"];
        $valor_producto = $fila["valor_producto"];
        $unidades_producto = $fila["unidades_producto"];
        mysqli_close($conexion);
        
        // Formulario para editar producto
    ?>
<div class="container">
    <div class="alert alert-info sombra">
        <h3>EDITAR PRODUCTO</h3>
        <a class="btn btn-dark" href="productos.php">Regresar</a><br><br>
    </div>
</div>

<div class="container">
    <?php
    // Mostrar errores de validación, si existen
    if (isset($errores) && !empty($errores)) {
        echo '<div class="alert alert-danger">';
        echo '<ul>';
        foreach ($errores as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
    ?>
    <form id="formulario" action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return validarFormulario()">
        <div class="form-group">
            <label for="ref_producto">Referencia del Producto (máx. 4 caracteres, mayúsculas):</label><br>
            <input type="text" id="ref_producto" name="ref_producto" class="form-control" value="<?php echo $ref_producto; ?>" maxlength="4" required>
            <small class="form-text text-muted">Máximo 4 caracteres alfanuméricos en mayúsculas</small>
        </div>
        
        <div class="form-group">
            <label for="cat_producto">Categoría del Producto:</label><br>
            <select id="cat_producto" name="cat_producto" class="form-control" required>
                <option value="TECNOLOGIA" <?php if($cat_producto=="TECNOLOGIA") echo "selected"; ?>>TECNOLOGIA</option>
                <option value="SOFTWARE" <?php if($cat_producto=="SOFTWARE") echo "selected"; ?>>SOFTWARE</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="descripcion_producto">Descripción del Producto:</label><br>
            <textarea id="descripcion_producto" name="descripcion_producto" class="form-control" maxlength="200" required><?php echo $descripcion_producto; ?></textarea>
            <small class="form-text text-muted">Máximo 200 caracteres</small>
            <div id="contador">0/200</div>
        </div>
        
        <div class="form-group">
            <label for="valor_producto">Valor del Producto:</label><br>
            <input type="text" id="valor_producto" name="valor_producto" class="form-control" value="<?php echo $valor_producto; ?>" maxlength="7" required>
            <small class="form-text text-muted">Máximo 7 dígitos numéricos (sin puntos ni comas)</small>
        </div>
        
        <div class="form-group">
            <label for="unidades_producto">Unidades del Producto:</label><br>
            <input type="text" id="unidades_producto" name="unidades_producto" class="form-control" value="<?php echo $unidades_producto; ?>" maxlength="2" required>
            <small class="form-text text-muted">Máximo 2 dígitos numéricos</small>
        </div>
        
        <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
        
        <button type="submit" name="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<script>
    // Actualizar contador de caracteres para la descripción
    document.addEventListener('DOMContentLoaded', function() {
        const descripcion = document.getElementById('descripcion_producto');
        const contador = document.getElementById('contador');
        
        function actualizarContador() {
            contador.textContent = descripcion.value.length + '/200';
            if (descripcion.value.length > 200) {
                contador.style.color = 'red';
            } else {
                contador.style.color = 'inherit';
            }
        }
        
        actualizarContador(); // Inicializa el contador
        descripcion.addEventListener('input', actualizarContador);
    });
    
    // Validación del formulario del lado del cliente
    function validarFormulario() {
        const ref = document.getElementById('ref_producto').value;
        const valor = document.getElementById('valor_producto').value;
        const unidades = document.getElementById('unidades_producto').value;
        const descripcion = document.getElementById('descripcion_producto').value;
        
        // Validar referencia (máximo 4 caracteres, letras y números en mayúsculas)
        if (!/^[A-Z0-9]{1,4}$/.test(ref)) {
            alert('La referencia debe tener máximo 4 caracteres (números y letras en mayúsculas)');
            return false;
        }
        
        // Validar descripción (máximo 200 caracteres)
        if (descripcion.length > 200) {
            alert('La descripción no debe superar los 200 caracteres');
            return false;
        }
        
        // Validar valor (máximo 7 caracteres numéricos)
        if (!/^[0-9]{1,7}$/.test(valor)) {
            alert('El valor debe contener máximo 7 dígitos numéricos sin puntos ni comas, ni letras');
            return false;
        }
        
        // Validar unidades (máximo 2 caracteres numéricos)
        if (!/^[0-9]{1,2}$/.test(unidades)) {
            alert('Las unidades deben ser máximo 2 dígitos numéricos');
            return false;
        }
        
        return true;
    }
</script>

<?php
    }
?>
</body>
</html>