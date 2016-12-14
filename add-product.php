<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['name'])&&isset($_REQUEST['price'])){
		$sqlgetid ="SELECT `id` FROM `customers` ORDER BY `id` DESC LIMIT 1";
		$result =$conn->query($sqlgetid);
		if ($row =mysqli_fetch_assoc($result)){
			$id=$row['id'];
		}
		$sao=substr($id,2);
		$sao2=(int) $sao;
		$nextid = "SP".(((int) substr($id,2))+1);
		$sql = "INSERT INTO `product` (`id`, `product_name`, `price`) VALUES ('".$nextid."', '".$_REQUEST['name']."', ".$_REQUEST['price'].");";
		if($conn->query($sql)){
			$respon['success']=1;	
		}  else {
			$respon['success']=2;
		}
	} else {
		$respon['success']=0;	
	}
	echo json_encode($respon);
?>