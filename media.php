<?php
require_once('config.php');

// require the media view
require_once(VIEW_DIR . '/media.php');

// require the Boom media classes (This includes the product api)
require_once(LIBRARY_DIR . '/media-class.php');

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
  if ((isset($_GET['flash'])) && ($_GET['flash'] != '')) { 
    BoomRenderMedia($media_id, $response, $_GET['flash']);
  }
  else { 
    BoomRenderMedia($media_id, $response);
  }
}
?>