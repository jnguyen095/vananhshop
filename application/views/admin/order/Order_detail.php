<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/3/2017
 * Time: 9:33 AM
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cập nhật đơn hàng</title>
	<?php $this->load->view('/admin/common/header-js') ?>
	<link rel="stylesheet" href="<?=base_url('/theme/admin/css/bootstrap-datepicker.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('/theme/admin/css/madmin.css')?>">

	<style type="text/css">
		span.twitter-typeahead{
			width: 100%
		}
	</style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

	<!-- Main Header -->
	<?php $this->load->view('/admin/common/admin-header')?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php $this->load->view('/admin/common/left-menu') ?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Cập nhật đơn hàng
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li><a href="<?=base_url("/admin/order/process-{$order->OrderID}")?>"> Xử lý đơn hàng</a></li>
				<li class="active">Cập nhật đơn hàng</li>
			</ol>
		</section>

		<!-- Main content -->
		<?php
		$attributes = array("id" => "frmOrder");
		echo form_open("admin/order/process-".$order->OrderID, $attributes);
		?>
		<section class="content container-fluid">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>
			<div class="box">
				<div class="box-header card-header mobile-hide">
					<div class="row no-margin">
						<div class="container-fluid text-center border-bottom ">
							<div class="progresses">
								<div class="steps step <?=$order->Status == ORDER_STATUS_NEW ? 'in-progress' : 'active'?>">
									<span><?=$order->Status == ORDER_STATUS_NEW ? '1' : '<i class="glyphicon glyphicon-ok"></i>'?></span>
								</div>
								<span class="line <?=$order->Status == ORDER_STATUS_NEW ? '' : 'active'?>" ><label class="label1">Tiếp nhận đơn hàng</label></span>

								<div class="steps <?=$order->Status == ORDER_STATUS_SHIPPING ? 'in-progress' : ($order->Status == ORDER_STATUS_COMPLETED ? 'active' : '')?>">
									<span class="font-weight-bold"><?=($order->Status == ORDER_STATUS_NEW || $order->Status == ORDER_STATUS_SHIPPING) ? '2' : '<i class="glyphicon glyphicon-ok"></i>'?></span>
								</div>
								<span class="line <?=$order->Status == ORDER_STATUS_COMPLETED ? 'active' : ''?>"><label class="label2">Đang giao hàng</label></span>

								<div class="steps <?=$order->Status == ORDER_STATUS_COMPLETED ? 'active' : ''?>">
									<span><?=$order->Status == ORDER_STATUS_COMPLETED ? '<i class="glyphicon glyphicon-ok"></i>' : '3'?></span>
								</div>
								<span class="last-line"><label class="label3">Hoàn thành</label></span>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<!-- Right column -->
					<div class="col-lg-9 col-sm-12">
						<div class="col-lg-6 col-sm-12">
							<div class="card m-b-30 card-body bg-success">
								<h4 class="card-title font-20 mt-0">Thông tin đơn hàng</h4>
								<div class="form-group row">
									<div class="col-sm-4 card-text">Mã đơn hàng:</div>
									<div class="col-sm-8"><?=$order->Code?></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-4 card-text">Tình trạng:</div>
									<div class="col-sm-8">
										<?php
										if($order->Status == ORDER_STATUS_NEW){
											echo '<lable class="label label-success">Đơn mới</lable>';
										} else if($order->Status == ORDER_STATUS_CANCEL){
											echo '<lable class="label label-danger">Đã hủy</lable>';
										} else if($order->Status == ORDER_STATUS_CONFIRM){
											echo '<lable class="label label-info">Chờ giao hàng</lable>';
										} else if($order->Status == ORDER_STATUS_SHIPPING){
											echo '<lable class="label label-warning">Đang giao hàng</lable>';
										} else if($order->Status == ORDER_STATUS_COMPLETED){
											echo '<lable class="label label-default">Hoàn thành</lable>';
										}
										?>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-4 card-text">Ngày mua:</div>
									<div class="col-sm-8"><?=date('d/m/Y H:i', strtotime($order->CreatedDate))?></div>
								</div>

								<div class="form-group row">
									<div class="col-sm-4 card-text">Ghi chú:</div>
									<div class="col-sm-8"><?=empty($order->Note) ? 'Không' : $order->Note?></div>
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-sm-12">
							<div class="card m-b-30 card-body bg-success">
								<h4 class="card-title font-20 mt-0">Thông tin người nhận hàng</h4>
								<div class="form-group row">
									<div class="col-sm-4 card-text">Tên người nhận:</div>
									<div class="col-sm-8"><?=$shippingAddr->Receiver?></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-4 card-text">Số điện thoại:</div>
									<div class="col-sm-8"><i class="fa fa-phone"></i>&nbsp;<?=$shippingAddr->Phone?></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-4 card-text">Địa chỉ nhận hạng:</div>
									<div class="col-sm-8"><?=$shippingAddr->Street?>, <?=$shippingAddr->DistrictName?>, <?=$shippingAddr->CityName?></div>
								</div>
								<div class="form-group row">
									<div class="col-sm-4 card-text">Phương thức TT:</div>
									<div class="col-sm-8"><?=$order->Payment?></div>
								</div>

								<a id="updateReceiver" href="#" class="btn btn-primary waves-effect waves-light"><i class="fa fa-edit"></i> Cập nhật địa chỉ nhận hàng</a>
							</div>
						</div>

						<div class="col-lg-12 col-sm-12">
							<div class="row">
								<div class="col-xs-12">
									<h4 class="card-title"><b>Mặt hàng:</b></h4>
								</div>
								<div class="col-xs-12">
									<table class="table table-bordered">
										<thead>
										<tr class="bg-primary">
											<td class="text-left">#</td>
											<td class="text-left">Mặt hàng</td>
											<td class="text-left">Số lượng</td>
											<td class="text-left">Đơn giá</td>
											<td class="text-left">Thành tiền</td>
											<td class="text-left">Lựa chọn</td>
										</tr>
										</thead>
										<tbody>
										<?php $index=0; foreach ($products as $item){
											?>
											<tr>
												<td class="text-right"><?=++$index?></td>
												<td class="text-left"><a href="<?=base_url().seo_url($item->ProductName).'-p'.$item->ProductID?>.html" target="_blank"><?=$item->ProductName?></a></td>
												<td class="text-center"><?=$item->Quantity?></td>
												<td class="text-right"><?=number_format($item->Price)?></td>
												<td class="text-right"><?=number_format($item->Price * $item->Quantity)?></td>
												<td class="text-left">
													<div>
													<u>
													<?php
														$ops = json_decode($item->Options);
														foreach ($ops as $k=>$v){
															foreach ($v as $k1=>$v1){
																if(!empty($v1)){
																	echo "<li style=\"margin-left: 10px\">".$k1.": ".$v1."</li>";
																}
															}
														}
													 ?>
													</u>
													</div>
													<div class="clear-both"></div>
												</td>
											</tr>
											<?php
										} ?>
										<tr>
											<td colspan="4" class="text-right">Phí giao hàng</td>
											<td class="text-right"><?=number_format($order->ShippingFee)?></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="4" class="text-right">Giảm giá</td>
											<td class="text-right"><?=number_format($order->Discount)?></td>
											<td><i class="label label-info"><?=$order->PromotionName?></i></td>
										</tr>
										<tr>
											<td colspan="4" class="text-right">Tổng cộng</td>
											<td class="text-right"><b><?=number_format($order->TotalPrice)?> VNĐ</b></td>
											<td></td>
										</tr>
										</tbody>
									</table>
								</div>

							</div>

						</div>

						<div class="col-lg-12">
							<div class="row no-margin top-buttons">
								<a class="btn btn-warning" id="addBack" href="<?=base_url("/admin/order/list.html")?>">Trở lại</a>&nbsp;
								<?php
								if($order->Status == ORDER_STATUS_NEW){
									?>
									<a class="btn btn-info" id="changeOrderItems">Thay đổi ĐH</a>
									<a class="btn btn-primary" data-new_action="<?=ORDER_STATUS_CONFIRM?>" id="changeStatus">Tiếp nhận ĐH</a>
									<?php
								} else if($order->Status == ORDER_STATUS_CONFIRM){
									?>
									<a class="btn btn-info" data-new_action="<?=ORDER_STATUS_SHIPPING?>" id="changeStatus">Đang giao hàng</a>
									<?php
								} else if($order->Status == ORDER_STATUS_SHIPPING){
									?>
									<a class="btn btn-success" data-new_action="<?=ORDER_STATUS_COMPLETED?>" id="changeStatus">Hoàn thành</a>
									<?php
								}
								?>

							</div>
						</div>

					</div>

					<!-- Left column -->
					<div class="col-lg-3 col-sm-12 order-history">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Lịch sử giao dịch</h6>
								<div id="content">
									<ul class="timeline">
										<?php foreach ($trackings as $tracking) {
											?>
											<li class="event">
												<h3><?=date('d/m/Y H:i', strtotime($tracking->CreatedDate))?></h3>
												<p><?=$tracking->Message?></p>
											</li>
											<?php
										}?>
									</ul>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

		</section>
		<!-- /.content -->
		<input type="hidden" id="crudaction" name="crudaction">
		<?php echo form_close(); ?>

		<!-- popups -->
		<!-- Modal -->
		<form id="modalForm" role="form">
			<div class="modal fade" id="modalOrderFormDialog" role="dialog">

			</div>
		</form>

	</div>
	<!-- /.content-wrapper -->

	<!-- Main Footer -->
	<?php $this->load->view('/admin/common/admin-footer')?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="<?=base_url('/theme/admin/js/jquery.min.js')?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('/theme/admin/js/bootstrap.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('/theme/admin/js/adminlte.min.js')?>"></script>
