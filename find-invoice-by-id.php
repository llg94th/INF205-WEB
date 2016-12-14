<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['id'])){
		$invoiceId = $_REQUEST['id'];
		$sql = "SELECT invoice.id,date,customers_id,employee.name FROM invoice JOIN employee ON employee_id LIKE employee.id WHERE invoice.id = '".$invoiceId."'";
		$cursor = $conn->query($sql);
		if($cursor->num_rows>0){
			$row = $cursor->fetch_assoc();
			$invoice = $row;
			$invoiceId = $invoice['id'];
			$customerId = $invoice['customers_id'];
			//get list items
			$sql2 = "SELECT product_id,product_name,number,price FROM invoice_detail JOIN product ON product_id LIKE product.id WHERE invoice_id = ".$invoiceId;
			$itemResult = $conn->query($sql2);
			$listItem = array();
			if($itemResult->num_rows>0){
				while($item = $itemResult->fetch_assoc()){
					array_push($listItem,$item);
				}
			}
			//get customer info
			$sql3 = "SELECT * FROM customers WHERE id LIKE '".$customerId."'";
			$customerCusor = $conn->query($sql3);
			$customer = $customerCusor->fetch_assoc();
			///////////////////////////////
			$invoice['items'] = $listItem;
			$invoice['customer'] = $customer;
			$respon['success']=1;
			$respon['result'] = $invoice;
		}else{
			$respon['success']=-1;
		}
	}else{
		$respon['success']=0;
	}
	echo json_encode($respon);
?>