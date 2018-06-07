<?php
require 'config.php';

//update price from USD-SEK
$_rate = 8.4316;
//ending entity_id=1819

// $sql = "SELECT entity_id,`value` as price,name FROM " . __TABLE_PRODUCT_PRICE__
    // //. " WHERE entity_id <=" . 1819
    // ." AND attribute_id=" . __ATTR_PRICE__
    // ." ORDER BY entity_id DESC";

$products = Mage::getModel('catalog/category')->load(89)
          ->getProductCollection()
          ->addAttributeToSelect('*');

foreach($products as $product)  {
       // echo $product->getEntityId() .'<br>';
      // // echo $product->getSku() .'<br>';
       // echo $product->getName() .'<br>';
      // echo "old: " . $product->getPrice() .'<br>';
       $newPrice = ($product->getPrice()- $product->getPrice());
     
	    try {
            if (updatePrice($product->getEntityId() , $newPrice)) {
                echo $product->getEntityId() . " Update Successfully<br>";
                usleep(5);
            }
        } catch (Exception $e) {
               print_r($e);
        }
	  
}  


function updatePrice($_entityId , $_price)
{
    global $db;
    $sql = "UPDATE " . __TABLE_PRODUCT_PRICE__ . " SET `value`=0.0000"
        ." WHERE entity_id=" . $_entityId;
        //." AND attribute_id=" . __ATTR_PRICE__;
    return $db->query($sql);
}