<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/tindatdai_admin.js')?>"></script>
<script src="<?=base_url('/js/typeahead.bundle.min.js')?>"></script>
<script type="text/javascript">
	function contactFormHandler(){
		$("#updateReceiver").click(function(){
			$.ajax({
				type:'POST',
				url: '<?=base_url("admin/OrderManagement_controller/updateShippingInfo")?>',
				data: {'orderId': <?=$order->OrderID?>},
				success:function(msg) {
					$("#modalOrderFormDialog").html(msg);
					var $modal = $('#modalOrderFormDialog');
					$modal.modal('show');
				}
			});
		});
	}

	function updateOrderItemsHandler(){
		$("#changeOrderItems").click(function(){
			$.ajax({
				type:'POST',
				url: '<?=base_url("admin/OrderManagement_controller/update")?>',
				data: {'orderId': <?=$order->OrderID?>},
				success:function(msg) {
					$("#modalOrderFormDialog").html(msg);
					var $modal = $('#modalOrderFormDialog');
					$modal.modal('show');
				}
			});
		});
	}

	function updateStatusHandler(){
		$('#changeStatus').click(function(){
			var nextAction = $(this).data('new_action');
			bootbox.confirm("Bạn đã chắc chắn thay đổi tình trạng đơn hàng?", function(result){
				if(result){
					$("#crudaction").val(nextAction);
					$("#frmOrder").submit();
				}
			});
		});
	}



	$(document).ready(function(){
		contactFormHandler();
		updateStatusHandler();
		updateOrderItemsHandler();
	});
</script>
</body>
</html>
