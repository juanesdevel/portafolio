<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <title>Mi Portafolio - Desarrollador Junior</title>
    <style>
    table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1em;
}

th, td {
  padding: 0.8em;
  border: 1px solid #ddd;
  text-align: left;
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
}

/* Estilos para dispositivos móviles (ancho máximo de 600px) */
@media (max-width: 600px) {
  table, thead, tbody, th, td, tr {
    display: block;
  }

  /* Ocultar los encabezados de la tabla visualmente */
  thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  tr {
    border: 1px solid #ccc;
    margin-bottom: 1em;
  }

  td {
    /* Ahora cada celda actuará como una fila */
    border: none;
    border-bottom: 1px solid #eee;
    position: relative;
    padding-left: 50%; /* Espacio para el "encabezado" */
    white-space: normal;
    text-align: left;
  }

  td:before {
    /* Añadir el texto del encabezado como "etiqueta" */
    position: absolute;
    top: 6px;
    left: 6px;
    width: 45%;
    padding-right: 10px;
    white-space: nowrap;
    font-weight: bold;
    content: attr(data-column); /* Usar el atributo data-column */
  }
}
         .visitas{
             font-family: "Courier New", Consolas, monospace;
             text-align:center;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
            margin: 0;
            padding: 0;
            transition: background-color 0.5s ease;
            
        }
        
        
                     img {
    max-width: 100%;
    height: auto;
     margin-top: 20px;
    margin-bottom: 20px;
}
        header {
            background-color: #2c2c2c;
            padding: 20px;
            text-align: center;
            animation: fadeIn 0.2s ease-in;
        }
        h1 {
            margin: 0;
        }
        nav {
            background-color: #333;
            padding: 10px;
        }
        nav a {
            color: #ffffff;
            text-decoration: none;
            padding: 5px 10px;
            transition: background-color 0.1s ease;
        }
        nav a:hover {
            background-color: #555;
        }
        section {
            padding: 20px;
            margin: 20px;
            background-color: #2c2c2c;
            border-radius: 5px;
            animation: slideIn 1.Os ease-out;
            
            }
             .fondo {
            background-image: url('/portafolio/redes.jpg'); /* Cambia por la ruta de tu imagen */
            background-size: cover; /* Ajusta la imagen para cubrir toda la sección */
            background-position: center; /* Centra la imagen */
            background-repeat: no-repeat; /* Evita que la imagen se repita */

            }
       
              
       .project {
    margin-bottom: 20px;
    padding: 10px;
    background-color: #333;
    border-radius: 5px;
    transition: transform 0.5s ease, opacity 0.5s ease; /* Agregado para animar la opacidad */
    opacity: 0.8; /* Nivel de opacidad inicial */
}
          .project:hover {
            transform: scale(1.05);
        }
        .photo-container {
            width: 200px;
            height: 200px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            position: relative;
            cursor: pointer;
        }
        .photo-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.9s ease;
        }
        .photo-container .photo-hover {
            opacity: 0;
        }
        .photo-container:hover .photo-initial {
            opacity: 0;
        }
        .photo-container:hover .photo-hover {
            opacity: 1;
        }
        #sobre-mi {
            text-align: center;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideIn {
            from { transform: translateY(8px); opacity: 0.5; }
            to { transform: translateY(0); opacity: 3; }
        }
        .arrow-up {
    position: fixed;
    left: 20px; /* Cambiado de right a left */
    top: 50%; /* Centrado vertical */
    transform: translateY(-50%); /* Ajusta el centro vertical */
    width: 50px;
    height: 50px;
    background-color: #007BFF;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: transform 0.5s, background-color 0.5s;
}
.arrow-up:hover {
    transform: scale(1.1);
    background-color: #0056b3;
}

        }
        .arrow-up svg {
            width: 24px;
            height: 24px;
        }
        .img {
            border-radius: 2%;
        }
    </style>
