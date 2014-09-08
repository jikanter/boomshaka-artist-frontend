<?php
/**
 * Utility functions for wordpress upload media
 * @package None
 * @subpackage None
 * @since 3.9.2
 */

require_once('config.php');
require_once('media-class.php');
require_once('Contrib/IXR_Library.php');

//define('WP_DEBUG', TRUE);

if (isset($_GET['media_id'])) {
  $media_id = preg_replace('/[^0-9]/', '', $_GET['media_id']);
}
else { 
  $media_id = $artist_posts['media'];
}

function checkUploadedFileOkP($uploadFileName) {
  // $uploadFileName is the file name such that $_FILES[$uploadedFileName]['error'] -> the file error
  // returns $uploadedFileName
  try {
    if ((!isset($_FILES[$uploadFileName]['error'])) || (is_array($_FILES[$uploadFileName]['error']))) { 
      throw new RuntimeException('Invalid file parameters');
    }

  switch($_FILES[$uploadFileName]['error']) { 
    case UPLOAD_ERR_OK:
      break;
    case UPLOAD_ERR_NO_FILE:
      throw new RuntimeException('No file send.');
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
      throw new RuntimeException('Exceeded filesize limit.');
    default:
      throw new RuntimeException('Unknown errors');
    } 
  }
  catch (RuntimeException $e) {
    echo($e->getMessage());
  }
  return $uploadFileName;
}

function checkUploadedFileSizeP($uploadFileName) { 
  // $uploadFileName is the file name such that
  // $_FILES[$uploadFileName]['size'] is the uploaded File Size
  // return the $uploadFileName
  try { 
    // check the file size
    if ($_FILES[$uploadFileName]['size'] > 1000000) { 
      throw new RuntimeException('Exceeded filesize limit.');
    }
  } catch (RuntimeException $e) { 
    echo($e->getMessage());
  }
  return $uploadFileName;
}

function checkUploadedFileTypeP($uploadFileName) {
  $finfo = new finfo(FILEINFO_MIME_TYPE);
  try { 
    if (false === $ext = array_search(
        $finfo->file($_FILES[$uploadFileName]['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf'
          ),
          true
        )) {
            throw new RuntimeException('Invalid file format.');
          }
        } catch (RuntimeException $e) { 
            echo($e->getMessage());
  }
  return $uploadFileName;
} 

function moveUploadedFileIntoStaging($uploadFileName) { 
  // move the uploaded file into staging
  // where $uploadFileName the file name such that
  // $_FILES[$uploadFileName]['tmp_name'] is the temporary name of the file
  // return the full path to the uploaded file
  $finfo = new finfo(FILEINFO_MIME_TYPE);

  // get the extension from the mimetype of the file
  $fileExtensionFromMimeTypeArray = array("image/jpeg"      => 'jpg',
                                          "image/png"       => 'png',
                                          "image/gif"       => 'gif',
                                          "application/pdf" => 'pdf');
  $ext = $fileExtensionFromMimeTypeArray[$finfo->file($_FILES[$uploadFileName]['tmp_name'])];
  var_dump($fileExtensionFromMimeTypeArray["image/jpeg"]);
  try { 
    $newFileName = sprintf('./uploads/%s.%s', sha1_file($_FILES[$uploadFileName]['tmp_name']), $ext);
    if (!move_uploaded_file($_FILES[$uploadFileName]['tmp_name'], $newFileName)) { 
      var_dump($_FILES);
      throw new RuntimeException('Failed to move uploaded file');
    }
  } catch (RuntimeException $e) { 
    echo($e->getMessage());
  }
  return $newFileName;
}

function PdfFileP($filename) {
  /* returns the $fname if $filename is a pdf file, NULL otherwise */
  if (!is_file($filename)) {
    return NULL;
  }
  else {
    $handle = fopen($filename, "rb");
    $contents = fread($handle, 4);
    fclose($handle);
    if (substr($contents,1,3) == "PDF") {
      return $filename;
    }
  }
  return NULL;
}


// if the file is good, move it into staging for wordpress
function runUpload($filename) { 
  // run the upload routines on the file name, return the path to the file in staging
  try  {
    checkUploadedFileOkP($filename);
    checkUploadedFileTypeP($filename);
    checkUploadedFileSizeP($filename);
    $stagedFilePath = moveUploadedFileIntoStaging($filename);
  } catch (RuntimeException $e) { 
    echo($e->getMessage());
  }
  return $stagedFilePath;
}

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

function debugUploaderContents($uploader) {
  // uploader is an instance of Boom_MediaUpload
  // print the contents of the object if 'WP_DEBUG' is set
  // also set the bits to something managable temporarily unless it is small
  // return the instance
  if (defined('WP_DEBUG')) { 
    if (strlen($uploader->bits) > 2048) { 
      $_tmp_bits = $uploader->bits;
      $uploader->bits = '|binary-content|'; 
    }
    echo('<pre>');
    print_r($uploader);
    echo('</pre>');
    if (isset($_tmp_bits)) { $uploader->bits = $_tmp_bits; }
  }
  return $uploader;
}

$status = array('jpg' => 'Thank you. JPEG uploaded',
                'png'  => 'Thank you. PNG uploaded',
                'gif'  => 'Thank you. GIF uploaded',
                'pdf'   => 'Thank you. PDF uploaded');

$finfo = new finfo(FILEINFO_MIME_TYPE);
$fname = 'media-file';
$stagedFilePath = runUpload($fname);
// get the file extension index (jpg | png | gif | pdf)
// get the type of the post                 
$postType = $finfo->file($stagedFilePath);
$uploader = new Boom_MediaUpload($stagedFilePath, $postType, $media_id, new IXR_Base64(binaryContents($stagedFilePath)));
$xmlClient = new IXR_Client($endpoint);
$xmlClient->query('wp.uploadFile', array(0, $username, $password, $uploader));
$data = $xmlClient->getResponse();
if (!$data) {
    throw new RuntimeException('Media file not uploaded. 404 returned.');
}
else {
    if (defined('WP_DEBUG')) { 
      var_dump($stagedFilePath);
    }
    //var_dump($uploader);
    // get the status message from the mimetype (<type>/<subtype>) string by extracting just the <subtype> part
    $fileExtensionFromMimeTypeArray = array("image/jpeg"      => 'jpg',
                                            "image/png"       => 'png',
                                            "image/gif"       => 'gif',
                                            "application/pdf" => 'pdf');
    $message = $status[$fileExtensionFromMimeTypeArray[$postType]];
    header("Location: media.php?media_id={$media_id}&flash=".urlencode($message));
  }
?>