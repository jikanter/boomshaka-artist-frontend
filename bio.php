<?php
/* test xml app
 */
//define('WP_DEBUG', true);
require_once('config.php');
require_once('views/bio.php');

$post_id = $artist_posts['bio'];
$request = xmlrpc_encode_request("wp.getPost", array(0, $username, $password, $post_id));
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
  if (isset($_GET['flash'])) { 
    BoomRenderBio($post_id, $response, $_GET['flash']);
  }
  else {
    BoomRenderBio($post_id, $response);
  }
}
?>
