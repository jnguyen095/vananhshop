<!DOCTYPE html>
<html lang = "en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Tạo Đơn Hàng | Vân Anh Shop</title>
	<?php $this->load->view('common_header')?>
	<link rel="stylesheet" href="<?=base_url('/css/jquery.mCustomScrollbar.min.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
	<link rel="stylesheet" href="<?=base_url('/css/carousel-custom.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/magnific-popup.css')?>" />
	<script src="<?=base_url('/js/jquery.mCustomScrollbar.min.js')?>"></script>

</head>

<body>
<div class="container-fluid no-padding-left no-padding-right">
<?php $this->load->view('/theme/header')?>

<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb always">
	<div class="container">
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo base_url('/')?>"><span itemprop="name">Trang chủ</span></a></li>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active mobile-hide"><span itemprop="item"><span itemprop="name">Tạo đơn hàng</span></span></li>
	</div>
</ul>

<div class="container">
	<div class="row">
		<div class="col-lg-12 mobile-hide ">
			<div class="container-fluid text-center border-bottom">
				<div class="place-order-header">Tạo Đơn Hàng</div>
			</div>
		</div>

		<?php
		$attributes = array("id" => "frmShippingAddress", "class" => "form-horizontal");
		echo form_open("check-out", $attributes);
		?>
		<div class="col-lg-12">
			<div class="col-lg-5 col-sm-12">
				<div class="form-group">
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Người nhận hàng <span class="required">*</span></label>
						<input type="text" class="form-control" name="txt_receiver" value="<?=isset($txt_receiver) ? $txt_receiver : ''?>">
						<span class="text-danger"><?php echo form_error('txt_receiver'); ?></span>
					</div>
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Số điện thoại <span class="required">*</span></label>
						<input type="text" class="form-control" name="txt_phone" value="<?=isset($txt_phone) ? $txt_phone : ''?>">
						<span class="text-danger"><?php echo form_error('txt_phone'); ?></span>
					</div>
					<div class="clear-both"></div>
				</div>

				<div class="form-group">
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Thành phố <span class="required">*</span></label>
						<select id="txtCity" class="form-control" name="txt_city">
							<option>Chọn tỉnh/thành phố</option>
							<?php
							if($cities != null && count($cities) > 0){
								$str = '';
								foreach ($cities as $ct){
									?>
									<option value="<?=$ct->CityID?>" <?=(isset($txt_city) && $txt_city == $ct->CityID) ? ' selected' : ''?> ><?=$ct->CityName?></option>
									<?php
								}
							}
							?>
						</select>
						<span class="text-danger"><?php echo form_error('txt_city'); ?></span>
					</div>
					<div class="no-padding-mobile col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<label>Quận/huyện <span class="required">*</span></label>
						<select id="txtDistrict" class="form-control" name="txt_district">
							<option>Chọn quận/huyện</option>
							<?php
							if(isset($districts) && count($districts) > 0) {
								foreach ($districts as $dt) {
									?>
									<option
										value="<?= $dt->DistrictID ?>" <?= (isset($txt_district) && $txt_district == $dt->DistrictID) ? ' selected' : '' ?> ><?= $dt->DistrictName ?></option>
									<?php
								}
							}
							?>
						</select>
						<span class="text-danger"><?php echo form_error('txt_district'); ?></span>
					</div>
					<div class="clear-both"></div>
				</div>

				<div class="form-group">
					<div class="no-padding-mobile col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label>Số nhà/Căn hộ/Đường <span class="required">*</span></label>
						<input type="text" id="txt_street" name="txt_street" class="form-control typeahead" value="<?=isset($street) ? $street : ''?>">
						<span class="text-danger"><?php echo form_error('txt_street'); ?></span>
					</div>
					<div class="clear-both"></div>
				</div>

				<div class="form-group">
					<div class="no-padding-mobile col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label>Ghi chú cho đơn hàng:</label>
						<textarea name="note" value="COD" class="form-control" placeholder="ví dụ: giao hàng giờ hành chính" style="width: 100%;height: 45px;resize: none;"></textarea>
					</div>
					<div class="clear-both"></div>
				</div>

			</div>

			<div class="col-lg-7 col-sm-12">
				<div class="row row-promotion">
					<div class="col-xs-5">
						<h3>Mã khuyến mãi:</h3>
					</div>
					<div class="col-xs-7">
						<div class="form-group no-margin">
							<input type="text" name="proCode" class="form-control" placeholder="Nhập mã khuyến mãi" id="proCode" value="<?=isset($proCode) ? $proCode : ''?>">
							<small id="proCodeMessage" style="color: #999;">
								<?php
								if(isset($promotion)){
									if($promotion['valid'] == true){
										echo '<span style="color: white;">✓ '.$promotion['promotion']->Name . '</span>';
									}else{
										echo '<span style="color: red;">✗ '.$promotion['message']. '</span>';
									}
								}
								?>
							</small>
						</div>
					</div>
					<div class="clear-both"></div>
				</div>

				<div class="row">
					<table class="table table-bordered">
						<thead>
						<tr class="bg-info">
							<td class="text-center">Hình ảnh</td>
							<td class="text-left">Sản phẩm</td>
							<td class="text-left">SL</td>
							<td class="text-right">Đơn Giá</td>
							<td class="text-right">Tổng cộng</td>
						</tr>
						</thead>
						<tbody>
							<?php $this->load->view('/cart/Cart_detail_body')?>
						</tbody>
					</table>
				</div>

			</div>
		</div>

		<div class="col-lg-12 text-center margin-bottom-20 margin-top-20">
			<a class="btn btn-default" href="<?=base_url('/check-out.html')?>"><i class="glyphicon glyphicon-menu-left"></i> Tiếp tục mua hàng </a>
			<button class="btn btn-primary" type="submit"> <i class="glyphicon glyphicon-shopping-cart"></i> Tạo Đơn</button>
		</div>

		<input type="hidden" name="crudaction" value="insert" >
		<?php echo form_close(); ?>
	</div>
