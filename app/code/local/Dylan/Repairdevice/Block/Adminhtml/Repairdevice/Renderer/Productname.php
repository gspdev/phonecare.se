<?php

class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Renderer_Productname extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   
	public function render(Varien_Object $row)
	{
        $productName = Mage::getModel("catalog/product")->load($row->getProductId())->getName();
	   
	    return $productName;
		
	}

}