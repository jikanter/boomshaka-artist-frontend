<?php

require_once('config.php');

// include the product client api
require_once(INCLUDE_DIR . "/class-wc-api-client.php");


class Boom_Product_Api { 
  /*
   * This class implements the Boom_Product_Api, which extends the WooCommerce API by adding a client method for
   * Add_Product (We need this because we need to be able to set up a product from our client)
   */
  
  /**
   * @access public
   * @var string
   */
  public $title;
  
  /**
   * @access public
   * @var object
   */
  public $client;
  
  /**
   * @access public
   * @var array
   * includes all product attributes including title, description, price, length, width, height, weight, images in_stock
   */
  public $product_fields;
  
  
  /**
   * @access public
   * @var array 
   * the current product. May be the product created or the product fetched to edit
   */
  public $product;
  
  
  
  function __construct($action = 'get', $product_title = '', $product_description = '', $product_price = '', $product_length = '11', $product_width = '1.5', $product_height = '8.5', $product_weight = '0.63', $product_images = '', $in_stock = TRUE, $post_id = FALSE) { 
    // reference the global variable defined in config.php
    global $artist_posts;
    if (!$post_id) { $post_id = $artist_posts['piece']; }
    $this->product_fields = array(
      //'type' => 'simple',  // only simple products are supported. This gets set automatically in the API
      'title' => $product_title,
      'short_description' => $product_description,
      '_regular_price' => $product_price,
      '_length' => $product_length,
      '_width' => $product_width,
      '_height' => $product_height,
      '_weight' => $product_weight,
      'images' => $product_images,
      'in_stock' => $in_stock,
      'post_id' => $post_id
    );
    
    $this->client = $this->createClient();
    
    // run the api method here
    
    if ($action == 'create') { 
      // productize the artist image here object here
      $this->product = $this->client->create_product($this->product_fields);
    }
    
    if ($action == 'get') { 
      $this->product = $this->client->get_product($this->product_fields['post_id']);
    }
    
    if ($action == 'edit') { 
      $this->product = $this->client->edit_product($this->product_fields);
    }
    
    if ($action == 'delete') { 
      $this->product = $this->client->delete_product($this->product_fields);
    }
  }
  
  function createClient() { 
    global $wc_config; // reference the global variable defined in config.php
    return new WC_API_Client( $wc_config['consumer_key'], $wc_config['consumer_secret'], $wc_config['store_url'] );
  }
}
?>