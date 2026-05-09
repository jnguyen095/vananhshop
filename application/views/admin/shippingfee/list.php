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
	<title>Quản Lý Phí Giao Hàng</title>
	<?php $this->load->view('/admin/common/header-js') ?>
	<link rel="stylesheet" href="<?=base_url('/theme/admin/css/bootstrap-datepicker.min.css')?>">
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
				Quản Lý Phí Giao Hàng
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Quản Lý Phí Giao Hàng</li>
			</ol>
		</section>

		<!-- Main content -->
		<?php
		$attributes = array("id" => "frmShippingFee");
		echo form_open("admin/shipping-fee/list", $attributes);
		?>
		<section class="content container-fluid">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Quản Lý Phí Giao Hàng</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="text-left categories">

						<table id="tbShippingFee" class="table table-bordered table-responsive">
							<thead>
								<tr>
									<td>Giá trị đơn hàng từ</td>
									<td>Giá trị đơn hàng đến</td>
									<td>Phí giao hàng</td>
									<td>&nbsp;</td>
								</tr>
							</thead>
							<tbody>

							<?php
							$index = 0;
							foreach ($fees as $fee){
								?>
								<tr>
									<td><input name="fees[<?=$index?>][from]" value="<?=$fee->OrderValueFrom?>" type="text" class="form-control"></td>
									<td><input name="fees[<?=$index?>][to]" value="<?=$fee->OrderValueTo?>" type="text" class="form-control"></td>
									<td><input name="fees[<?=$index?>][fee]" value="<?=$fee->ShippingFee?>" type="text" class="form-control"></td>
									<td class="text-right"><a href="javascript:void(0);" onclick="removeRow(this)" data-toggle="tooltip" title="Xóa dòng"><i class="fa fa-minus-circle"></i></a></td>
								</tr>
							<?php
								$index++;
							}
							?>

							<?php if(!isset($fees) || count($fees) < 1) {?>
							<tr>
								<td><input name="fees[0][from]" type="text" class="form-control"></td>
								<td><input name="fees[0][to]" type="text" class="form-control"></td>
								<td><input name="fees[0][fee]" type="text" class="form-control"></td>
								<td class="text-right"><a href="javascript:void(0);" onclick="removeRow(this)" data-toggle="tooltip" title="Xóa dòng"><i class="fa fa-minus-circle"></i></a></td>
							</tr>
							<?php }?>

							<tr class="text-right">
								<td colspan="4"><a href="javascript:void(0);" onclick="addRow()" data-toggle="tooltip" title="Thêm dòng"><i class="fa fa-plus-circle"></i></a> </td>
							</tr>
							</tbody>
						</table>
						<div class="row no-margin text-right">
							<a class="btn btn-primary" id="submitBtn">Lưu</a>
						</div>
					</div>
				</div>
			</div>

		</section>
		<!-- /.content -->
		<input type="hidden" id="crudaction" name="crudaction" value="insert-update">
		<?php echo form_close(); ?>

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

<script type="text/javascript">
	function addRow(){
	var index = $("#tbShippingFee tbody tr").length - 1;

	var html = '<tr>';
		html += '<td><input name="fees[' + index + '][from]" type="text" class="form-control"></td>';
			html += '<td><input name="fees[' + index + '][to]" type="text" class="form-control"></td>';
			html += '<td><input name="fees[' + index + '][fee]" type="text" class="form-control"></td>';
			html += '<td class="text-right"><a href="javascript:void(0);" onclick="removeRow(this)" data-toggle="tooltip" title="Xóa dòng"><i class="fa fa-minus-circle"></i></a></td>';
		html += '</tr>';
		$("#tbShippingFee tbody tr:last").before(html);
	}
	function removeRow(btn){
		var row = btn.parentNode.parentNode;
		row.parentNode.removeChild(row);
	}

	$(document).ready(function() {
		$("#submitBtn").click(function(){
			$("#frmShippingFee").submit();
		})	;
	});

</script>
</body>
</html>
