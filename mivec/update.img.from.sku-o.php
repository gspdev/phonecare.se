<?php
// require dirname(__FILE__) . '/config.php';
//echo __PATH_MEDIA_PRODUCT_REPAIR__;exit;
// echo dirname(__FILE__) . '/config.php';
/*******************************************************刷新产品图片***************************************************************/
/**
 * 刷新产品图片
 * */

refreshProductPic();
function refreshProductPic() {
	// if ($_REQUEST['submit'] == 1) {
		$tempFileDir="/var/www/phonecare.se/media/catalog/product/imagetem/";
		$subSkuArr = getImageDir1($tempFileDir);
		// var_dump($subSkuArr);die;
		$dbhost = 'localhost:3306';  // mysql服务器主机地址
		$dbuser = 'root';            // mysql用户名
		$dbpass = '4tvM55zXRb4qbS96';          // mysql用户名密码
		$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
		if(! $conn )
		{
			die('Could not connect: ' . mysqli_error());
		}
		echo '数据库连接成功！';
		// 设置编码，防止中文乱码
		mysqli_query($conn , "set names utf8");
		 
		

		$sql = "SELECT * FROM catalog_product_entity  WHERE `sku` = 'IP6SA16R'";
		 
		 
		mysqli_select_db( $conn, 'phonecare515' );
		
		if (count($subSkuArr) > 0) {
			$i = 0;
			foreach ($subSkuArr as $productSku) {
				 echo $productSku;
				
				
				// $sql = "";

				/*categories*/
				// $sql = "SELECT * FROM catalog_product_entity  WHERE `sku` = 'IP6SA16R'";
				$sql = "SELECT * FROM catalog_product_entity  WHERE `sku` = '$productSku'";
				// $sql = "SELECT * FROM catalog_product_entity  WHERE `sku` = 'REPIP5S11'";
				// echo $sql;exit;
				
				var_dump($sql);
				 echo '<br/>';
				
				$retval = mysqli_query( $conn, $sql );
				// print_r($retval);
				// echo '<br/>';
				foreach($retval as $productEntity){
					
					var_dump($productEntity);
				}
				 echo '<br/>';
				// print_r($productEntity['entity_id']);
				//
				var_dump('$productEntity');
				 echo '<br/>';
				var_dump($productEntity['entity_id']);
				 echo '<br/>';
				if(!$productEntity['entity_id']) continue;

				if(! $retval )
				{
				  die('无法插入数据: ' . mysqli_error($conn));
				}
				
				
				
				$productId = $productEntity['entity_id'];
				
				if ($productEntity['type_id'] == 'simple') {
					$fromSkuDir = $productSku."/";
					$toSkuDir = $productSku."/";
					if(updateProductPic($productId, $fromSkuDir, $toSkuDir, $productSku, 1)) {
						$i++;
					}
				} 
				
				
				
			}
			echo '<br/>';
			die('共更新'.$i.'个产品图片');
		} else {
			echo '<br/>';
			die('该文件夹下面没有产品图片');
		}
	// }
	
	// $this->display('refreshProductPic');
}


/**
 * $productid :简单产品的id   //图片批量上传
 * $productSku :产品文件夹sku
 * $fromSkuDir ：图片源文件夹
 * $toSkuDir ：图片转移后的文件夹
 * */
