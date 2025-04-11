<?php
// Incluir el archivo de conexión a la base de datos
include("../../conexion/conexion.php");

// Verificar si se recibió el ID por GET
if (isset($_GET['id'])) {
    $id = $conexion->real_escape_string($_GET['id']);

    // Consulta SQL para eliminar el registro
    $sql = "DELETE FROM balance WHERE id = '$id'";

    if ($conexion->query($sql) === TRUE) {
        // Registro eliminado con éxito
        echo "<script>
                    alert('Registro de balance eliminado correctamente.');
                    window.location.href = 'balance.php';
                </script>";
    } else {
        // Error al eliminar el registro
        echo "<script>
                    alert('Error al eliminar el registro de balance: " . $conexion->error . "');
                    window.location.href = 'balance.php';
                </script>";
    }
} else {
    // ID no recibido
    echo "<script>
                alert('ID de balance no válido.');
                window.location.href = 'balance.php';
            </script>";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>