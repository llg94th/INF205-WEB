var numOfAll=0,numOfToday=0,numOfThisM=0,numOfThisW=0,numOfThisY=0;
// lay danh sach hoa don
function loadListInvoice(result){
	result.forEach(loadInvoice);
	$('#all-invoice').html(numOfAll);
	$('#thisY').html(numOfThisY);
	$('#thisM').html(numOfThisM);
	$('#thisW').html(numOfThisW);
	$('#thisD').html(numOfToday);
}
function loadInvoice(invoice,i){
	addInvoiceToList(invoice,$('#list-invoice-a'));
	numOfAll++;
	var currentDate = new Date();
	var date = new Date(parseFloat(invoice.date));
	if(date.getFullYear()==currentDate.getFullYear()){
		addInvoiceToList(invoice,$('#list-invoice-y'));
		numOfThisY++;
	}
	if(date.getFullYear()==currentDate.getFullYear()&&date.getMonth()==currentDate.getMonth()){
		addInvoiceToList(invoice,$('#list-invoice-m'));
		numOfThisM++;
	}
	if(date.getFullYear()==currentDate.getFullYear()&&date.getMonth()==currentDate.getMonth()&&date.getDay()>=1&&Math.abs(date.getDate()-currentDate.getDate())<7){
		addInvoiceToList(invoice,$('#list-invoice-w'));
		numOfThisW++;
	}
	if(date.getFullYear()==currentDate.getFullYear()&&date.getMonth()==currentDate.getMonth()&&date.getDay()==currentDate.getDay()){
		addInvoiceToList(invoice,$('#list-invoice-d'));
		numOfToday++;
	}
}
//them moi 1 hoa don
function addInvoiceToList(invoice,taget){
	var itemString ='';
	invoice.items.forEach(function(itemp,i){
		itemString +=itemp.product_id+'(x'+itemp.number+'), ';
	});
	itemString = itemString.substring(0, itemString.length - 2);
	var date = new Date(parseFloat(invoice.date));
	var html = '<a href="invoice-template.php?id='+invoice.id+'" class="list-group-item">'+
		  '<span class="badge">'+date.toLocaleDateString()+'</span>'+
		  ' <span class="badge">'+invoice.name+'</span>'+
		  '<h4 class="list-group-item-heading">Mã khách hàng: '+invoice.customers_id+' -  Mã hoá đơn: '+invoice.id+'</h4>'+
		  '<h5 class="list-group-item-text">Sản phẩm: '+itemString+'</h5>'+
		'</a>';
	taget.append(html);
}
//tim kiem
function msearch(){
	$('#search-result').empty();
	var firstChild = '<li class="list-group-item active">'+
		  '<h4 class="list-group-item-heading">Hoá đơn bán hàng - Tìm kiếm</h4>'+
		'</li>';
	$('#search-result').append(firstChild);
	var option = parseInt($('#searchOption').val());
	var query = $('#searchQ').val();
	if(option==1){
		objs.result.forEach(function(iv,i){
			if(iv.customers_id.search(query)>=0){
				addInvoiceToList(iv,$('#search-result'));
			}
		});
	}else if (option==2){
		objs.result.forEach(function(iv,i){
			if(iv.id.search(query)>=0){
				addInvoiceToList(iv,$('#search-result'));
			}
		});
	}
}
// lay danh sach san pham
function loadListProducts(){
	$.getJSON('get-list-product.php',function(data,e){
		console.log(data.result);
		if(data.success==1){
			$('#list-product-l').empty();
			var result = data.result;
			for (i = 0; i < result.length; i++) { 
				loadProduct(data.result[i],i);
			}
		}
	});
}
function loadProduct(product,i){
	var content = '<li class="list-group-item"> <span style="background:#FFF" class="badge">'
            +'<button onClick="showDialogDelete(\''+product.id+'\')" type="button" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span>&nbsp; Xoá</button>'
            +'<button onClick="showDialogEdit(\''+product.id+'\',\''+product.product_name+'\',\''+product.price+'\',\''+product.category_id+'\')" type="button" data-toggle="modal" data-target="#modalEdit" class="btn  btn-sm btn-success"><span class="glyphicon glyphicon-edit"></span>&nbsp; Sửa</button>'
            +'</span>'
            +'<h4 class="list-group-item-heading">'+product.id+' - '+product.product_name+'</h4>'
            +'<h5 class="list-group-item-text">Giá: '+product.price+' VNĐ</h5>'
         +'</li>';
		 
	$('#list-product-l').append(content);
}

function showDialogDelete(id){
	$('#dlDelContent').html('Xoá sản phẩm: '+id+'?');
	console.log('Xoá sản phẩm: '+id+'?');
	$('#myModal').modal();
	$('#btnDelProduct').click(function(e) {
        deleteProduct(id);
    });
}
function deleteProduct(id){
	$.getJSON('delete-product-by-id.php?id='+id,function(data,e){
		if(data.success==1){
			modalAleart('Xoá thành công');
			loadListProducts();
		}else{
			modalAleart('Có lỗi xảy ra! \n'+e);
		}
	});
	
}
function showDialogEdit(id,name,price,categoty_id){
	$('#product-id').attr('placeholder',id);
	$('#product-name').val(name);
	$('#product-price').val(price);
	$('#product-category').val(categoty_id);
}
function updateProduct(){
	var id = $('#product-id').attr('placeholder');
	var name = $('#product-name').val();
	var price = $('#product-price').val();
	var category = $('#product-category').val();
	console.log('update-product.php?id='+id+'&name='+name+'&price='+price+'&category='+category);
	$.getJSON('update-product.php?id='+id+'&name='+name+'&price='+price+'&category='+category,function(data,e){
		if(data.success==1){
			modalAleart('Chỉnh sửa được lưu thành công');
			loadListProducts();
		}else{
			modalAleart('Có lỗi xảy ra! \n'+e);
		}
	});
}

function saveProduct(){
	var name = $('#product-name-a').val();
	var price = $('#product-price-a').val();
	var category = $('#product-category-a').val();
	if(name.trim()==""||price.trim()==""){
		modalAleart('Bạn đã bỏ qua gì đó ^_^');
	}else{
		$.getJSON('add-product.php?name='+name+'&price='+price+'&category='+category,function(data,e){
			if(data.success==1){
				modalAleart('Thêm thành công sản phẩm: '+name);
				loadListProducts();
			}else{
				modalAleart('Có lỗi xảy ra! </br>'+e);
				console.log(data);
			}
		});
	}
}
function clearForm(){
	$('#product-name-a').val('');
	$('#product-price-a').val('');
	$('#product-category-a').val(1);
}

function modalAleart(msg){
	$('#aleartContent').html(msg)
	$('#modalAleart').modal();
}

function loadListProductCategory(){
	$.getJSON('get-list-product-category.php',function(data,e){
		$('#product-category-a').empty();
		$('#product-category').empty();
		if(data.success==1){
			var list = data.result;
			for (i=0 ; i<list.length ; i++){
				var html = '<option value="'+list[i].id+'">'+list[i].name+'</option>';
				$('#product-category-a').append(html);
				$('#product-category').append(html);
			}
		}
	});
}