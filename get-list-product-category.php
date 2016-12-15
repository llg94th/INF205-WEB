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
			$category = $row;
			$sql2 = 'SELECT COUNT(category_id) AS number FROM product WHERE category_id='.$row['id'];
			$result2 = $conn->query($sql2);
			$cusor = $result2->fetch_assoc();
			$category['number'] = $cusor['number'];
			array_push($mang,$category);
		}
		$respon['success']=1;
		$respon['result']=$mang;
		
	}else{
		$respon['success']=0;
	}
	echo json_encode($respon);
?>