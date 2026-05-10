<!DOCTYPE html>
<html lang = "en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="audience" content="general" />
	<meta name="resource-type" content="document" />
	<meta name="abstract" content="Hạt giống hoa, cây trồng, dụng cụ làm vườn" />
	<meta name="classification" content="Hạt giống hoa, cây trồng, dụng cụ làm vườn" />
	<meta name="area" content="Hạt giống hoa, cây trồng, dụng cụ làm vườn" />
	<meta name="placename" content="Việt Nam" />
	<meta name="author" content="lamvuonvui.com" />
	<meta name="copyright" content="©2025 lamvuonvui.com" />
	<meta name="owner" content="lamvuonvui.com" />
	<meta name="distribution" content="Global" />
	<meta name="description" content="Báo giá sản phẩm">
	<meta name="keywords" content="<?=keyword_maker('Báo giá sản phẩm')?>">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="follow" />
	<title>Báo giá sản phẩm</title>
	<?php $this->load->view('common_header')?>
	<?php $this->load->view('/common/googleadsense')?>
	<?php $this->load->view('/common/facebook-pixel-tracking')?>
</head>

<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid no-padding-left no-padding-right">

	<?php $this->load->view('/theme/header')?>
		<ul class="breadcrumb">
			<div class="container">
				<li><a href="<?=base_url().'trang-chu.html'?>">Trang Chủ</a></li>
				<li class="active">Báo Giá Sỉ</li>
			</div>
		</ul>

	<div class="container">
		<div class="row no-margin">
			<div class="search-result col-md-9 no-margin no-padding">

			</div>
			<?php
			$attributes = array("id" => "quoteForm", "class" => "custom-input");
			echo form_open("bao-gia-si", $attributes);
			?>

			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>

			<?php if(!empty($error_response)){
				echo '<div class="alert alert-danger">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $error_response;
				echo '</div>';
			}?>

			<div class="col-md-8 no-margin no-padding">
				<div class="search-result-panel col-md-12">Báo Giá Sỉ</div>
				<div class="product-panel col-md-5 no-padding-left margin-bottom-20">
					<select id="cmCatId" class="form-control" name="CatId">
						<option value="-1">Tất cả danh mục</option>
						<?php
						if($categories != null && count($categories) > 0){
							foreach ($categories as $c){
								?>
								<option value="<?=$c['CategoryID']?>" <?=((isset($cmCatId) && $cmCatId == $c['CategoryID']) ? ' selected="selected"' : '')?> ><?=$c['CatName']?></option>
								<?php
								if(count($c['nodes']) > 0){
									foreach ($c['nodes'] as $k){
										?>
										<option value="<?=$k['CategoryID']?>" <?=((isset($cmCatId) && $cmCatId == $k['CategoryID']) ? ' selected="selected"' : '')?> >&nbsp;&nbsp;&nbsp;&nbsp;<?=$k['CatName']?></option>
										<?php
									}
								}
							}
						}
						?>
					</select>
				</div>
				<div class="product-panel col-md-7 no-padding margin-bottom-20">
					<input type="text" class="form-control typeahead" id="staticSearch" placeholder="Nhập mã sản phẩm hoặc tên">
				</div>
				<div class="product-panel col-md-12  no-margin no-padding">
					<table id="tbProducts" class="table table-responsive table-bordered">
						<thead>
						<tr class="bg-info">
							<td class="col-sm-1">#</td>
							<td class="col-sm-2"></td>
							<td>Sản phẩm</td>
							<td class="col-sm-2">Số lượng</td>
						</tr>
						</thead>
						<tbody>
						<?php
						if(isset($products) && count($products) > 0){
							$counter = 1;
							foreach ($products as $product){
								?>
								<tr id="tr-<?=$product['ProductID']?>" class="prodItem">
									<td><?=$counter++?></td>
									<td><img class="img-sm" src="<?=base_url($product['Thumb'])?>"></td>
									<td><?=$product['Title']?></td>
									<td><input id="qty-<?=$product['ProductID']?>" name="products[<?=$product['ProductID']?>]qty" type="number" value="<?=$product['Quantity']?>" class="form-control"/></td>
								</tr>
								<?php
							}
						} else {
							?>
							<tr id="toberemove" class="text-center">
								<td colspan="4"><i>Hãy tìm sản phẩm để thêm vào danh sách yêu cầu!</i></td>
							</tr>
							<?php
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-4 no-margin-right no-padding-right no-padding-left-mobile">
				<div class="search-panel block-panel">
					<div class="block-header">Thông Tin Người Mua Hàng</div>

					<div class="block-body">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label text-left">Họ Tên <span class="required">*</span></label>
							<div class="col-sm-8">
								<input id="txtName" class="form-control" type="text" placeholder="Tên người mua hàng" name="name" value="<?php echo set_value('name'); ?>"/>
								<span class="text-danger text-left"><?php echo form_error('name'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="text-left col-sm-4 col-form-label">Số ĐT/Zalo <span class="required">*</span></label>
							<div class="col-sm-8">
								<input id="txtPhone" class="form-control" type="text" placeholder="Số điện thoại" name="phone" value="<?php echo set_value('phone'); ?>"/>
								<span class="text-danger text-left"><?php echo form_error('phone'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="text-left col-sm-4 col-form-label">Email <span class="required">*</span></label>
							<div class="col-sm-8">
								<input id="txtEmail" class="form-control" type="text" placeholder="Email nhận báo giá" name="email" value="<?php echo set_value('email'); ?>"/>
								<span class="text-danger text-left"><?php echo form_error('email'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-sm-4 text-left col-form-label">Địa chỉ</label>
							<div class="col-sm-8">
								<input id="txtAddress" class="form-control" type="text" placeholder="Address" name="address" value="<?php echo set_value('address'); ?>"/>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-text-input" class="col-sm-4 text-left col-form-label">Ghi chú</label>
							<div class="col-sm-8">
								<input id="txtNote" class="form-control" type="text" placeholder="Ghi chú" name="note" value="<?php echo set_value('note'); ?>"/>
							</div>
						</div>

						<div class="form-group row">
							<label for="example-text-input" class="col-sm-4 text-left col-form-label"></label>
							<div class="col-sm-8 text-left">
								<a id="btnQuote" class="btn btn-tindatdai btn-sm"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Yêu Cầu Báo Giá</a>
							</div>
						</div>
					</div>

				</div>
			</div>
			<input type="hidden" name="crudaction" value="request-quotation">
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<?php $this->load->view('/theme/footer')?>
<script src="<?=base_url('/js/typeahead.bundle.min.js')?>"></script>
<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
<script type="text/javascript">

	function autocompleteProductNameHandle(){
		$('.typeahead').typeahead({
			hint: true,
			highlight: true,
			minLength: 2
		}, {
			name: 'ProductID',
			async: true,
			displayKey: 'Title',
			source: function (query, process) {
				return $.get('<?=base_url("Ajax_controller/findProductByCodeOrTitle")?>', {query: query, categoryId: $("#cmCatId").val()}, function (data) {
					if (data != null && data.length > 0) {
						var json = $.parseJSON(data);
						return process(json);
					}

				});

			}
		});
	}

	function autocompletValueSelected(){
		$('.typeahead').on('typeahead:selected', function(evt, item) {
			// do what you want with the item here
			if($("#toberemove").length > 0){
				$("#toberemove").remove();
			}
			// console.log(item);
			$(this).val('');
			var productId = item['ProductID'];
			if($("#tr-" + productId).length < 1){
				var index = $("#tbProducts tr").length;
				var html = '<tr id="tr-' + productId + '" class="prodItem">';
				html += '<td>' + index + '</td>';
				html += '<td><img class="img-sm" src="<?=base_url()?>' + item['Thumb'] + '"/></td>';
				html += '<td>'+item['Title']+'</td>';
				html += '<td><input id="qty-'+productId+'" name="products['+productId+']qty" type="number" value="10" class="form-control"/></td>';
				html += '</tr>';
				$("#tbProducts tbody").append(html);
			} else {
				$("#qty-" + productId).val(parseInt($("#qty-" + productId).val() == '' ? 0 : $("#qty-" + productId).val()) + 1);
			}

		})
	}

	function handleSubmitForm(){
		$("#btnQuote").click(function(){
			$("#quoteForm").submit();
		});
	}

	$(document).ready(function(){
		autocompleteProductNameHandle();
		autocompletValueSelected();
		handleSubmitForm();
	});
</script>

</body>
</html>