</div>

<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script src="<?=base_url('/js/jquery.magnific-popup.min.js')?>"></script>

</div>

<?php $this->load->view('/theme/footer')?>

<script type="text/javascript">
	$(document).ready(function() {
		loadDistrictByCityId();

		var cartTotal = <?=$this->cart->total()?>;
		var shippingFee = <?=$ShippingFee?>;
		var baseTotal = cartTotal + shippingFee;

		$('#proCode').on('blur', function() {
			var proCode = $.trim($(this).val());
			if (proCode.length > 0) {
				validatePromoCode(proCode, cartTotal, shippingFee);
			} else {
				resetPromotion();
			}
		});

		function validatePromoCode(proCode, cartTotal, shippingFee) {
			$.ajax({
				url: '<?=base_url("check-out/validate-promo-code")?>',
				type: 'POST',
				dataType: 'json',
				data: {
					proCode: proCode,
					cartTotal: cartTotal,
					shippingFee: shippingFee
				},
				success: function(response) {
					if (response.valid) {
						var discountAmount = response.discountAmount;
						var newTotal = baseTotal - discountAmount;

						$('#discountRow').show();
						$('#discountAmount').text(response.discountFormatted);
						$('#totalPrice').text(number_format(newTotal));
						$('#proCodeMessage').html('<span style="color: white;">✓ ' + response.promotionName + '</span>');
					} else {
						resetPromotion();
						$('#proCodeMessage').html('<span style="color: red;">✗ ' + response.message + '</span>');
					}
				},
				error: function() {
					resetPromotion();
					$('#proCodeMessage').html('<span style="color: red;">✗ Lỗi khi kiểm tra mã khuyến mãi</span>');
				}
			});
		}

		function resetPromotion() {
			$('#discountAmount').text('0');
			$('#totalPrice').text(number_format(baseTotal));
			$('#proCodeMessage').text('');
		}

		function number_format(number) {
			return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}
	});

	function loadDistrictByCityId(){
		$("#txtCity").change(function(){
			$(".overlay").show();
			var cityId = $(this).val();
			jQuery.ajax({
				type: "POST",
				url: urls.loadDistrictByCityId,
				dataType: 'json',
				data: {cityId: cityId},
				success: function(res){
					document.getElementById("txtDistrict").options.length = 1;
					for(key in res){
						$("#txtDistrict").append("<option value='"+res[key].DistrictID+"'>"+res[key].DistrictName+"</option>");
					}
					$(".overlay").hide();
				}
			});
		});
	}
</script>

</body>

</html>
