<?php
require dirname(__FILE__) . "/config.php";

define("__ATTR_PRODUCT_STATUS__" , 96);
define("__ATTR_PRODUCT_STATUS_ENABLED__" , 1);
define("__ATTR_PRODUCT_STATUS_DISABLED__" , 2);

//set product status is `Enabled`



$cat = Mage::getModel('catalog/category')->load(2505);


/*Returns comma separated ids*/
//$subcats = $cat->getChildren();
//$subcats = '2511,2512,2513,2504,2514,2515,2516,2517,2518,2519,2520,2521,2522,2523,2524';
//print_r($subcats);exit;
if(!$cat->getChildren()){
		$subcats = $cat->getEntityId();
	}else{
		$subcats = $cat->getChildren().','.$cat->getEntityId();
	}
//Print out categories string
#print_r($subcats);

foreach(explode(',',$subcats) as $subCatid){
	
  $_category = Mage::getModel('catalog/category')->load($subCatid);
  $products = Mage::getModel('catalog/category')->load($_category->getEntityId())
          ->getProductCollection()
          ->addAttributeToSelect('*');
    foreach($products as $_product)  {
		//print_r($product);
       // echo $product->getEntityId() .'<br>';
      // echo $product->getSku() .'<br>';
      // echo $product->getName() .'<br>';
        //echo $product->getAttribute() .'<br>';
      // echo "old: " . $product->getPrice() .'<br>';
	   $setId = $_product->getAttributeSetId();
	   if ($setId) {
		   $specificationsAttributeGroup = Mage::getResourceModel('eav/entity_attribute_group_collection')
                        ->setAttributeSetFilter($setId)
                        ->addFieldToFilter('attribute_group_name',array('eq'=>'Repair'))
                        ->setSortOrder()
                        ->getFirstItem();
				if(!($specificationsAttributeGroup == null || $specificationsAttributeGroup->getId() == null )){
							  $attributes = $_product->getAttributes($specificationsAttributeGroup->getId(), true);
								// do not add groups without attributes
							  
							  $headerNum=0;
							  $lastHeadKey=-1;
							  $count=0;
							  $delCount=0;
						foreach ($attributes as $key => $attribute) {
                            if( (!$attribute->getFrontend()->getValue($_product)  || $attribute->getFrontend()->getValue($_product)==Mage::helper('catalog')->__('N/A')  )&& $attribute->getDefaultValue()!='use_as_header' ) {
                                unset($attributes[$key]);
                                $delCount++;
                            }
                            
                            $count++;
                            if($attribute->getDefaultValue()=='use_as_header'){
                                if($delCount==$count-1 && $lastHeadKey!=-1){
                                    
                                   unset($attributes[$lastHeadKey]);
                                }
                                
                                $delCount=0;
                                $count=0;
                                $lastHeadKey=$key;
                            }
                        }
                        
                        $attrKeys = array_keys($attributes);
                        $theLastKey = array_pop($attrKeys);
                  
                        if(count($attributes)>0 && $attributes[$theLastKey]->getDefaultValue()=='use_as_header')
                               unset($attributes[$theLastKey]);
						 if (count($attributes)>0) {
							foreach($attributes as $attribute ){
                                          if($attribute->getDefaultValue()=='use_as_header'){
                                            echo  $attribute->getStoreLabel().'<br/>';
                                          }else{
                                           // echo   $attribute->getFrontend()->getValue($_product);
										   if($attribute->getFrontend()->getValue($_product)=="callspeaker"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												$descUp = '<p>Kan du inte höra personen på andra sidan telefonen? Oavsett om det är dåligt ljud eller inget ljud alls så kan vi hjälpa dig! Ta in din enhet på reparation redan idag för att få en fullt fungerande samtalshögtalare igen.</p>';
												$update->setDescription($descUp);
												 try {
													$update->save();
													echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   if($attribute->getFrontend()->getValue($_product)=="volumn"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												$descUp = '<p>Volymknappar kan fastna, falla av eller sluta fungera helt och hållet. Om du inte kan justera din volym efter vilja, kommer lösningen på ditt problem vara att komma in till oss idag för att reparera den här Phonecare.</p>';
												$update->setDescription($descUp);
												 try {
													$update->save();
													echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   if($attribute->getFrontend()->getValue($_product)=="speaker"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												$descUp = '<p>Har du problem med din enhets högtalare? Oroa dig inte! Vi erbjuder högtalarservice, så att du ska kunna komma igång med att lyssna på musik eller prata på högtalartelefonen igen så fort som möjligt!</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   if($attribute->getFrontend()->getValue($_product)=="charger"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>Om din iPhone inte håller laddning kan problemet vara en trasig laddningsport. Ta med dig telefonen till oss på Phonecare för en åtgärd på plats! </p><h3>Garantitiden</h3><p>3 månader</P>';
												$descUp = '<p>Om din cell phone inte håller laddning kan problemet vara en trasig laddningsport. Ta med dig telefonen till oss på Phonecare för en åtgärd på plats! </p><h3>Garantitiden</h3><p>3 månader</P>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										    if($attribute->getFrontend()->getValue($_product)=="antenna"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												$descUp = '<p>Denna mobil antenna är ansvarig för fångar upp och sänder ut radiovågor till basstationerna. Om din antenn är trasig eller fungerar dåligt, så är det denna del du ska ersätta för att återställa anslutningen. Kom in till oss idag så hjälper vi dig!</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   if($attribute->getFrontend()->getValue($_product)=="battery"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												$descUp = '<p>En mobil med ett opålitligt batteri är ett problem och kan vara väldigt frustrerande. Ta med dig telefonen till en av våra butiker för en åtgärd på plats!</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   if($attribute->getFrontend()->getValue($_product)=="backcamera"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												$descUp = '<p>Låt inte dig själv lida på grund av en trasig bak kamera. Ta med dig din mobil till oss här på Phonecare för en kostnadsfri diagnos där vi kollar om den behöver repareras eller inte.</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   if($attribute->getFrontend()->getValue($_product)=="headphonejack"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												$descUp = '<p>Kommer det bara ut ljud från ena sidan av dina öronproppar? Fungerar inte ljudet överhuvudtaget utan hörlurar? Oavsett om hörlurarna inte verkar ansluta eller om de inte längre är något att lita på, kan du lita på att få ditt hörlursuttag reparerat hos oss!</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										   if($attribute->getFrontend()->getValue($_product)=="microphone"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>Har mikrofonen slutat fungera på din cell iPhone? Denna funktion kan påverka både telefonsamtal, röststyrning och inspelningar. Vänta inte med att få din mikrofon reparerad!</p>';
												$descUp = '<p>Har mikrofonen slutat fungera på din cell phone? Denna funktion kan påverka både telefonsamtal, röststyrning och inspelningar. Vänta inte med att få din mikrofon reparerad!</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										    if($attribute->getFrontend()->getValue($_product)=="vibrator"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												$descUp = '<p>Ibland kan mobil vibratorer bli sämre, och när de blir sämre behöver du vår vibratorservicetjänst. Om din mobil saknar bra vibrationer, kom in till oss idag för att ändra på det.</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										    if($attribute->getFrontend()->getValue($_product)=="waterdamage"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>iPhones som inte är vattentäta bör inte kombineras med simning. På Phonecare erbjuder vi en fullständig diagnos service för vattenskador för att vi ska kunna se vad din mobil behöver för att kunna bli frisk och jobba som ny igen. Från att göra en noggrann torknings- och rengöringsprocess till att kontrollera varje enskild komponent i din telefon för skador.</p><br/><p>När denna process är klar kontaktar vi dig för att meddela dig om vad som behöver bytas ut, samt reparationskostnad och omställningstid. Kom ihåg att om du inte skulle vilja fortsätta med reparationen eller om vi inte kan lösa problemet, så debiteras du aldrig för servicekostnader!</p>';
												$descUp = '<p>Mobile phone som inte är vattentäta bör inte kombineras med simning. På Phonecare erbjuder vi en fullständig diagnos service för vattenskador för att vi ska kunna se vad din mobil behöver för att kunna bli frisk och jobba som ny igen. Från att göra en noggrann torknings- och rengöringsprocess till att kontrollera varje enskild komponent i din telefon för skador.</p><br/><p>När denna process är klar kontaktar vi dig för att meddela dig om vad som behöver bytas ut, samt reparationskostnad och omställningstid. Kom ihåg att om du inte skulle vilja fortsätta med reparationen eller om vi inte kan lösa problemet, så debiteras du aldrig för servicekostnader!</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										    if($attribute->getFrontend()->getValue($_product)=="OEM Screen" || $attribute->getFrontend()->getValue($_product)=="Original Screen"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>Till alla iPhones har vi olika kvaliteter när det kommer till skärmbyte, detta för att man ska få frihet att välja kvalitet själv samt för att alla ska ha möjlighet att reparera sina telefoner. Det som skiljer skärmarna åt är ljusstyrka, skärpa på bild, ömtålighet, touch känsla och tjocklek på skärm samt garantitid.</p><br/><p>Det är lätt hänt att mobiltelefonen åker i golvet. I vissa fall är det glaset som går sönder, i andra fall går även LCD-displayen sönder. I båda fallen behöver både glaset och displayen bytas ut. Kom in redan idag och få tillbaka din telefon medan du väntar!</p><br/><h3>Garantitiden</h3><p>Kvalitet (Original LCD): 12 månaders garanti</p><p>Kvalitet (Ersättnings-LCD): 3 månaders garanti</p>';
												$descUp = '<p>Till alla cell phone har vi olika kvaliteter när det kommer till skärmbyte, detta för att man ska få frihet att välja kvalitet själv samt för att alla ska ha möjlighet att reparera sina telefoner. Det som skiljer skärmarna åt är ljusstyrka, skärpa på bild, ömtålighet, touch känsla och tjocklek på skärm samt garantitid.</p><br/><p>Det är lätt hänt att mobiltelefonen åker i golvet. I vissa fall är det glaset som går sönder, i andra fall går även LCD-displayen sönder. I båda fallen behöver både glaset och displayen bytas ut. Kom in redan idag och få tillbaka din telefon medan du väntar!</p><br/><h3>Garantitiden</h3><p>Kvalitet (Original LCD): 12 månaders garanti</p><p>Kvalitet (Ersättnings-LCD): 3 månaders garanti</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										   if($attribute->getFrontend()->getValue($_product)=="Replacing sensor"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>Till alla iPhones har vi olika kvaliteter när det kommer till skärmbyte, detta för att man ska få frihet att välja kvalitet själv samt för att alla ska ha möjlighet att reparera sina telefoner. Det som skiljer skärmarna åt är ljusstyrka, skärpa på bild, ömtålighet, touch känsla och tjocklek på skärm samt garantitid.</p><br/><p>Det är lätt hänt att mobiltelefonen åker i golvet. I vissa fall är det glaset som går sönder, i andra fall går även LCD-displayen sönder. I båda fallen behöver både glaset och displayen bytas ut. Kom in redan idag och få tillbaka din telefon medan du väntar!</p><br/><h3>Garantitiden</h3><p>Kvalitet (Original LCD): 12 månaders garanti</p><p>Kvalitet (Ersättnings-LCD): 3 månaders garanti</p>';
												$descUp = '<p> Är det störande att prata i telefon när sensor inte funkar som det ska. Ja då ska du komma in till oss på Phonecare vi löser problemet på 10 minuter</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										   if($attribute->getFrontend()->getValue($_product)=="powerbutton"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>Till alla iPhones har vi olika kvaliteter när det kommer till skärmbyte, detta för att man ska få frihet att välja kvalitet själv samt för att alla ska ha möjlighet att reparera sina telefoner. Det som skiljer skärmarna åt är ljusstyrka, skärpa på bild, ömtålighet, touch känsla och tjocklek på skärm samt garantitid.</p><br/><p>Det är lätt hänt att mobiltelefonen åker i golvet. I vissa fall är det glaset som går sönder, i andra fall går även LCD-displayen sönder. I båda fallen behöver både glaset och displayen bytas ut. Kom in redan idag och få tillbaka din telefon medan du väntar!</p><br/><h3>Garantitiden</h3><p>Kvalitet (Original LCD): 12 månaders garanti</p><p>Kvalitet (Ersättnings-LCD): 3 månaders garanti</p>';
												$descUp = '<p>Funkar inte ström knappen på din mobil? inga problem för på Phonecare löser vi det och dessutom på samma dag du lämnar in mobil på.</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										   if($attribute->getFrontend()->getValue($_product)=="Replacement of home button"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>Till alla iPhones har vi olika kvaliteter när det kommer till skärmbyte, detta för att man ska få frihet att välja kvalitet själv samt för att alla ska ha möjlighet att reparera sina telefoner. Det som skiljer skärmarna åt är ljusstyrka, skärpa på bild, ömtålighet, touch känsla och tjocklek på skärm samt garantitid.</p><br/><p>Det är lätt hänt att mobiltelefonen åker i golvet. I vissa fall är det glaset som går sönder, i andra fall går även LCD-displayen sönder. I båda fallen behöver både glaset och displayen bytas ut. Kom in redan idag och få tillbaka din telefon medan du väntar!</p><br/><h3>Garantitiden</h3><p>Kvalitet (Original LCD): 12 månaders garanti</p><p>Kvalitet (Ersättnings-LCD): 3 månaders garanti</p>';
												$descUp = '<p>Trasig hemknapp kan vara vdldigt irriterande se kom in till oss och fe den lagat pe 15 minuter bara. </p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										   if($attribute->getFrontend()->getValue($_product)=="wifi"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>Till alla iPhones har vi olika kvaliteter när det kommer till skärmbyte, detta för att man ska få frihet att välja kvalitet själv samt för att alla ska ha möjlighet att reparera sina telefoner. Det som skiljer skärmarna åt är ljusstyrka, skärpa på bild, ömtålighet, touch känsla och tjocklek på skärm samt garantitid.</p><br/><p>Det är lätt hänt att mobiltelefonen åker i golvet. I vissa fall är det glaset som går sönder, i andra fall går även LCD-displayen sönder. I båda fallen behöver både glaset och displayen bytas ut. Kom in redan idag och få tillbaka din telefon medan du väntar!</p><br/><h3>Garantitiden</h3><p>Kvalitet (Original LCD): 12 månaders garanti</p><p>Kvalitet (Ersättnings-LCD): 3 månaders garanti</p>';
												$descUp = '<p>Vi alla vet att en mobil utan internet är inget roligt. Kom in till oss på Phonecare så lagar vi din mobil på samma dag.</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										   if($attribute->getFrontend()->getValue($_product)=="Soldering in the motherboard"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>Till alla iPhones har vi olika kvaliteter när det kommer till skärmbyte, detta för att man ska få frihet att välja kvalitet själv samt för att alla ska ha möjlighet att reparera sina telefoner. Det som skiljer skärmarna åt är ljusstyrka, skärpa på bild, ömtålighet, touch känsla och tjocklek på skärm samt garantitid.</p><br/><p>Det är lätt hänt att mobiltelefonen åker i golvet. I vissa fall är det glaset som går sönder, i andra fall går även LCD-displayen sönder. I båda fallen behöver både glaset och displayen bytas ut. Kom in redan idag och få tillbaka din telefon medan du väntar!</p><br/><h3>Garantitiden</h3><p>Kvalitet (Original LCD): 12 månaders garanti</p><p>Kvalitet (Ersättnings-LCD): 3 månaders garanti</p>';
												$descUp = '<p>Är det så att du har en ovanlig skada på mobil. På phonecare hittar vi problemet. Du får all information du behöver veta om din mobil. Våra tekniker är kunniga och säkra inom sitt område, och kan i flera fall reparera skador i moderkortet</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
										   if($attribute->getFrontend()->getValue($_product)=="Replacement of SIM card reader"){
											   $update = Mage::getModel('catalog/product')->loadByAttribute('sku',$_product->getSku());
											   // echo   $_product->getId();
											    $desc = $_product->getDescription();
												//$descUp = '<p>Till alla iPhones har vi olika kvaliteter när det kommer till skärmbyte, detta för att man ska få frihet att välja kvalitet själv samt för att alla ska ha möjlighet att reparera sina telefoner. Det som skiljer skärmarna åt är ljusstyrka, skärpa på bild, ömtålighet, touch känsla och tjocklek på skärm samt garantitid.</p><br/><p>Det är lätt hänt att mobiltelefonen åker i golvet. I vissa fall är det glaset som går sönder, i andra fall går även LCD-displayen sönder. I båda fallen behöver både glaset och displayen bytas ut. Kom in redan idag och få tillbaka din telefon medan du väntar!</p><br/><h3>Garantitiden</h3><p>Kvalitet (Original LCD): 12 månaders garanti</p><p>Kvalitet (Ersättnings-LCD): 3 månaders garanti</p>';
												$descUp = '<p>Har du dålig täckning eller ingen täckning överhuvetaget? Du kan vara lugn kom in till oss på Phonecare så löser vi det åt dig.</p>';
												$update->setDescription($descUp);
												 try {
													 $update->save();
													 echo "<pre>".$_product->getId(). " successfully</pre>";
												} catch (Exception $e) {
													$e->getMessage();
												}
										   }
										   
											
										  }
                                  }
								  
						 }   
				}
	   }
	  
      
}   		  
		  
}
