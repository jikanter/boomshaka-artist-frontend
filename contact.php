<?php
/* test xml app
 */
require_once('config.php');
// require the contact view
require_once(VIEW_DIR . '/contact.php');
// TODO: use IXR Library
$post_id = $artist_posts['contact']; // the contact page
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
    BoomRenderContact($post_id, $response, $_GET['flash']);
  } 
  else { 
    BoomRenderContact($post_id, $response);
  }
}
?>