</head>
<body>
    <header class="fondo"id="top">
        <h1>JUAN ESTEBAN GALLEGO CANO </h1>
        <p>Técnico en Sistemas y estudiante de Análisis y Desarrollo de Software</p>
    </header>
    
    <nav>
        <a href="#">Secciones >>> </a>
        <a href="#sobre-mi">Sobre Mí</a>
        <a href="#conocimientos">Conocimientos</a>
        <a href="#proyectos">Proyectos</a>
        <a href="hv.pdf" target="_blank">Curriculum</a>
        <a href="#contacto">Contacto</a>
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
         Lista de Proyectos</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a target="_blank" class="dropdown-item" href="proyecto1/index.php">ElectroFact</a></li>
                            <li><a target="_blank" class="dropdown-item" href="proyecto8/public/index.php">Compra y Venta</a></li>
                            <li><a target="_blank" class="dropdown-item" href="proyecto9/personal.php">Personal</a></li>
                            <li><a target="_blank" class="dropdown-item" href="proyecto2/ahorcado.html">Juego de ahorcado</a></li>
                            <li><a target="_blank" class="dropdown-item" href="proyecto3/3.html">Sección Galería interactiva de imagenes</a></li>
                            <li><a target="_blank" class="dropdown-item" href="proyecto7/formulario.html">Sección de contacto</a></li>
                            <li><a target="_blank" class="dropdown-item" href="proyecto4/tower-defense.html">Juego defensa de torres</a></li>
                            <li><a target="_blank" class="dropdown-item" href="proyecto5/kanban.html">Gestor de Tareas</a></li>
                            <li><a target="_blank" class="dropdown-item" href="proyecto10/index.php">Turnos</a></li>
                            <li><a target="_blank" class="dropdown-item" href="proyecto11/index.php">Clon WhatsApp</a></li>
                        </ul>


   </nav>
   <hr>
   
    <section class= "fondo" id="sobre-mi">
        <div class="photo-container ">
            <img src="portafolio/foto1.png" alt="" class="photo-initial">
            <img src="portafolio/foto3.png" alt="" class="photo-hover">
        </div>
        <h2>Sobre Mí</h2>
        <div class="project">
        <p>Soy Técnico en Sistemas y estudiante de desarrollo de software, apasionado por la tecnología y comprometido con sobresalir en todos los campos relacionados con mi profesión. Poseo experiencia y habilidades en áreas como el mantenimiento preventivo y predictivo de equipos de cómputo, la configuración de dispositivos y redes, así como en el diseño, manejo y administración de sitios web. Además, cuento con conocimientos en lenguajes de programación como Python, PHP, Java y JavaScript, y estoy familiarizado con metodologías ágiles para la gestión de proyectos, de asesoría en compra y venta de equipos, gestión de redes sociales o desarrollo de soluciones innovadoras en el ámbito digital. Me destaco por mi creatividad, adaptabilidad y capacidad para trabajar en equipo, siempre enfocado en el aprendizaje continuo y en generar un impacto positivo en el mundo tecnológico. Aspiro a servir profesionalmente a una compañía que requiera de estos servicios.</p>
        </div>
    </section>
   <section class="fondo" id="conocimientos">
      <h2>Conocimientos</h2>
    <div class="project">
  
        <h2>Tecnologías</h2>
        <ul>
            <li>HTML5</li>
            <li>CSS</li>
            <li>JavaScript</li>
            <li>PHP</li>
            <li>Python</li>
            <li>Bootstrap</li>
            <li>XAMPP</li>
            <li>GitHub</li>
        </ul>
         </div>
<div class="project">
     <h2>Gestores de Bases de datos</h2>
        <ul>
            <li>SQL</li>
            <li>phpMyAdmin</li>
            <li>MongoDB</li>
        </ul>
        
</div class="container-fluid">
    </section> 
     
        <section class="fondo" id="proyectos">
        <h2>Proyectos</h2>
        
        <div class="project">
            <h3>GitHub</h3>
            <h3><a href="https://github.com/juanesdevel/portafolio.git"target="_blank" rel="noopener noreferrer">https://github.com/juanesdevel/portafolio.git</a></h3>
        </div>

        <div class="project">
            <h3>Proyecto 1</h3>
            <h3><a href="proyecto1/index.php"target="_blank" rel="noopener noreferrer">Gestión Integral de Ventas</a></h3>
            <p>El software de facturación es una solución integral diseñada para optimizar la gestión de productos, clientes, usuarios y procesos comerciales en general. Permite gestionar el inventario de productos, administrar la información de clientes y usuarios, y generar facturas de manera eficiente y personalizada. Además, facilita el seguimiento de ventas y la emisión de reportes detallados sobre el desempeño del negocio. El sistema incluye funciones de alertas y notificaciones para mantener informados a los usuarios sobre eventos importantes, asegura la integridad de los datos mediante backups automáticos y proporciona un control de cambios para auditar las acciones dentro del software, garantizando así un entorno seguro y bien organizado.</p>
               <img class= "img" src="img/Imagen1.png" alt="proyecto 1" style="width: 800px; height: auto;">
        </div>
        <div class="project">
            <h3>Proyecto 2</h3>
            <h3><a href="proyecto2/ahorcado.html"target="_blank" rel="noopener noreferrer">Juego del Ahorcado</a></h3>
            <p>El Juego del Ahorcado es una aplicación web interactiva que desafía a los jugadores a adivinar palabras ocultas. Esta versión está desarrollada utilizando HTML, CSS y JavaScript, ofreciendo una experiencia de juego intuitiva y entretenida.
