<?php
require dirname(__FILE__) . "/config.php";

define("__TABLE_PRODUCT__" , "catalog_product_entity");
define("__ATTR_PRODUCT_CATALOG_SEARCH__" , 4);
define("__ATTR_PRODUCT_ATTRIBUTE_ID__" , 102);
define("__ATTR_PRODUCT_NOT_VISIBLE_INDIVIDUALLY__" , 1);
define("__TABLE_PRODUCT_INT__" , "catalog_product_entity_int");

//set product status is `Enabled`

$sql = "SELECT a.entity_id,a.sku,b.`value` as status,b.attribute_id FROM "
    . __TABLE_PRODUCT__." a"
    ." LEFT JOIN ".__TABLE_PRODUCT_INT__." b ON(a.entity_id=b.entity_id)"
    ." WHERE b.attribute_id=".__ATTR_PRODUCT_ATTRIBUTE_ID__
    ." AND b.value=".__ATTR_PRODUCT_NOT_VISIBLE_INDIVIDUALLY__
    ." ORDER BY entity_id ASC";

echo $sql . "</p>";

if ($row = $db->fetchAll($sql)) {
    foreach ($row as $rs) {
        try {
            $_id = $rs['entity_id'];
            if (updateStatus($_id)) {
                echo $_id . " update status successfully<br>";
                usleep(5);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
}


function updateStatus($_entityId)
{
    global $db;
    $sql = "UPDATE " . __TABLE_PRODUCT_INT__ . " SET `value`=" . __ATTR_PRODUCT_CATALOG_SEARCH__
        ." WHERE entity_id=" . $_entityId;
    return $db->query($sql);
}
