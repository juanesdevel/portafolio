<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a; /* Fondo oscuro para el body */
            color: #e0e0e0; /* Texto claro para contraste */
            max-width: 600px;
            margin: 20px auto; /* A�0�9adido margen superior e inferior */
            padding: 20px;
        }
        form {
            background-color: #2c2c2c; /* Fondo oscuro para el formulario */
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Sutil sombra para destacar el formulario */
        }
        .form-group {
            margin-bottom: 20px; /* Aumentado el margen inferior */
        }
        label {
            display: block;
            margin-bottom: 8px; /* Aumentado el margen inferior */
            font-weight: bold;
            color: #f0f0f0; /* Texto de etiqueta m��s claro */
        }
        input, textarea {
            width: 100%;
            padding: 10px; /* Aumentado el padding */
            border: 1px solid #555; /* Borde m��s visible */
            border-radius: 6px; /* Bordes m��s redondeados */
            box-sizing: border-box;
            background-color: #333; /* Fondo oscuro para los campos de entrada */
            color: #e0e0e0; /* Texto claro en los campos de entrada */
        }
        textarea {
            min-height: 180px; /* Aumentado la altura m��nima del textarea */
        }
        button {
            background-color: #007bff; /* Color azul �ѧܧ�֧ߧ�ߧ��� */
            color: white;
            padding: 12px 20px; /* Aumentado el padding del bot��n */
            border: none;
            border-radius: 6px; /* Bordes m��s redondeados */
            cursor: pointer;
            font-size: 16px; /* Tama�0�9o de fuente un poco mayor */
            transition: background-color 0.3s ease; /* Transici��n suave para el hover */
        }
        button:hover {
            background-color: #0056b3; /* Color m��s oscuro al pasar el rat��n */
        }
        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            display: none;
        }
        .error-message {
            background-color: #f44336;
            color: white;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>
    
    

    <form id="contact-form" action="recuperar_pass.php" method="POST">
       
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <button type="submit">Recuperar contraseña</button>
    </form>
    

</body>
</html>