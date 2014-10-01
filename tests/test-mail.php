<?php
require_once('../config.php');
require_once('../vendor/autoload.php');
  
  $firstname = "Bugs";
  $lastname = "Bunny"; 
  $email = "bugs@whatsup.doc";
  $domain = "eatcarro.ts";
  $mail = new PHPMailer;
  
  $mail->isSMTP();
  $mail->Host = $mail_config['host'];
  $mail->SMTPAuth = true;
  
  $mail->Username = $mail_config['username'];
  $mail->Password = $mail_config['password'];
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
  
  $mail->From = 'no-reply@jordankanter.com';
  // to
  $mail->addAddress('boomshakadesign@gmail.com');
  $mail->Subject = "[Boomshaka] Test Site Request: {$firstname} {$lastname} for {$domain}";
  $mail->Body = "Name: {$firstname} {$lastname}\n";
  $mail->Body .= "Email: {$email}\n";
  // TODO: turn this into an output of a whois query
  $mail->Body .= "Desired Domain (Eventually this will be a whois query): {$domain}";
  
  if (!$mail->send()) { 
    $mail->Status = "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
  }
  else { 
    $mail->Status = "Message Sent\n";
  }
  echo($mail->Status);
  return $mail;
?>