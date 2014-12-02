<?php
require_once('config.php');


function DataBind($type = 'wordpress', $method = 'xml-rpc', $location = null, $d_username = null, $d_password = null) { 
    
    global $data_config;
    global $endpoint;
    global $username;
    global $password;
    
    if (!$location) { $location = $endpoint; }
    if (!$d_username) { $d_username = $username; }
    if (!$d_password) { $d_password = $password; }
    $data_config = array(
      'type' => $type, 
      'method' => $method, 
      'location' => $location,
      'username' => $username,
      'password' => $password
    );
    return $data_config;
    
}


function Data() { 
  // $type = 'sql';
  //   $method = 'mysql';
  //   $location = 'localhost';
  //   $username = 'admin';
  //   $password = '';
  //   $connection = mysqli_connect($location, $username, $password);
  //   $connection->close();
  // $type = 'wordpress';
//   $method = 'xml-rpc';
//   $location = '';
  return DataBind();
}

$b = Data();

var_dump($b);


?>