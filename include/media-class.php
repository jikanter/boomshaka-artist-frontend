<?php
/*
 * Media Upload Class. Represents a media object for upload into wordpress
 */

// woocommerce productizer, use the API Key in the config
require_once('../' . LIBRARY_DIR . '/product-class.php');

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
  
  
  /**
   * the product fields to pass to the product creation api
   * @access public
   * @var array
   */
  public $product_fields;
  
  
  function __construct($name, $type, $postid, $bits, $product_fields) { 
    $this->name = $name;
    $this->type = $type;
    $this->bits = $bits;
    $this->overwrite = true;
    $this->create_product = true;
    $this->postid = $postid;
    if (this->create_product) { 
      $this->productp = $this->productize_media($product_fields);
    }
  }
  
  function productize_media($product_fields) { 
    return new Boom_Product_Api(
      'create', // action
      $product_fields['title'], // title
      $product_fields['description'], // description
      $product_fields['price'], // price
      $product_fields['length'], // length
      $product_fields['width'], // width
      $product_fields['height'], // height 
      $product_fields['weight'], // weight
      $product_fields['images'], // images
      true // in_stock
    );
  }
  
};

?>