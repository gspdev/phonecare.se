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
 
class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
   public function __construct()
  {
      parent::__construct();
      $this->setId('repairdevice_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('repairdevice')->__('Repairdevice information'));
  }
 
  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('repairdevice')->__('Repairdevice information'),
          'title'     => Mage::helper('repairdevice')->__('Repairdevice information'),
          'content'   => $this->getLayout()->createBlock('repairdevice/adminhtml_repairdevice_edit_tab_form')->toHtml(),
		  'active'    => true,
      ));
	  
	   $this->addTab('products_section' , array(
            'label'     => 'Customer Item Products',
            'title'     => 'Customer Item Products',
            'content'   => $this->getLayout()->createBlock('repairdevice/adminhtml_repairdevice_edit_tab_products')->toHtml(),
        ));
		$this->addTab('address_section' , array(
			'label'     => 'Address Message',
			'title'     => 'Address Message',
			'content'   => $this->getLayout()->createBlock('repairdevice/adminhtml_repairdevice_edit_tab_address')->toHtml(),
		));
		
		$this->addTab('invoiceinfo_section' , array(
			'label'     => 'Invoice Info',
			'title'     => 'Invoice Info',
			'content'   => $this->getLayout()->createBlock('repairdevice/adminhtml_repairdevice_edit_tab_invoiceinfo')->toHtml(),
		));	
		
	    $this->addTab('manageproducts_section' , array(
			'label'     => ' Invoice Item  Products',
			'title'     => 'Invoice Item Products',
			'content'   => $this->getLayout()->createBlock('repairdevice/adminhtml_repairdevice_edit_tab_manageproducts')->toHtml(),
		));	
		

      return parent::_beforeToHtml();
  }
}