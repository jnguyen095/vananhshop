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
	<title>Quản lý Khu Vực Bán Hàng</title>
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
				Thêm/Chỉnh Khu Vực Bán Hàng
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?=base_url('/admin/dashboard.html')?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li><a href="<?=base_url('/admin/area/list.html')?>">Quản Lý Khu Vực Bán Hàng</a></li>
				<li class="active">Thêm/Chỉnh sửa</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content container-fluid">
			<?php if(!empty($error_message)){
				echo '<div class="alert alert-danger">';
				echo $error_message;
				echo '</div>';
			}?>
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<?php
					$attributes = array("id" => "frmAddArea", "class" => "form-horizontal");
					echo form_open("admin/area/add".(isset($AreaID) ? "-".$AreaID : ""), $attributes);
					?>
					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_parent" class="control-label">Khu vực cha </label>
							</div>
							<div class="col-lg-4 col-sm-8">
								<select name="txt_parent" class="form-control">
									<option value="">Chọn khu vực cha</option>
								<?php
									foreach ($areas as $area){
								?>
									<option value="<?=$area->AreaID?>" <?=(isset($txt_parent) && $txt_parent == $area->AreaID) ? "selected": ""?> ><?=$area->AreaName?></option>
										<?php
										if(count($child[$area->AreaID]) > 0){
											foreach ($child[$area->AreaID] as $k){?>
												<option class="category-level1" disabled value="<?=$k->AreaID?>">&nbsp;&nbsp;&nbsp;&nbsp;<?=$k->AreaName?></option>
												<?php
											}
										}
										?>
								<?php
									}
								?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_areaname" class="control-label">Tên khu vực <span class="required">*</span> </label>
							</div>
							<div class="col-lg-4 col-sm-8">
								<input class="form-control" id="txt_areaname" name="txt_areaname" placeholder="Tên khu vực" type="text" value="<?=isset($txt_areaname) ? $txt_areaname : ""?>" />
								<span class="text-danger"><?php echo form_error('txt_areaname'); ?></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_active" class="control-label">Hoạt động</label>
							</div>
							<div class="col-lg-8 col-sm-8">
								<input type="checkbox" name="ch_status" value="1" <?=(!isset($ch_status) || $ch_status == 1) ? "checked" : "" ?> class="form-control minimal">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-8 col-sm-8 col-lg-offset-2 text-left">
							<input type="hidden" name="crudaction" value="register"/>
							<input id="btn_login" name="btn_login" type="submit" class="btn btn-primary" value="Lưu" />
							<a class="btn btn-danger" href="<?=base_url("/admin/area/list.html")?>">Trở lại</a>
						</div>
					</div>
					<input type="hidden" name="crudaction" value="insert" >
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

<script src="<?=base_url('/ckeditor/ckeditor.js')?>"></script>

<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
<script>
	$(function () {
		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
	});
</script>

</body>
</html>
