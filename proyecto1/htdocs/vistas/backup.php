<?php
// Incluir el archivo de seguridad de sesión
include '../conexion/conexion.php';
include '../conexion/sesion.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="../scripts/horaYfecha.js" defer></script>
    <link rel="stylesheet" href="../style/style.css">
    <script src="librerias/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div class="container-fluid alert alert-info sombra">
        <div class="row">
            <div class="col-8">
                <h1>Gestión de Backup</h1>
                <a href="inicio_admin.php" class="btn btn-dark sombra"><svg xmlns="http://www.w3.org/2000/svg" width="24"
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
            <div class="col-2">
                <h5><span class="badge text-bg-info" id="fechaHora"></span></h5>
            </div>
            <div class="col-2">
                <div class="logo-container">
                    <img src="../img/logo.png" alt="Logo de la empresa" class="logo" style="width: 200px; height: auto;">
                </div>
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
                // Incluir el archivo de seguridad de sesión
                include '../conexion/conexion.php';

                if (isset($_POST['backup'])) {
                    $result = realizarBackup($dbhost, $dbuser, $dbpass, $dbname);
                    echo $result;

                    // Actualizar la fecha y hora de la última ejecución
                    file_put_contents($last_execution_file, date("Y-m-d H:i:s"));
                }
                ?>
            </div>
        </div>

        <hr>

        <div class="container-fluid">
            <div class="row">
                <div class="col"><img src="../img/Backup.png" alt="Backup"></div>
                <div class="col">
                    <h2>
                        Esta opción genera un backup de toda la base de datos en formato SQL.
                        Si requiere restaurar los datos con algún backup obtenido, se debe comunicar con soporte técnico.
                        Para más información comuníquese con juanesnet2016@gmail.com
                    </h2>
                </div>
            </div>
        </div>
    </div>

</body>
</html>