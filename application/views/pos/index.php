<!DOCTYPE html>
<html lang = "en">

<head>
	<meta charset = "utf-8">
	<title>Point of Sales</title>
	<?php $this->load->view('common_header')?>
	<link rel="stylesheet" href="<?=base_url('/theme/pos/css/pos.css')?>">
</head>

<body class="news">
<div class="container-fluid no-padding">

<?php $this->load->view('/pos/header')?>

<div class="row no-margin pos">

	<div class="col-md-12 no-margin no-padding">
		<ul id="tabId" class="nav nav-tabs">
			<li class="active">
				<a class="mytab" data-toggle="tab" id="tab-1" href="#order1">Order 1</a>
				<a onclick="removeTab('tab-1')" class="glyphicon glyphicon-remove removeTab no-padding no-margin"></a>
			</li>
			<a id="addTab" title="Thêm đơn" data-toggle="tooltip" href="#"><i class="glyphicon glyphicon-plus"></i></a>
		</ul>


		<div id="tabContent" class="tab-content">
			<div id="tab-1-content" class="tab-pane fade in active">
				
			</div>
			
		</div>
	</div>
</div>


<?php $this->load->view('/pos/footer')?>
</div>

<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
<div class="overlay" style="display: none"><img src="<?=base_url('/img/spinner.gif')?>"/></div>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		initialTabsEvent();
		loadTabContent('tab-1');
		initialAddNewTab();
	});

	function addProduct2Cart(productId, tabID){

	}

	function initialAddNewTab(){
		$("#addTab").click(function(){
			addNewTab();
		});
	}

	function initialCatCollapseExpend(tabID){
		$("#cat-" + tabID).unbind('click');
		$("#cat-" + tabID).click(function(e){
			$this = $(e);
			$elm = $('#cat-' + tabID + ' i');
			if($(".pos-navbar-nav").is(":visible")){
				$elm.removeClass("glyphicon-menu-up");
				$elm.addClass("glyphicon-menu-down");
				$("#navbar-" + tabID).hide();
			}else{
				$elm.removeClass("glyphicon-menu-down");
				$elm.addClass("glyphicon-menu-up");
				$("#navbar-" + tabID).show();
				
			}
		});
	}

	function initialTabsEvent(){
		$("#tabId > li > a.mytab").unbind('click');
		$("#tabId > li > a.mytab").click(function(){
			$id = $(this).attr("id");
			selectedTab($id);
		});
	}	

	function addNewTab(){
		$(".overlay").show();	
		$tabs = $("#tabId li");
		var newID = $tabs.length + 1;
		for(var i = 1; i < newID; i++){
			if($("#tab-"+i).length == 0){
				// missing tab
				newID = i;
				break;
			}
		}
		$('<li><a class="mytab" data-toggle="tab" id="tab-'+ newID +'" href="#menu'+ newID +'">Order '+ newID +'</a><a onclick="removeTab(\'tab-' + newID + '\')" class="glyphicon glyphicon-remove removeTab no-padding no-margin"></a></li>').insertBefore($("#addTab"));
		$("#tabContent").append('<div id="tab-'+ newID +'-content" class="tab-pane fade"><h3>Menu '+newID+'</h3><p>Some content in menu '+newID+'.</p></div>');
		loadTabContent('tab-'+newID);
		initialTabsEvent();
	}

	function loadTabContent(tabID){
		$.ajax({
			type:'POST',
			url: '<?=base_url()?>POS_controller/loadTabContent',
			data: {'tabID': tabID},
			success:function(msg) {
				$("#" + tabID + '-content').html(msg);
				initialCatCollapseExpend(tabID);
				initialSearchCustomer(tabID);
				$(".overlay").hide();
			}
		});
	}

	function initialSearchCustomer(tabID){
		$("#addcustomer-" + tabID).click(function(){
			var $modal = $('#modalCustomerDialog-' + tabID);
			$.ajax({
				type: "POST",
				url: '<?=base_url()?>POS_controller/getCustomerList',
				data: {'tabID': tabID, 'keyword': ''},
			}).done(function (data) {
				$modal.html(data);
				$modal.modal('show');
			});
		});
	}

	function selectCustomer(customerId, tabID){
		$.ajax({
			type: "POST",
			url: '<?=base_url()?>POS_controller/getCustomerById',
			data: {'tabID': tabID, 'userId': customerId},
		}).done(function (data) {
			$("#customer-" + tabID).html(data);
			updateTabName(customerId, tabID);
			$('#modalCustomerDialog-' + tabID).modal('hide');
		});
	}

	function updateTabName(customerId, tabID){
		$.ajax({
			type: "POST",
			url: '<?=base_url()?>POS_controller/getCustomerNameById',
			data: {'tabID': tabID, 'userId': customerId},
		}).done(function (data) {
			$("#" + tabID).html(data);
		});
	}

	function loadProduct(catId, tabID){
		$(".overlay").show();
		$.ajax({
			type:'POST',
			url: '<?=base_url()?>POS_controller/loadProductByCatId',
			data: {'catId': catId, 'tabID': tabID},
			success:function(msg) {
				$("#product-" + tabID).html(msg);
				if(catId != undefined && catId > 0){
					loadCategoryFilter(catId, tabID);	
				} else {
					$(".overlay").hide();
				}
				
			}
		});
	}

	function loadCategoryFilter(catId, tabID){
		$.ajax({
			type:'POST',
			url: '<?=base_url()?>POS_controller/getCategoryById',
			data: {'catId': catId},
			success:function(data) {
				var json = $.parseJSON(data);
				$(".cat-filter-" + tabID).remove();
				$("#cat-" + tabID).after('<a class="btn-filter cat-filter-' + tabID + '" href="#" onclick="removeCatFillter(\'' + tabID + '\')">' + json.CatName + ' <i class="glyphicon glyphicon-remove"></i></a>');
				$(".overlay").hide();
			}
		});
	}

	function removeCatFillter(tabID){
		loadProduct(-1, tabID);
		$(".cat-filter-" + tabID).remove();
	}

	function removeTab(tabID){
		
		bootbox.confirm("Bạn có chắc chắn xóa đơn hàng: <b>" + $("#" + tabID).text() + "</b>?", function(r){
			if(r){
				// Remove Tab content
				$("#"+ tabID + "-content").remove();
				// Remove Tab header
				$("#" + tabID).parent().remove();
			}
		});
	}

	function selectedTab(tabId){
		$(".nav-tabs li").removeClass("active");
		$(this).parent().addClass("active");
		$(".tab-content .tab-pane").removeClass("active");
		$(".tab-content .tab-pane").removeClass("in");
		$("#" + tabId + "-content").addClass("active");
		$("#" + tabId + "-content").addClass("in");
	}

	function add2Cart(productId, tabID){
		$(".overlay").show();
		$.ajax({
			type:'POST',
			url: '<?=base_url()?>POS_controller/getProductById',
			data: {'productId': productId},
			success:function(data) {
				var json = $.parseJSON(data);
				// console.log(json);
				$("." + tabID + "-emptyrow").parent().remove();
				if($("#" + json.ProductID  + "-" + tabID).length < 1){
					var html = '<tr>';
						html += '<td scope="row">'+ ($("#cart-" + tabID + " tr").length) +'</td>';
						html += '<td>' + json.Title + '</td>';
						html += '<td id="' + json.ProductID + '-' + tabID + '">1</td>';
						html += '<td>' + json.Price + '</td>';
						html += '<td class="text-center"><a href="#" onclick="removePrd(' + json.ProductID + ', \''+ tabID + '\')"><i class="glyphicon glyphicon-remove"></i></a></td>';
						html += '</tr>';

						$("#cart-" + tabID + " tbody").append(html);
				}else{
					$("#" + json.ProductID  + "-" + tabID).text(parseInt($("#" + json.ProductID  + "-" + tabID).text()) + 1);
				}
				$(".overlay").hide();
			}
		});
	}

	function removePrd(productId, tabID){
		$("#" + productId + "-" + tabID).parent().remove();
		if($("#cart-" + tabID + " tbody tr").length < 1){
			var html = '<tr>';
			html += '<td colspan="5" class="text-warning text-center ' + tabID + '-emptyrow">Chưa có sản phẩm nào</td>';
			html += '</tr>';
			$("#cart-" + tabID + " tbody").append(html);
		}
	}
</script>
</html>
