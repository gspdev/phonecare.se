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
 
class Dylan_Repairdevice_Block_Adminhtml_Invoice extends Mage_Adminhtml_Block_Template
{
	public function _construct()
    {
        $this->setTemplate('repairdevice/create/form.phtml');
    }
	
	protected $_repairdevice;
	protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->_repairdevice = Mage::getModel('repairdevice/repairdevice');
        if ($id = $this->getRequest()->getParam('id')) {
            $this->_repairdevice->load($id);
        }
    }
	public function getRepairdevice(){
		return $this->_repairdevice;
	}
	
	public function getStatus(){
		
		  $data = array(
            1    => "Pending",
            2    => "Received",
            3    => "Invoice",
            4    => "Processing",
            5    => "Complete",
            6    => "Canceled",
        );
        return $data;
	}
	
	public function getCustomer($id){
		$customerData = Mage::getModel('customer/customer')->load($id)->getData();
		return $customerData;
		
	}
	
	public function getProduct($productId)
	{
		$collection = Mage::getModel('repairdevice/repairproduct')
		  ->getCollection()->addFieldToFilter('if_invoice', 0)
		  ->addAttributeToFilter('repair_id' , $productId)->getData();
		  $productIds = array_column($collection, 'product_id');
		  
		 return $productIds;
		  
	}
	
	public function getProductInvoice($productId)
	{
		$collection = Mage::getModel('repairdevice/repairproduct')
		  ->getCollection()->addFieldToFilter('if_invoice', 1)
		  ->addAttributeToFilter('repair_id' , $productId)->getData();
		  $productIds = array_column($collection, 'product_id');
		  
		 return $productIds;
		  
	}
	
	public function getAddress($repairId)
	{
		$collection = Mage::getModel('repairdevice/repairaddress')
		  ->getCollection()
		  ->addAttributeToFilter('repair_id' , $repairId)->getData();
		  $Ids = array_column($collection, 'id');
		  
		 return $Ids;
		  
	}
	
	 public function getSaveInvoiceUrl()
    {
        return $this->getUrl('*/*/saveinvoice', array('id' => $this->getRequest()->getParam('id')));
    }
	
	public function getBackUrl()
    {
        return $this->getUrl('*/*/edit', array('id'=> $this->getRequest()->getParam('id')));
    }
	
	public function getProductForCategory($productId){
		
		$collection = Mage::getModel('repairdevice/repairproduct')
		  ->getCollection()
		  ->addAttributeToFilter('repair_id' , $productId)->getData();
		  $productIds = array_column($collection, 'product_id');
		  //$implodeProduct = implode(',',$productIds);
		  foreach($productIds as $itemId){
			  
			  $product = Mage::getModel('catalog/product')->load($itemId);
              $cats = $product->getCategoryIds();
			 // print_r($cats);exit;
			  
		  }
		   //print_r($implodeProduct);exit;
		  foreach($cats as $subCatid){
	      $_category = Mage::getModel('catalog/category')->load($subCatid);
          $products = Mage::getModel('catalog/category')->load($_category->getEntityId())
          ->getProductCollection()
		  ->addAttributeToFilter('status', 1)//optional for only enabled products
          ->addAttributeToFilter('visibility', 4)//optional for products only visible in catalog and search
          ->addAttributeToSelect('*');
		 
		  //  $dataArr =array();
			foreach ($products as $product){
					$dataArr[] = array(
					 'entity_id'=>$product->getEntityId(),
					 'sku'=>trim($product->getSku()),
					 'name' =>trim($product->getName()),
					 'price'=>$product->getPrice(),
					 'currency' => Mage::helper('core')->currency($product->getPrice(), true, false)
					//'currency' => Mage::app()->getStore()->getCurrentCurrencyCode()
				   );
                   //$dataArr[]=$product->getData();				   
					 
				}
			//print_r($dataArr);exit;
			return json_encode($dataArr);
			
       } 
		
	}

}