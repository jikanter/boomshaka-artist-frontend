<?php
require_once('config.php');
// also known as the attachment id in the wordpress api
if (isset($_GET['media_id'])) { 
  $media_id = preg_replace('/[^0-9]/', '', $_GET['media_id']);
}
else { 
  $media_id = $artist_posts['media'];
}
$request = xmlrpc_encode_request("wp.getMediaItem", array(0, $username, $password, $media_id));
$context = stream_context_create(array('http' => array(
                        'method' => 'POST',
                        'header' => 'Content-Type: text/xml',
                        'content' => $request)));
$data = file_get_contents($endpoint, false, $context);
$response = xmlrpc_decode($data);
if ($response && xmlrpc_is_fault($response)) { 
  trigger_error("xmlrpc: {$response['faultString']}, {$response['faultCode']}");
}
else { 
  echo("<!DOCTYPE HTML>");
  echo("<html>");
  echo("<head>");
  echo("<script src='scripts/jquery.js' type='text/javascript'></script>");
  //echo("<script src='scripts/dropzone.js' type='text/javascript'></script>");
  //echo("<script src='scripts/config.js' type='text/javascript'></script>");
  echo("</head>");
  echo("<body>");
  /*if (defined('WP_DEBUG')) { 
    echo("<pre>");
    print_r($response);
    echo("</pre>");
  }*/
  //gecho("<h1>{$response['title']}</h1>");
  if ((isset($_GET['flash'])) && ($_GET['flash'] != '')) { 
    echo("<h2 style='color: green;'>" . $_GET['flash'] . '</h1>');
  }
  echo("<form id='artist-media-info' method='POST' enctype='multipart/form-data' action='update-media.php'>");
  echo("<section>");
  echo("<label for='media-file'>Upload your image by Choosing a file. Please note we support jpeg, png, gif, and pdf files. </label>");
  echo("<input name='media-file' type='file' accept='.jpeg,.jpg,.jpe,image/jpeg,image/jpg,.png,image/png,.gif,image/gif,.pdf,application/pdf'>");
  echo("</input>");
  echo("</section>");
  echo("<section>");
  echo("<input value='Update Media' type='submit' />");
  echo("</section>");
  echo("<input value='{$media_id}' type='hidden' />"); // I do not actually use this when setting a media item
  echo("</form>");
  echo("</body>");
  echo("<html>");
}
?>