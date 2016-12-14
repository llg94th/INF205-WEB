<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['phone'])){
		$sql = "SELECT * FROM customers WHERE phonenumber LIKE '%".$_REQUEST['phone']."%'";
		$result = $conn->query($sql);
		
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
	}else{
		$respon['success']=-1;
	}
	echo json_encode($respon);
?>