Características Principales
Categorías
El juego incluye cinco categorías distintas, cada una con 30 palabras cuidadosamente seleccionadas:

Países del Mundo: Incluye naciones de todos los continentes
Animales: Abarca especies terrestres, acuáticas y aéreas
Frutas: Contempla variedades de diferentes regiones
Apellidos: Incluye apellidos comunes e históricos
Artistas Internacionales: Contempla músicos y artistas de diferentes épocas y géneros</p>
<img class= "img"src="img/Ahorcado.png" alt="Proyecto 2" style="width: 800px; height: auto;">
        </div>
        <div class="project">
            <h3>Proyecto 3</h3>
            <h3><a href="proyecto3/3.html"target="_blank" rel="noopener noreferrer">Galería Interactiva - Visualizador de Imágenes Moderno</a></h3>
            <p>La Galería Interactiva es una aplicación web moderna y elegante diseñada para mostrar colecciones de imágenes de manera atractiva y funcional. La interfaz se divide en tres componentes principales que trabajan en conjunto para ofrecer una experiencia de usuario fluida y agradable.</p>
            <img class= "img"src="img/Galeria.png" alt="Proyecto 3" style="width: 800px; height: auto;">
        </div>
        <div class="project">
            <h3>Proyecto 4</h3>
            <h3><a href="proyecto4/tower-defense.html"target="_blank" rel="noopener noreferrer">Juego de defensa de Torres</a></h3>
            <p>Juego de defenza de torres, Debes proteger a toda costa que las unidades enemigas recorran el camino hacia tus torres.</p>
        <img class= "img"src="/proyecto4/tower-defense.png" alt="proyecto 4" style="width: 800px; height: auto;">
        </div>
        <div class="project">
            <h3>Proyecto 5</h3>
            <h3><a href="proyecto5/kanban.html"target="_blank" rel="noopener noreferrer">Gestor de Tareas</a></h3>
            <p>Sistema de Gestión de Tareas Kanban: Aplicación web con interfaz en modo oscuro que permite organizar actividades en tres columnas (Por Hacer, En Progreso, Completadas) mediante drag & drop. Incluye autenticación de usuarios, guardado automático y diseño responsivo.</p>
            <img class= "img"src="/proyecto5/kanban.png" alt="proyecto 5" style="width: 800px; height: auto;">
        </div>
        <div class="project">
            <h3>Proyecto 6</h3>
             <h3><a href="proyecto6/interplay.html"target="_blank" rel="noopener noreferrer">Interplay</a></h3>
            <p>Descripción breve del proyecto 6.</p>
    <img class= "img"src="/proyecto6/img/logo.jpg" alt="Proyecto 6" style="width: 800px; height: auto;">

        </div>
        <div class="project">
            <h3>Proyecto 7</h3>
            <h3><a href="proyecto7/formulario.html"target="_blank" rel="noopener noreferrer">Sección de contacto</a></h3>

            <p>Este formulario prueba el envío de datos atravéz de una página a un correo electrónico.</p>
                <img class= "img"src="/proyecto7/formulario.jpg" alt="Proyecto 6" style="width: 800px; height: auto;">

        </div>
        <div class="project">
            <h3>Proyecto 8</h3>
            <h3><a href="proyecto8/public/index.php"target="_blank" rel="noopener noreferrer">Página de compra y venta</a></h3>
            <p>Este proyecto es una página tipo OLX para publicar articulos, servicios, Inmuebles, comprar y vender</p>
            <img class= "img"src="/proyecto8/img/comprayventa.jpg" alt="Proyecto 8" style="width: 800px; height: auto;">

        </div>
        <div class="project">
            <h3>Proyecto 9</h3>
            <h3><a href="proyecto9/personal.php"target="_blank" rel="noopener noreferrer">Página personal</a></h3>
            <p>Este proyecto ha sido desarrollado utilizando tecnologías web como HTML, PHP, JavaScript y el framework Bootstrap, y está estructurado en tres módulos principales: Keepass, Eventos y Mensualidades.<br>

