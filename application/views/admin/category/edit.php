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
				Thêm/Chỉnh danh mục
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?=base_url('/admin/dashboard.html')?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li><a href="<?=base_url('/admin/category/list.html')?>">Quản lý danh mục</a></li>
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
					$attributes = array("id" => "frmAddCategory", "enctype" => "multipart/form-data", "class" => "form-horizontal");
					echo form_open("admin/category/add".(isset($CategoryID) ? "-".$CategoryID : ""), $attributes);
					?>
					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_parent" class="control-label">Danh mục cha </label>
							</div>
							<div class="col-lg-4 col-sm-8">
								<select name="txt_parent" class="form-control">
									<option value="">Chọn danh mục cha</option>
								<?php
									foreach ($categories as $category){
								?>
									<option value="<?=$category['CategoryID']?>" <?=(isset($txt_parent) && $txt_parent == $category['CategoryID']) ? "selected": ""?> ><?=$category['CatName']?></option>
										<?php
										if(count([$category['nodes']]) > 0){
											foreach ([$category['nodes']] as $subCats){
												foreach ($subCats as $subCat){
													?>
													<option class="category-level1" disabled value="<?=$subCat['CategoryID']?>">&nbsp;&nbsp;&nbsp;&nbsp;<?=$subCat['CatName']?></option>
													<?php
												}
												?>

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
								<label for="txt_catname" class="control-label">Tên danh mục <span class="required">*</span> </label>
							</div>
							<div class="col-lg-4 col-sm-8">
								<input class="form-control" id="txt_catname" name="txt_catname" placeholder="Tên danh mục" type="text" value="<?=isset($txt_catname) ? $txt_catname : ""?>" />
								<span class="text-danger"><?php echo form_error('txt_catname'); ?></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_catname" class="control-label">Thứ tự</label>
							</div>
							<div class="col-lg-1 col-sm-1">
								<input class="form-control" id="txt_index" name="txt_index" placeholder="Thứ tự" type="text" value="<?=isset($index) ? $index : ""?>" />
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Hình ảnh</label>
						</div>
						<div class="col-md-10">
							<input type="file" id="txt_image" name="txt_image">
							<span class="text-danger"><?php echo form_error('txt_image'); ?></span>
							<?php
							if(isset($txt_image) && strlen($txt_image) > 0){
								?>
								<img style="max-height: 200px" src="<?=base_url('/img/category/'.$txt_image)?>"/>
								<?php
							}
							?>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Banner</label>
						</div>
						<div class="col-md-10">
							<input type="file" id="txt_banner" name="txt_banner">
							<span class="text-danger"><?php echo form_error('txt_banner'); ?></span>
							<?php
							if(isset($txt_banner) && strlen($txt_banner) > 0){
								?>
								<img style="max-height: 200px" src="<?=base_url('/img/category/'.$txt_banner)?>"/>
								<?php
							}
							?>
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
							<a class="btn btn-danger" href="<?=base_url("/admin/category/list.html")?>">Trở lại</a>
						</div>
					</div>
					<input type="hidden" name="staffID" value="<?=isset($staffID) ? $staffID : ''?>">
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
