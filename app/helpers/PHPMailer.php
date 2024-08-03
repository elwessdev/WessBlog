<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require '../../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

//Server settings
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption

$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
$mail->Username   = 'bms93951@gmail.com';                     //SMTP username
$mail->Password   = 'usbpazmfmciavtmp';                               //SMTP password

$mail->isHTML(true);
return $mail;