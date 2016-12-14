<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['id'])){
		$sql = "DELETE FROM `product` WHERE `id`='".$_REQUEST['id']."'";
		$res=$conn->query($sql);
		echo $conn->affected_rows;
		if(mysql_affected_rows()!=0){
			$respon['success']=1;	
		}  else {
			$respon['success']=2;
		}
	} else {
		$respon['success']=0;	
	}
	echo json_encode($respon);
?>