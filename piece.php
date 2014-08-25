<?php
require_once('config.php');
// sanitize the post_id. make sure 
$post_id = preg_replace('/[^0-9]/', '', $_GET['post_id']);
$request = xmlrpc_encode_request("wp.getPost", array(0, $username, $password, $post_id));
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
  //DAN GO!
  echo("</head>");
  echo("<body>");
	if (defined('WP_DEBUG')) { 
		echo("<pre>");
		print_r($response);
		echo("<pre>");
	}
	echo("<h1>{$response[post_title]}</h1>");
	if ($_GET['flash'] != '') {  
		echo("<h2 style='color: green;'>" . $_GET['flash'] . "</h2>");
	}
	echo("<form id='artist-piece-info' method='POST' enctype='application/x-www-form-urlencoded' action='update-post.php'>");
	echo("<textarea form='artist-piece-info' name='content' rows='20' cols='200'>");
	echo("{$response[post_content]}");
	echo("</textarea>");
  echo("<section>");
  echo("<label for='piece_price'>Price:</label>");
  echo("<input name='piece_price' type='text' />");
  echo("</section>");
  echo("<section>");
  echo("<label for='piece_width'>Width:</label>");
  echo("<input name='piece_width' type='text' />");
  echo("</section>");
  echo("<section>");
  echo("<label for='piece_height'>Height:</label>");
  echo("<input name='piece_height' type='text' />");
  echo("</section>");
  echo("<section>");
  echo("<label for='piece_length'>Length:</label>"
  echo("<input name='piece_length' type='text' />");
  echo("</section>");
  echo("<br />"); // get rid of this
	echo("<input value='Update Post' type='submit' />");
	echo("<input name='post_type' value='piece' type='hidden' />");
	echo("<input name='post_id' value='${post_id}' type='hidden' />");
	echo("</form>");
  echo("</body>");
  echo("</html>");
}
?>