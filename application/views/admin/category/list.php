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
	<title>Cà Phê Rang Hạt | Quản Lý Danh Mục</title>
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
				Quản Lý Danh Mục Sản Phẩm
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Quản Lý Danh Mục Sản Phẩm</li>
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
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					<?php
						$attributes = array("id" => "frmCategory", "class" => "form-horizontal");
						echo form_open("admin/category/list", $attributes);
					?>
					<div class="text-left categories">
						<div class="row no-margin">
							<a class="btn btn-primary" href="<?=base_url('/admin/category/add.html');?>">Thêm danh mục</a>
						</div>
						<?php
						foreach ($categories as $parent) {
						?>
						<div class="category-level0" catid="<?=$parent['CategoryID']?>">
							<span class="category-status-<?=$parent['Active']?>"> <?=$parent['CatName'];?></span>
							<a data-toggle="tooltip" title="Chỉnh sửa" href="<?=base_url("/admin/category/add-".$parent['CategoryID']).".html"?>"><i class="glyphicon glyphicon-edit"></i> </a>
							&nbsp;|&nbsp;<a class="remove-cat" data-toggle="tooltip" data-category="<?=$parent['CategoryID']?>" title="Xóa danh mục" href="#"><i class="glyphicon glyphicon-trash"></i> </a>
							<?php
							if(count($parent['nodes']) > 0){
								foreach ($parent['nodes'] as $child){?>
									<div class="category-level1" catid="<?=$child['CategoryID']?>">
										<span class="category-status-<?=$child['Active']?>"><?=$child['CatName']?></span>
										<a data-toggle="tooltip" title="Chỉnh sửa" href="<?=base_url("/admin/category/add-".$child['CategoryID']).".html"?>"><i class="glyphicon glyphicon-edit"></i> </a>
										&nbsp;|&nbsp;<a class="remove-cat" data-toggle="tooltip" data-category="<?=$child['CategoryID']?>" title="Xóa danh mục" href="#"><i class="glyphicon glyphicon-trash"></i> </a>
									</div>
									<?php
								}
							}
							?>
						</div>
						<?php
						}
						?>

					</div>
				</div>
			</div>

		</section>
		<!-- /.content -->
		<input type="hidden" id="crudaction" name="crudaction">
		<input type="hidden" id="categoryId" name="categoryId">
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
		window.location.href = '<?=base_url('admin/brand/list.html')?>?query='+searchKey+ '&orderField='+curOrderField+'&orderDirection='+curOrderDirection;
	}

	var curOrderField, curOrderDirection;
	$('[data-action="sort"]').on('click', function(e){
		curOrderField = $(this).data('title');
		curOrderDirection = $(this).data('direction');
		sendRequest();
	});


	$('#searchKey').val(decodeURIComponent(getNamedParameter('query')||""));

	var curOrderField = getNamedParameter('orderField')||"";
	var curOrderDirection = getNamedParameter('orderDirection')||"";
	var currentSort = $('[data-action="sort"][data-title="'+getNamedParameter('orderField')+'"]');
	if(curOrderDirection=="ASC"){
		currentSort.attr('data-direction', "DESC").find('i.glyphicon').removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top active');
	}else{
		currentSort.attr('data-direction', "ASC").find('i.glyphicon').removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom active');
	}

	function updateHot(brandId){

		var hot = $("#selectid-" + brandId + " option:selected").val();
		jQuery.ajax({
			type: "POST",
			url: '<?=base_url("/admin/BrandManagement_controller/updateHot")?>',
			dataType: 'json',
			data: {BrandID: brandId, Hot: hot},
			success: function(res){
				if(res == 'success'){
					bootbox.alert("Cập nhật thành công");
				}
			}
		});
	}


	function pushPostUp(CooperateID){
		jQuery.ajax({
			type: "POST",
			url: '<?=base_url("/admin/CooperateManagement_controller/pushPostUp")?>',
			dataType: 'json',
			data: {CooperateID: CooperateID},
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

	function deleteCategoryHandler(){
		$('.remove-cat').click(function(){
			var catId = $(this).data('category');
			bootbox.confirm("Bạn đã chắc chắn xóa danh mục này và thư mục con liên quan chưa?", function(result){
				if(result){
					$("#categoryId").val(catId);
					$("#crudaction").val("delete");
					$("#frmCategory").submit();
				}
			});
		});
	}
	$(document).ready(function(){
		deleteCategoryHandler();
		// deleteMultiplePostHandler();
	});
</script>
</body>
</html>
