<!-- Code by Ferhat OZCELIK -->
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require 'config.php';

$name = mysqli_real_escape_string($conn, $_POST['name']);
$from = mysqli_real_escape_string($conn, $_POST['from']);
$reply_to = mysqli_real_escape_string($conn, $_POST['reply-to']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$msg = mysqli_real_escape_string($conn, $_POST['msg']);

$mail = new PHPMailer(true);
$mail->CharSet = "UTF-8";
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;     //Enable verbose debug output

    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $ConfigHost;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $ConfigUsername;                     //SMTP username
    $mail->Password   = $ConfigPassword;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $ConfigPort;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($from, $name);

    $addressArray = array();
    if (!empty($_POST['to'])) {
        foreach ($_POST['to'] as $key => $value) {
            $addressArray[] = $value;
        }
    }

    if (!empty($_POST['email-group'])) {
        $query = "SELECT * FROM bulk_email_list WHERE `group`='{$_POST['email-group']}'";
        $query_run = mysqli_query($conn, $query);
        if (mysqli_num_rows($query_run) > 0) {
            foreach ($query_run as $bulk_email_list) {
                $addressArray[] = $bulk_email_list['email'];
            }
        }
    }

    if (!empty($reply_to)) {
        $mail->addReplyTo($reply_to);
    }

    //Attachments
    $file_dir = array();
    foreach ($_FILES['file']['name'] as $key => $value) {
        echo $value;
        if (!empty($value)) {
            $target = "uploads/" . rand() . $value;
            move_uploaded_file($_FILES['file']['tmp_name'][$key], $target);
            $file_dir[] = $target;
            $mail->addAttachment($target);

            
        }
    }

    //Content
    $mail->isHTML(true);
    //Set email format to HTML
    $mail->Subject = $subject;
    if (!empty($msg)) {
        $mail->Body = $msg . '<br><br><br>' . $ConfigSignature;
    } else {
        $mail->Body = ' ' .'<br><br><br>' . $ConfigSignature;
    }


    $sending = false;
    foreach ($addressArray as $key => $value) {
        $sending = true;
        $mail->addAddress($value);
        $mail->send();
        $mail->clearAddresses();
    }

    $sending = false;
    sleep(2);
    if($sending == false){
        if (!empty($file_dir)) {
            foreach ($file_dir as $target) {
                $status = unlink($target);
            }
        }
    }

    

    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
