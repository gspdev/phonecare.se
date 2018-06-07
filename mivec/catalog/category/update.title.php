<?php
require 'config.php';

//替换标题 For 去掉,并重新生成URL
define("__ATTR_NAME__" , 41);

$_key = "For ";

$sql = "SELECT a.*,b.* FROM " . __TABLE_CATEGORY__ . " a LEFT JOIN " . __TABLE_CATEGORY_VARCHAR__." b ON(a.entity_id=b.entity_id)"
    ." WHERE a.level > 2 AND b.`value` LIKE '%$_key%'"
    ." ORDER BY a.entity_id DESC";
echo $sql . "</p></p>";

if ($row = $db->fetchAll($sql)) {
    foreach ($row as $rs) {
        $id = $rs['entity_id'];
        $name = str_replace($_key , "" , $rs['value']);

        //update
        if (updateCategoryValue($id , __ATTR_NAME__ , $name)) {
            echo $id . " was updated.<br>";
        }
    }
}

function updateCategoryValue($_entityId , $_attributeId , $_name)
{
    global $db;
    $sql = "UPDATE " . __TABLE_CATEGORY_VARCHAR__ . " SET `value`='$_name'"
        ." WHERE attribute_id=" . $_attributeId
        ." AND entity_id=" . $_entityId;

    return $db->query($sql);
}


/*$categoryCollection = Mage::getModel('catalog/category')
    ->getCollection()
    ->addAttributeToSelect("*")
    ->addAttributeToFilter("level" , array("gt" => 3))
    ->addAttributeToFilter("name" , array("like"    => '%$_key%'))
    ->setOrder("entity_id" , "DESC");*/