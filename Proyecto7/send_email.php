<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/phpmailer.php';
require 'PHPMailer/src/smtp.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']); 
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']); 
    $message = htmlspecialchars($_POST['message']); 

    
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
        $mail->addAddress('portafolio@juanesnet.com', 'Juan Esteban Gallego Cano');
        $mail->addReplyTo($email, $name);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body     = "
        <h2>Hola $name</h2>
        <p>$name dice $message su correo es: $email. </p><br>
        <p><strong>Mensaje desde el Portafolio</strong></p>
        ";

        $mail->AltBody = "Nombre: {$name}\nEmail: {$email}\nAsunto: {$subject}\nMensaje: {$message}";

        if ($mail->send()) {
           echo '<script>alert("Se envio exitosamente"); window.location.href = "http://juanesnet.com/";</script>';
        } else {
            echo "<p style='color: red;'>Error al enviar el correo: " . $mail->ErrorInfo . "</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>Error: " . $mail->ErrorInfo . "</p>";
    }
}

?>
