<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php
include '../conexion/conexion.php';
include '../conexion/sesion.php';

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

if(isset($_POST['submit'])){
    // Recoger datos del formulario
    $ref_producto = strtoupper($_POST['ref_producto']); // Convertir a mayúsculas
    $cat_producto = $_POST['cat_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $valor_producto = $_POST['valor_producto'];
    $unidades_producto = $_POST['unidades_producto'];

    // Validar los datos antes de insertar
    $errores = validarDatos($ref_producto, $cat_producto, $descripcion_producto, $valor_producto, $unidades_producto);
    
    if (empty($errores)) {
        // SQL para insertar los datos en la tabla productos
        $sql_insertar = "INSERT INTO productos (ref_producto, cat_producto, descripcion_producto, valor_producto, unidades_producto) VALUES ('$ref_producto', '$cat_producto', '$descripcion_producto', $valor_producto, '$unidades_producto')";

        if ($conexion->query($sql_insertar) === TRUE) {
            echo '<script>alert("Datos guardados correctamente");location.assign("productos.php");</script>';
        } else {
            echo "<script> alert ('ERROR: Los datos no fueron ingresados a la base de datos'); location.assign ('productos.php'); </script>";
        }
    }
    $conexion->close();
} else {
?>
<body>
<div class="container">
    <div class="alert alert-info">
    <h3>Crear Producto</h3>
    <a href="productos.php" class="btn btn-dark">Regresar</a>
    </div>
</div>
  
<section>
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
    <form id="formulario" action="<?=$_SERVER['PHP_SELF']?>" method="post">
      <div class="form-group">
        <input type="hidden" class="form-control" id="id_producto" name="id_producto" placeholder="ID Producto" autocomplete="off">
      </div>
      
      <div class="form-group">
        <label for="ref_producto">Referencia Producto (máx. 4 caracteres, mayúsculas):</label>
        <input type="text" class="form-control" id="ref_producto" name="ref_producto" placeholder="Referencia Producto" maxlength="4" autocomplete="off" required>
        <small class="form-text text-muted">Máximo 4 caracteres alfanuméricos en mayúsculas</small>
      </div>
      
      <div class="form-group">
        <label for="cat_producto">Categoría Producto:</label>
        <select class="form-control" id="cat_producto" name="cat_producto" required>
            <option value="">Seleccione una categoría</option>
            <option value="TECNOLOGIA">TECNOLOGIA</option>
            <option value="SOFTWARE">SOFTWARE</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="descripcion_producto">Descripción Producto:</label>
        <textarea class="form-control" id="descripcion_producto" name="descripcion_producto" placeholder="Descripción Producto" maxlength="200" autocomplete="off" required></textarea>
        <small class="form-text text-muted">Máximo 200 caracteres</small>
        <div id="contador">0/200</div>
      </div>

      <div class="form-group">
        <label for="valor_producto">Valor Producto:</label>
        <input type="text" class="form-control" id="valor_producto" name="valor_producto" placeholder="Valor Producto" maxlength="7" autocomplete="off" required>
        <small class="form-text text-muted">Máximo 7 dígitos numéricos (sin puntos ni comas)</small>
      </div>
      
      <div class="form-group">
        <label for="unidades_producto">Unidades Producto:</label>
        <input type="text" class="form-control" id="unidades_producto" name="unidades_producto" placeholder="Unidades Producto" maxlength="2" autocomplete="off" required>
        <small class="form-text text-muted">Máximo 2 dígitos numéricos</small>
      </div>
      
      <button type="submit" class="btn btn-success" name="submit" onclick="return validarCampos() && confirmarCreacion();">Crear Producto</button>
      <button type="button" class="btn btn-secondary" onclick="confirmacionBorrardatos() && borrarDatos()">Limpiar</button>
    </form>
  </div>

  <?php
  }
  ?>
  
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
    
    function validarCampos() {
      var ref_producto = document.getElementById("ref_producto").value;
      var cat_producto = document.getElementById("cat_producto").value;
      var descripcion_producto = document.getElementById("descripcion_producto").value;
      var valor_producto = document.getElementById("valor_producto").value;
      var unidades_producto = document.getElementById("unidades_producto").value;

      // Validar que no haya campos vacíos
      if (ref_producto === "" || cat_producto === "" || descripcion_producto === "" || valor_producto === "" || unidades_producto === "") {
        alert("Debe llenar todos los campos.");
        return false;
      }
      
      // Validar referencia (máximo 4 caracteres, letras y números en mayúsculas)
      if (!/^[A-Z0-9]{1,4}$/.test(ref_producto)) {
          alert('La referencia debe tener máximo 4 caracteres (números y letras en mayúsculas)');
          return false;
      }
      
      // Validar descripción (máximo 200 caracteres)
      if (descripcion_producto.length > 200) {
          alert('La descripción no debe superar los 200 caracteres');
          return false;
      }
      
      // Validar valor (máximo 7 caracteres numéricos)
      if (!/^[0-9]{1,7}$/.test(valor_producto)) {
          alert('El valor debe contener máximo 7 dígitos numéricos sin puntos ni comas');
          return false;
      }
      
      // Validar unidades (máximo 2 caracteres numéricos)
      if (!/^[0-9]{1,2}$/.test(unidades_producto)) {
          alert('Las unidades deben ser máximo 2 dígitos numéricos');
          return false;
      }
      
      return true;
    }
    
    function borrarDatos() {
      document.getElementById("formulario").reset();
      document.getElementById("contador").textContent = "0/200";
      return false; // Para evitar el envío del formulario
    }
    
    function confirmacionBorrardatos() {
      return confirm("¿Estás seguro que deseas limpiar el formulario?");
    }
    
    function confirmarCreacion() {
      return confirm("¿Estás seguro de crear el nuevo producto?");
    }
  </script>
</section>
</body>
</html>