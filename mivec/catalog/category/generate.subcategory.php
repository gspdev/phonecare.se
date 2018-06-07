<?php
require 'config.php';

$_log = "data/generate.sub.log";
$fp = fopen($_log , "wb");

/**
 * mobilephone parts 目录下 所有型号的分类下生成以下子类
 */
$_sub = array("LCD" , "Flex Cable" , "Button" , "Camera" , "Battery" , "Speaker" , "Circuit" , "SIM Card" , "Other");

//获得所有 ·型号· 的目录；
//$_categoryCollection = getCategoryCollection(array("level"  => 5));
//$_category = Mage::getModel('catalog/category')->load(923);print_r($_category->getData());exit;

$_categoryCollection = getCategoryCollection(
    array("parent_id"  => 124) //iphone
);

foreach ($_categoryCollection->getItems() as $_item) {
    $_parentId = $_item->getId();
    foreach ($_sub as $_subCategory) {
        $data = array(
            "parent_id" => $_parentId,
            "name"      => $_subCategory
        );
/*        if (createCategory($data)) {
            echo $_parentId . " was create subcategory $_subCategory <br>";
        }*/
    }
    usleep(10);
    //exit;
    echo "</p>";
}

function getCategoryCollection($_param = "")
{
    global $db;
    $_categoryCollection = Mage::getModel("catalog/category")
        ->getCollection();
    if (is_array($_param)) {
        foreach ($_param as $_field => $_value) {
            $_categoryCollection->addAttributeToFilter($_field , array("eq" => $_value));
        }
    }
    $_categoryCollection->getSelect()->order("position ASC");
    $sql = $_categoryCollection->getSelect()->__toString();
    //echo $sql;exit;

    return $_categoryCollection;
}


function createCategory($data)
{
    global $db;

    $_return = false;
    $parentId = $data['parent_id'];

    try{
        $category = Mage::getModel('catalog/category');
        $category->setName($data['name']);
        $category->setUrlKey(strtolower($data['name']));
        $category->setIsActive(1);
        $category->setDisplayMode('PRODUCTS');
        $category->setIsAnchor(1); //for active anchor
        $category->setStoreId(Mage::app()->getStore()->getId());

        //get parent
        $parentCategory = Mage::getModel('catalog/category')->load($parentId);
        $category->setPath($parentCategory->getPath());

        if ($category->save()) {
            $_return = true;
        }
    } catch(Exception $e) {
        print_r($e);
    }

    /*
    $_return = false;
    try {
        if ($db->insert(__TABLE_CATEGORY__ ,$data)) {
            $_return = true;
            echo $data['parent_id'] . " was create subcategory<br>";
        }
    } catch (Exception $e) {
        echo $e->getCode() . " : " . $e->getMessage();
    }
    return $_return;*/

    return $_return;
}

fclose($fp);