<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include ("../conexion/conexion.php");

// Verificar si la sesión está activa y si existen las variables de usuario
if (!isset($_SESSION["usuario_id"]) || !isset($_SESSION["usuario"]) || !isset($_SESSION["rol"])) {
    // La sesión no está activa o faltan variables de usuario

    echo '<script>alert("Usuario no autorizado"); location.assign("../index.php");</script>';
    exit();
}

// Ahora se asume que la sesión está activa, podemos verificar el rol para esta página específica (admin)
if ($_SESSION['rol'] != 'admin') {
    echo '<script>alert("Acceso denegado. Se requiere rol de administrador."); location.assign("inicio_asesor.php");</script>';
    exit();
}

// Si llegamos aquí, la sesión está activa y el rol es 'admin'
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">

    </script>
    <style>
        body {
            background-color: #f4f6f8;
            /* Fondo gris muy claro */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: #ffffff;
            /* Fondo blanco para la barra de navegación */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: #333;
            font-size: 1.5rem;
            font-weight: 400;
            text-decoration: none;
        }

        .navbar-user {
            display: flex;
            align-items: center;
        }

        .navbar-user span {
            font-size: 0.9rem;
            color: #555;
            margin-right: 15px;
        }

        .btn-logout {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        .content-wrapper {
            flex-grow: 1;
            padding: 2rem;
        }

        .dashboard-actions {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .dashboard-actions a {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.8rem 1.2rem;
            text-decoration: none;
            font-size: 0.95rem;
            transition: background-color 0.3s ease;
        }

        .dashboard-actions a:hover {
            background-color: #0056b3;
        }

        .widget-container {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .widget-title {
            font-size: 1.2rem;
            font-weight: 300;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .widget-icon {
            font-size: 2rem;
            color: #007bff;
        }

        .footer {
            background-color: #333;
            color: #f8f9fa;
            text-align: center;
            padding: 1rem;
            font-size: 0.8rem;
        }

        .update-button {
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .update-button:hover {
            background-color: #1e7e34;
        }
                .acciones-columna {
            width: 150px; /* Ajusta el ancho según necesites */
            text-align: center;
        }
        .acciones-columna button {
            margin: 0 5px;
            padding: 5px 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .acciones-columna button.notificar { background-color: #ffc107; color: white; }
        .acciones-columna button.cancelar { background-color: #dc3545; color: white; }
        .acciones-columna button.confirmar { background-color: #28a745; color: white; }
    </style>
    <script>
        function actualizarFechaHora() {
            const fechaHoraElemento = document.getElementById('fechaHora');
            const ahora = new Date();
            const fecha = ahora.toLocaleDateString();
            const hora = ahora.toLocaleTimeString();
            fechaHoraElemento.textContent = `${fecha} ${hora}`;
        }

        // Actualizar la fecha y hora cada segundo
        setInterval(actualizarFechaHora, 1000);

        // Llamar a la función al cargar la página para mostrarla inmediatamente
        actualizarFechaHora();
    </script>
</head>

<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">Panel Administrador</a>
        <div class="navbar-user">
            <i class="fas fa-clock widget-icon"></i>
            <span id="fechaHora" class="badge bg-light text-dark"></span>

            <span class="badge bg-info"><?php echo "Usuario: " . htmlspecialchars($_SESSION['usuario']); ?></span>
            <a href="../conexion/cerrar_sesion.php" class="btn btn-danger btn-sm"
                onclick="return confirmarCierreSesion()"><i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión</a>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="dashboard-actions">
            <a href="pantalla_usuario.php" target="_blank"class=""><i class="fas fa-users me-2"></i> Pantalla Usuario</a>
            <a href="pantalla_turnos.php" target="_blank"class=""><i class="fas fa-users me-2"></i> Generador de turnos</a>
            <a href="clientes.php" class=""><i class="fas fa-users me-2"></i> Gestión de Clientes</a>
            <a href="usuarios.php" class=""><i class="fas fa-user-cog me-2"></i> Gestión de Usuarios</a>
            <a href="backup.php" class=""><i class="fas fa-database me-2"></i> Backup</a>
        </div>

        <div class="widget-container">
            <div class="container mt-5">
                <h2>Gestión de Turnos</h2>
                <form method="post" class="mb-3">
                    <div class="form-group">
                        <label for="estado">Seleccionar Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="">Todos los servicios</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Notificado">Notificado</option>
                            <option value="Cancelado">Cancelado</option>
                            <option value="Confirmado">Confirmado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="filtrar_estado">Filtrar</button>
                </form>

                <?php
                // Procesar el formulario si se ha enviado
                if (isset($_POST['filtrar_estado'])) {
                    $estado_seleccionado = $_POST['estado'];
                    $sql_turnos = "SELECT id, estado, fecha, servicio, entidad, turno, doc_usuario, atencion FROM turnos WHERE estado = ? ";
                    $stmt_turnos = $conn->prepare($sql_turnos);
                    $stmt_turnos->bind_param("s", $estado_seleccionado);
                    $stmt_turnos->execute();
                    $result_turnos = $stmt_turnos->get_result();
                } else {
                    // Mostrar todos los estados
                    $result_turnos = null;
                }
                ?>
                <?php if (isset($result_turnos)): ?>
                    <?php if ($result_turnos->num_rows > 0): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Servicio</th>
                                    <th>Turno</th>
                                    <th>Doc. Usuario</th>
                                    <th>Atención</th>
                                    <th>Estado</th>
                                    <th class="acciones-columna">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($fila_turno = $result_turnos->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($fila_turno['fecha']); ?></td>
                                        <td><?php echo htmlspecialchars($fila_turno['servicio']); ?></td>
                                        <td><?php echo htmlspecialchars($fila_turno['turno']); ?></td>
                                        <td><?php echo htmlspecialchars($fila_turno['doc_usuario']); ?></td>
                                        <td><?php echo htmlspecialchars($fila_turno['atencion']); ?></td>
                                        <td><?php echo htmlspecialchars($fila_turno['estado']); ?></td>
                        <td class="acciones-columna">
                            
                                <button class="accion-turno notificar" data-id="<?php echo htmlspecialchars($fila_turno['id']); ?>" data-accion="notificar" title="Notificar"><i class="fas fa-bell"></i></button>
                            
                            <button class="accion-turno cancelar" data-id="<?php echo htmlspecialchars($fila_turno['id']); ?>" data-accion="cancelar" title="Cancelar"><i class="fas fa-times"></i></button>
                            <button class="accion-turno confirmar" data-id="<?php echo htmlspecialchars($fila_turno['id']); ?>" data-accion="confirmar" title="Confirmar"><i class="fas fa-check"></i></button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron turnos pendientes o notificados para el servicio seleccionado.</p>
    <?php endif; ?>
    <?php $stmt_turnos->close(); ?>
<?php elseif (isset($_POST['filtrar_estado']) && $result_turnos === null): ?>
    <p>Por favor, selecciona un servicio para filtrar.</p>
<?php endif; ?>

            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </div>


        <div
            <a href="#" class="btn btn-outline-secondary update-button" onclick="location.reload();"><i
                    class="fas fa-sync-alt me-1"></i> Actualizar página</a>
        </div>
    </div>

    <footer class="footer">
        <p class="mb-0">Desarrollado por: Juan Esteban Gallego Cano. Contacto: juanesnet2016@gmail.com Celular: +57 300 8144841</p>
    </footer>

    <script>
        function confirmarCierreSesion() {
            return confirm("¿Está seguro de que desea cerrar la sesión?");
        }
        
document.addEventListener('DOMContentLoaded', function() {
        const botonesAccion = document.querySelectorAll('.accion-turno');
        const tablaTurnos = document.querySelector('.table'); // Selecciona la tabla por su clase
        const contenedorTabla = tablaTurnos.parentNode; // Obtén el contenedor de la tabla
        const formularioFiltro = document.querySelector('#filtrarFormulario'); // Selecciona el formulario de filtro (si tienes uno)

        const mensajeNotificacion = document.createElement('div');
        mensajeNotificacion.style.position = 'fixed';
        mensajeNotificacion.style.top = '20px';
        mensajeNotificacion.style.left = '50%';
        mensajeNotificacion.style.transform = 'translateX(-50%)';
        mensajeNotificacion.style.backgroundColor = '#28a745';
        mensajeNotificacion.style.color = 'white';
        mensajeNotificacion.style.padding = '15px 20px';
        mensajeNotificacion.style.borderRadius = '5px';
        mensajeNotificacion.style.zIndex = '1000';
        mensajeNotificacion.style.opacity = '0';
        mensajeNotificacion.style.transition = 'opacity 0.5s ease-in-out';
        document.body.appendChild(mensajeNotificacion);

        function mostrarNotificacion(mensaje, tipo = 'success') {
            mensajeNotificacion.textContent = mensaje;
            mensajeNotificacion.style.backgroundColor = tipo === 'success' ? '#28a745' : '#dc3545';
            mensajeNotificacion.style.opacity = '1';
            setTimeout(() => {
                mensajeNotificacion.style.opacity = '0';
            }, 3000); // Ocultar después de 3 segundos
        }

        function recargarTabla() {
            if (formularioFiltro) {
                const formData = new FormData(formularioFiltro);
                fetch('cargar_tabla_turnos.php', { // Nuevo archivo PHP para cargar la tabla
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    contenedorTabla.innerHTML = data; // Reemplaza el contenido de la tabla
                    // Volver a agregar los event listeners a los nuevos botones
                    const nuevosBotonesAccion = contenedorTabla.querySelectorAll('.accion-turno');
                    nuevosBotonesAccion.forEach(boton => {
                        boton.addEventListener('click', function(event) {
                            event.preventDefault();
                            const idTurno = this.dataset.id;
                            const accion = this.dataset.accion;
                            ejecutarAccionTurno(idTurno, accion, this);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error al recargar la tabla:', error);
                    mostrarNotificacion('Error al actualizar la tabla.', 'error');
                });
            } else {
                // Si no hay formulario de filtro, simplemente recarga toda la página (opcional)
                window.location.reload();
            }
        }

        botonesAccion.forEach(boton => {
            boton.addEventListener('click', function(event) {
                event.preventDefault();
                const idTurno = this.dataset.id;
                const accion = this.dataset.accion;
                ejecutarAccionTurno(idTurno, accion, this);
            });
        });

        function ejecutarAccionTurno(id, accion, boton) {
            fetch('acciones_turno.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + encodeURIComponent(id) + '&accion=' + encodeURIComponent(accion)
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                if (data.includes('actualizado')) {
                    mostrarNotificacion(`Turno ${accion} correctamente.`);
                    recargarTabla(); // Recargar la tabla después de la acción
                    // Hacer una petición AJAX a pantalla_turnos.php para indicar la actualización
                    fetch('pantalla_turnos.php?actualizar=true');
                } else {
                    mostrarNotificacion(`Error al ${accion} el turno.`, 'error');
                }
            })
            .catch(error => {
                console.error('Error al realizar la acción:', error);
                mostrarNotificacion('Error de conexión con el servidor.', 'error');
            });
        }
    });
    
    
    </script>
    
</body>

</html>

<?php
// Cerrar la conexión fuera del bloque if para asegurar que siempre se cierre
if (isset($conn)) {
    $conn->close();
}
?>
