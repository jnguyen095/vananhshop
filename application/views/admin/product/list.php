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
	<title>Vân Anh Shop | Quản lý sản phẩm</title>
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
				Quản lý sản phẩm
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Quản lý sản phẩm</li>
			</ol>
		</section>

		<!-- Main content -->
		<?php
		$attributes = array("id" => "frmPost");
		echo form_open("admin/product/list", $attributes);
		?>
		<section class="content container-fluid">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<div class="search-filter">
						<div class="row">
							<div class="col-sm-4">
								<label>Tiêu đề</label>
								<div class="form-group">
									<input type="text" name="searchFor" placeholder="Tìm tiêu đề" class="form-control" id="searchKey">
								</div>
							</div>

							<div class="col-sm-4">
								<label>Danh mục</label>
								<div class="form-group">
									<select class="form-control" id="sl_category" name="sl_category">
										<option value="">Tất cả danh mục</option>
										<?php

										if($categories != null && count($categories) > 0){
											foreach ($categories as $c){
												?>
												<option value="<?=$c['CategoryID']?>" <?=(isset($_GET['sl_category']) && $_GET['sl_category'] == $c['CategoryID']) ? ' selected="selected"' : ''?>><?=$c['CatName']?></option>
												<?php
												if(count($c['nodes']) > 0){
													foreach ($c['nodes'] as $k){?>
														<option value="<?=$k['CategoryID']?>" <?=(isset($_GET['sl_category']) && $_GET['sl_category'] == $k['CategoryID']) ? ' selected="selected"' : ''?>>&nbsp;&nbsp;&nbsp;&nbsp;<?=$k['CatName']?></option>
														<?php
													}
												}
											}
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-sm-4">
								<label>Tình trạng</label>
								<div class="form-group">
									<label><input id="st_0" checked="checked" type="radio" name="status" value="-1"> Tất cả</label>
									<label><input id="st-1" type="radio" name="status" value="1"> Hoạt động</label>
									<label><input id="st-0" type="radio" name="status" value="0"> Tạm dừng</label>
								</div>
							</div>
						</div>

						<div class="text-center">
							<a class="btn btn-primary" onclick="sendRequest()">Tìm kiếm</a>
						</div>
					</div>

					<div class="row no-margin top-buttons">
						<a class="btn btn-primary" id="addNew" href="<?=base_url("/admin/product/edit.html")?>">Thêm sản phẩm</a>
						<a class="btn btn-danger" id="deleteMulti">Xóa Nhiều</a>
					</div>

					<div class="table-responsive">
						<table class="admin-table table table-bordered table-striped">
							<thead>
								<tr>
									<th><input name="checkAll" value="1" type="checkbox" ></th>
									<th data-action="sort" data-title="Title" data-direction="ASC"><span>Tiêu đề</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="c.CatName" data-direction="ASC"><span>Danh mục</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="Price" data-direction="ASC"><span>Giá bán</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="View" data-direction="ASC"><span>Lượt xem</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="Status" data-direction="ASC"><span>Status</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="ModifiedDate" data-direction="ASC"><span>Ngày cập nhật</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="CreatedByID" data-direction="ASC"><span>Người đăng</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>

							<?php
							$counter = 1;
							foreach ($products as $product) {
								?>
								<tr>
									<td><input name="checkList[]" type="checkbox" value="<?=$product->ProductID?>"></td>
									<td><?=$product->Title?></td>
									<td><?=$product->CatName?></td>
									<td class="text-right"><?=number_format($product->Price)?></td>
									<td class="text-right"><?=number_format($product->View)?></td>
									<td>
										<?php
											if($product->Status == ACTIVE){
												echo '<span class="label label-success">Đang bán</span>';
											} else{
												echo '<span class="label label-warning">Tạm ngưng</span>';
											}
										?>
									</td>
									<td><?=date('d/m/Y H:i', strtotime($product->ModifiedDate))?></td>
									<td><?=$product->FullName?></td>
									<td>
										<a href="<?=base_url('/admin/product/edit-'.$product->ProductID.'.html')?>" data-toggle="tooltip" title="Chỉnh sửa"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;|&nbsp;
										<a class="remove-post" data-post="<?=$product->ProductID?>" data-toggle="tooltip" title="Xóa tin đăng"><i class="glyphicon glyphicon-remove"></i></a>
									</td>
								</tr>
								<?php
							}
							?>
							</tbody>
						</table>
						<div class="text-center">
							<?php echo $pagination; ?>
						</div>
					</div>
				</div>
			</div>

		</section>
		<!-- /.content -->
		<input type="hidden" id="crudaction" name="crudaction">
		<input type="hidden" id="productId" name="productId">
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
	var sendRequest = function(){
		var searchKey = $('#searchKey').val()||"";
		var catId = $('#sl_category').val()||"";
		var status = $('input[name=status]:checked').val();
		window.location.href = '<?=base_url('admin/product/list.html')?>?query='+searchKey + '&sl_category=' + catId + '&status=' + status + '&orderField='+curOrderField+'&orderDirection='+curOrderDirection;
	}

	var curOrderField, curOrderDirection;
	$('[data-action="sort"]').on('click', function(e){
		curOrderField = $(this).data('title');
		curOrderDirection = $(this).data('direction');
		sendRequest();
	});


	$('#searchKey').val(decodeURIComponent(getNamedParameter('query')||""));
	$('#fromDate').val(decodeURIComponent(getNamedParameter('fromDate')||""));
	$('#toDate').val(decodeURIComponent(getNamedParameter('toDate')||""));
	$('#code').val(decodeURIComponent(getNamedParameter('code')||""));
	$('#phoneNumber').val(decodeURIComponent(getNamedParameter('phoneNumber')||""));
	if(decodeURIComponent(getNamedParameter('hasAuthor')) != null){
		$("#chb-" + (parseInt(decodeURIComponent(getNamedParameter('hasAuthor'))) + 1)).prop( "checked", true );
	}else{
		$("#chb-0").prop( "checked", true );
	}

	if(decodeURIComponent(getNamedParameter('status')) != null){
		$("#st-" + (parseInt(decodeURIComponent(getNamedParameter('status'))))).prop( "checked", true );
	}else{
		$("#st_0").prop( "checked", true );
	}

	var curOrderField = getNamedParameter('orderField')||"";
	var curOrderDirection = getNamedParameter('orderDirection')||"";
	var currentSort = $('[data-action="sort"][data-title="'+getNamedParameter('orderField')+'"]');
	if(curOrderDirection=="ASC"){
		currentSort.attr('data-direction', "DESC").find('i.glyphicon').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top active');
	}else{
		currentSort.attr('data-direction', "ASC").find('i.glyphicon').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom active');
	}

	function updateView(productId, val){
		$("#pr-" + productId).addClass("process");
		jQuery.ajax({
			type: "POST",
			url: '<?=base_url("/Ajax_controller/updateViewForProductIdManual")?>',
			dataType: 'json',
			data: {productId: productId, view: val},
			success: function(res){
				if(res == 'success'){
					/*bootbox.alert("Cập nhật thành công");*/
					$("#pr-" + productId).addClass("success");
				}
			}
		});
	}
	function updateVip(productId, val){
		jQuery.ajax({
			type: "POST",
			url: '<?=base_url("/Ajax_controller/updateVipPackageForProductId")?>',
			dataType: 'json',
			data: {productId: productId, vip: val},
			success: function(res){
				if(res == 'success'){
					bootbox.alert("Cập nhật thành công");
				}
			}
		});
	}

	function pushPostUp(productId){
		jQuery.ajax({
			type: "POST",
			url: '<?=base_url("/admin/ProductManagement_controller/pushPostUp")?>',
			dataType: 'json',
			data: {productId: productId},
			success: function(res){
				if(res == 'success'){
					bootbox.alert("Cập nhật thành công");
				}
			}
		});
	}

	function deleteMultiplePostHandler(){
		$("#deleteMulti").click(function(){
			var selectedItems = $("input[name='checkList[]']:checked").length;
			if(selectedItems > 0) {
				bootbox.confirm("Bạn đã chắc chắn xóa những tin rao này chưa?", function (result) {
					if (result) {
						$("#crudaction").val("delete-multiple");
						$("#frmPost").submit();
					}
				});
			}else{
				bootbox.alert("Bạn chưa check chọn tin cần xóa!");
			}
		});
	}

	function deletePostHandler(){
		$('.remove-post').click(function(){
			var prId = $(this).data('post');
			bootbox.confirm("Bạn đã chắc chắn xóa tin rao này chưa?", function(result){
				if(result){
					$("#productId").val(prId);
					$("#crudaction").val("delete");
					$("#frmPost").submit();
				}
			});
		});
	}
	$(document).ready(function(){
		deletePostHandler();
		deleteMultiplePostHandler();
	});
</script>
</body>
</html>
