<?php
require dirname(__FILE__) . "/config.php";


//set product qty is 0
//UPDATE cataloginventory_stock_item SET `qty` = 0,`is_in_stock` = 0;
define("__ATTR_PRODUCT_QTY__" , 0);
define("__ATTR_PRODUCT_IS_IN_STOCK__" , 0);

define("__TABLE_PRODUCT_STOCK_ITEM__" , "cataloginventory_stock_item");


/*$sql = "SELECT a.entity_id,a.sku,b.product_id FROM "
    . __TABLE_PRODUCT__." a"
    ." LEFT JOIN ".__ATTR_PRODUCT_STOCK_ITEM__." b ON(a.entity_id=b.product_id)"
    ." WHERE b.attribute_id=".__ATTR_PRODUCT_STATUS__
    ." AND a.entity_id=5346"
    ." ORDER BY entity_id ASC";*/

//set `manage_stock`=0 in SKU like 'REP'

define("__ATTR_MANAGE_STOCK__" , 0);
define("__ATTR_QTY__" , 'qty');
define("__ATTR_IN_STOCK__" , "is_in_stock");

$sql = "SELECT 
  a.entity_id,
  a.sku,
  b.`manage_stock` 
FROM
  ".__TABLE_PRODUCT__." a 
  LEFT JOIN ".__TABLE_PRODUCT_STOCK_ITEM__." b 
    ON (a.entity_id = b.product_id) 
WHERE a.`sku` LIKE '%REP%' 
ORDER BY entity_id DESC;";

//echo $sql . "</p>";
if ($row = $db->fetchAll($sql)) {
    foreach ($row as $rs) {
        try {
            if (updateStock($rs["entity_id"])) {
                echo $rs["sku"] . " update success<br>";
                usleep(5);
            }
        } catch(Exception $e) {
            echo $e->getMessage();exit;
        }
    }
}

function updateStock($entityId)
{
    global $db;
    $sql = "UPDATE " . __TABLE_PRODUCT_STOCK_ITEM__ ." SET `manage_stock`=1
    ,".__ATTR_IN_STOCK__."=1 
    ,".__ATTR_QTY__."=1000
        WHERE product_id=$entityId";
    return $db->query($sql);
}



/*if ($row = $db->fetchAll($sql)) {
    foreach ($row as $rs) {
        try {
            if (update()) {
                echo " update inventory successfully<br>";
                usleep(5);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
}*/

  

function update()
{
    global $db;
    $sql = "UPDATE " . __ATTR_PRODUCT_STOCK_ITEM__ . " SET `qty`=" . __ATTR_PRODUCT_QTY__.",`is_in_stock`=".__ATTR_PRODUCT_IS_IN_STOCK__.",manage_stock=0";
    return $db->query($sql);
	//echo " Inventory update successfully<br>";
}