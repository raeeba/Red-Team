<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/vendor/autoload.php';

$mail = new PHPMailer(true);

//$mail->SMTPDebug = SMTP::DEBUG_SERVER; // debug script 

$mail->IsSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// enable imap in gmail account settings
$mail->Username = "sender-email@gmail.com"; // email of sender
$mail->Password = "sender-password"; // sender's app password 

$mail->isHtml(true);

return $mail;
?>