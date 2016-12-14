<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Quản lý hoá đơn bán hàng</title>
<link href="css/mainindex.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script type="text/javascript">
<?php
	echo "var jsonInvoices = '";
	include('get-list-invoices.php');
	echo "';";
?>
	$.getJSON('get-list-product.php',function(data,e){
	});
	var objs = $.parseJSON(jsonInvoices);
	$(document).ready(function(e) {
		if(objs.success==1){
			loadListInvoice(objs.result);
		}else{
			alert('Có lỗi xảy ra');
		}
		loadListProducts();
		loadListProductCategory();
	});
</script>
</head>

<body>
<div class="modal fade" id="modalAleart" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="background:#999999">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><strong>Thông báo</strong></h4>
      </div>
      <div class="modal-body">
        <p id="aleartContent"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Xoá sản phẩm</h4>
      </div>
      <div class="modal-body">
        <p id="dlDelContent"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        <button id="btnDelProduct" type="button" class="btn btn-danger" data-dismiss="modal">Xoá</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalEdit" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sửa sản phẩm</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">Tên sản phẩm</span>
          <input id="product-name" type="text" class="form-control input-lg" placeholder="Tên sản phẩm">
        </div>
        <div class="input-group" style="margin-top:10px">
          <span class="input-group-addon">Giá sản phẩm</span>
          <input id="product-price" type="number" class="form-control input-lg" placeholder="Giá sản phẩm">
          <span class="input-group-addon">Mã sản phẩm</span>
          <input id="product-id" type="number" class="form-control input-lg" placeholder="SP0001" disabled >
        </div>
        <div class="input-group" style="margin-top:10px">
          <span class="input-group-addon">Loại sản phẩm</span>
          <select id="product-category" class="form-control input-lg">
            <option value="0">Chưa phân loại</option>
            <option value="1">Apple</option>
            <option value="2">Samsung</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        <button onClick="updateProduct()" id="btnEditProduct" type="button" class="btn btn-success" data-dismiss="modal">Lưu</button>
      </div>
    </div>
  </div>
</div>
<header class="container-fluid navbar navbar-fixed-top" >
  <h2>Quản lý hoá đơn bán hàng</h2>
