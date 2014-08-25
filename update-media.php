<?php
/**
 * Utility functions for wordpress upload media
 * @package None
 * @subpackage None
 * @since 3.9.2
 */
require_once('config.php');

$status = array(
  'jpg' => 'Image uploaded',
  'png'  => 'Image uploaded',
  'gif'  => 'Image uploaded',
  'pdf'   => 'PDF uploaded',
);
$post_mimetype = array(
  'jpg' => 'image/jpeg',
  'png' => 'image/png',
  'gif' => 'image/gif',
  'pdf' => 'application/pdf'
);

class Boom_MediaUpload { 
  /**
   * @access public
   * @var string
   */
  var $name; // filename
  
  /**
   * @access public
   * @var string
   */
  var $type; // file MIME/TYPE
  
  /**
   * @access public
   * @var binary
   */
  var $bits;
  
  /**
   * Whether to overwrite the data in the wordpress instance. defaults to true;
   * @access public
   */
  var $overwrite = true;
  
  function ___construct($name, $type, $bits) { 
    $this->name = $name;
    $this->type = $type;
    $this->bits = $bits;
    $this->overwrite = $overwrite;
  }
};

$post_type = $_POST['media_type'];
// check the post_type in the upload file, then set the mimetype (using itself)
if (($post_type == 'jpg') || ($post_type == 'jpg') || ($post_type == 'jpe')) { 
  $post_type = 'jpg';
  $post_mimetype = $post_mimetype[$post_type];
}
else if (($post_type == 'png')) { 
  $post_type = 'png'; // technically this is unecessary, but setting it for documentation purposes
  $post_mimetype = $post_mimetype[$post_type];
}
else if (($post_type == 'gif')) { 
  $post_type = 'gif'; // technically this is unecessary, but setting it for documentation purposes
  $post_mimetype = $post_mimetype[$post_type];
}

$uploader = new Boom_MediaUpload($_POST['media_filename'], $post_mimetype, base64_decode($_POST['content']);

$request = xmlrpc_encode_request('wp.uploadFile', array(0, $username, $password, $uploader));
$context = stream_context_create(array('http' => array(
									   'method' => 'POST',
									   'header' => 'Content-Type: text/xml',
									   'content' => $request)));
$data = file_get_contents($endpoint, false, $context);
if (!$data) { 
  trigger_error('Media file not uploaded. 404 returned.');
}
else { 
  $message = $status[$post_type];
  header("Location: media.php?flash=".urlencode($message));
}
?>