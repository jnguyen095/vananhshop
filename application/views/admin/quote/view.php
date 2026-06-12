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
	<title>Vân Anh Shop | Xem báo giá</title>
	<?php $this->load->view('/admin/common/header-js') ?>
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
	<link rel="stylesheet" href="<?=base_url('/theme/admin/css/madmin.css')?>">
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
				Xem báo giá
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?=base_url('/admin/dashboard.html')?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li><a href="<?=base_url('/admin/quote/list.html')?>">Báo giá</a></li>
				<li class="active">Xem báo giá</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content container-fluid">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>

			<?php if(!empty($error_message)){
				echo '<div class="alert alert-danger">';
				echo $error_message;
				echo '</div>';
			}?>
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<?php
					$attributes = array("id" => "frmQuotation", "class" => "form-horizontal");
					echo form_open("admin/quote/view-".$quotationId, $attributes);
					?>
					<div class="row">
						<div class="col-lg-8">
							<div class="card">
								<div class="card-body">
									<h6 class="card-title">Đơn hàng cần báo giá:</h6>
									<div id="content" class="table-responsive">
										<table class="table">
											<thead>
											<tr>
												<th>#</th>
												<th scope="col" class="col-lg-1">Mã hàng</th>
												<th scope="col">Sản phẩm</th>
												<th scope="col" class="col-lg-1">Giá tham chiếu</th>
												<th scope="col" class="col-lg-2">Giá báo</th>
												<th scope="col" class="col-lg-1">SL</th>
												<th scope="col" class="col-lg-1">Thành tiền</th>
												<th scope="col" class="col-lg-2">Ghi chú</th>
											</tr>
											</thead>
											<tbody>
											<?php
											$counter = 1;
											$totalPrice = 0;
											foreach ($details as $item){
												$totalPrice += ($item->Quantity * $item->ReferencePrice);
												?>
												<tr>
													<td><?=$counter++?></td>
													<td><?=$item->ProductCode?></td>
													<td><?=$item->ProductName?></td>
													<td><?=number_format($item->ReferencePrice)?></td>
													<td><input class="form-control" type="number" name="quotes[<?=$item->QuotationDetailID?>][OfferPrice]" value="<?=$item->OfferPrice?>"></td>
													<td><input type="hidden" name="quotes[<?=$item->QuotationDetailID?>][Quantity]" value="<?=$item->Quantity?>"/><?=$item->Quantity?></td>
													<td> <?=number_format($item->Quantity * $item->OfferPrice)?></td>
													<td><input class="form-control" name="quotes[<?=$item->QuotationDetailID?>][Note]" value="<?=$item->Note?>" type="text"></td>
												</tr>
											<?php
											}
											?>
											<tr>
												<td colspan="6" class="text-right">Giá vận chuyển</td>
												<td colspan="2"><input type="text" name="ShippingFee" value="<?=$quote->ShippingFee?>" class="form-control"></td>
											</tr>
											<tr>
												<td colspan="6" class="text-right">Giảm giá</td>
												<td colspan="2"><input type="text" value="<?=$quote->Discount?>" name="Discount" class="form-control"></td>
											</tr>
											<tr>
												<td colspan="6" class="text-right">Tổng cộng</td>
												<td colspan="2"><b><?=number_format($quote->TotalPrice)?> VNĐ</b></td>
											</tr>
											<tr>
												<td colspan="6" class="text-right">Báo giá hiệu lực đến ngày <span class="required">*</span></td>
												<td colspan="2">
													<input type="text" id="txt_validate" name="valid_date" data-fromdate="" value="<?=isset($quote->ValidDate) ? date('d/m/Y',strtotime($quote->ValidDate)) : ''?>" class="form-control valid_date">
													<span class="text-danger"><?php echo form_error('valid_date'); ?></span>
												</td>
											</tr>
											</tbody>
										</table>
									</div>

									<div class="row no-margin text-right">
										<a class="btn btn-default" href="<?=base_url('/admin/quote/list.html')?>">Trở lại</a>&nbsp;
										<a class="btn btn-info" href="javascript:void(0);" id="btnUpdate">Tính & Cập nhật</a>&nbsp;
										<?php
										if($quote->Status == QUOTE_STATUS_UPDATE) {
											?>
											<a class="btn btn-warning" href="javascript:void(0);" id="btnApproved">Gửi
												khách</a>
											<?php
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="card bg-info">
								<div class="card-body">
									<h6 class="card-title">Thông tin người yêu cầu</h6>
									<div id="content">
										<div class="form-group row">
											<div class="col-xs-4 card-text">Mã báo giá</div>
											<div class="col-xs-8"><?=$quote->Code?></div>
										</div>
										<div class="form-group row">
											<div class="col-xs-4 card-text">Ngày gửi</div>
											<div class="col-xs-8"><?=date('d/m/Y H:i', strtotime($quote->RequestedDate))?></div>
										</div>
										<div class="form-group row">
											<div class="col-xs-4 card-text">Tên người gửi</div>
											<div class="col-xs-8"><?=$quote->Name?></div>
										</div>
										<div class="form-group row">
											<div class="col-xs-4 card-text">Số điện thoại </div>
											<div class="col-xs-8"><i class="fa fa-phone"></i>&nbsp;<?=$quote->Phone?></div>
										</div>
										<div class="form-group row">
											<div class="col-xs-4 card-text">Email</div>
											<div class="col-xs-8"><i class="fa fa-mail-bulk"></i>&nbsp;<?=$quote->Email?></div>
										</div>
										<div class="form-group row">
											<div class="col-xs-4 card-text">Địa chỉ</div>
											<div class="col-xs-8"><?=$quote->Address?></div>
										</div>
										<div class="form-group row">
											<div class="col-xs-4 card-text">Ghi chú yêu cầu</div>
											<div class="col-xs-8"><?=$quote->Note?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" id="crudaction" name="crudaction" value="update">
					<?php echo form_close(); ?>
				</div>
			</div>

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- Main Footer -->
	<?php $this->load->view('/admin/common/admin-footer')?>

	<!-- /.control-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>


</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="<?=base_url('/theme/admin/js/jquery.min.js')?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('/theme/admin/js/bootstrap.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('/theme/admin/js/adminlte.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/adminlte.min.js')?>"></script>
<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/bootstrap-datepicker.min.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#btnUpdate").click(function(){
			$("#frmQuotation").submit();
		});
		$("#btnApproved").click(function(){
			$("#crudaction").val('approved');
			$("#frmQuotation").submit();
		});
		$('.valid_date').datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true,
			startDate: '<?=date("d/m/Y")?>'
		});
	});
</script>

</body>
</html>
