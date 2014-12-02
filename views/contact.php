<?php
function BoomRenderContact($post_id = 1, $response = array(), $flash = '') { 
	echo("<!DOCTYPE HTML>");
	  echo '<head>';
	  echo ' <link rel="stylesheet" href="styles/style.css" type="text/css">';
	  echo '</head>';
	  echo '<body>';	
		
	 echo("<h1>{$response['post_title']}</h1>");
	if ($flash != '') {  
		echo("<h2 role='flash' style='color: green;'>" . $flash . "</h2>");
	}
	echo("<form id='artist-contact-info' method='POST' enctype='application/x-www-form-urlencoded' action='update-post.php'>");
	echo("<textarea form='artist-contact-info' name='content' rows='20' cols='200'>");
	echo("{$response['post_content']}");
	echo("</textarea>");
	echo("<input name='post_type' value='contact' type='hidden' />");
	echo("<input name='post_id' value='${post_id}' type='hidden' />");
	echo("<input value='Update Post' type='submit' />");
	echo("</form>");

	echo '</body>';
	echo '</html>';	
}
?>