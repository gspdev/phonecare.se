<?php
class Dylan_Repairdevice_Model_Product_Productcolltion extends Mage_Core_Model_Abstract
{
    public static function getProduct()
    {
       $data = Mage::getModel('catalog/product')->load($id)->getName();
	   
       return $data;
    }
}