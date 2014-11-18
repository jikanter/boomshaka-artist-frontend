<?php

// Boomshaka functional programming library, inspired by pharen (http://pharen.org)

class Boom_Functional { 
  public static $_root = FALSE;
  public static $_current = array( 'node' => FALSE, 'env' => FALSE);
  public static $_next = array(    'node' => FALSE, 'env' => FALSE);
  public static $functions = array();
  
  public function boomParse($node, $env = array(ENV)) { 
    if ($_current['node'] != FALSE) { 
      $_current['node'] = $node;
      $_current['env'] = $env;
    }
    else { 
      
    }
  }
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