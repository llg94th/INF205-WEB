<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['id'])){
		$sql = "DELETE FROM `product` WHERE `id`='".$_REQUEST['id']."'";
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