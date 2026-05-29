<!DOCTYPE html>
<html lang = "en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Giỏ Hàng | Vân Anh Shop</title>
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
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="mobile-hide"><span itemprop="item"><span itemprop="name"><a itemprop="item" href="<?=base_url('/check-out.html')?>">Giỏ hàng</a></span></span></li>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="mobile-hide"><span itemprop="item"><span itemprop="name"><a itemprop="item" href="<?=base_url('/check-out/address.html')?>">Địa chỉ giao hàng</a></span></span></li>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active mobile-hide"><span itemprop="item"><span itemprop="name">Đặt hàng</span></span></li>
	</div>
</ul>

<div class="container">
	<div class="row">
		<div class="col-lg-12 mobile-hide ">
			<div class="container-fluid text-center border-bottom">
				<div class="progresses">
					<div class="steps active">
						<span><i class="glyphicon glyphicon-ok"></i></span>
					</div>

					<span class="line active"><label class="label1">Xem đơn hàng</label></span>

					<div class="steps active">
						<span class="font-weight-bold"><i class="glyphicon glyphicon-ok"></i></span>
					</div>

					<span class="line active"><label class="label2">Địa chỉ giao hàng</label></span>

					<div class="steps in-progress">
						<span >3</span>
					</div>
					<span class="last-line"><label class="label3">Hoàn thành</label></span>

				</div>

			</div>
		</div>

		<?php
		$attributes = array("id" => "frmShippingAddress", "class" => "form-horizontal");
		echo form_open("check-out/review", $attributes);
		?>
		<div class="col-lg-12">

			<div class="col-lg-7">
				<table class="table table-bordered">
					<thead>
					<tr class="bg-success">
						<td class="text-left">Sản phẩm</td>
						<td class="text-left">SL</td>
						<td class="text-right">Tổng cộng</td>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($this->cart->contents() as $item){?>
						<tr>
							<td class="text-left">
								<a href="<?=base_url().seo_url($item['name']).'-p'.$item['id']?>.html"><?=$item['name']?></a>
								<?php if($this->cart->has_options($item['rowid']) == TRUE){
									echo "<br>";
									foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
										$i = 1;
										foreach ($option_value as $k => $v){ ?>
											<i><small><?=$v?></small></i>
											<?=$i == 1 ? ':' : ''?>
											<?php
											$i++;
										}
										echo "</br>";
									}
								}?>

							</td>
							<td class="text-center">
								<?=$item['qty']?>
							</td>
							<td class="text-right" colspan="2"><?=number_format($item['price'] * $item['qty'])?></td>

						</tr>
					<?php } ?>
					<tr>
						<td colspan="2">Phí giao hàng</td>
						<td class="text-right"><?=number_format($ShippingFee)?></td>
					</tr>
					<tr id="discountRow" style="display: none;">
						<td colspan="2">Giảm giá</td>
						<td class="text-right" id="discountAmount">0</td>
					</tr>
					<tr>
						<td colspan="2"><strong>Tổng cộng</strong></td>
						<td class="text-right"><strong id="totalPrice"><?=number_format($this->cart->total() + $ShippingFee)?></strong>(VNĐ)</td>
					</tr>

					</tbody>
				</table>
			</div>

			<div class="col-lg-5">
				<div class="row">
					<div class="col-xs-12">
						<h3><b>Thông tin người nhận hàng:</b></h3>
					</div>
					<div class="col-xs-12">
						Người nhận hàng: <label><?=$txt_receiver?></label>
					</div>
					<div class="col-xs-12">
						Số điện thoại: <label><?=$txt_phone?></label>
					</div>
					<div class="col-xs-12">
						Địa chỉ giao hàng: <label><?=$street?>, <?=$district->DistrictName?>, <?=$city->CityName?></label>
					</div>
					<div class="clear-both"></div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3>Thanh toán:</h3>
					</div>
					<div class="col-xs-12">
						<label><input type="radio" name="payment" value="COD" checked> Lúc nhận hàng </label>
					</div>
					<div class="col-xs-12">
						<label><input type="radio" name="payment" value="BANK_TRANSFER"> Chuyển khoản </label>
					</div>
					<div class="clear-both"></div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3>Mã khuyến mãi:</h3>
					</div>
					<div class="col-xs-12">
						<div class="form-group no-margin">
							<input type="text" name="proCode" class="form-control" placeholder="Nhập mã khuyến mãi" id="proCode">
							<small id="proCodeMessage" style="color: #999;"></small>
						</div>
					</div>
					<div class="clear-both"></div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h3>Ghi chú cho đơn hàng:</h3>
					</div>
					<div class="col-xs-12">
						<div class="form-group no-margin">
							<textarea name="note" value="COD" placeholder="ví dụ: giao hàng giờ hành chính" style="width: 100%;height: 40px;resize: none;border: solid 1px #ccc"></textarea>
							<small id="proCodeMessage" style="color: #999;"></small>
						</div>
					</div>
					<div class="clear-both"></div>
				</div>

				<div class="row margin-bottom-20">
					<div class="col-xs-12">
						<a class="btn btn-info" href="<?=base_url('/check-out/address.html')?>"><i class="glyphicon glyphicon-menu-left"></i> Trở Lại  </a>
						<button class="btn btn-warning" type="submit">Tạo Đơn</button>
					</div>
				</div>
			</div>


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
						$('#proCodeMessage').html('<span style="color: green;">✓ ' + response.message + '</span>');
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
			$('#discountRow').hide();
			$('#discountAmount').text('0');
			$('#totalPrice').text(number_format(baseTotal));
			$('#proCodeMessage').text('');
		}

		function number_format(number) {
			return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}
	});

</script>

</body>

</html>
