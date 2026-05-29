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
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active mobile-hide"><span itemprop="item"><span itemprop="name">Địa chỉ giao hàng</span></span></li>
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

					<div class="steps in-progress">
						<span class="font-weight-bold">2</span>
					</div>

					<span class="line"><label class="label2">Địa chỉ giao hàng</label></span>

					<div class="steps">
						<span >3</span>
					</div>
					<span class="last-line"><label class="label3">Hoàn thành</label></span>

				</div>

			</div>
		</div>

		<?php
		$attributes = array("id" => "frmShippingAddress", "class" => "form-horizontal");
		echo form_open("check-out/address", $attributes);
		?>
		<div class="col-lg-12">
			<div class="col-lg-7">
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
						<label>Đường/Số nhà/Căn hộ <span class="required">*</span></label>
						<input type="text" id="txt_street" name="txt_street" class="form-control typeahead" value="<?=isset($street) ? $street : ''?>">
						<span class="text-danger"><?php echo form_error('txt_street'); ?></span>
					</div>
					<div class="clear-both"></div>
				</div>

			</div>

			<div class="col-lg-5">
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
					<tr>
						<td colspan="2">Tổng cộng</td>
						<td class="text-right"><?=number_format($this->cart->total() + $ShippingFee)?>(VNĐ)</td>
					</tr>

					</tbody>
				</table>
			</div>
		</div>

		<div class="col-lg-12 text-right margin-bottom-20">
			<a class="btn btn-info" href="<?=base_url('/check-out.html')?>"><i class="glyphicon glyphicon-menu-left"></i> Trở Lại  </a>
			<button class="btn btn-primary" type="submit">Tiếp Theo <i class="glyphicon glyphicon-menu-right"></i> </button>
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
