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
	<title>Vân Anh Shop | Chỉnh sửa bài đăng</title>
	<?php $this->load->view('/admin/common/header-js') ?>
	<link rel="stylesheet" href="<?=base_url('/theme/admin/css/bootstrap-datepicker.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
	<script src="<?= base_url('/ckeditor/ckeditor.js') ?>"></script>
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
				Chỉnh sửa sản phẩm</b>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li><a href="<?=base_url('/admin/product/list.html')?>">Quản lý sản phẩm</a></li>
				<li class="active">Chỉnh sửa sản phẩm</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content container-fluid">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-danger">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<?php
					$attributes = array("id" => "frmAddProduct", "enctype" => "multipart/form-data", "class" => "form-horizontal");
					echo form_open("admin/product/edit".((isset($product->ProductID) && $product->ProductID > 0) ? "-".$product->ProductID : ""), $attributes);
					?>
					<div class="form-group">
						<div class="col-md-2">
							<label>Mã sản phẩm <span class="required">*</span></label>
						</div>
						<div class="col-md-2">
							<input type="text" name="Code" readonly="readonly" class="form-control" value="<?=isset($product->Code) ? $product->Code: ''?>"/>
							<span class="text-danger"><?php echo form_error('Code'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Danh mục sản phẩm <span class="required">*</span></label>
						</div>
						<div class="col-md-6">
							<select class="form-control" id="sl_category" name="sl_category">
								<option value="">Chọn danh mục</option>
								<?php

								if($categories != null && count($categories) > 0){
									foreach ($categories as $c){
										?>
										<option value="<?=$c['CategoryID']?>" <?=(isset($product->CategoryID) && $product->CategoryID == $c['CategoryID']) ? ' selected="selected"' : ''?>><?=$c['CatName']?></option>
										<?php
										if(count($c['nodes']) > 0){
											foreach ($c['nodes'] as $k){?>
												<option value="<?=$k['CategoryID']?>" <?=((isset($product->CategoryID) && $product->CategoryID == $k['CategoryID']) ? ' selected="selected"' : '')?>>&nbsp;&nbsp;&nbsp;&nbsp;<?=$k['CatName']?></option>
												<?php
											}
										}
									}
								}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('sl_category'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Nhà cung cấp</label>
						</div>
						<div class="col-md-6">
							<select class="form-control" id="sl_brand" name="sl_brand">
								<option value="">Chọn nhà cung cấp</option>
								<?php
									if($brands != null && count($brands) > 0){
										foreach ($brands as $b){
											?>
											<option value="<?=$b->BrandID?>" <?=(isset($product->BrandID) && $product->BrandID == $b->BrandID) ? ' selected="selected"' : ''?>><?=$b->BrandName?></option>
											<?php
										}
									}
								?>
							</select>
							<span class="text-danger"><?php echo form_error('sl_brand'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Tên sản phẩm <span class="required">*</span></label>
						</div>
						<div class="col-md-6">
							<input type="text" name="Title" placeholder="Tiêu đề" class="form-control" value="<?=isset($product->Title)? $product->Title : ""?>" >
							<span class="text-danger"><?php echo form_error('Title'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Giá bán <span class="required">*</span></label>
						</div>
						<div class="col-md-2">
							<input type="text" name="Price" placeholder="Giá bán" class="form-control" value="<?=isset($product->Price)? $product->Price : ""?>" >
							<span class="text-danger"><?php echo form_error('Price'); ?></span>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label for="txt_active" class="control-label">Có hàng bán</label>
						</div>
						<div class="col-md-2">
							<input type="checkbox" name="Status" value="1" <?=(!isset($product->Status) || $product->Status == 1) ? "checked" : "" ?> class="form-control minimal">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Hình ảnh đại diện <span class="required">*</span></label>
						</div>
						<div class="col-md-10">
							<input type="file" id="txt_image" name="txt_image">
							<input type="hidden" value="<?=$product->Code?>" name="txt_pimg">
							<span class="text-danger"><?php echo form_error('txt_image'); ?></span>
							<?php
							if(isset($product->Thumb) && strlen($product->Thumb) > 0){
								?>
								<img style="width:50px" src="<?=base_url($product->Thumb)?>"/>
								<?php
							}
							?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2">
							<label>Hình ảnh chi tiết</label>
						</div>
						<div class="col-md-10">
							<div class="others-images-container">
								<?=isset($other_images) ? $other_images : ''?>
							</div>
							<a href="javascript:void(0);" data-toggle="modal" data-target="#modalMoreImages" class="btn btn-info">Upload thêm hình</a>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Thuộc tính sản phẩm</label>
						</div>
						<div class="col-md-10">
							<?php
							if($properties != null && count($properties) > 0){
								foreach ($properties['properties'] as $p){
									?>
									<div class="parent-property col-lg-2" id="<?=$p->PropertyID?>">
										<div class="form-group parent-property">
											<div class="col-lg-12"><?=$p->PropertyName?></div>
										</div>
										<?php
										if(($properties['child'][$p->PropertyID]) > 0){
											foreach ($properties['child'][$p->PropertyID] as $k){?>
												<div class="form-group children-property">
													<div class="col-lg-12">
														<input type="checkbox" name="properties[<?=$k->PropertyID?>]" value="<?=$k->PropertyID?>" <?=isset($productProperties[$k->PropertyID]) ? "checked" : "" ?> class="form-control minimal">
														<?=$k->PropertyName?>
													</div>
												</div>
												<?php
											}
											?>
										<?php } ?>
									</div>
								<?php } ?>
							<?php } ?>
						</div>

					</div>

					<div class="form-group">
						<div class="col-md-2">
							<label>Thông tin ngắn <span class="required">*</span></label>
						</div>
						<div class="col-md-6">
							<input type="text" name="Brief" id="brief" class="form-control" value="<?=isset($product->Brief) ? $product->Brief : ''?>"></input>
							<span class="text-danger"><?php echo form_error('Brief'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2">
							<label>Thông tin chi tiết sản phẩm <span class="required">*</span></label>
						</div>
						<div class="col-md-6">
							<textarea name="Description" id="description" rows="50" class="form-control"><?=isset($product->Description) ? $product->Description : ''?></textarea>
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
						<div class="col-md-6 col-md-offset-2">
							<a class="btn btn-default" href="<?=base_url("/admin/product/list.html")?>">Trở lại</a>
							<button  type="submit" class="btn btn-primary">Lưu</button>
						</div>
					</div>

					<input type="hidden" id="crudaction" name="crudaction" value="insert">
					<?php echo form_close(); ?>

					<!-- Modal upload images -->
					<div class="modal fade" id="modalMoreImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h4 class="modal-title" id="myModalLabel">Upload thêm hình</h4>
								</div>
								<div class="modal-body">
									<form id="uploadImagesForm">
										<input type="hidden" value="<?=$product->Code?>" name="txt_folder">
										<label for="others">Được chọn nhiều hình</label>
										<input type="file" name="others[]" id="others" multiple="">
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-info finish-upload">
										<span class="finish-text" style="display: inline;">Xong</span>
										<img src="<?=base_url('/img/load.gif')?>" class="loadUploadOthers" alt="" style="display: none;">
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- end modal upload images -->

				</div>
			</div>

		</section>
		<!-- /.content -->



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
<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
		uploadMultipleImages("<?= base_url('/admin/ProductManagement_controller/do_upload_others_images') ?>");
	});

	function reloadOthersImagesContainer() {
		$('.others-images-container').empty();
		$('.others-images-container').load("<?= base_url('/admin/ProductManagement_controller/loadOthersImages') ?>", {"txt_folder": $('[name="txt_folder"]').val()});
	}


	function uploadMultipleImages(url){
		$('.finish-upload').click(function () {
			$('.finish-upload .finish-text').hide();
			$('.finish-upload .loadUploadOthers').show();
			var someFormElement = document.getElementById('uploadImagesForm');
			var formData = new FormData(someFormElement);
			$.ajax({
				url: url,
				type: "POST",
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				success: function (data)
				{
					var ok = true;
					if(data != null && data.length > 0){
						var json = $.parseJSON(data);
						if(json.error != null && json.error.length > 0){
							ok = false;
						}
					}
					if(ok){
						reloadOthersImagesContainer();
					}
					$('.finish-upload .finish-text').show();
					$('.finish-upload .loadUploadOthers').hide();
					$('#modalMoreImages').modal('hide');
					document.getElementById("uploadImagesForm").reset();
				}
			});

		});
	}

	function removeSecondaryProductImage(image, folder, container) {
		$.ajax({
			type: "POST",
			url: "<?=base_url('/admin/ProductManagement_controller/removeSecondaryImage')?>",
			data: {image: image, txt_folder: folder}
		}).done(function (data) {
			$('#image-container-' + container).remove();
		});
	}
</script>
</body>
</html>
