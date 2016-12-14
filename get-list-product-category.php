<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$sql = "SELECT * FROM product_category ORDER BY id";
	$result = $conn->query($sql);
	$respon = array();
	if($result->num_rows>0){
		$mang = array();
		while($row = $result->fetch_assoc()){
			array_push($mang,$row);
		}
		$respon['success']=1;
		$respon['result']=$mang;
		
	}else{
		$respon['success']=0;
	}
	echo json_encode($respon);
?>