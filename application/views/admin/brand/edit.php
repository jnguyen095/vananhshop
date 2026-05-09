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
	<title>Vân Anh Shop | Quản lý nhà cung cấp</title>
	<?php $this->load->view('/admin/common/header-js') ?>
	<script src="<?= base_url('/ckeditor/ckeditor.js') ?>"></script>
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
				Quản lý nhà cung cấp
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Thêm nhà cung cấp</li>
			</ol>
		</section>

		<!-- Main content -->
		<?php
		$attributes = array("id" => "frmBrand", "enctype" => "multipart/form-data", "class" => "form-horizontal");
		echo form_open("admin/brand/edit".(isset($brand->BrandID) ? "-".$brand->BrandID : ""), $attributes);
		?>
		<section class="content container-fluid">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>
			<?php if(!empty($error_message)){
				echo '<div class="alert alert-danger">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $error_message;
				echo '</div>';
			}?>
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Thêm nhà cung cấp</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">

					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_catname" class="control-label">Tên nhà cung cấp <span class="required">*</span> </label>
							</div>
							<div class="col-lg-4 col-sm-8">
								<input class="form-control" id="txt_catname" name="BrandName" placeholder="Tên nhà cung cấp" type="text" value="<?=isset($brand->BrandName) ? $brand->BrandName : '' ?>" />
								<span class="text-danger"><?php echo form_error('BrandName'); ?></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Thông tin chi tiết</label>
						</div>
						<div class="col-md-6">
							<textarea name="Description" id="description" rows="50" class="form-control"><?=isset($brand->Description) ? $brand->Description : ''?></textarea>
							<span class="text-danger"><?php echo form_error('Description'); ?></span>
							<script>
								CKEDITOR.replace('description',{
									toolbar: [
										{ name: 'document', items: [ 'Source', '-', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
										[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
										{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
										{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
										{ name: 'styles', items: [ 'Styles', 'Format' ] }
									]
								});
							</script>
						</div>
					</div>

					<div class="form-group">
						<div class="row colbox no-margin">
							<div class="col-lg-2 col-sm-4">
								<label for="txt_catname" class="control-label">Hình ảnh</label>
							</div>
							<div class="col-lg-4 col-sm-8">
								<input type="file" id="txt_image" name="txt_image">
								<span class="text-danger"><?php echo form_error('Thumb'); ?></span>
								<?php
								if(isset($brand->Thumb) && strlen($brand->Thumb) > 0){
									?>
									<img style="max-height: 200px" src="<?=base_url('/img/brand/'.$brand->Thumb)?>"/>
									<?php
								}
								?>
							</div>
						</div>
					</div>

					<div class="row ">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<a class="btn btn-default" href="<?=base_url('/admin/brand/list')?>">Trở lại</a>
							<button type="submit" class="btn btn-primary" href="<?=base_url('/admin/brand/list')?>">Lưu</button>
						</div>
					</div>
				</div>
			</div>


		</section>
		<!-- /.content -->
		<input type="hidden" name="BrandID" value="<?=isset($brand->BrandID)? $brand->BrandID : '' ?>">
		<input type="hidden" id="crudaction" name="crudaction" value="insert">
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

</body>
</html>
