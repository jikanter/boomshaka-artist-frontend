<?php
try { 
  
  // Register an autoLoader
  $loader = new \Phalcon\Loader();
  $loader->registerDirs(array(
    '../app/controllers',
    '../app/models/'
  ))->register();
  
  // Create a DI
  $di = new Phalcon\DI\FactoryDefault();
  
  // Setup the database service
  $di->set('db', function() { 
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
      "host" => "localhost",
      "username" => "admin",
      "password" => "",
      "dbname" => "webapps"
    ));
    
  });  
  
  // Setup the view component
  $di->set('view', function() { 
    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir('../app/views/');
    return $view;
  });
  
  // Setup a base URI so that all generated URIs include the "test-phalcon-app" folder
  $di->set('url', function() { 
    $view = new \Phalcon\Mvc\Url();
    $url->setBaseUri('/~admin/2014/7/21/tests/test-phalcon-app/');
    return $url;
    
  });
  
  $application = new \Phalcon\Mvc\Application($di);
  
  echo $application->handle()->getContent();
  
} catch (\Phalcon\Exception $e) { 
  echo "PhalconException: ", $e->getMessage();
}
?>