function updateProductPic($productId, $fromSkuDir, $toSkuDir, $productSku, $dirLevel=1) {
	//更新产品varchar的图片
	$tempFileDir="/var/www/phonecare.se/media/catalog/product/imagetem/";
	$desFileDir  ="/var/www/phonecare.se/media/catalog/product/ima/";
	$fromSkuAbDir = $tempFileDir.$fromSkuDir;
	$toSkuAbDir = $desFileDir.$toSkuDir;
	$mainPicFile = getMainPicBySku($fromSkuAbDir);
   // echo 223;die;
   $dbhost = 'localhost:3306';  // mysql服务器主机地址
	$dbuser = 'root';            // mysql用户名
	$dbpass = '4tvM55zXRb4qbS96';          // mysql用户名密码
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
	if(! $conn )
	{
		die('Could not connect: ' . mysqli_error());
	}
	echo '<br/>';
	echo '数据库连接成功！';
	// 设置编码，防止中文乱码
	mysqli_query($conn , "set names utf8");
	 
	

	$sql = "SELECT * FROM catalog_product_entity  WHERE `sku` = 'IP6SA16R'";
	 
	 
	mysqli_select_db( $conn, 'phonecare515' );
   
	if (file_exists($fromSkuAbDir.$mainPicFile)) {
		
		mkdir($toSkuAbDir,0777, 1);
		// echo 11223;die;
		//先删除原来的目录，如果存在的话
		deldir($toSkuAbDir);

		$mainPicFileSrc = '/ima/'.$toSkuDir.$mainPicFile;
		$varcharArr = array(
			85=>$mainPicFileSrc,
			86=>$mainPicFileSrc,
			// $this->_eav_attribute['varchar']['small_image']=>$mainPicFileSrc,
			// $this->_eav_attribute['varchar']['thumbnail']=>$mainPicFileSrc,
			87=>$mainPicFileSrc,
		);
		foreach($varcharArr as $key=>$value) {
			// var_dump($value);die;
			$dataVarchar = array();
			$dataVarchar["entity_type_id"] = 4;
			$dataVarchar['attribute_id'] = $key;
			$dataVarchar['store_id'] = 0;
			$dataVarchar['entity_id'] = $productId;
			// $result = M("catalog_product_entity_varchar")->where($dataVarchar)->find();
			$sql = "SELECT * FROM catalog_product_entity_varchar  WHERE `entity_type_id` = 4 AND `attribute_id`='".$dataVarchar['attribute_id']."' AND store_id=0 AND `entity_id`='".$dataVarchar['entity_id']."'";
			$results = mysqli_query( $conn, $sql );
			// var_dump('$results');
			// var_dump($results);die;
			foreach($results as $result){
				
			}
             // var_dump($result);die;			
			if ($result['value_id']) {
				// M("catalog_product_entity_varchar")->where($dataVarchar)->save(array('value'=>$value));
				$sql1="UPDATE catalog_product_entity_varchar SET `value`='".$value."' WHERE `entity_type_id` = 4 AND `attribute_id`='".$dataVarchar['attribute_id']."' AND store_id=0 AND `entity_id`='".$dataVarchar['entity_id']."'";
				 mysqli_query( $conn, $sql1 );
			} else {
				// $dataVarchar['value'] = $value;
				// M("catalog_product_entity_varchar")->add($dataVarchar);

				$sql2="INSERT INTO catalog_product_entity_varchar "."(entity_type_id,attribute_id, store_id,entity_id,value) ".
                "VALUES ".
                "(4,'$key',0,'$productId','$value')";
				mysqli_query( $conn, $sql2 );
			}
		}
		// die;
		//删除产品已存在的图片
		
		$sql3 = "DELETE FROM catalog_product_entity_media_gallery_value WHERE `value_id`=".$productId."";
		mysqli_query( $conn, $sql3 );
        $sql4 = "DELETE FROM catalog_product_entity_media_gallery WHERE `entity_id`=".$productId."";
		// var_dump($sql4);die;
		mysqli_query( $conn, $sql4 );

		//添加商品的主图 数据到catalog_product_entity_media_gallery表
		$data5 = array();
		// $data5['attribute_id'] = $this->_eav_attribute['varchar']['media_gallery'];
		$data5['attribute_id'] = 88;
		$data5['entity_id'] = $productId;
		$data5['value'] = $mainPicFileSrc;

		// $newProductEntityMediaGalleryId = M("catalog_product_entity_media_gallery")->add($data5);
		$sql5="INSERT INTO catalog_product_entity_media_gallery "."(attribute_id,entity_id,value) ".
                "VALUES ".
            "(88,'$productId','$mainPicFileSrc')";
		mysqli_query( $conn, $sql5 ); 
		
		$sql6="select max(value_id) as value_id from catalog_product_entity_media_gallery";	
			
		$newProductEntityMediaGalleryId1=mysqli_query($conn, $sql6);
		foreach($newProductEntityMediaGalleryId1 as $newProductEntityMediaGalleryd){
			$newProductEntityMediaGalleryId=$newProductEntityMediaGalleryd['value_id'];
		}
		

		//添加商品的主图 数据到catalog_product_entity_media_gallery_value表
		$data6 = array();
		$data6['value_id'] = $newProductEntityMediaGalleryId;
		$data6['store_id'] = 0;
		$data6['label'] = '';
		$data6['position'] = 1;
		$data6['disabled'] = 0;
		// M("catalog_product_entity_media_gallery_value")->data($data6)->add();
		$sql7="INSERT INTO catalog_product_entity_media_gallery_value "."(value_id,store_id,label,position,disabled) ".
                "VALUES ".
                "('$newProductEntityMediaGalleryId',0,'',1,0)";
        $entityMediaGalleryValueId0=mysqli_query( $conn, $sql7 ); 
		if(!$entityMediaGalleryValueId0) {
			echo '<br/>';
			var_dump($sql7);
			die("商品插入表1 catalog_product_entity_media_gallery_value 失败");
		}
		
		/*获取商品的其他图片，并把他们插入到上面两个表中*/
		$vicePicArr = getVicePicBySku($fromSkuAbDir);
		if ($vicePicArr) {
			$imageIndex = 1;
			foreach ($vicePicArr as $vicePic) {
				rename($fromSkuAbDir.$vicePic, $toSkuAbDir.$vicePic);

				$data7 = array();
				// $data7['attribute_id'] = $this->_eav_attribute['varchar']['media_gallery'];
				$data7['attribute_id'] = 88;
				$data7['entity_id'] = $productId;
				$data7['value'] = '/ima/'.$toSkuDir.$vicePic;
				$datavalue = '/ima/'.$toSkuDir.$vicePic;

				// $newProductEntityMediaGalleryId = M("catalog_product_entity_media_gallery")->data($data7)->add();
				$sql8="INSERT INTO catalog_product_entity_media_gallery "."(attribute_id,entity_id,value) ".
					"VALUES ".
					"(88,'$productId','$datavalue')";
                $newProductEntityMediaGalleryId=mysqli_query( $conn, $sql8 );
				
				if(!$newProductEntityMediaGalleryId) {
					// $this->dal->rollback();
					die("商品插入表catalog_product_entity_media_gallery失败");
				}
                $sql16="select max(value_id) as value_id from catalog_product_entity_media_gallery";	
			
		        $newProductEntityMediaGalleryId1=mysqli_query($conn, $sql16);
				foreach($newProductEntityMediaGalleryId1 as $newProductEntityMediaGalleryd){
					$newProductEntityMediaGalleryId1=$newProductEntityMediaGalleryd['value_id'];
				}
				
				// var_dump($sql8);
				// var_dump("LAST_INSERT_ID  ".$newProductEntityMediaGalleryId1);	
				$data8 = array();
				$data8['value_id'] = $newProductEntityMediaGalleryId1;
				$data8['store_id'] = 0;
				$data8['label'] = '';
				$data8['position'] = $imageIndex+1;
				
				$data8['disabled'] = 0;
				
				$dataposition = $imageIndex+1;
				// $entityMediaGalleryValueId = M("catalog_product_entity_media_gallery_value")->data($data8)->add();
				$sql8="INSERT INTO catalog_product_entity_media_gallery_value "."(value_id,store_id,label,position,disabled) ".
					"VALUES ".
                "('$newProductEntityMediaGalleryId1',0,'','$dataposition',0)";
                $entityMediaGalleryValueId=mysqli_query( $conn, $sql8 );
				
				
				if(!$entityMediaGalleryValueId) {
					// $this->dal->rollback();
					echo '<br/>';
					die($sql8);
					die("商品插入表2 catalog_product_entity_media_gallery_value 失败");
				}

				$imageIndex = $imageIndex + 1;
			}
		}
		if (rename($fromSkuAbDir, $toSkuAbDir) == true){
			return true;
		}
	}
}

