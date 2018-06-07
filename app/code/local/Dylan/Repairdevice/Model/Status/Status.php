<?php
class Dylan_Repairdevice_Model_Status_Status extends Mage_Core_Model_Abstract
{
    public static function getStatus()
    {
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

}