<?php

class SignupController extends \Phalcon\Mvc\Controller { 
  
  public function indexAction() { 
    
  }
  
  public function registerAction() { 
    
    $user = new Users();
    
    // Store and check for errors
    // wp_id -> wordpress id,
    // wp_pass -> wordpress password
    $success = $user->save($this->request->getPost(), array('name', 'email', 'wp_id', 'wp_pass'));
    
    if ($success) { 
      echo("Thanks for registering. Please wait while the robots configure your new site...");
    } else { 
      echo("Sorry, your signup request had some problems<br />");
      foreach ($user->getMessages() as $message) { 
        echo($message->getMessage() . "<br />");
      }
    }
    
    $this->view->disable();
  }
  
}
