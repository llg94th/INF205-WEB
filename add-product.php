<?php
	include('db-config.php');
	$db = new DB_Connect();
	$conn = $db->connect();
	$respon = array();
	if(isset($_REQUEST['name'])&&isset($_REQUEST['price'])&&isset($_REQUEST['category'])){
		$sqlgetid ="SELECT `id` FROM `product` ORDER BY `id` DESC LIMIT 1";
		$result =$conn->query($sqlgetid);
		if ($row =mysqli_fetch_assoc($result)){
			$id=$row['id'];
		}
		$sao=substr($id,2);
		$sao2=(int) $sao;
		$nextid = "SP0".(((int) substr($id,2))+1);
		$sql = "INSERT INTO `product` (`id`, `product_name`, `price`, `category_id`) VALUES ('".$nextid."', '".$_REQUEST['name']."', ".$_REQUEST['price'].",".$_REQUEST['category'].");";
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