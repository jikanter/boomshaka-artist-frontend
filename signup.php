<?php
require_once('config.php');
require_once(VIEW_DIR . '/signup.php');
// use composer installed libraries
require_once('vendor/autoload.php');

function BoomSendSignupRequestMail() { 
  global $mail_config;
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
  $mail->Subject = "[Boomshaka] Site Request: {$_POST['firstname']} {$_POST['lastname']} wanting the following services: {$_POST['imlookingfor']}";
  $mail->Body = "Name: {$_POST['firstname']} {$_POST['lastname']}\n";
  $mail->Body .= "Email: {$_POST['email']}\n";
  // TODO: turn this into an output of a whois query
  //$mail->Body .= "Desired Domain (Eventually this will be a whois query): {$_POST['domain']}";
  $mail->Body .= "Desired Services {$_POST['imlookingfor']}";
  
  if (!$mail->send()) { 
    $mail->Status = "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
  }
  else { 
    $mail->Status = "Message Sent";
  }
  return $mail;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  $status = BoomSendSignupRequestMail()->Status;
  if ($status == "Message Sent") { 
    $flash = "Thank You! Our Team of Hamsters are on their wheels and are firing up your site. As soon as they reach maximum revolutions, you will hear from us via email..";
  }
  else { 
    $flash = $status;
  }
  BoomRenderSignupRequestSubmitted($flash);
}
else {
  BoomRenderSignup();
}
?>