<?php
require dirname(__FILE__) . '/config.php';
//echo __PATH_MEDIA_PRODUCT_REPAIR__;exit;

//从category的图复制记录更新到产品数据表中
$sql = "";

/*categories*/
$sql = "SELECT * FROM " . __TABLE_CATEGORY__
    ." WHERE `level` = 4"
    ." AND parent_id=2622"
    ." ORDER BY entity_id DESC";
//echo $sql;exit;

if ($row = $db->fetchAll($sql)) {
    foreach ($row as $rs) {
        $_categoryId = $rs['entity_id'];
        //$_categoryId = 2511;
        $_category = getCategory($_categoryId);
        $_categoryImg = $_category->getData("image");

        //创建目标目录，复制图片,更新数据库;
        $_dir['source'] = __PATH_MEDIA_CATEGORY__;
        $_dir['dest'] = __PATH_MEDIA_PRODUCT_REPAIR__;
        createDir($_dir['dest']);

        $_image['source'] = $_dir['source'] . $_categoryImg;
        $_image['dest'] = $_dir['dest'] . $_categoryImg;
        cloneImage($_image['source'] , $_image['dest']);

        if ($_productIds = getProductIdByCategory($_category)) {
            foreach ($_productIds as $_id) {
                //update database;
                $_image['filename'] = $_repairPrefix . $_categoryImg;
                //echo $_image['filename'];exit;
                if (updateProductImage($_id , $_image['filename'])) {
                    echo $_id . " update image successfully<br>";
                    //exit;
                }
            }
        }
        usleep(5);
    }
}



function getCategory($_categoryId)
{
    global $db;
    return Mage::getModel('catalog/category')->load($_categoryId);
}

function getProductIdByCategory($_category)
{
    $_productCollection = Mage::getModel('catalog/product')
        ->getCollection()
        ->addCategoryFilter($_category)
        ->setOrder("entity_id" , "DESC");
    if ($_productCollection) {
        $data = array();
        foreach ($_productCollection->getItems() as $_item) {
            $data[] = $_item->getId();
        }
        return $data;
    }
    return false;
}

function updateProductImage($_entityId , $_image)
{
    global $db;
    $sql = "REPLACE INTO " . __TABLE_PRODUCT_MEDIA__
        ." SET `value`='$_image'"
        .",entity_id=" . $_entityId
        .",attribute_id=" . __ATTR_PRODUCT_IMG__;

        //." WHERE entity_id=" . $_entityId
        //." AND attribute_id=" . __ATTR_PRODUCT_IMG__;

    //echo $sql;exit;
    //set images for product
    setProductImageValue($_entityId , $_image);

    try {
        if ($db->query($sql)) {
            return true;
        }
    } catch (Exception $e) {
        print_r($e);
    }
}

function setProductImageValue($_entityId , $_image)
{
    global $db,$_imgType;

    $_return = false;

    foreach ($_imgType as $_code => $_val) {
        $sql = "REPLACE INTO " . __TABLE_PRODUCT_VARCHAR__
            ." SET `value`='$_image'"
            .",entity_id=" . $_entityId
            .",attribute_id=" . $_val
            .",store_id=0,entity_type_id=4";
       // echo $sql;

        if ($db->query($sql)) {
            $_return = TRUE;
        }
    }
    return $_return;
}

function getFinalDir($_path)
{
    return basename($_path) . PHP_EOL;
}

function createDir($_destinationDir)
{
    if (!file_exists($_destinationDir)) {
        mkdir($_destinationDir);
    }
}

function cloneImage($_source , $_destination)
{
    if (!file_exists($_destination)) {
        return copy($_source , $_destination);
    }
}
