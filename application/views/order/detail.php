<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/9/2017
 * Time: 2:19 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
	<head>
		<meta charset = "utf-8">
		<title>Vân Anh Shop | Quản Lý Đơn Hàng</title>
		<?php $this->load->view('common_header')?>
		<script src="<?= base_url('/js/createpost.js') ?>"></script>
		<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
		<?php $this->load->view('/common/googleadsense')?>
</head>
</head>
<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid">
	<?php $this->load->view('/theme/header')?>


	<div class="container no-padding">
		<?php $this->load->view('/common/user-menu')?>

		<div class="row no-margin">
			<?php
			$attributes = array("id" => "frmOrder", "class" => "custom-input");
			echo form_open("don-hang-".$order->OrderID, $attributes);
			?>
			<div class="col-lg-12 col-sm-12">
				<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb always">
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo base_url('/quan-ly-don-hang.html')?>"><span itemprop="name">Đơn hàng</span></a></li>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active mobile-hide"><span itemprop="item"><span itemprop="name">Chi tiết đơn hàng <?=$order->Code?></span></span></li>
				</ul>

				<?php if(!empty($message_response)){
					echo '<div class="alert alert-success">';
					echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
					echo $message_response;
					echo '</div>';
				}?>

				<div class="card">
					<ul class="list-group list-group-flush">
						<li class="list-group-item text-center mobile-hide">
							<div class="progresses">
								<?php
								if($order->Status == ORDER_STATUS_CANCEL) {
									?>
									<div class="steps active">
										<span><i class="glyphicon glyphicon-ok"></i></span>
									</div>
									<span class="line active"><label class="label1">Chờ xác nhận</label></span>

									<div class="steps active">
										<span class="font-weight-bold"><i class="glyphicon glyphicon-ok"></i></span>
									</div>
									<span class="last-line active"><label class="label3">Đã hủy đơn</label></span>
									<?php
									} else {

									?>
									<div class="steps step <?=$order->Status == ORDER_STATUS_NEW ? 'in-progress' : 'active'?>">
										<span class="font-weight-bold"><?=$order->Status == ORDER_STATUS_NEW ? '1' : '<i class="glyphicon glyphicon-ok"></i>'?></span>
									</div>
									<span class="line <?=$order->Status == ORDER_STATUS_NEW ? '' : 'active'?>"><label class="label1">Chờ xác nhận đơn hàng</label></span>

									<div class="steps <?=$order->Status == ORDER_STATUS_SHIPPING ? 'in-progress' : ($order->Status == ORDER_STATUS_COMPLETED ? 'active' : '')?>">
										<span><?=($order->Status == ORDER_STATUS_NEW || $order->Status == ORDER_STATUS_SHIPPING) ? '2' : '<i class="glyphicon glyphicon-ok"></i>'?></span>
									</div>
									<span class="line <?=$order->Status == ORDER_STATUS_COMPLETED ? 'active' : ''?>"><label class="label2">Chờ giao hàng</label></span>

									<div class="steps <?=$order->Status == ORDER_STATUS_COMPLETED ? 'active' : ''?>">
										<span><?=$order->Status == ORDER_STATUS_COMPLETED ? '<i class="glyphicon glyphicon-ok"></i>' : '3'?></span>
									</div>
									<span class="last-line"><label class="label3">Hoàn thành</label></span>
									<?php
								}
								?>
							</div>
						</li>
						<li class="list-group-item no-padding">
							<div class="card-body  table-responsive">
								<table class="productDetailTable table no-margin">
									<thead class="thead-table">
									<tr class="bg-info">
										<th class="text-center">#</th>
										<th colspan="2">Sản phẩm</th>
										<th class="text-center">SL</th>
										<th class="text-center">Đơn giá</th>
										<th class="text-right">Thành tiền</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$counter = 1;
									foreach ($products as $item) {
										?>
										<tr>
											<td class="text-center"><?=$counter++?>.</td>
											<td class="text-left">
												<a href="<?=base_url().seo_url($item->ProductName).'-p'.$item->ProductID?>.html" target="_blank">
													<img src="<?=base_url($item->Thumb)?>" class="img-fluid width100px" alt="Phone">
												</a>
											</td>
											<td class="text-left">
												<a href="<?=base_url().seo_url($item->ProductName).'-p'.$item->ProductID?>.html" target="_blank">
													<?=$item->ProductName?>
												</a>
												<?php
												$ops = json_decode($item->Options);
												echo "<ul class='no-padding'>";
												foreach ($ops as $k=>$v){
													foreach ($v as $k1=>$v1){
														if(!empty($v1)){
															echo "<li><i>".$k1.": ".$v1."</i></li>";
														}
													}
												}
												echo "</ul>";
												?>
											</td>
											<td class="text-center"><?=number_format($item->Quantity)?></td>
											<td class="text-center"><?=number_format($item->Price)?></td>
											<td class="text-right"><?=number_format(($item->Price) * ($item->Quantity))?></td>
										</tr>
										<?php
									}
									?>
									<tr>
										<td class="text-right" colspan="5">Phí giao hàng:</td>
										<td class="text-right"><?=number_format($order->ShippingFee)?></td>
									</tr>
									<tr>
										<td class="text-right" colspan="5">Giảm giá:</td>
										<td class="text-right"><?=number_format($order->Discount)?></td>
									</tr>
									<tr>
										<td class="text-right" colspan="5">Tổng cộng:</td>
										<td class="text-right"><?=number_format($order->TotalPrice)?> (VNĐ)</td>
									</tr>
									<tr>
										<td class="text-right" colspan="5">Hình thức thanh toán:</td>
										<td class="text-right"><?=$order->Payment?></td>
									</tr>
									</tbody>
								</table>
							</div>
						</li>
					</ul>
				</div>

				<div class="card">
					<ul class="list-group list-group-flush">
						<li class="list-group-item no-padding">
							<div class="alert alert-info no-margin no-border-radius" role="alert">Thông tin người nhận hàng</div>
						</li>
						<li class="list-group-item">
							<form>
								<div class="form-group row">
									<label class="col-lg-2 col-sm-4 col-form-label">Người nhận hàng:</label>
									<div class="col-lg-10 col-sm-6"><?=$shippingAddr->Receiver?></div>
								</div>
								<div class="form-group row">
									<label for="inputPassword" class="col-sm-2 col-form-label">Số ĐT:</label>
									<div class="col-sm-10"><?=$shippingAddr->Phone?></div>
								</div>
								<div class="form-group row">
									<label for="inputPassword" class="col-sm-2 col-form-label">Địa chỉ:</label>
									<div class="col-sm-10"><?=$shippingAddr->Street?>, <?=$shippingAddr->DistrictName?>, <?=$shippingAddr->CityName?></div>
								</div>
								<div class="form-group row">
									<label for="inputPassword" class="col-sm-2 col-form-label">Ghi chú:</label>
									<div class="col-sm-10"><?=empty($order->Note) ? '-' : $order->Note?></div>
								</div>
							</form>
						</li>
					</ul>
				</div>

				<div class="row col-lg-12 margin-bottom-20 text-right">
					<a class="btn btn-primary" href="<?=base_url('quan-ly-don-hang.html')?>"><i class="glyphicon glyphicon glyphicon-chevron-left"></i> Trở lại</a>
					<?php
					if($order->Status == ORDER_STATUS_NEW){
						?>
						<a class="btn btn-danger" href="#" onclick="cancelOrder(<?=$order->OrderID?>)">Hủy đơn hàng</a>
						<?php
					}
					?>
				</div>

				<!-- end content -->
				<div class="clear-both"></div>

				<input type="hidden" id="crudaction" name="crudaction">
				<input type="hidden" id="orderId" name="orderId">
				<?php echo form_close(); ?>
			</div>
		</div>


	</div>

	<?php $this->load->view('/theme/footer')?>
</div>
<script type="text/javascript">

</script>

</body>
</html>
