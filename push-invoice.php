<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	$test = $_POST["json"];
	$json_invoice= json_decode($test,true);
	$product =  array();
	$product = $json_invoice['listProducts'];
	$sql = "INSERT INTO `invoice` (`id`, `date`, `customers_id`, `employee_id`) VALUES (NULL, '".$json_invoice['date']."','".$json_invoice['customerID']."', '".$json_invoice['employeeID']."');";
	if ($conn->query($sql) === TRUE) {
		$id = $conn->insert_id;
		for ($i=0; $i<count($product);$i++){
			$sql1="INSERT INTO `invoice_detail` (`invoice_id`, `product_id`, `number`) VALUES ('".$id."', '".$product[$i]['product_id']."', '".$product[$i]['number']."')";
			if ($conn->query($sql1) === TRUE) {
				$respon['suscess']=true;
			} else {
				$respon['success']=false;
			}
		}
	} else {
		$respon['success']=false;
	}
	echo json_encode($respon);
?>