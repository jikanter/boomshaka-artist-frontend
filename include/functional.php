<?php

// Boomshaka functional programming library, inspired by pharen (http://pharen.org)

class Boom_Functional { 
  public static $_root = FALSE;
  public static $_current = array( 'node' => FALSE, 'env' => FALSE);
  public static $functions = array();
}

function defGeneric($fun, $args = array()) { 
  if (sizeof($args) > 0) { 
    Boom_Functional::$functions[] = array($fun => $args);
  }
  return Boom_Functional::$functions[] = $fun;
}

function funCall($fun, $args) { 
  // call the function with name $fun with args $args
  call_user_func_array(__NAMESPACE__ . 'Boom_Functional::$functions[' . $fun . ']', $args);
}

?>