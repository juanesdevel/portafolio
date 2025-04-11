<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso de números</title>
</head>
<body>
    <h2>Ingresa dos números</h2>
    <form action="array.php" method="post">
       
          <label for="dia">seleccionador de días:</label>
        <select name="dia" id="dia" required>
            <option value="">Selecciona un día</option>
            <option value="lunes">lunes</option>
            <option value="martes">martes</option>
            <option value="miercoles">miercoles</option>
            <option value="jueves">jueves</option>
            <option value="viernes">viernes</option>
            <option value="sabado">sabado</option>
            <option value="domingo">domingo</option>
        </select><br><br>
        
<h2>Resultado es: 

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dia = $_POST["dia"];


    switch ($dia){
        case "lunes":
            echo "Haz seleccionado el día " . $dia;        
            break;
        case "martes":
            echo "Haz seleccionado el día " . $dia;        
        case "miercoles":
            echo "Haz seleccionado el día " . $dia;        
            break;
        case "jueves":
             echo "Haz seleccionado el día " . $dia;
             break;
        case "viernes":
            echo "Haz seleccionado el día " . $dia;
            break;
        case "sabado":
            echo "Haz seleccionado el día " . $dia;
            break;
        case "domingo":
            echo "Haz seleccionado el día " . $dia;
            break;
     default:
            echo "no seleccionaste ningún día";
            break;
    }
}
?>
         <input type="submit" value="Seleccionar">

</body>
</html>

