<?php
/**
 * IDEALIAGroup srl
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@idealiagroup.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category   IG
 * @package    IG_LightBox
 * @copyright  Copyright (c) 2010-2011 IDEALIAGroup srl (http://www.idealiagroup.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Riccardo Tempesta <tempesta@idealiagroup.com>
*/
 
class Dylan_Repairdevice_IndexController extends Mage_Core_Controller_Front_Action
{

	 public function indexAction(){
		$this->loadLayout();
		$headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->setTitle(Mage::helper('repairdevice')->__('Repair-device'));
        }
    	$this->renderLayout();
	 }
	
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
	 
	public function categoryAction(){
			 
        $id = (int)$this->getRequest()->getParam('id');
      
        $categoryModel = Mage::getModel('catalog/category')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($id);           
           
        $respone = array();
        
        foreach ($categoryModel->getChildrenCategories() as $categoryId) {
            $category = $categoryModel->load($categoryId->getId());
			$categoryData = Mage::getModel('catalog/category')->load($category->getId());
			  array_push($respone, array( "name" => $categoryData->getName(), "id" => $categoryData->getId(), "image" => $categoryData->getImageUrl()));
           
        }      
            
        $this->getResponse()->clearHeaders()->setHeader('Content-Type', 'application/json')->setBody(Mage::helper('core')->jsonEncode($respone));
    }
    
    public function productAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $taxHelper = Mage::helper('tax');
        $store = Mage::app()->getStore();
      
        $categoryModel = Mage::getModel('catalog/category')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($id);           
           
        $respone = array();
        
        foreach ($categoryModel->getProductCollection() as $productId) {
            $product = Mage::getModel('catalog/product')->load($productId->getId());
           
//            $price = (float)round($taxHelper->getPrice($product,$product->getPrice(),$taxHelper->displayPriceIncludingTax()));
            $price = Mage::helper('core')->currency($taxHelper->getPrice($product,$product->getPrice(),$taxHelper->displayPriceIncludingTax()), true, false);
            array_push($respone, array( "name" => $product->getName(), "price" =>$price , "id" => $product->getId(), "image" => $product->getImageUrl()));
        }      
            
        $this->getResponse()->clearHeaders()->setHeader('Content-Type', 'application/json')->setBody(Mage::helper('core')->jsonEncode($respone));
    }
	
	 public function saveLoginAction()
    {
      
      if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');	
            return;
        }
        $this->_initLayoutMessages('customer/session');
        $session = $this->_getSession();
        if ($this->getRequest()->isPost())
        {
            $login = $this->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password']))
            {  
		      
		       $customer = Mage::getModel('customer/customer')
			  ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
			   ->loadByEmail($login['username']);
			    $in_id = $customer->getId();
				$data['customer_id'] = $in_id;
				$data['create_at'] = date('Y-m-d');
			    $id = $this->getRequest()->getParam('id');
				$model = Mage::getModel('repairdevice/repairdevice')->load($id);
                    try {
						
						
                        $session->login($login['username'], $login['password']);
                        if ($session->getCustomer()->getIsJustConfirmed()) {
                            $this->_welcomeCustomer($session->getCustomer(), true);
                        }
                        Mage::getSingleton('core/session')->
                        addSuccess(Mage::helper('repairdevice')
                            ->__('Login Successfully!'));
						

                     }catch (Mage_Core_Exception $e) {
						 
						  Mage::getSingleton('core/session')->
                        addError(Mage::helper('repairdevice')
                            ->__('invalid login or password!'));
                    }
					
            }
           
        }
	     $this->_redirect('*/*/');

           
		
    }
	
	public function saveAction(){
		
		$status = Mage::getSingleton('customer/session')->isLoggedIn();
		if($status){
			//var_dump(__METHOD__);
			if($data = $this->getRequest()->getPost()){
				if (!$this->_validateFormKey()) {
					$this->_redirect('*/*/');
					return;
				}
               // $address = Mage::getModel('customer/address')->load($data['billing_address_id']);
				//print_r($data);exit;
				$id = $this->getRequest()->getParam('id');
				$model = Mage::getModel('repairdevice/repairdevice')->load($id);
				//$productId = $data['repairs']; 
				$data['invoice_id'] = 'REP'.$data['customer_id'].date("Ymdhis");
				//$data['invoice_status'] = 1;
				$data['create_at'] = date('Y-m-d H:m:s');
					$model->setData($data);
				try {
						
					$model->save();
					$resource = Mage::getSingleton('core/resource');
					$inster = Mage::getSingleton('core/resource')->getConnection('core_write');
					$tablePrefix = (string) Mage::getConfig()->getTablePrefix();
					$type_address_billing =0; 
					$type_address_shipping =1; 
					
					if(isset($data['billing']['use_for_shipping']) && $data['billing']['use_for_shipping']==1 && isset($data['billing_address_id']) && $data['billing_address_id']!=''){
						
						$address = Mage::getModel('customer/address')->load($data['billing_address_id']);
						$firstname = $address->getFirstname();
						$lastname = $address->getLastname();
						$company = $address->getCompany();
						$city = $address->getCity();
						if(isset($address->getStreet()['1']) && $address->getStreet()['1']!='' ){
							$street = $address->getStreet()['0'].' '.$address->getStreet()['1'];
						}else{
							$street = $address->getStreet()['0'];
						}
						
						$country_id = $address->getCountryId();
						$region = $address->getRegion();
						$postcode = $address->getPostcode();
						$telephone = $address->getTelephone();
						$fax = $address->getFax();
						$vat_id = $address->getVatId();
						$region_id = $address->getRegionId();
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_address = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_billing','".$model->save()->getId()."','$firstname','$lastname','$company','$street','$vat_id','$city','$region_id','$region','$postcode','$country_id','$telephone','$fax')";
						$inster->query($sql_inster_address);
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_address = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_shipping','".$model->save()->getId()."','$firstname','$lastname','$company','$street','$vat_id','$city','$region_id','$region','$postcode','$country_id','$telephone','$fax')";
						$inster->query($sql_inster_address);
						
					    $productIdArray = $this->getRequest()->getPost('repairs');
						foreach($productIdArray as $productId){
							
							
							$tableName = $resource->getTableName('repair_product');
							$sql_inster = "INSERT INTO ".$tableName." (repair_id,product_id)VALUES('".$model->save()->getId()."','$productId')";
							$inster->query($sql_inster);  
						}	
					}
					
					if(isset($data['billing']['use_for_shipping']) && $data['billing']['use_for_shipping']==1 && isset($data['billing_address_id']) && $data['billing_address_id'] ==''){
						
						$billing_new_shipping = $this->getRequest()->getPost('billing');
						
						$firstname = $billing_new_shipping['firstname'];
						$lastname = $billing_new_shipping['lastname'];
						$company = $billing_new_shipping['company'];
						$city = $billing_new_shipping['city'];
						if(isset($billing_new_shipping['street']['1']) && $billing_new_shipping['street']['0'] !=''){
							 $street = $billing_new_shipping['street']['0'].''.$billing_new_shipping['street']['1'];
						}else{
							 $street = $billing_new_shipping['street']['0'];
						}
						$country_id = $billing_new_shipping['country_id'];
						$region = $billing_new_shipping['region'];
						$postcode = $billing_new_shipping['postcode'];
						$telephone = $billing_new_shipping['telephone'];
						$fax = $billing_new_shipping['fax'];
						$vat_id = $billing_new_shipping['vat_id'];
						$region_id = $billing_new_shipping['region_id'];
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_address = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_billing','".$model->save()->getId()."','$firstname','$lastname','$company','$street','$vat_id','$city','$region_id','$region','$postcode','$country_id','$telephone','$fax')";
						$inster->query($sql_inster_address);
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_address = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_shipping','".$model->save()->getId()."','$firstname','$lastname','$company','$street','$vat_id','$city','$region_id','$region','$postcode','$country_id','$telephone','$fax')";
						$inster->query($sql_inster_address);
						
					    $productIdArray = $this->getRequest()->getPost('repairs');
						foreach($productIdArray as $productId){
							
							
							$tableName = $resource->getTableName('repair_product');
							$sql_inster = "INSERT INTO ".$tableName." (repair_id,product_id)VALUES('".$model->save()->getId()."','$productId')";
							$inster->query($sql_inster);  
						}	
					}
					
					if(isset($data['billing']['use_for_shipping']) && $data['billing']['use_for_shipping']==1 && isset($data['billing']) && !isset($data['billing_address_id'])){
						
						$billing_new_shipping = $this->getRequest()->getPost('billing');
						
						$firstname = $billing_new_shipping['firstname'];
						$lastname = $billing_new_shipping['lastname'];
						$company = $billing_new_shipping['company'];
						$city = $billing_new_shipping['city'];
						if(isset($billing_new_shipping['street']['1']) && $billing_new_shipping['street']['1'] !='' ){
							$street = $billing_new_shipping['street']['0'].''.$billing_new_shipping['street']['1'];
						}else{
							$street = $billing_new_shipping['street']['0'];
						}
						$country_id = $billing_new_shipping['country_id'];
						$region = $billing_new_shipping['region'];
						$postcode = $billing_new_shipping['postcode'];
						$telephone = $billing_new_shipping['telephone'];
						$fax = $billing_new_shipping['fax'];
						$vat_id = $billing_new_shipping['vat_id'];
						$region_id = $billing_new_shipping['region_id'];
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_address = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_billing','".$model->save()->getId()."','$firstname','$lastname','$company','$street','$vat_id','$city','$region_id','$region','$postcode','$country_id','$telephone','$fax')";
						$inster->query($sql_inster_address);
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_address = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_shipping','".$model->save()->getId()."','$firstname','$lastname','$company','$street','$vat_id','$city','$region_id','$region','$postcode','$country_id','$telephone','$fax')";
						$inster->query($sql_inster_address);
						
					    $productIdArray = $this->getRequest()->getPost('repairs');
						foreach($productIdArray as $productId){
							
							
							$tableName = $resource->getTableName('repair_product');
							$sql_inster = "INSERT INTO ".$tableName." (repair_id,product_id)VALUES('".$model->save()->getId()."','$productId')";
							$inster->query($sql_inster);  
						}	
					}
					
					if(isset($data['billing']) && isset($data['shipping']) && isset($data['billing_address_id']) && $data['billing_address_id']==''){
						
						$new_billing = $this->getRequest()->getPost('billing');
						$new_shipping = $this->getRequest()->getPost('shipping');
						
						$firstname = $new_billing['firstname'];
						$lastname = $new_billing['lastname'];
						$company = $new_billing['company'];
						$city = $new_billing['city'];
						if(isset($new_billing['street']['1']) && $new_billing['street']['1'] !=''){
							$street = $new_billing['street']['0'].''.$new_billing['street']['1'];
						}else{
							$street = $new_billing['street']['0'];
						}
						$country_id = $new_billing['country_id'];
						$region = $new_billing['region'];
						$postcode = $new_billing['postcode'];
						$telephone = $new_billing['telephone'];
						$fax = $new_billing['fax'];
						$vat_id = $new_billing['vat_id'];
						$region_id = $new_billing['region_id'];
						
						$firstname_new_shipping = $new_shipping['firstname'];
						$lastname_new_shipping = $new_shipping['lastname'];
						$company_new_shipping = $new_shipping['company'];
						$city_new_shipping = $new_shipping['city'];
						if(isset($new_shipping['street']['1']) && $new_shipping['street']['1']!=''){
							$street_new_shipping = $new_shipping['street']['0'].''.$new_shipping['street']['1'];
						}else{
							$street_new_shipping = $new_shipping['street']['0'];
						}
						$country_id_new_shipping = $new_shipping['country_id'];
						$region_new_shipping = $new_shipping['region'];
						$postcode_new_shipping = $new_shipping['postcode'];
						$telephone_new_shipping = $new_shipping['telephone'];
						$fax_new_shipping = $new_shipping['fax'];
						$vat_id_new_shipping = $new_shipping['vat_id'];
						$region_id_new_shipping = $new_shipping['region_id'];
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_address = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_billing','".$model->save()->getId()."','$firstname','$lastname','$company','$street','$vat_id','$city','$region_id','$region','$postcode','$country_id','$telephone','$fax')";
						$inster->query($sql_inster_address);
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_new_shipping = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_shipping','".$model->save()->getId()."','$firstname_new_shipping','$lastname_new_shipping','$company_new_shipping','$street_new_shipping','$vat_id_new_shipping','$city_new_shipping','$region_id_new_shipping','$region_new_shipping','$postcode_new_shipping','$country_id_new_shipping','$telephone_new_shipping','$fax_new_shipping')";
						$inster->query($sql_inster_new_shipping);
						
					    $productIdArray = $this->getRequest()->getPost('repairs');
						foreach($productIdArray as $productId){
							
							
							$tableName = $resource->getTableName('repair_product');
							$sql_inster = "INSERT INTO ".$tableName." (repair_id,product_id)VALUES('".$model->save()->getId()."','$productId')";
							$inster->query($sql_inster);  
						}	
					}
					
					if(isset($data['billing']) && isset($data['shipping']) && !isset($data['billing_address_id'])){
						
						$new_billing = $this->getRequest()->getPost('billing');
						$new_shipping = $this->getRequest()->getPost('shipping');
						
						$firstname = $new_billing['firstname'];
						$lastname = $new_billing['lastname'];
						$company = $new_billing['company'];
						$city = $new_billing['city'];
						if(isset($new_billing['street']['1']) && $new_billing['street']['1']!=''){
							$street = $new_billing['street']['0'].''.$new_billing['street']['1'];
						}else{
							$street = $new_billing['street']['0'];
						}
						$country_id = $new_billing['country_id'];
						$region = $new_billing['region'];
						$postcode = $new_billing['postcode'];
						$telephone = $new_billing['telephone'];
						$fax = $new_billing['fax'];
						$vat_id = $new_billing['vat_id'];
						$region_id = $new_billing['region_id'];
						
						$firstname_new_shipping = $new_shipping['firstname'];
						$lastname_new_shipping = $new_shipping['lastname'];
						$company_new_shipping = $new_shipping['company'];
						$city_new_shipping = $new_shipping['city'];
						if($new_shipping['street']['1']!='' && isset($new_shipping['street']['1'])){
							$street_new_shipping = $new_shipping['street']['0'].''.$new_shipping['street']['1'];
						}else{
							$street_new_shipping = $new_shipping['street']['0'];
						}
						
						$country_id_new_shipping = $new_shipping['country_id'];
						$region_new_shipping = $new_shipping['region'];
						$postcode_new_shipping = $new_shipping['postcode'];
						$telephone_new_shipping = $new_shipping['telephone'];
						$fax_new_shipping = $new_shipping['fax'];
						$vat_id_new_shipping = $new_shipping['vat_id'];
						$region_id_new_shipping = $new_shipping['region_id'];
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_address = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_billing','".$model->save()->getId()."','$firstname','$lastname','$company','$street','$vat_id','$city','$region_id','$region','$postcode','$country_id','$telephone','$fax')";
						$inster->query($sql_inster_address);
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_new_shipping = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_shipping','".$model->save()->getId()."','$firstname_new_shipping','$lastname_new_shipping','$company_new_shipping','$street_new_shipping','$vat_id_new_shipping','$city_new_shipping','$region_id_new_shipping','$region_new_shipping','$postcode_new_shipping','$country_id_new_shipping','$telephone_new_shipping','$fax_new_shipping')";
						$inster->query($sql_inster_new_shipping);
						
					    $productIdArray = $this->getRequest()->getPost('repairs');
						foreach($productIdArray as $productId){
							
							
							$tableName = $resource->getTableName('repair_product');
							$sql_inster = "INSERT INTO ".$tableName." (repair_id,product_id)VALUES('".$model->save()->getId()."','$productId')";
							$inster->query($sql_inster);  
						}	
					}
					
					if(isset($data['shipping']) && isset($data['billing_address_id']) && $data['billing_address_id'] !=''){
						
						$address = Mage::getModel('customer/address')->load($data['billing_address_id']);
						$new_shipping = $this->getRequest()->getPost('shipping');
						
						$firstname = $address->getFirstname();
						$lastname = $address->getLastname();
						$company = $address->getCompany();
						$city = $address->getCity();
						if(isset($address->getStreet()['1']) && $address->getStreet()['1']!=''){
							$street = $address->getStreet()['0'].' '.$address->getStreet()['1'];
						}else{
							$street = $address->getStreet()['0'];
						}
						$country_id = $address->getCountryId();
						$region = $address->getRegion();
						$postcode = $address->getPostcode();
						$telephone = $address->getTelephone();
						$fax = $address->getFax();
						$vat_id = $address->getVatId();
						$region_id = $address->getRegionId();
						
						
						$firstname_new_shipping = $new_shipping['firstname'];
						$lastname_new_shipping = $new_shipping['lastname'];
						$company_new_shipping = $new_shipping['company'];
						$city_new_shipping = $new_shipping['city'];
						if(isset($new_shipping['street']['1']) && $new_shipping['street']['1']!=''){
							$street_new_shipping = $new_shipping['street']['0'].''.$new_shipping['street']['1'];
						}else{
							$street_new_shipping = $new_shipping['street']['0'];
						}
						$country_id_new_shipping = $new_shipping['country_id'];
						$region_new_shipping = $new_shipping['region'];
						$postcode_new_shipping = $new_shipping['postcode'];
						$telephone_new_shipping = $new_shipping['telephone'];
						$fax_new_shipping = $new_shipping['fax'];
						$vat_id_new_shipping = $new_shipping['vat_id'];
						$region_id_new_shipping = $new_shipping['region_id'];
						
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_address = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_billing','".$model->save()->getId()."','$firstname','$lastname','$company','$street','$vat_id','$city','$region_id','$region','$postcode','$country_id','$telephone','$fax')";
						$inster->query($sql_inster_address);
						
						$tableName = $resource->getTableName('repair_address');
						$sql_inster_new_shipping = "INSERT INTO ".$tableName." (type_address,repair_id,firstname,lastname,company,street,vat_id,city,region_id,region,postcode,country_id,telephone,fax)VALUES('$type_address_shipping','".$model->save()->getId()."','$firstname_new_shipping','$lastname_new_shipping','$company_new_shipping','$street_new_shipping','$vat_id_new_shipping','$city_new_shipping','$region_id_new_shipping','$region_new_shipping','$postcode_new_shipping','$country_id_new_shipping','$telephone_new_shipping','$fax_new_shipping')";
						$inster->query($sql_inster_new_shipping);
						
						
					    $productIdArray = $this->getRequest()->getPost('repairs');
						foreach($productIdArray as $productId){
							
							
							$tableName = $resource->getTableName('repair_product');
							$sql_inster = "INSERT INTO ".$tableName." (repair_id,product_id)VALUES('".$model->save()->getId()."','$productId')";
							$inster->query($sql_inster);  
						}	
					}
					
					if(isset($data['shipping_store']) && $data['shipping_store']==0){
						$productIdArray = $this->getRequest()->getPost('repairs');
						foreach($productIdArray as $productId){
							
							$resource = Mage::getSingleton('core/resource');
							$inster = Mage::getSingleton('core/resource')->getConnection('core_write');
							$tablePrefix = (string) Mage::getConfig()->getTablePrefix();
							$tableName = $resource->getTableName('repair_product');
							$sql_inster = "INSERT INTO ".$tableName." (repair_id,product_id)VALUES('".$model->save()->getId()."','$productId')";
							$inster->query($sql_inster);  
						}
					}
					Mage::getSingleton('core/session')->
					addSuccess(Mage::helper('repairdevice')
					->__('Your information was submitted successfully.'));
					
					$this->_redirect('*/*/');
					return;
				} catch (Exception $e) {
				  Mage::getSingleton('core/session')->addError($e->getMessage());
				  return;
				}

			}
		}
		
		$this->_redirect('*/*/');	

	}
}
