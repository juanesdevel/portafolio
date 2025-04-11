<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Turnos</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }

        .modal-container {
            display: none; /* Ocultar todos los modales por defecto */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro semitransparente */
            justify-content: center;
            align-items: center;
            z-index: 1000; /* Asegurar que esté por encima de todo */
        }

        .modal-container.active {
            display: flex; /* Mostrar el modal activo */
        }

        .modal {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 80%;
            max-width: 400px;
        }

        .modal h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .servicios, .atenciones {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        .servicios button, .atenciones button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .servicios button:hover, .atenciones button:hover {
            background-color: #0056b3;
        }

        .visor-teclado {
            display: flex;
            margin-bottom: 15px;
        }

        .visor-teclado input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            font-size: 18px;
            text-align: center;
            outline: none;
        }

        .visor-teclado button {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 0 5px 5px 0;
            background-color: #eee;
            cursor: pointer;
            font-size: 16px;
        }

        .teclado {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .teclado button {
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #ddd;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .teclado button:hover {
            background-color: #ccc;
        }

        .botones-modal {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .botones-modal button, .modal .btn-atras {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #6c757d;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .modal .btn-atras {
            background-color: #dc3545;
        }

        .botones-modal button:hover, .modal .btn-atras:hover {
            background-color: #5a6268;
        }

        .resumen .resaltado {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        .resumen .resaltado.grande {
            font-size: 2em;
        }

        #aceptar-resumen {
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        #aceptar-resumen:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="modal-container active" id="modalServicio">
        <div class="modal">
            <h2>Seleccionar Servicio</h2>
            <div class="servicios">
                <button data-servicio="Consulta General">Consulta General</button>
                <button data-servicio="Odontología">Odontología</button>
                <button data-servicio="Laboratorio">Laboratorio</button>
                <button data-servicio="Imagenología">Imagenología</button>
            </div>
            <a href="inicio_admin.php" class="btn-atras"><i class="fas fa-database me-2"></i>Atrás</a>

            
        </div>
    </div>

    <div class="modal-container" id="modalDocumento">
        <div class="modal">
            <h2>Ingrese su Documento</h2>
            <div class="visor-teclado">
                <input type="text" id="documento" readonly>
                <button id="borrar">←</button>
            </div>
            <div class="teclado">
                <button>1</button>
                <button>2</button>
                <button>3</button>
                <button>4</button>
                <button>5</button>
                <button>6</button>
                <button>7</button>
                <button>8</button>
                <button>9</button>
                <button>0</button>
            </div>
            <div class="botones-modal">
                <button class="btn-atras" onclick="mostrarModal('modalServicio')">Atrás</button>
                <button id="ok-documento">OK</button>
            </div>
        </div>
    </div>

    <div class="modal-container" id="modalAtencion">
        <div class="modal">
            <h2>Tipo de Atención</h2>
            <div class="atenciones">
                <button id="preferencial">Preferencial</button>
                <button id="ordinaria">Ordinaria</button>
            </div>
            <button class="btn-atras" onclick="mostrarModal('modalDocumento')">Atrás</button>
        </div>
    </div>
    <div class="modal-container" id="modalResumen">
        <div class="modal resumen">
            <h2>Resumen de Turno</h2>
            <p>Servicio: <span id="resumen-servicio" class="resaltado"></span></p>
            <p>Número de Turno: <span id="resumen-turno" class="resaltado grande"></span></p>
            <button id="aceptar-resumen">Aceptar</button>
        </div>
    </div>

    <script>
        // Contador simulado de turnos
        const contadorTurnos = {
            'Consulta General': 100,
            'Odontología': 200,
            'Laboratorio': 300,
            'Imagenología': 400
        };

        const modalServicio = document.getElementById('modalServicio');
        const modalDocumento = document.getElementById('modalDocumento');
        const modalAtencion = document.getElementById('modalAtencion');
        const modalResumen = document.getElementById('modalResumen');

        const servicioSeleccionado = { servicio: null, documento: null, atencion: null };

        // Función para mostrar un modal y ocultar los demás
        function mostrarModal(idModal) {
            modalServicio.classList.remove('active');
            modalDocumento.classList.remove('active');
            modalAtencion.classList.remove('active');
            modalResumen.classList.remove('active');

            const modalToShow = document.getElementById(idModal);
            if (modalToShow) {
                modalToShow.classList.add('active');
            }
        }

        // Eventos para la selección de servicio
        const botonesServicio = document.querySelectorAll('#modalServicio .servicios button');
        botonesServicio.forEach(boton => {
            boton.addEventListener('click', function() {
                servicioSeleccionado.servicio = this.dataset.servicio;
                mostrarModal('modalDocumento');
            });
        });

        // Lógica del teclado numérico
        const visorDocumento = document.getElementById('documento');
        const botonesTeclado = document.querySelectorAll('#modalDocumento .teclado button');
        const botonBorrar = document.getElementById('borrar');
        const botonOkDocumento = document.getElementById('ok-documento');

        botonesTeclado.forEach(boton => {
            boton.addEventListener('click', function() {
                visorDocumento.value += this.textContent;
            });
        });

        botonBorrar.addEventListener('click', function() {
            visorDocumento.value = visorDocumento.value.slice(0, -1);
        });

        botonOkDocumento.addEventListener('click', function() {
            if (visorDocumento.value.trim() !== '') {
                servicioSeleccionado.documento = visorDocumento.value;
                mostrarModal('modalAtencion');
            } else {
                alert('Por favor, ingrese su número de documento.');
            }
        });

        // Eventos para la selección de tipo de atención
        const botonPreferencial = document.getElementById('preferencial');
        const botonOrdinaria = document.getElementById('ordinaria');

        botonPreferencial.addEventListener('click', function() {
            servicioSeleccionado.atencion = 'Preferencial';
            registrarTurno();
        });

        botonOrdinaria.addEventListener('click', function() {
            servicioSeleccionado.atencion = 'Ordinaria';
            registrarTurno();
        });

        // Función para registrar el turno (modificada para funcionar sin PHP)
        function registrarTurno() {
            try {
                // Intentar hacer la petición al servidor primero
                fetch('registrar_turno.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        servicio: servicioSeleccionado.servicio,
                        documento: servicioSeleccionado.documento,
                        atencion: servicioSeleccionado.atencion
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.log('Error del servidor:', data.error);
                        generarTurnoLocal();
                    } else {
                        document.getElementById('resumen-turno').textContent = data.turno;
                        document.getElementById('resumen-servicio').textContent = servicioSeleccionado.servicio;
                        mostrarModal('modalResumen');
                    }
                })
                .catch(error => {
                    console.log('Error en la petición:', error);
                    generarTurnoLocal();
                });
            } catch (error) {
                console.log('Error general:', error);
                generarTurnoLocal();
            }
        }

        // Función para generar un turno localmente cuando falla la petición al servidor
        function generarTurnoLocal() {
            const servicio = servicioSeleccionado.servicio;
            const esPrioritario = servicioSeleccionado.atencion === 'Preferencial';
            
            // Incrementar el contador para el servicio seleccionado
            contadorTurnos[servicio]++;
            
            // Generar un prefijo según el servicio y si es atención preferencial
            let prefijo = '';
            switch(servicio) {
                case 'Consulta General':
                    prefijo = esPrioritario ? 'PG' : 'CG';
                    break;
                case 'Odontología':
                    prefijo = esPrioritario ? 'PO' : 'OD';
                    break;
                case 'Laboratorio':
                    prefijo = esPrioritario ? 'PL' : 'LB';
                    break;
                case 'Imagenología':
                    prefijo = esPrioritario ? 'PI' : 'IM';
                    break;
            }
            
            const numeroTurno = `${prefijo}${contadorTurnos[servicio]}`;
            
            // Mostrar el turno en el resumen
            document.getElementById('resumen-turno').textContent = numeroTurno;
            document.getElementById('resumen-servicio').textContent = servicioSeleccionado.servicio;
            mostrarModal('modalResumen');
        }

        // Evento para aceptar el resumen y volver al inicio
        const botonAceptarResumen = document.getElementById('aceptar-resumen');
        botonAceptarResumen.addEventListener('click', function() {
            // Limpiar la selección anterior
            servicioSeleccionado.servicio = null;
            servicioSeleccionado.documento = null;
            servicioSeleccionado.atencion = null;
            visorDocumento.value = '';
            mostrarModal('modalServicio');
        });

        // Mostrar el primer modal al cargar la página
        mostrarModal('modalServicio');
    </script>
</body>
</html>