<strong>Módulo Keepass: </strong>Diseñado para almacenar de forma segura las contraseñas personales de diversas cuentas. Este módulo permite al usuario consultar, actualizar o eliminar credenciales según sea necesario, facilitando una gestión eficiente de la información sensible.<br>

<strong>Módulo de Eventos</strong>: En este módulo, el usuario puede crear, consultar, modificar y eliminar eventos importantes como citas médicas, cumpleaños, reuniones familiares, entre otros. Su objetivo es servir como recordatorio y herramienta de organización personal.<br>

<strong>Módulo de Mensualidades: </strong>Permite registrar, consultar y editar los gastos mensuales, brindando un control detallado de los pagos realizados. Este módulo está orientado al seguimiento y planificación de las finanzas personales.<br>

En conjunto, estos tres módulos ofrecen una solución integral para la gestión personal de información sensible, eventos importantes y control financiero, todo desde una interfaz intuitiva y accesible desde cualquier dispositivo con conexión a internet.</p>
            <img class= "img"src="/proyecto9/img/personal.jpg" alt="Proyecto 8" style="width: 800px; height: auto;">

        </div>
        <div class="project">
            <h3>Proyecto 10</h3>
            <h3><a href="proyecto10/index.php"target="_blank" rel="noopener noreferrer">Servico de turnos</a></h3>
            <p>Descripción breve del proyecto 10.</p>
            <img class= "img"src="/proyecto10/img/turnos.jpg" alt="Proyecto 8" style="width: 800px; height: auto;">

        </div>
    </section>
    <div class="arrow-up" onclick="scrollToTop()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </div>
     <div class="visitas">
    <p>Esta página ha sido visitada <span id="visit-count">
        <?php
            // Ruta del archivo que almacena el contador
            $file = "contador.txt";

            // Leer el contador actual
            if (file_exists($file)) {
                $count = (int)file_get_contents($file);
            } else {
                $count = 0;
            }

            // Incrementar el contador
            $count++;

            // Guardar el nuevo valor en el archivo
            file_put_contents($file, $count);

            // Mostrar el contador
            echo $count;
        ?>
    </span> veces.</p>
</div>
    <section class="fondo" id="contacto">
    
        <h2>Contacto</h2>
        <p><i class="fas fa-envelope icon"></i>  juanesnet2016@gmail.com </p>
        <p><i class="fas fa-phone"></i> + 57 300 8144841 </p>
        <p> <i class="fas fa-file-alt"></i><a href="hv.pdf"target="_blank" rel="noopener noreferrer">  Descargar Curriculum</a><p/>
        <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fab fa-whatsapp icon"></i>
             <h4 style="margin: 0;">
             <a href="https://wa.me/+573008144841?text=Hola, ví tu portafolio y estoy interesado en tu perfil, podemos hablar?" target="_blank" rel="noopener     noreferrer">Enviar mensaje via WhatsApp
            </a> </h4> <br><br>
        </div>
          <div style="display: flex; align-items: center; gap: 8px;">
            <i class="fab fa-linkedin"></i>
             <h4 style="margin: 0;">
             <a href="https://www.linkedin.com/public-profile/settings?trk=d_flagship3_profile_self_view_public_profile" target="_blank" rel="noopener     noreferrer">Linkedin
            </a> </h4>
        </div>
        
            <h1>Enviame un mensaje</h1>
    

    <form id="contact-form" action="/Portafolio/send_email.php" method="POST">
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="subject">Asunto:</label>
            <input type="text" id="subject" name="subject" required>
        </div>
        
        <div class="form-group">
            <label for="message">Mensaje:</label>
            <textarea id="message" name="message" size="200" required></textarea>
        </div>
        
        <button type="submit">Enviar mensaje</button>
    </form>

   </section>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Animación de desplazamiento suave
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Animación de cambio de color de fondo
            let colors = ['#1a1a1a', '#2c2c2c', '#333', '#444'];
            let currentIndex = 0;
            setInterval(() => {
                document.body.style.backgroundColor = colors[currentIndex];
                currentIndex = (currentIndex + 1) % colors.length;
            }, 5000);
        });
           function scrollToTop() {
            document.getElementById('top').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
