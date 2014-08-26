<?php
/*
 * Media Upload Class. Represents a media object for upload into wordpress
 */
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

?>