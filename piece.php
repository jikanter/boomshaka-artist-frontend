<?php
require_once('config.php');

// require the piece view
require_once(VIEW_DIR . '/piece.php');

// require the Boom product api
require_once(LIBRARY_DIR . '/product-class.php');

// sanitize the post_id. make sure 
if (isset($_GET['post_id'])) { 
  $post_id = preg_replace('/[^0-9]/', '', $_GET['post_id']);
}
else { 
  $post_id = $artist_posts['piece'];
}
$request = xmlrpc_encode_request("wp.getPost", array(0, $username, $password, $post_id));
$context = stream_context_create(array('http' => array(
								       'method' => 'POST', 
									     'header' => 'Content-Type: text/xml', 
									     'content' => $request)));
$data = file_get_contents($endpoint, false, $context);
$response = xmlrpc_decode($data);

$product_data = new Boom_Product_Api();
$response['product'] = $product_data;


if ($response && xmlrpc_is_fault($response)) { 
	trigger_error("xmlrpc: {$response['faultString']}, {$response['faultCode']}");
} 
else { 
  if (isset($_GET['flash'])) { 
	  BoomRenderPiece($post_id, $response, $_GET['flash']);
  }
  else { 
    BoomRenderPiece($post_id, $response);
  }
}
?>