<?php
include '../includes/conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/phpmailer.php';
require 'PHPMailer/src/smtp.php';

    
 // Verifica si la solicitud es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el correo electrónico enviado por POST
    $email_post = $_POST['email']; // Asegúrate de que el campo del formulario se llame 'email'

    // Prepara la consulta SQL para buscar el correo en la tabla 'usuarios'
    $sql = "SELECT id, email FROM usuarios WHERE email = ?";

    // Prepara la sentencia para evitar inyecciones SQL
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincula el parámetro (el correo electrónico) a la sentencia preparada
        $stmt->bind_param("s", $email_post);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado de la consulta
        $result = $stmt->get_result();

        // Verifica si se encontró algún usuario con ese correo
        if ($result->num_rows > 0) {
            // Si se encuentra un usuario, obtiene los datos
            $row = $result->fetch_assoc();
            $user_id = $row['id'];
            $user_email = $row['email'];
            $name = $row['nombre'];

            // Genera un enlace único para la recuperación de contraseña (esto es un ejemplo básico, considera hacerlo más seguro)
            $token = md5(uniqid(rand(), true));
            $link = "https://juanesnet.com/proyecto8/public/crear_pass.php?token=" . $token . "&id=" . $user_id; // Reemplaza tudominio.com

            // Asigna los valores para el correo electrónico
            $subject = 'Recuperación de Contraseña';
            $message = 'Haz clic en el siguiente enlace para crear una nueva contraseña:';

            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'juanesnet2016@gmail.com';
                $mail->Password   = 'smre sjke vxgl djxj';
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;

                // Remitente y destinatario
                $mail->setFrom('juanesnet2016@gmail.com', 'Juan Esteban Gallego Cano');
                $mail->addAddress($user_email, $name);
                //$mail->addReplyTo($email, $name);

                // Contenido
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = "
                    <h2>Hola $name</h2>
                    <p>Presione el link de recuperación y cree una contraseña nueva. </p><br>
                    <p><strong><a href='" . $link . "'>" . $link . "</a></strong></p>
                ";

                $mail->AltBody = "Nombre: {$name}\nEmail: {$user_email}\nAsunto: {$subject}\nMensaje: {$message}\nEnlace: {$link}";

                if ($mail->send()) {
                    echo '<script>alert("Se envió un link de recuperacion al correo: ' . $user_email . '"); window.location.href = "https://juanesnet.com/proyecto8/public/login.php";</script>';
                } else {
                    echo '<script>alert("Error al enviar el correo de recuperación."); window.location.href = "https://juanesnet.com/proyecto8/public/index.php";</script>';
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>Error de PHPMailer: " . $mail->ErrorInfo . "</p>";
            }

        } else {
            // Si no se encuentra ningún usuario con ese correo
            echo '<script>alert("No se encontró el correo electrónico registrado."); window.location.href = "https://juanesnet.com/proyecto8/public/index.php";</script>';
        }

        // Cierra la sentencia
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Error al preparar la consulta: " . $conn->error . "</p>";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}

?>