<?php
// Incluir el archivo de seguridad de sesión
include '../../conexion/conexion.php';
include '../../conexion/sesion.php';

// Función para realizar el backup
function realizarBackup($dbhost, $dbuser, $dbpass, $dbname) {
    try {
        // Conectar a la base de datos con PDO
        $dsn = "mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Nombre del archivo de backup
        $fecha = date("Ymd-His");
        $backup_file = "../backup/backup_{$dbname}_{$fecha}.sql";

        // Abrir archivo para guardar el backup
        $file = fopen($backup_file, 'w+');
        if (!$file) {
            throw new Exception("No se puede crear el archivo de backup.");
        }

        // Escribir el encabezado del archivo SQL
        fwrite($file, "-- Backup de la base de datos: $dbname\n");
        fwrite($file, "-- Fecha de creación: " . date("Y-m-d H:i:s") . "\n\n");

        // Obtener todas las tablas
        $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

        // Recorrer todas las tablas
        foreach ($tables as $table) {
            // Obtener la estructura de la tabla
            $create_table_stmt = $pdo->query("SHOW CREATE TABLE $table")->fetch(PDO::FETCH_ASSOC);
            fwrite($file, "-- Estructura de la tabla $table\n");
            fwrite($file, $create_table_stmt['Create Table'] . ";\n\n");

            // Obtener los datos de la tabla
            $rows = $pdo->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0) {
                fwrite($file, "-- Datos de la tabla $table\n");

                foreach ($rows as $row) {
                    $row_data = array_map([$pdo, 'quote'], $row); // Escapar los valores
                    $row_values = implode(", ", $row_data);
                    fwrite($file, "INSERT INTO $table VALUES ($row_values);\n");
                }

                fwrite($file, "\n");
            }
        }

        fclose($file);

        return "<div class='alert alert-success'>Backup realizado con éxito. Archivo guardado en: {$backup_file}</div>";
    } catch (Exception $e) {
        return "<div class='alert alert-danger'>Error al realizar el backup: " . $e->getMessage() . "</div>";
    }
}

// Archivo para almacenar la última ejecución
$last_execution_file = "../backup/last_backup_execution.txt";

// Verificar la última ejecución
if (file_exists($last_execution_file)) {
    $last_execution = strtotime(file_get_contents($last_execution_file));
    $now = time();
    $one_day = 24 * 60 * 60; // Segundos en un día

    // Ejecutar el backup diariamente
    if ($now - $last_execution >= $one_day) {
        $result = realizarBackup($dbhost, $dbuser, $dbpass, $dbname);
        echo $result;

        // Actualizar la fecha y hora de la última ejecución
        file_put_contents($last_execution_file, date("Y-m-d H:i:s"));
    }
} else {
    // Si el archivo no existe, ejecutar el backup por primera vez
    $result = realizarBackup($dbhost, $dbuser, $dbpass, $dbname);
    echo $result;

    // Crear el archivo con la fecha y hora de la primera ejecución
    file_put_contents($last_execution_file, date("Y-m-d H:i:s"));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Administrador</title>
        <link rel="icon" href="../../img/victoria.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="../scripts/horaYfecha.js" defer></script>
    <link rel="stylesheet" href="../style/style.css">
    <script src="librerias/jquery-3.2.1.min.js"></script>
        <style>
            body {
            background-color: #121212; /* Fondo oscuro */
            background-image: url('../../img/fondo3.png'); /* Mantiene tu imagen de fondo */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

            color: #e0e0e0; /* Texto claro */

.table-dark {
    color: #e0e0e0;
    background-color: #121212;
    opacity: 0.5; /* valor entre 0 (transparente) y 1 (opaco) */
}

.table-dark th,
.table-dark td {
    border-color: #424242;
}
        .form-control { background-color: #333; color: #e0e0e0; border: 1px solid #555; }
        .form-control:focus { background-color: #444; color: #e0e0e0; border-color: #666; }
        label { color: #bdbdbd; }
        .alert-info { background-color: #333; color: #e0e0e0; border-color: #424242; }
        .password-toggle { cursor: pointer; }
        
        /* Añade esto a tu sección de estilos */
.copy-password {
    margin-left: 5px;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.input-group {
    flex-wrap: nowrap;
}
    </style>

</head>
<body>
    <div class="container-fluid alert alert-blak sombra">
        <div class="row">
            <div class="col-8">
                <h1>Gestión de Backup</h1>
                <a href="../panel_inicio/inicio_admin.php" class="btn btn-dark sombra"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                           height="24" viewBox="0 0 24 24" fill="none"
                                                                           stroke="white" stroke-width="2"
                                                                           stroke-linecap="round"
                                                                           stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Home</a>
                <span class="badge text-bg-info"><?php echo " Usuario:  " . $_SESSION['usuario']; ?></span>
            </div>
        </div>
    </div>
    <hr>

    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <form method="POST">
                    <button type="submit" name="backup" class="btn btn-primary">Realizar Backup</button>
                </form>
            </div>
            <div class="col-10">
                <?php

                if (isset($_POST['backup'])) {
                    $result = realizarBackup($dbhost, $dbuser, $dbpass, $dbname);
                    echo $result;

                    // Actualizar la fecha y hora de la última ejecución
                    file_put_contents($last_execution_file, date("Y-m-d H:i:s"));
                }
                ?>
            </div>
        </div>

        </div>
    </div>

</body>
</html>