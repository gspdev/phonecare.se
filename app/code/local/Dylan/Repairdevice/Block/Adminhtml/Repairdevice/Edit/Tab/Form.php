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
 
class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	 protected function _prepareForm()
	  {   
	      $formData = Mage::registry("repairdevice_data");
		 // print_r($formData);exit;
	      $form = new Varien_Data_Form();
	      $this->setForm($form);
	      $fieldset = $form->addFieldset(
            'web_form', 
            array('legend'=>Mage::helper('repairdevice')->__('Repairdevice information'))
	      );
	      
	      // $fieldset->addField('repairdevice_id', 'text', array(
	          // 'label'     => Mage::helper('repairdevice')->__('Repairdevice Id'),
	          // 'class'     => 'required-entry',
	          // 'required'  => true,
	          // 'name'      => 'repairdevice_id',
	      // ));
		  
		 $_customer = $this->helper('repairdevice/customer')->getCustomer($formData->getCustomerId());
		  
		 // $customerEmail = Mage::getModel('customer/customer')->load($formData->getCustomerId())->getEmail();	
		 // print_r($customerEmail);exit;

		  // $fieldset->addField('customer_email' , 'link' , array(
            // 'label'     => 'Customer email: '.$_customer->getEmail().'',
            // 'name'      => 'customer_email',
            // 'value'     => $_customer->getEmail(),
        // ));
		
		  // $fieldset->addField('customer_id' ,'link', array(
            // 'label'     => 'Customer email',
			// 'readonly' => true,
            // 'name'      => 'customer_id',
            // 'value'     => $customerEmail,
			
        // ));
		  
		  $fieldset->addField('imei', 'text', array(
	          'label'     => Mage::helper('repairdevice')->__('Serie/IMEI-nummer:'),
	          'class'     => 'required-entry',
	          'required'  => true,	
	          'name'      => 'imei',
	      ));
		  
		  $fieldset->addField('screencode', 'text', array(
	          'label'     => Mage::helper('repairdevice')->__('Skärmlås:'),
	          'class'     => 'required-entry',
	          'required'  => true,	
	          'name'      => 'screencode',
	      ));
		  
		  
		$shipping_method = Dylan_Repairdevice_Model_Shipping_Shippingmethod::getShippingMethod();
	
        $fieldset->addField('shipping_method', 'select', array(
            'name'		=> 'shipping_method',
            'label'     => 'Shipping Method',
            'required'	=> true,
            'values'	=> $shipping_method,
            'value'		=> $formData['shipping_method']
        ));

		  
	      // $fieldset->addField('shipping_method', 'select', array(
	          // 'label'     => Mage::helper('repairdevice')->__('Shipping Method'),
	          // 'name'      => 'shipping_method',
	          // 'values'    => array(
                  // array(
                      // 'value'     => 1,
                      // 'label'     => Mage::helper('repairdevice')->__('1'),
                  // ),
                  // array(
                      // 'value'     => 2,
                      // 'label'     => Mage::helper('repairdevice')->__('2'),
                  // ),
	          // ),
	      // ));
	      
	    $invoice_status = Dylan_Repairdevice_Model_Status_Status::getStatus();
		//print_r($formData);exit;
		$fieldset->addField('invoice_status', 'select', array(
		
            'name'		=> 'invoice_status',
            'label'     => 'Status',
            'required'	=> true,
            'values'	=> $invoice_status,
            'value'		=> $formData['invoice_status'],
        ));
		
	      $fieldset->addField('detailed', 'editor', array(
	          'name'      => 'detailed',
	          'label'     => Mage::helper('repairdevice')->__('Beskriv problemet'),
	          'title'     => Mage::helper('repairdevice')->__('Beskriv problemet'),
	          'style'     => 'width:700px; height:200px;',
	          'wysiwyg'   => FALSE,
	          'required'  => true,
	      ));
		  
	      
	      if (Mage::getSingleton('adminhtml/session')->getRepairdeviceData())
	      {
	          $form->setValues(Mage::getSingleton('adminhtml/session')->getRepairdeviceData());
	          Mage::getSingleton('adminhtml/session')->setRepairdeviceData(null);
	      } elseif ( Mage::registry('repairdevice_data')) {
	          $form->setValues(Mage::registry('repairdevice_data')->getData());
	      }
	       
	      return parent::_prepareForm();
	       
	  }
}