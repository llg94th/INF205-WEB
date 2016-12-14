<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['id'])&&isset($_REQUEST['name'])&&isset($_REQUEST['price'])&&isset($_REQUEST['category'])){
		$sql = "UPDATE `product` SET `product_name`='".$_REQUEST['name']."',`price`=".$_REQUEST['price'].",`category_id` =".$_REQUEST['category']." WHERE `id`='".$_REQUEST['id']."'";
			if($conn->query($sql)){
				$respon['success']=1;	
			}  else {
				$respon['success']=2;
			}
		} else {
			$respon['success']=0;	
	}
	echo json_encode($respon);
?>