<?php

class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Renderer_Productsku extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   
	public function render(Varien_Object $row)
	{
        $productSku = Mage::getModel("catalog/product")->load($row->getProductId())->getSku();
	   
	    return $productSku;
		
	}

}