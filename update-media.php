<?php
/**
 * Utility functions for wordpress upload media
 * @package None
 * @subpackage None
 * @since 3.9.2
 */
/* TODO: Write Tests */

require_once('config.php');
require_once(LIBRARY_DIR . '/functional.php');
require_once(LIBRARY_DIR . '/media-class.php');
require_once(INCLUDE_DIR . '/IXR_Library.php');

if (isset($_GET['media_id'])) {
  $media_id = preg_replace('/[^0-9]/', '', $_GET['media_id']);
}
else { 
  $media_id = $artist_posts['media'];
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

function binaryContents($filename) { 
  // takes a file name and reads the binary contents of the file (for platforms
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
};

function checkUploadedFileTypeP($uploadFileName) {
  $finfo = new finfo(FILEINFO_MIME_TYPE);
  try { 
    if (false === $ext = array_search(
        $finfo->file($_FILES[$uploadFileName]['tmp_name']),
        array(
            'jpeg' => 'image/jpeg',
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
  //print_r($uploadFileName);
  $ext = $fileExtensionFromMimeTypeArray[$finfo->file($_FILES[$uploadFileName]['tmp_name'])];
  //var_dump($fileExtensionFromMimeTypeArray["image/jpeg"]);
  try { 
    $newFileName = sprintf('./uploads/%s.%s', sha1_file($_FILES[$uploadFileName]['tmp_name']), $ext);
    if (!move_uploaded_file($_FILES[$uploadFileName]['tmp_name'], $newFileName)) { 
      //var_dump($_FILES);
      throw new RuntimeException('Failed to move uploaded file');
    }
  } catch (RuntimeException $e) { 
    echo($e->getMessage());
  }
  return $newFileName;
}
// debug functions 
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
    /*echo('<pre>');
    print_r($uploader);
    echo('</pre>');*/
    if (isset($_tmp_bits)) { $uploader->bits = $_tmp_bits; }
  }
  return $uploader;
}

function runUpload($filename) { 
  // run the upload routines on the file name, return the path to the file in 
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


// function BoomUploadMedia($fname, $endpoint) {
//   // TODO: make this function WORK
//   // uploads the file contained in $fname to the wordpress xml-rpc endpoint at $endpoint.
//   // $fname is name= parameter for the file object in the form
//   // $endpoint is the configured XML-RPC endpoint
//   // returns the $xmlRpc data object from the file upload
//   $finfo = new finfo(FILEINFO_MIME_TYPE);
//   // do the upload into staging
//   $stagedFilePath = runUpload($fname);
//   // get the mime-type from the file extension of the uploaded file (jpg | png | gif | pdf)
//   $postType = $finfo->file($stagedFilePath);
//   // get the wordpress uploader
//   $uploader = new Boom_MediaUpload($stagedFilePath, $postType, $media_id, new IXR_Base64(binaryContents($stagedFilePath)));
//   // get the IXR XML-RPC data client. endpoint comes from the config.php
//   $xmlClient = new IXR_Client($endpoint);;
//   // run the upload file query
//   $xmlClient->query('wp.uploadFile', array(0, $username, $password, $uploader));
//   // return the servers response
//   return $xmlClient->getResponse();
// }

$status = array('jpg' => 'Thank you. JPEG uploaded ',
                'png'  => 'Thank you. PNG uploaded',
                'gif'  => 'Thank you. GIF uploaded',
                'pdf'   => 'Thank you. PDF uploaded');

$finfo = new finfo(FILEINFO_MIME_TYPE);
$fname = 'media-file';
$stagedFilePath = runUpload($fname);
// get the mimeType from the file extension (jpg | png | gif | pdf)                 
$postType = $finfo->file($stagedFilePath);
$uploader = new Boom_MediaUpload($stagedFilePath, $postType, $media_id, new IXR_Base64(binaryContents($stagedFilePath)));
$xmlClient = new IXR_Client($endpoint);
$xmlClient->query('wp.uploadFile', array(0, $username, $password, $uploader));

$data = $xmlClient->getResponse();
if (!$data) {
    throw new RuntimeException('Media file not uploaded. 404 returned.');
}
else {
    // get the status message from the mimetype (<type>/<subtype>) string by extracting just the <subtype> part
    // using this array
    $fileExtensionFromMimeTypeArray = array("image/jpeg"      => 'jpg',
                                            "image/png"       => 'png',
                                            "image/gif"       => 'gif',
                                            "application/pdf" => 'pdf');
    $message = $status[$fileExtensionFromMimeTypeArray[$postType]];
    //header("Location: media.php?media_id={$media_id}&flash=".urlencode($message));
    //echo($stagedFilePath);
  }
?>