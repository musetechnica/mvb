<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home/solopreneur/PHPMailer/src/Exception.php';
require '/home/solopreneur/PHPMailer/src/PHPMailer.php';
require '/home/solopreneur/PHPMailer/src/SMTP.php';

$config = include('/home/solopreneur/email_config.php');

$mail = new PHPMailer(true);                             // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                // Enable verbose debug output
    $mail->isSMTP();                                     // Set mailer to use SMTP
    $mail->Host = 'smtp.dreamhost.com';                  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                              // Enable SMTP authentication
    $mail->Username = $config['smtp_user'];              // SMTP username
    $mail->Password = $config['smtp_pass'];              // SMTP password
    $mail->SMTPSecure = 'tls';                            
    $mail->Port = 587;                                   // TCP port to connect to

    //Recipients
    $mail->setFrom('contact@michaelvballard.com', 'Website Mailer');       //This is the email your form sends From
    $mail->addAddress('michaelvballard@outlook.com', 'Michael');            // Add a recipient address
    //$mail->addAddress('contact@example.com');                             // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $mail->Subject = 'Portfolio Inquiry' . $name;
        $mail->Body    = "Name: $name<br>Email: $email<br><br>Message:<br>$message";
        $mail->AltBody = "Name: $name<br>Email: $email<br><br>Message:<br>$message";

        try {
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>