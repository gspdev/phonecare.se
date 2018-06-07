<?php
//require 'config.php';
require dirname(__FILE__) . "/config.php";

error_reporting(E_ALL | E_STRICT);
define('MAGENTO_ROOT', getcwd());
//$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
//require_once $mageFilename;
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
//Mage::app();
// $products = Mage::getModel("catalog/product")->getCollection();
// $products->addAttributeToSelect('For iPhone');
// $products->addAttributeToFilter('status', 1);//optional for only enabled products
// $products->addAttributeToFilter('visibility', 4);//optional for products only visible in catalog and search
$cat = Mage::getModel('catalog/category')->load(2502);
//$cat = Mage::getModel('catalog/category')->load(173);
	// if(!$cat->getChildren()){
		// $subcats = $cat->getEntityId();
	// }else{
		$subcats = $cat->getChildren();
	//}

//print_r($subcats);exit;

//$fp = fopen('C:/Users/Administrator/Desktop/'.$cat->getName().date("Y-m-d").'.csv', 'w');
$fp = fopen($cat->getEntityId().'-'.date("Y-m-d").'.csv', 'w');
$csvHeader = array("Name","Sku");
fputcsv( $fp, $csvHeader,",");
// foreach(explode(',',$subcats) as $subCatid){
	
	      // $_category = Mage::getModel('catalog/category')->load($subCatid);
          // $products = Mage::getModel('catalog/category')->load($_category->getEntityId())
          // ->getProductCollection()
		  // ->addAttributeToFilter('status', 1)//optional for only enabled products
          // ->addAttributeToFilter('visibility', 4)//optional for products only visible in catalog and search
          // ->addAttributeToSelect('*');
		$categoryid = 2502;
		$category = new Mage_Catalog_Model_Category();
		$category->load($categoryid);
		$collection = $category->getProductCollection();
		$collection->addAttributeToSelect('*'); 
		  
	    foreach ($collection as $product){
			
			    $name = trim($product->getName());
				$sku = trim($product->getSku());
				//$price_us = $product->getPrice();
				//$goods_url = $product->getProductUrl();
				//$weight = $product->getWeight();
				// $goods_img = $product->getImage();
				//$goods_qty = $product->getQty();
				//$goods_img =Mage::helper('catalog/image')->init($product, 'image')->resize(265);
				//$goods_url = $product->getProductUrl();
				
				//$des_en = $product->getDescription();
				//$categoryIds = implode('|', $product->getCategoryIds());//change the category separator if needed
				//$_category = Mage::getModel('catalog/category')->load($categoryIds);
				//$categoryData = $_category->getName();
				fputcsv($fp, array($name,$sku), ",");
			}
//}
fclose($fp);