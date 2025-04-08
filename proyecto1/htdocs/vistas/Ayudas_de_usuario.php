<?php
// Incluir el archivo de seguridad de sesión
include '../conexion/conexion.php';
include '../conexion/sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Administrador</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .mensaje {
            text-align: right;
            margin-left: 20px;
        }
        .sombra {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>  
</head>
<body>
<div class="container-fluid alert alert-info sombra">
    <h1>Administración Backup</h1> 
    <a href="inicio_admin.php" class="btn btn-dark btn-sm">Regresar</a><span> </span>
    <?php echo "Usuario: ".$_SESSION['usuario']; ?>
</div>
<hr>

<div class="container-fluid">
    <div class="row">
        <div class="col-2">
        <form method="POST">
            <!-- Botón para ejecutar el backup -->
            <button type="submit" name="backup" class="btn btn-primary">Realizar Backup</button>
        </form></div> 
        <div class="col-10"><?php
// Incluir el archivo de seguridad de sesión
include '../conexion/conexion.php';

</div>
    </div>

    <hr>

    <div class="container-fluid">
        <div class="row">
            <div class="col"><img src="../img/x.png" alt="imagen"> </div>
            <div class="col">
                <h2>
                    Este opción genera un backup de toda la base de datos en formato SQL. 
                    Si requiere restaurar los datos con algún backup obtenido, se debe comunicar con soporte técnico.
                    Para más información comuníquese con juan_egallegoc@soy.sena.edu.co
                </h2>
            </div>
        </div>
    </div>
</div>

</body>
</html>
