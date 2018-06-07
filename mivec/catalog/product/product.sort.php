<?php 

   require dirname(__FILE__) . "/config.php";

   $attributeCode = "repair_part";
   $attributeOptionId = 119;//OEM Screen1
   $attributeOptionId2 = 120;//Original Screen2
   $attributeOptionId3 = 108;//battery3
   $attributeOptionId4 = 107;//backcover4
   $attributeOptionId5 = 118;//Replacement of home button5
   $attributeOptionId6 = 114;//Soldering in the motherboard6
    $resource = Mage::getSingleton('core/resource');
	$readConnection = $resource->getConnection('core_read');
	$inster = Mage::getSingleton('core/resource')->getConnection('core_write');
	$tablePrefix = (string) Mage::getConfig()->getTablePrefix();
	//$tableName = $resource->getTableName('catalog_product_entity_int');
	$tableName = $resource->getTableName('catalog_product_entity_int');
   // $attribute = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', $attributeCode);
   // $options = Mage::getModel('eav/entity_attribute_source_table')
            // ->setAttribute($attribute)
            // ->getAllOptions(false);
			
	$attribute = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product',$attributeCode);
    $attr = Mage::getModel('catalog/resource_eav_attribute')->load($attribute);
    if ($attr->usesSource()) {

    $options = $attr ->getSource()->getAllOptions(false); 

    foreach ($options as $option) {
     //  echo $option['label']." => ".$option['value']."<br>";
		 
       if ($option['value'] == $attributeOptionId) {
			$selectedOptionId = $option['value']; 
		if ($selectedOptionId) {
          $products = Mage::getModel('catalog/product')
			 ->getCollection()
			 ->addAttributeToSelect('*')
			 ->addAttributeToFilter($attributeCode, $selectedOptionId);
			    foreach($products as $item){
				 //echo $item['sku']."<br>";
				  //echo $item['entity_id']."<br>";
				   
					$sortId = 100;
					$productId = $item['entity_id'];
					$productTypeId = $item['entity_type_id'];
					$storeId = $item['store_id'];
					
					try {
						
						if (addSort($productTypeId,$storeId,$productId,$sortId)) {
							echo $productId. ' add successfully<br>';
							usleep(5);
						}
					} catch (Exception $e) {
						//print_r($e);
						
						global $db;
						$sql = "SELECT * FROM ".$tableName." where entity_id=".$productId."";
					    $res = $readConnection->fetchRow($sql);
						//echo  $res['entity_id'];
					  
					    $delOldData ="DELETE FROM ".$tableName." WHERE attribute_id=177 AND entity_id IN (".$res['entity_id'].")";
					    $db->query($delOldData);
						 if (addSort($productTypeId,$storeId,$res['entity_id'],$sortId)) {
							 echo $productId. ' add successfully<br>';
							 usleep(5);
						 }

						
					  // $sql = "UPDATE ".$tableName." SET `value`= 100 WHERE entity_id=".$productId;
					  // $db->query($sql);
					  // echo $productId.' update successfully<br>';
						
					}
			    }
		}
			
       }
	
    if ($option['value'] == $attributeOptionId2) {
			$selectedOptionId = $option['value']; 
		if ($selectedOptionId) {
          $products = Mage::getModel('catalog/product')
			 ->getCollection()
			 ->addAttributeToSelect('*')
			 ->addAttributeToFilter($attributeCode, $selectedOptionId);
			    foreach($products as $item){
				// echo $item['sku']."<br>";
				 // echo $item['entity_id']."<br>";
				   
					$sortId = 99;
					$productId = $item['entity_id'];
					$productTypeId = $item['entity_type_id'];
					$storeId = $item['store_id'];
					
					try {
						
						if (addSort($productTypeId,$storeId,$productId,$sortId)) {
							echo $productId. ' add successfully<br>';
							usleep(5);
						}
					} catch (Exception $e) {
						
						global $db;
						$sql = "SELECT * FROM ".$tableName." where entity_id=".$productId."";
					    $res = $readConnection->fetchRow($sql);
						//echo  $res['entity_id'];
					  
					    $delOldData ="DELETE FROM ".$tableName." WHERE attribute_id=177 AND entity_id IN (".$res['entity_id'].")";
					    $db->query($delOldData);
						 if (addSort($productTypeId,$storeId,$res['entity_id'],$sortId)) {
							 echo $productId. ' add successfully<br>';
							 usleep(5);
						 }
					}
					
					
			    }
		}
			
       }
      
    if ($option['value'] == $attributeOptionId3) {
			$selectedOptionId = $option['value']; 
		if ($selectedOptionId) {
          $products = Mage::getModel('catalog/product')
			 ->getCollection()
			 ->addAttributeToSelect('*')
			 ->addAttributeToFilter($attributeCode, $selectedOptionId);
			    foreach($products as $item){
				// echo $item['sku']."<br>";
				 // echo $item['entity_id']."<br>";
				   
					$sortId = 98;
					$productId = $item['entity_id'];
					$productTypeId = $item['entity_type_id'];
					$storeId = $item['store_id'];
					
					try {
						
						if (addSort($productTypeId,$storeId,$productId,$sortId)) {
							echo $productId. ' add successfully<br>';
							usleep(5);
						}
					} catch (Exception $e) {
						
						global $db;
						$sql = "SELECT * FROM ".$tableName." where entity_id=".$productId."";
					    $res = $readConnection->fetchRow($sql);
						//echo  $res['entity_id'];
					  
					    $delOldData ="DELETE FROM ".$tableName." WHERE attribute_id=177 AND entity_id IN (".$res['entity_id'].")";
					    $db->query($delOldData);
						 if (addSort($productTypeId,$storeId,$res['entity_id'],$sortId)) {
							 echo $productId. ' add successfully<br>';
							 usleep(5);
						 }
					}
					
					
			    }
		}
			
       }	

    if ($option['value'] == $attributeOptionId4) {
			$selectedOptionId = $option['value']; 
		if ($selectedOptionId) {
          $products = Mage::getModel('catalog/product')
			 ->getCollection()
			 ->addAttributeToSelect('*')
			 ->addAttributeToFilter($attributeCode, $selectedOptionId);
			    foreach($products as $item){
				// echo $item['sku']."<br>";
				  //echo $item['entity_id']."<br>";
				   
					$sortId = 97;
					$productId = $item['entity_id'];
					$productTypeId = $item['entity_type_id'];
					$storeId = $item['store_id'];
					
					try {
						
						if (addSort($productTypeId,$storeId,$productId,$sortId)) {
							echo $productId. ' add successfully<br>';
							usleep(5);
						}
					} catch (Exception $e) {
						
						global $db;
						$sql = "SELECT * FROM ".$tableName." where entity_id=".$productId."";
					    $res = $readConnection->fetchRow($sql);
						//echo  $res['entity_id'];
					  
					    $delOldData ="DELETE FROM ".$tableName." WHERE attribute_id=177 AND entity_id IN (".$res['entity_id'].")";
					    $db->query($delOldData);
						 if (addSort($productTypeId,$storeId,$res['entity_id'],$sortId)) {
							 echo $productId. ' add successfully<br>';
							 usleep(5);
						 }
					}
					
					
			    }
		}
			
       }	


    if ($option['value'] == $attributeOptionId5) {
			$selectedOptionId = $option['value']; 
		if ($selectedOptionId) {
          $products = Mage::getModel('catalog/product')
			 ->getCollection()
			 ->addAttributeToSelect('*')
			 ->addAttributeToFilter($attributeCode, $selectedOptionId);
			    foreach($products as $item){
				// echo $item['sku']."<br>";
				  //echo $item['entity_id']."<br>";
				   
					$sortId = 96;
					$productId = $item['entity_id'];
					$productTypeId = $item['entity_type_id'];
					$storeId = $item['store_id'];
					
					try {
						
						if (addSort($productTypeId,$storeId,$productId,$sortId)) {
							echo $productId. ' add successfully<br>';
							usleep(5);
						}
					} catch (Exception $e) {
						
						global $db;
						$sql = "SELECT * FROM ".$tableName." where entity_id=".$productId."";
					    $res = $readConnection->fetchRow($sql);
						//echo  $res['entity_id'];
					  
					    $delOldData ="DELETE FROM ".$tableName." WHERE attribute_id=177 AND entity_id IN (".$res['entity_id'].")";
					    $db->query($delOldData);
						 if (addSort($productTypeId,$storeId,$res['entity_id'],$sortId)) {
							 echo $productId. ' add successfully<br>';
							 usleep(5);
						 }
					}
					
					
			    }
		 }
			
       }
    
    if ($option['value'] == $attributeOptionId6) {
			$selectedOptionId = $option['value']; 
		if ($selectedOptionId) {
          $products = Mage::getModel('catalog/product')
			 ->getCollection()
			 ->addAttributeToSelect('*')
			 ->addAttributeToFilter($attributeCode, $selectedOptionId);
			    foreach($products as $item){
				// echo $item['sku']."<br>";
				  //echo $item['entity_id']."<br>";
				   
					$sortId = 95;
					$productId = $item['entity_id'];
					$productTypeId = $item['entity_type_id'];
					$storeId = $item['store_id'];
					
					try {
						
						if (addSort($productTypeId,$storeId,$productId,$sortId)) {
							echo $productId. ' add successfully<br>';
							usleep(5);
						}
					} catch (Exception $e) {
						
						global $db;
						$sql = "SELECT * FROM ".$tableName." where entity_id=".$productId."";
					    $res = $readConnection->fetchRow($sql);
						//echo  $res['entity_id'];
					  
					    $delOldData ="DELETE FROM ".$tableName." WHERE attribute_id=177 AND entity_id IN (".$res['entity_id'].")";
					    $db->query($delOldData);
						 if (addSort($productTypeId,$storeId,$res['entity_id'],$sortId)) {
							 echo $productId. ' add successfully<br>';
							 usleep(5);
						 }
					}
					
					
			    }
		 }
			
       }	
		
   }
   
   }

   
function addSort($productTypeId,$storeId,$productId,$sortId){
	
     global $db;
	 // $sql = "UPDATE ".$tableName." SET `value`= 1010 WHERE entity_id=".$res['entity_id'];
	 // $db->query($sql);
	 // echo $res['entity_id'].' update successfully<br>';
	$resource = Mage::getSingleton('core/resource');
	$readConnection = $resource->getConnection('core_read');
	$inster = Mage::getSingleton('core/resource')->getConnection('core_write');
	$tablePrefix = (string) Mage::getConfig()->getTablePrefix();
	$tableName = $resource->getTableName('catalog_product_entity_int');
	//$tableName = $resource->getTableName('catalog_product_entity_varchar');
	$sql_inster = "INSERT INTO ".$tableName." (entity_type_id,attribute_id,store_id,entity_id,value)VALUES('".$productTypeId."',177,'".$storeId."','".$productId."','".$sortId."')";
	return $db->query($sql_inster);
	//echo $sql_inster;
	//echo $productId. ' add successfully<br>';
	
}
  
   
  
?>