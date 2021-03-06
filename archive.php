<?php
/* test xml app - Retrieve the piece archive */

class ArchiveFilter { 
  var $post_type = "piece";
  var $post_status = "publish"; // only the published posts
}

$archive = new ArchiveFilter;

require_once('config.php');
$post_id = $artist_posts['archive']; // the archive page
$request = xmlrpc_encode_request("wp.getPosts", array(0, $username, $password, $archive));
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
		echo '<head>';
    	echo ' <link rel="stylesheet" href="styles/style.css" type="text/css">';
		echo '</head>';
		echo '<body>';	
		echo '<h1>Archive</h1>';	
		
	if (defined('WP_DEBUG')) { 
		echo("<pre>");
		print_r($response);
		echo("<pre>");
	}
  // will not have a {$response[post_title]} because this is a list of posts
  for ($i = 0; $i < sizeof($response); $i++) {
    $response_content_item = $response[$i];
    echo("<h2>{$response_content_item[post_title]}</h2>");
    if ($_GET['flash'] != '') {  
    	echo("<h2 style='color: green;'>" . $_GET['flash'] . "</h2>");
    }
    echo("<form id='artist-contact-info' method='POST' enctype='application/x-www-form-urlencoded' action='update-post.php'>");
    echo("<textarea form='artist-archive-info' name='content' rows='20' cols='200'>");
    echo("{$response_content_item[post_content]}");
    echo("</textarea>");
    echo("<input name='post_type' value='archive' type='hidden' />");
    echo("<input name='post_id' value='{$response_content_item[post_id]}' type='hidden' />");
    echo("<input value='Update Post' type='submit' />");
    echo("</form>");
  }

	echo '</body>';
	echo '</html>';
}
?>
