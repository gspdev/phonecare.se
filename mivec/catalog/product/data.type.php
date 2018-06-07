<?php
require dirname(__FILE__) . "/config.php";
header("Content-Type: text/html;charset=utf-8"); 
define("__ATTR_PRODUCT_STATUS__" , 96);
define("__ATTR_PRODUCT_STATUS_ENABLED__" , 1);
define("__ATTR_PRODUCT_STATUS_DISABLED__" , 2);
define("__ATTR_PRODUCT_NUMBER_STOCK__" , 10000);
define("__ATTR_PRODUCT_IN_STOCK__" , 1);
define("__ATTR_PRODUCT_STOCK_ITEM__" , "cataloginventory_stock_item");

//set product status is `Enabled`
	  
    // $categoryid = 2658;
	// $category = new Mage_Catalog_Model_Category();
	// $category->load($categoryid);
	// $collection = $category->getProductCollection();
	// $collection->addAttributeToFilter('status', 1);//optional for only enabled products
    // $collection->addAttributeToFilter('visibility', 4);//optional for products only visible in catalog and search
	// $collection->addAttributeToSelect('*');    
	$cat = Mage::getModel('catalog/category')->load(2659);
//$cat = Mage::getModel('catalog/category')->load(173);
	if(!$cat->getChildren()){
		$subcats = $cat->getEntityId();
	}else{
		$subcats = $cat->getChildren();
	}
	echo ('Produktnamn;Kategori;Artikelnnr;Pris;URL;Tillgänglighet;Skick;Image_URL').'<br/>';	
	foreach(explode(',',$subcats) as $subCatid){
	
	      $_category = Mage::getModel('catalog/category')->load($subCatid);
          $products = Mage::getModel('catalog/category')->load($_category->getEntityId())
          ->getProductCollection()
		  ->addAttributeToFilter('status', 1)//optional for only enabled products
          ->addAttributeToFilter('visibility', 4)//optional for products only visible in catalog and search
          ->addAttributeToSelect('*');
	
   
   // print_r(count($collection));
	foreach($products as $_product)  {
		
		  
		    $name = trim($_product->getName());
			$sku = trim($_product->getSku());
			$price_us = $_product->getPrice();
			$goods_url = $_product->getProductUrl();
			$visibility= $_product->getVisibility();
			if($visibility==4){
				$echovisibility = 'Avhämtning / leverens';
			}
			$img =Mage::helper('catalog/image')->init($_product, 'image')->resize(265);
			$categoryIds = implode('|', $_product->getCategoryIds());//change the category separator if needed
			$_category = Mage::getModel('catalog/category')->load($categoryIds);
			//$categoryData = $_category->getName();
			$categoryData = 'Mobiltelefon';
			if($_product->getData('status')==1){
				$Stock = 'Begagnat';
			}
			echo $name.';'.$categoryData.';'.$sku.';'.$price_us.';'.$goods_url.';'.$echovisibility.';'.$Stock.';'.$img.'<br/>';
			
			
	   // try {
            // $_id = $_product->getEntityId();
            // if (update($_id)) {
                // echo $_id . " update successfully<br>";
                // usleep(5);
            // }
        // } catch (Exception $e) {
            // print_r($e);
        // }
      
}
		  
}		  

// function update($_entityId)
// {
 
	// global $db;
    // $sql = "UPDATE " . __ATTR_PRODUCT_STOCK_ITEM__ . " SET `qty`=" . __ATTR_PRODUCT_NUMBER_STOCK__.", `is_in_stock`=".__ATTR_PRODUCT_IN_STOCK__.",manage_stock=1"." WHERE product_id=" . $_entityId;
    // return $db->query($sql);
// }
