<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['id'])&&isset($_REQUEST['password'])){
		$sql = "SELECT * FROM employee WHERE id='".$_REQUEST['id']."' AND password='".$_REQUEST['password']."'";
		$result = $conn->query($sql);
		if($result->num_rows>0){
			$respon['success']=1;
			$respon['account']=$result->fetch_assoc();
		}else{
			$respon['success']=2;
		}
	}else{
			$respon['success']=3;
	}
	echo json_encode($respon);
?>