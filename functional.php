<?php

class Boom_Functional { 
  public $functions = array();
}

function defGeneric($fun) { 
  $Boom_Functional->functions->push($fun);
}

function funCall($fun, $args) { 
  // call the function with name $fun with args $args
  call_user_func_array($fun, $args);
}

?>