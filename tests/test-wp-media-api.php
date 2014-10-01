<?php
require_once('../config.php');
require_once('../media-class.php');
require_once('../Contrib/IXR_Library.php');

function binaryContents($filename) { 
  // takes a file name and reads the binary contents of the file (for platforms that distinguish between binary and text) 
  // returns the contents
  try {
    if (!is_file($filename)) { 
      throw new RuntimeException('file passed is not a file');
    }
    $handle = fopen($filename, "rb");
    $contents = fread($handle, filesize($filename));
    if (($contents == '') || ($contents == NULL)) { 
      throw new RuntimeException('File contents is empty');
    }
    fclose($handle);
  } catch (RuntimeException $e) { 
    echo($e->getMessage());
  }
  return $contents;
}
$stagedFilePath = '../uploads/26962fda31ac4a87f31ecc87d65b31bf2498a3aa.jpg';
$postType = 'image/jpeg';
$mediaId = 14;
$uploader = new Boom_MediaUpload($stagedFilePath, $postType, $mediaId, new IXR_Base64(binaryContents($stagedFilePath)));
$xmlClient = new IXR_Client($endpoint);
$xmlClient->query('wp.uploadFile', array(0, $username, $password, $uploader));
print_r($xmlClient->getResponse());
?>