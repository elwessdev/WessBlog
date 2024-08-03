<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable( __DIR__ . '/../../');
$dotenv->load();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

//Server settings
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
// $mail->SMTPSecure = 'tls';

$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
$mail->Username   = $_ENV["PHPHMAILER_USERNAME"];                     //SMTP username
$mail->Password   = $_ENV["PHPHMAILER_PASSWORD"];                               //SMTP password

$mail->isHTML(true);
return $mail;