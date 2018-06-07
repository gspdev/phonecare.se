<?php
//class Mivec_Support_Block_Adminhtml_Ticket_Edit_Renderer_Customer extends Mage_Adminhtml_Block_Abstractimplements Varien_Data_Form_Element_Renderer_Interface
class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Renderer_Customer extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        //customer_id
        $customerEmail = Mage::getModel("customer/customer")->load($row->getCustomerId())->getEmail();
		
        return $customerEmail;
    }
}