<?php
class Dylan_Repairdevice_Model_Shipping_Shippingmethod extends Mage_Core_Model_Abstract
{
    public static function getShippingMethod()
    {
        $data = array(
            1    => "Skicka in med post",
            2    => "Kungsgatan 29, 11156 Stockholm, Sverige",
            3    => "Tivolivägen 2, 12631 Hägersten, Sverige"
        );
        return $data;
    }
	
	public static function getShippingType()
    {
        $data = array(
            0    => "Billing Adress",
            1    => "Shipping Adress",
        );
        return $data;
    }
}