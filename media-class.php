<?php
/*
 * Media Upload Class. Represents a media object for upload into wordpress
 */

// woocommerce productizer
require_once('include/product-class.php');
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
  
  /**
   * whether to create a woocommerce product based on this media object
   * @access public
   * @var object
   * if this is not false, it is the product that represents this media object
   */
  public $productp;
  
  function __construct($name, $type, $postid, $bits) { 
    $this->name = $name;
    $this->type = $type;
    $this->bits = $bits;
    $this->overwrite = true;
    $this->postid = $postid;
  }
  
  function productize_media() { 
    $this->productp = new Boom_Product_Mixin($this->name);
  }
  
};

?>