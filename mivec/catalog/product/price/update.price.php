<?php
require 'config.php';

//update price from USD-SEK
$_rate = 8.4316;
//ending entity_id=1819

$sql = "SELECT entity_id,`value` as price FROM " . __TABLE_PRODUCT_PRICE__
    . " WHERE entity_id <=" . 1819
    ." AND attribute_id=" . __ATTR_PRICE__
    ." ORDER BY entity_id DESC";

if ($row = $db->fetchAll($sql)) {
    foreach ($row as $rs) {
        $_entityId = $rs['entity_id'];
        $_price = $rs['price'] * $_rate;
        try {
            if (updatePrice($_entityId , $_price)) {
                echo $_entityId . " Update Successfully<br>";
                usleep(5);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
}

function updatePrice($_entityId , $_price)
{
    global $db;
    $sql = "UPDATE " . __TABLE_PRODUCT_PRICE__ . " SET `value`=$_price"
        ." WHERE entity_id=" . $_entityId
        ." AND attribute_id=" . __ATTR_PRICE__;
    //return $db->query($sql);
}