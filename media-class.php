<?php
/*
 * Media Upload Class. Represents a media object for upload into wordpress
 */

class Boom_MediaUpload { 
  /**
   * @access public
   * @var string
   */
  public $name; // filename
  
  /**
   * @access public
   * @var string
   */
  public $type; // file MIME/TYPE
  
  /**
   * @access public
   * @var binary
   */
  // TODO: base64 encode the bits correctly for wordpress upload!
  public $bits;
  
  /**
   * Whether to overwrite the data in the wordpress instance. defaults to true;
   * @access public
   */
  public $overwrite;
  
  /**
   * whether to assign this data to a post id
   * @access public 
   * @var integer
   */
  public $postid;
  
  function __construct($name, $type, $postid, $bits) { 
    $this->name = $name;
    $this->type = $type;
    $this->bits = $bits;
    $this->overwrite = true;
    $this->postid = $postid;
  }
};

?>