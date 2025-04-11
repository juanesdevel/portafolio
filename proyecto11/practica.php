<?php
// $i = 1;
// do {
//     echo "El número es: " . $i . "<br>";
//     $i++;
// } while ($i <= 100);


// for ($i = 1; $i <= 5; $i++) {
//     echo "El número es: " . $i . "<br>";
// }


// $colores = array("rojo", "verde", "azul");

// foreach ($colores as $color) {
//     echo "El color es: " . $color . "<br>";
// }

$persona = array("nombre" => "Juan", "edad" => 30, "ciudad" => "Medellín");

foreach ($persona as $clave => $valor) {
    echo $clave . ": " . $valor . "<br>";
}
?>


