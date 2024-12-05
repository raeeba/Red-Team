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
$mail->Username = "noreplyamolinat@gmail.com"; // username of sender
$mail->Password = "bfhh scrg zmhh lmmx"; // app password 

$mail->isHtml(true);

return $mail;
?>