<?php
/* all paths in this (and all view scripts are relative to the top level directory)
/* render a media object that is NOT a piece, but is attached to a piece */
function BoomRenderMedia($media_id = 14, $response = array(), $flash = '') { 
  echo("<!DOCTYPE HTML>");
  echo("<html>");
  echo("<head>");
  echo("<script src='scripts/jquery.js' type='text/javascript'></script>");
  echo("<script src='scripts/dropzone.js' type='text/javascript'></script>");
  echo("<script src='scripts/config.js' type='text/javascript'></script>");
  echo("<link rel='stylesheet' href='styles/style.css' type='text/css' />");
  echo("<link rel='stylesheet' href='styles/dropzone.css' type='text/css' />");
  echo("</head>");
  echo("<body class='artist-frontend'>");
  /*if (defined('WP_DEBUG')) { 
    echo("<pre>");
    print_r($response);
    echo("</pre>");
  }*/
  //gecho("<h1>{$response['title']}</h1>");
  echo("<form id='artist-media-info' method='POST' enctype='multipart/form-data' action='update-media.php' class='dropzone'>");
  echo("<section>");
  echo("<input name='productize' type='checkbox' />");
  // echo("<label for='productize'> These media objects are <a target='productize these media files after uploading'>products</a> (productize these media files after uploading)</label>");
  echo("</section>");
  echo("<div class='fallback'>"); // if dropzone does not work
  echo("<section>"); 
  echo("<label for='media-file'>Upload your image by Choosing a file. Please note we support jpeg, png, gif, and pdf files. </label>");
  echo("<input name='media-file' type='file' accept='.jpeg,.jpg,.jpe,image/jpeg,image/jpg,.png,image/png,.gif,image/gif,.pdf,application/pdf'>");
  echo("</input>");
  echo("</section>");
  echo("</div>");
  echo("<section>");
  //echo("<input value='Update Media' type='submit' />");
  echo("</section>");
  // I do not actually use this when setting a media item because we are uploading multiple media items. For each item that we upload as a product i set
  echo("<input name='piece_id' value='{$piece_id}' type='hidden' />");
  echo("<input name='media_id' value='{$media_id}' type='hidden' />"); 
  echo("</form>");
  echo("</body>");
  echo("<html>");
}
?>