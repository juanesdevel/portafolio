
        function actualizarFechaHora() {
            const fechaHora = new Date();
            const opcionesFecha = { year: 'numeric', month: 'long', day: 'numeric' };
            const fechaFormateada = fechaHora.toLocaleDateString('es-ES', opcionesFecha);
            const horaFormateada = fechaHora.toLocaleTimeString('es-ES');
            
            document.getElementById('fechaHora').innerHTML = `${fechaFormateada} - ${horaFormateada}`;
        }

        setInterval(actualizarFechaHora, 1000); // Actualizar cada segundo
        actualizarFechaHora(); // Llamar inmediatamente para mostrar la fecha y hora al cargar la página