</header>
<div class="container-fluid" id="content">
  <div class="row content">
    <div class="col-sm-3 sidenav" id="sidenav">
      <div id="employee">
        <h3>Nguyễn Tuấn Hùng</h3>
        <h5>Nhân viên kế toán</h5>
      </div>
      <ul class="list-group">
        <li  class="list-group-item" style="text-decoration:none;font-size:16px;color:#000;font-weight:bold;background:#FF0">Quản lý hoá đơn</li>
        <li class="list-group-item active"><a style="text-decoration:none;font-size:16px;color:#000;font-weight:" data-toggle="tab" href="#list-invoice-a" >Tất cả hoá đơn</a><span id="all-invoice" class="badge">100</span></li>
        <li class="list-group-item"><a style="text-decoration:none;font-size:16px;color:#000;font-weight:" data-toggle="tab" href="#list-invoice-y">Năm này</a><span id="thisY" class="badge">10</span></li>
        <li class="list-group-item"><a style="text-decoration:none;font-size:16px;color:#000;font-weight:" data-toggle="tab" href="#list-invoice-m">Tháng này</a><span id="thisM" class="badge">10</span></li>
        <li class="list-group-item"><a style="text-decoration:none;font-size:16px;color:#000;font-weight:" data-toggle="tab" href="#list-invoice-w">Tuần này</a><span id="thisW" class="badge">10</span></li>
        <li class="list-group-item"><a style="text-decoration:none;font-size:16px;color:#000;font-weight:" data-toggle="tab" href="#list-invoice-d">Hôm nay</a><span id="thisD" class="badge">10</span></li>
        <li class="list-group-item"><a style="text-decoration:none;font-size:16px;color:#000;font-weight:" data-toggle="tab" href="#list-invoice-s">Tìm kiếm</a></li>
        <li  class="list-group-item" style="text-decoration:none;font-size:16px;color:#000;font-weight:bold;background:#FF0">Quản lý sản phẩm</li>
        <li class="list-group-item"><a href="#list-product-l" style="text-decoration:none;font-size:16px;color:#000;font-weight:" data-toggle="tab">Danh sách Sản phẩm</a></li>
        <li class="list-group-item"><a href="#list-product-a" style="text-decoration:none;font-size:16px;color:#000;font-weight:" data-toggle="tab">Thêm sản phẩm</a></li>
      </ul>
    </div>
    <div class="col-sm-9" style="overflow:scroll;height:84vh">
      <div class="tab-content">
        <div id="list-invoice-a" class="list-group tab-pane flash in active" style="margin-top:10px;">
          <li class="list-group-item active">
            <h4 class="list-group-item-heading">Hoá đơn bán hàng - Tất cả</h4>
          </li>
        </div>
        <div id="list-invoice-y" class="list-group tab-pane flash" style="margin-top:10px;">
          <li class="list-group-item active">
            <h4 class="list-group-item-heading">Hoá đơn bán hàng - Năm này</h4>
          </li>
        </div>
        <div id="list-invoice-m" class="list-group tab-pane flash" style="margin-top:10px;">
          <li class="list-group-item active">
            <h4 class="list-group-item-heading">Hoá đơn bán hàng - Tháng này</h4>
          </li>
        </div>
        <div id="list-invoice-w" class="list-group tab-pane flash" style="margin-top:10px;">
          <li class="list-group-item active">
            <h4 class="list-group-item-heading">Hoá đơn bán hàng - Tuần này</h4>
          </li>
        </div>
        <div id="list-invoice-d" class="list-group tab-pane flash" style="margin-top:10px;">
          <li class="list-group-item active">
            <h4 class="list-group-item-heading">Hoá đơn bán hàng - Hôm nay</h4>
          </li>
        </div>
        
        <div id="list-invoice-s" class="tab-pane flash" style="margin-top:10px;">
          <div class="form-group" style="margin-bottom:50px">
            <div class="container">
              <div class="col-xs-4">
                <select class="form-control input-lg" id="searchOption" name="searchOption">
                  <option value="1">Mã khách hàng</option>
                  <option value="2">Mã hoá đơn</option>
                </select>
              </div>
              <div class="col-xs-4">
                <input type="search" class="form-control input-lg" id="searchQ" name="searchQ" placeholder="Nhập từ khoá"/>
              </div>
              <div class="col-xs-3">
                <button type="submit" onClick="msearch()" class="btn btn-default btn-lg"> <span class="glyphicon glyphicon-search"></span> Tìm kiếm </button>
              </div>
            </div>
          </div>
          <div id="search-result" class="list-group">
            <li class="list-group-item active">
              <h4 class="list-group-item-heading">Hoá đơn bán hàng - Tìm kiếm</h4>
            </li>
          </div>
        </div>
        
        <div id="list-product-l" class="list-group tab-pane flash" style="margin-top:10px;">
          <li class="list-group-item"> <span style="background:#FFF" class="badge">
            <button onClick="showDialogDelete('SP0001')" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span>&nbsp; Xoá</button>
            <button onClick="" type="button" data-toggle="modal" data-target="#modalEdit" class="btn  btn-sm btn-success"><span class="glyphicon glyphicon-edit"></span>&nbsp; Sửa</button>
            </span>
            <h4 class="list-group-item-heading">Apple - iPhone 7 Black</h4>
            <h5 class="list-group-item-text">Giá: 100000000</h5>
          </li>
        </div>
        <div id="list-product-a" class="list-group tab-pane flash" style="margin-top:10px;">
        	<div class="input-group">
              <span class="input-group-addon">Tên sản phẩm</span>
              <input id="product-name-a" type="text" class="form-control input-lg" placeholder="Tên sản phẩm" required>
            </div>
            <div class="input-group" style="margin-top:10px">
              <span class="input-group-addon">Giá sản phẩm</span>
              <input id="product-price-a" type="number" class="form-control input-lg" placeholder="Giá sản phẩm" required>
              <span class="input-group-addon">Mã sản phẩm</span>
              <input id="product-id" type="text" class="form-control input-lg" placeholder="Tự động" disabled>
            </div>
            <div class="input-group" style="margin-top:10px">
              <span class="input-group-addon">Loại sản phẩm</span>
              <select id="product-category-a" class="form-control input-lg">
              	<option value="0">Chưa phân loại</option>
                <option value="1">Apple</option>
                <option value="2">Samsung</option>
              </select>
            </div>
            <div align="center" style="margin-top:10px">
            	<button onClick="clearForm()" type="reset" class="btn btn-info"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp; Nhập lại</button>
                <button onClick="saveProduct()" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span>&nbsp; Lưu lại</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<footer class="container-fluid navbar navbar-fixed-bottom"> <span>Demo của Go Pink Color Team </span> </footer>
</body>
</html>