<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Hoá đơn mua hàng</title>
<link href="css/main.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
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
	echo "var invoiceString = '".json_encode($respon)."';";
?>
	var totalPrice;
	$( document ).ready(function() {
		totalPrice=0;
    	loadInvoice();
		$('body').show();
	});
	function loadInvoice(){
		var invoiceObj = $.parseJSON(invoiceString);
		var date = new Date(parseFloat(invoiceObj.result.date));
		$('#invoiceId').html(invoiceObj.result.id);
		$('#invoiceDate').html(date.toLocaleDateString());
		$('#customerName').html(invoiceObj.result.customer.name+' ('+invoiceObj.result.customer.id+')');
		$('#customerPhone').html(invoiceObj.result.customer.phonenumber);
		$('#customerAdd').html(invoiceObj.result.customer.address);
		$('#employee').html(invoiceObj.result.name);
		invoiceObj.result.items.forEach(loadItems);
		var htmlLastItem = '<div class="item"><span class="stt">&nbsp;</span><span class="product">&nbsp;</span><span class="number">&nbsp;</span><span class="price">Tổng:</span><span class="total">'+totalPrice.toLocaleString()+'</span></div>';
		$('#items').append(htmlLastItem);
	}
	
	
	function loadItems(product, i){
		var htmlItem = '<div class="item"><span class="stt">'+(i+1)+'</span><span class="product">'+product.product_id+' - '+product.product_name+'</span><span class="number">'+product.number+'</span><span class="price">'+parseInt(product.price).toLocaleString()+'</span><span class="total">'+(product.number*product.price).toLocaleString()+'</span></div>';
		totalPrice = totalPrice + product.number*product.price;
		$('#items').append(htmlItem);
	}
</script>
</head>
<body hidden>
<div class="book">
  <div class="page">
    <div class="subpage">
    	<div id="topbar">
        	<h4>Công ty TMCP & ĐT </br>Pink Color Shop</h4>
            <span>Cộng hoà xã hội chủ nghĩa Việt Nam</br>Độc lập - Tự do - Hạnh phúc</span>
        </div>
        <p><strong>HOÁ ĐƠN BÁN HÀNG</strong></br>(GIÁ TRỊ GIA TĂNG)</p>
        <div id="invoice">
        	<span>Mã hoá đơn:</span>
            <span id="invoiceId"></span>
            <span id="invoiceDate"></span>
        </div>
        <div id="customer">
        	<fieldset>
            	<span class="key">Họ và tên khách hàng:</span>
                <span class="value" id="customerName"></span>
            </fieldset>
            <fieldset>
            	<span class="key">Số điện thoại di động:</span>
                <span class="value" id="customerPhone"></span>
            </fieldset>
            <fieldset>
            	<span class="key">Địa chỉ hiện tại:</span>
                <span class="value" id="customerAdd"></span>
            </fieldset>
        </div>
        <div id="items">
        	<div class="item">
            	<span class="stt">STT</span>
                <span class="product">Tên sản phẩm</span>
                <span class="number">Số lượng</span>
                <span class="price">Giá (VNĐ)</span>
                <span class="total">Thành giá (VNĐ)</span>
            </div>
        </div>
        <div id="footer">
        	<div id="left">
            	<h4>Người mua hàng</h4>
                <h6 style="font-weight:normal">(Kí và ghi rõ họ tên)</h6>
            </div>
            <div id="right">
            	<h4>Nhân viên bán hàng</h4>
                <h6 style="font-weight:normal">(Kí và ghi rõ họ tên)</h6>
                <h5 id="employee" style="margin-top:2cm"></h4>
            </div>
        </div>
    </div>
  </div>
</div>
</body>
</html>
