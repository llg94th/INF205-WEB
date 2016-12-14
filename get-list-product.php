<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$sql = "SELECT product.id,product.product_name,product.price,product.category_id,product_category.name AS category_name FROM product INNER JOIN product_category WHERE product.category_id = product_category.id";
	$result = $conn->query($sql);
	$respon = array();
	
	//Get list products
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