/**
 * 获得文件夹下面的子文件夹
 * add by wangfan
 * */
 function getImageDir1($pDir) {
	$categoryArr = array();

	//1.得到图片根目录下面所有的类别名称
	// var_dump($pDir);
	if(!is_dir($pDir)){
		echo '!is_dir';
		die;
	}
	$fp = opendir($pDir);
	
	
	if($fp) {
		
		while(false !== ($file = readdir($fp))) {
			
			if($file!="." && $file!=".." && is_dir($pDir.$file)) {
				
				chmod ($file, 0777);
				$categoryArr[] = $file;
			}
			
		}
	}

	sort($categoryArr);

	return $categoryArr;
}

/**
	 * 根据sku获得该文件夹下面的主图片
	 * add by wangfan 2014=03-28
	 * */
    function getMainPicBySku($skuDir) {
		//1.得到图片根目录下面所有的类别名称
		$fp = opendir($skuDir);//dump($skuDir);
		if($fp) {
			$size=20000;
			while(false !== ($file = readdir($fp))) {
				
				//if($file!="." && $file!=".." && !is_dir($skuDir.$file) &&filesize($skuDir.$file)>20000&& substr($file, -5)=="1.jpg") {
				if($file!="." && $file!=".." && !is_dir($skuDir.$file) &&filesize($skuDir.$file)>20000) {
					//return substr($file, 0, -4);
				    chmod ($file, 0777);
					if(filesize($skuDir.$file)>$size){
						$size=filesize($skuDir.$file);
						$filez=$file;
					}
					
				}
			}
			return $filez;
		}
	}
	
	function deldir($dir) {
	    //先删除目录下的文件：
	    $dh=opendir($dir);
	    while ($file=readdir($dh)) {
	        if($file!="." && $file!="..") {
	            $fullpath=$dir."/".$file;
	            if(!is_dir($fullpath)) {
	                chmod ($fullpath, 0777);
	                unlink($fullpath);
	            }
	        }
	    }

	    closedir($dh);
	    //删除当前文件夹：

	    chmod ($dir, 0777);
	    if(rmdir($dir)) {
	        return true;
	    } else {
	        return false;
	    }
	}
	
	/**
	 * 根据sku获得该文件夹下面的辅图片
	 * add by wangfan 2014=03-28
	 * */
	function getVicePicBySku($skuDir) {
		$viceFilePicName = array();
		//1.得到图片根目录下面所有的类别名称
		$fp = opendir($skuDir);//dump($skuDir);
		if($fp) {
			while(false !== ($file = readdir($fp))) {
				if($file!="." && $file!=".." && !is_dir($skuDir.$file)&&filesize($skuDir.$file)>20000 && substr($file, -5)!="1.jpg" && substr($file, -4)==".jpg") {
				    chmod ($file, 0777);
					$viceFilePicName[] = $file;
				}
			}

			if ($viceFilePicName) {
				sort($viceFilePicName);
			}
		}

		return $viceFilePicName;
	}
        