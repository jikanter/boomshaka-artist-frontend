<?php
/* test xml app
 */
require_once('config.php');
$post_id = $artist_posts['contact']; // the contact page
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
	if (defined('WP_DEBUG')) { 
		echo("<pre>");
		print_r($response);
		echo("<pre>");
	}
	echo("<h1>{$response[post_title]}</h1>");
	if ($_GET['flash'] != '') {  
		echo("<h2 style='color: green;'>" . $_GET['flash'] . "</h2>");
	}
	echo("<form id='artist-contact-info' method='POST' enctype='application/x-www-form-urlencoded' action='update-post.php'>");
	echo("<textarea form='artist-contact-info' name='content' rows='20' cols='200'>");
	echo("{$response[post_content]}");
	echo("</textarea>");
	echo("<input name='post_type' value='contact' type='hidden' />");
	echo("<input name='post_id' value='${post_id}' type='hidden' />");
	echo("<input value='Update Post' type='submit' />");
	echo("</form>");
}
?>
