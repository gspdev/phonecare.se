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
 
class Dylan_Repairdevice_Block_Adminhtml_Repairdevice extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	 public function __construct()
    {
        $this->_controller     = 'adminhtml_repairdevice';
        $this->_blockGroup     = 'repairdevice';
        $this->_headerText     = Mage::helper('repairdevice')->__('Repairdevice Manager');
        $this->_addButtonLabel = Mage::helper('repairdevice')->__('Add Repairdevice');
        parent::__construct();
	    $this->_removeButton('add');
    }
}