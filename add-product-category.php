<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['name'])){
		$sql = "INSERT INTO product_category (id, name) VALUES (NULL, '".$_REQUEST['name']."')";
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