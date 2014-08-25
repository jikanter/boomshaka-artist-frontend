<?php
require_once('config.php');
// also known as the attachment id in the wordpress api
$media_id = preg_replace('/[^0-9]/', '', $_GET['media_id']);
$request = xmlrpc_encode_request("wp.getMediaItem", array(0, $username, $password, $media_id));
$context = stream_context_create(array('http' => array(
                        'method' => 'POST',
                        'header' => 'Content-Type: text/xml',
                        'content' => $request)));
$data = file_get_contents($endpoint, false, $context);
$response = xmlrpc_decode($data);
if ($response && xmlrpc_is_fault($response)) { 
  trigger_error("xmlrpc: {$response[faultString]}, {$response[faultCode]}");
}
else { 
  echo("<!DOCTYPE HTML>");
  echo("<html>");
  echo("<head>");
  echo("<script src='scripts/dropzone.js' type='text/javascript'></script>");
  echo("</head>");
  echo("<body>");
  if (defined('WP_DEBUG')) { 
    echo("<pre>");
    print_r($response);
    echo("</pre>");
  }
  echo("<h1>{$response[title]}</h1>");
  if ($GET['flash'] != '') { 
    echo("<h2 style='color: green;'>" . $_GET['flash'] . '</h1>');
  }
  echo("<form id='artist-media-info' method='POST' enctype='application/x-www-form-urlencoded' action='update-media.php'>)");
  echo("<section>");
  echo("<input name='media_filename' type='file' accept='.jpeg,.jpg,.jpe,image/jpeg,.png,image/png,.gif,image/gif,.pdf,application/pdf'>");
  echo("</input>");
  echo("<input value='Update Media' type='submit' />");
  echo("<input value='{$media_id}' type='hidden' />"); // I do not actually use this when setting a media item
  echo("</form>");
  echo("</body>");
  echo("<html>");
}
?>