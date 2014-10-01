<?php
require_once('config.php');
require_once(VIEW_DIR . '/signup.php');
// use composer installed libraries
require_once('vendor/autoload.php');

function BoomSendSignupRequestMail() { 
  $mail = new PHPMailer;
  
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  
  $mail->Username = 'jikanter@gmail.com';
  $mail->Password = 'M0PRKc5vI8ZMk1Zf';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
  
  $mail->From = 'no-reply@jordankanter.com';
  // to
  $mail->addAddress('jikanter@gmail.com');
  $mail->Subject = "[Boomshaka] Site Request: {$_POST['firstname']} {$_POST['lastname']} for {$_POST['domain']}";
  $mail->Body = "Name: {$_POST['firstname']} {$_POST['lastname']}\n";
  $mail->Body .= "Email: {$_POST['email']}\n";
  // TODO: turn this into an output of a whois query
  $mail->Body .= "Desired Domain (Eventually this will be a whois query): {$_POST['domain']}";
  
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
    $flash = "Thank You! Our Hamsters are on their wheels  will be firing up your site shortly.";
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