<?php
/**
 * Utility functions for wordpress upload post
 * @package None
 * @subpackage None
 * @since 3.9.2
 */
require_once('config.php');
// not used
$status = array(
	'contact' => "Contact info updated",
	'bio' => "Artist biography updated",
	'archive' => "Piece archive updated"
);
$post_id = intval($_POST['post_id']);
$post_type = $_POST['post_type'];
$content = array('post_content' => urldecode($_POST['content']));
$request = xmlrpc_encode_request("wp.editPost", array(0, $username, $password, $post_id, $content));
$context = stream_context_create(array('http' => array(
									   'method' => 'POST',
									   'header' => 'Content-Type: text/xml',
									   'content' => $request)));
$data = file_get_contents($endpoint, false, $context);
if (!$data) {
	trigger_error("post not found. 404 returned");
}
else {
	$message = $status[$post_type];
	header("Location: {$post_type}.php?flash=".urlencode($message));
}
?>