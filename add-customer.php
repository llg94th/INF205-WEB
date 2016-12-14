<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['name'])&&isset($_REQUEST['phonenumber'])&&isset($_REQUEST['address'])){
		$name = $_REQUEST['name'];
		$phonenumber = $_REQUEST['phonenumber'];
		$address = $_REQUEST['address'];
		do {
			$id = generateId();
			$sql = "INSERT INTO customers(id, name, phonenumber, address) VALUES ('".$id."','".$name."','".$phonenumber."','".$address."')";
			$result = $conn->query($sql);
		} while($conn->error=="Duplicate entry '".$id."' for key 'PRIMARY'");
		if($result) {
			$respon['success']=1;
		}
		else {
			$respon['success']=0;
		}
	}else{
		$respon['success']=-1;
	}
	echo json_encode($respon);
	
	function generateId(){
		$randNum = rand(0,9999);
		return "KH".$randNum;
	}
?>