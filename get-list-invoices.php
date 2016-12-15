<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	$sql = "SELECT invoice.id,date,customers_id,name FROM invoice INNER JOIN employee WHERE employee.id LIKE employee_id";
	$invoiceResult = $conn->query($sql);
	if($invoiceResult->num_rows>0){
		$listInvoice = array();
		while ($row = $invoiceResult->fetch_assoc()){
			$invoice = $row;
			$invoiceId = $row['id'];
			$sql2 = "SELECT invoice_detail.product_id,invoice_detail.number FROM invoice_detail WHERE invoice_id = ".$invoiceId;
			$itemResult = $conn->query($sql2);
			$listItem = array();
			if($itemResult->num_rows>0){
				while($item = $itemResult->fetch_assoc()){
					array_push($listItem,$item);
				}
			}
			$sql3 = "SELECT * FROM customers WHERE id LIKE '".$invoice['customers_id']."'";
			$customerCusor = $conn->query($sql3);
			$customer = $customerCusor->fetch_assoc();
			
			$invoice['items'] = $listItem;
			$invoice['customer'] = $customer;
			array_push($listInvoice,$invoice);
		}
		$respon['success']=1;
		$respon['result']=$listInvoice;
	}else{
		$respon['success']=0;
	}
	
	echo json_encode($respon);
?>