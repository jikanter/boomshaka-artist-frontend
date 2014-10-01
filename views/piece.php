<?php
function BoomRenderPiece($post_id = 1, $response = array(), $flash = '') {
	echo("<!DOCTYPE HTML>");
  echo("<html>");
  echo("<head>");
   echo '<link rel="stylesheet" href="styles/style.css" type="text/css">"';
  echo("</head>");
  echo("<body>");
	if (defined('WP_DEBUG')) {
    echo("<pre>");
    print_r($response);
    echo("<pre>");
  }
	echo("<h1>{$response['post_title']}</h1>");
  if ($flash != '') { 
    echo("<h2 style='color: green;'>" . $flash . "</h2>");
  }
  echo("<div><img src='{$response['post_thumbnail']['thumbnail']}'></div>");
	echo("<form id='artist-piece-info' method='POST' enctype='application/x-www-form-urlencoded' action='update-post.php'>");
	echo("<textarea form='artist-piece-info' name='content' rows='20' cols='200'>");
  // use the exerpt here instead of the content because this is a product to sell.
	echo("{$response['post_excerpt']}");
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
  echo("<label for='piece_length'>Length:</label>");
  echo("<input name='piece_length' type='text' />");
  echo("</section>");
  echo("<section>");
  echo("<label for='piece_weight'>Weight (lbs):</label>");
  echo("<input name='piece_weight' type='text' />");
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