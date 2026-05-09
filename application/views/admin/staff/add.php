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
	<title>Vân Anh Shop | Quản lý nhân viên</title>
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
				Thêm/Chỉnh sửa nhân viên
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?=base_url('/admin/dashboard.html')?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li><a href="<?=base_url('/admin/staff/list.html')?>">Quản lý nhân viên</a></li>
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
					$attributes = array("id" => "frmAddStaff", "class" => "form-horizontal");
					echo form_open("admin/staff/add".(isset($staffId) ? "-".$staffId : ""), $attributes);
					?>
					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_fullname" class="control-label">Nhóm người dùng <span class="required">*</span> </label>
							</div>
							<div class="col-lg-8 col-sm-8">
								<select name="txt_userGroupID" class="form-control">
									<option value="">Chọn nhóm người dùng</option>
									<?php
									foreach ($userGroups as $userGroup){
										?>
										<option value="<?=$userGroup->UserGroupID?>" <?=(isset($txt_userGroupID) && $txt_userGroupID == $userGroup->UserGroupID) ? "selected": ""?> ><?=$userGroup->GroupName?></option>
										<?php
									}
									?>
								</select>
								<span class="text-danger"><?php echo form_error('txt_userGroupID'); ?></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_fullname" class="control-label">Họ tên <span class="required">*</span> </label>
							</div>
							<div class="col-lg-8 col-sm-8">
								<input class="form-control" id="txt_fullname" name="txt_fullname" placeholder="Họ tên" type="text" value="<?=(isset($txt_fullname) ? $txt_fullname : "")?>" />
								<span class="text-danger"><?php echo form_error('txt_fullname'); ?></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_username" class="control-label">Tên đăng nhập <span class="required">*</span> </label>
							</div>
							<div class="col-lg-8 col-sm-8">
								<input class="form-control" id="txt_phone" name="txt_phone" placeholder="Tên đăng nhập" type="text" value="<?=(isset($txt_phone) ? $txt_phone : "")?>" />
								<span class="text-danger"><?php echo form_error('txt_phone'); ?></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_password" class="control-label">Mật khẩu <span class="required">*</span></label>
							</div>
							<div class="col-lg-8 col-sm-8">
								<input class="form-control" id="txt_password" name="txt_password" placeholder="******" type="password" value="<?php echo set_value('txt_password'); ?>" />
								<span class="text-danger"><?php echo form_error('txt_password'); ?></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_email" class="control-label">Email</label>
							</div>
							<div class="col-lg-8 col-sm-8">
								<input class="form-control" id="txt_email" name="txt_email" placeholder="Email" type="text" value="<?=(isset($txt_email) ? $txt_email : "")?>" />
								<span class="text-danger"><?php echo form_error('txt_email'); ?></span>
							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_address" class="control-label">Hoạt động</label>
							</div>
							<div class="col-lg-8 col-sm-8">
								<input type="checkbox" name="ch_status" value="1" <?=(isset($ch_status) && $ch_status == 1) ? "checked" : "" ?> class="form-control minimal">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-8 col-sm-8 col-lg-offset-2 text-left">
							<input type="hidden" name="crudaction" value="register"/>
							<input id="btn_login" name="btn_login" type="submit" class="btn btn-info" value="Lưu" />
							<a class="btn btn-danger" href="<?=base_url('/admin/staff/list.html')?>">Cancel</a>
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
			radioClass   : 'iradio_minimal-blue'
		})
	})
</script>
</body>
</html>
