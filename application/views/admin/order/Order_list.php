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
	<title>Quản lý đơn hàng</title>
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
				Quản lý đơn hàng
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Quản lý đơn hàng</li>
			</ol>
		</section>

		<!-- Main content -->
		<?php
		$attributes = array("id" => "frmOrder");
		echo form_open("admin/order/list", $attributes);
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
					<h3 class="box-title">Danh sách đơn hàng</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="search-filter">
						<div class="row">
							<div class="col-sm-4">
								<label>Mã đơn hàng</label>
								<div class="form-group">
									<input type="text" name="code" placeholder="Tìm mã đơn hàng" class="form-control" id="txtCode">
								</div>
							</div>

							<div class="col-sm-3">
								<label>Số ĐT</label>
								<div class="form-group">
									<input type="text" name="txtPhone" placeholder="Tìm số điện thoại" class="form-control" id="phoneNumber">
								</div>
							</div>

							<div class="col-sm-5">
								<label>Tình trạng</label>
								<div class="form-group">
									<label><input id="st_0" checked="checked" type="radio" name="status" value="">Tất cả</label>
									<label><input id="st-<?=ORDER_STATUS_NEW?>" type="radio" name="status" value="<?=ORDER_STATUS_NEW?>"> Đơn mới</label>
									<label><input id="st-<?=ORDER_STATUS_CONFIRM?>" type="radio" name="status" value="<?=ORDER_STATUS_CONFIRM?>"> Chờ giao hàng</label>
									<label><input id="st-<?=ORDER_STATUS_SHIPPING?>" type="radio" name="status" value="<?=ORDER_STATUS_SHIPPING?>"> Đang giao hàng</label>
									<label><input id="st-<?=ORDER_STATUS_COMPLETED?>" type="radio" name="status" value="<?=ORDER_STATUS_COMPLETED?>"> Đã giao</label>
									<label><input id="st-<?=ORDER_STATUS_CANCEL?>" type="radio" name="status" value="<?=ORDER_STATUS_CANCEL?>"> Đã hủy</label>
								</div>
							</div>
						</div>
						<div class="text-center">
							<a class="btn btn-primary" onclick="sendRequest()">Tìm kiếm</a>
						</div>
					</div>

					<div class="row no-margin top-buttons">
						<a class="btn btn-primary" id="addNew" href="<?=base_url("/admin/order/edit.html")?>">Thêm sản phẩm</a>
						<a class="btn btn-danger" id="deleteMulti">Xóa Nhiều</a>
					</div>

					<div class="table-responsive">
						<table class="admin-table table table-bordered table-striped">
							<thead>
							<tr>
								<th><input name="checkAll" value="1" type="checkbox" ></th>
								<th data-action="sort" data-title="m.Code" data-direction="ASC"><span>Mã ĐH</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="u.FullName" data-direction="ASC"><span>Khách hàng</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="u.Phone" data-direction="ASC"><span>SĐT</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="m.CreatedDate" data-direction="ASC"><span>Tạo lúc</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="m.TotalItems" data-direction="ASC"><span>SL</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="m.ShippingFee" data-direction="ASC"><span>Phí GH</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="m.Discount" data-direction="ASC"><span>Giảm giá</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="m.TotalPrice" data-direction="ASC"><span>Giá trị</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="m.Payment" data-direction="ASC"><span>Thanh toán</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="m.Status" data-direction="ASC"><span>Status</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th data-action="sort" data-title="m.UpdatedDate" data-direction="ASC"><span>Cập nhật</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
								<th></th>
							</tr>
							</thead>
							<tbody>

							<?php
							$counter = 1;
							foreach ($orders as $order) {
								?>
								<tr>
									<td><input name="checkList[]" type="checkbox" value="<?=$order->OrderID?>"></td>
									<td><?=$order->Code?></td>
									<td><?=$order->FullName?></td>
									<td><?=$order->Phone?></td>
									<td><?=date('d/m/Y H:i', strtotime($order->CreatedDate))?></td>
									<td class="text-right"><?=number_format($order->TotalItems)?></td>
									<td class="text-right"><?=number_format($order->ShippingFee)?></td>
									<td class="text-right"><?=number_format($order->Discount)?></td>
									<td class="text-right"><?=number_format($order->TotalPrice)?></td>
									<td class="text-center"><?=$order->Payment?></td>
									<td class="text-center"><?php
										if($order->Status == ORDER_STATUS_NEW){
											echo '<lable class="label label-success">Đơn mới</lable>';
										} else if($order->Status == ORDER_STATUS_CANCEL){
											echo '<lable class="label label-danger">Đã hủy</lable>';
										} else if($order->Status == ORDER_STATUS_CONFIRM){
											echo '<lable class="label label-info">Chờ giao hàng</lable>';
										} else if($order->Status == ORDER_STATUS_SHIPPING){
											echo '<lable class="label label-warning">Đang giao hàng</lable>';
										} else if($order->Status == ORDER_STATUS_COMPLETED){
											echo '<lable class="label label-default">Đã giao</lable>';
										}
										?>
									</td>
									<td><?=date('d/m/Y H:i', strtotime($order->UpdatedDate))?></td>

									<td class="text-center">
										<a href="<?=base_url('/admin/order/process-'.$order->OrderID.'.html')?>" data-toggle="tooltip" title="Xử lý đơn hàng"><i class="glyphicon glyphicon-shopping-cart"></i></a>
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
		var searchKey = $('#txtCode').val()||"";
		var phoneNumber = $('#phoneNumber').val()||"";
		var status = $('input[name=status]:checked').val();
		window.location.href = '<?=base_url('admin/order/list.html')?>?code='+searchKey + '&phoneNumber=' + phoneNumber + '&status=' + status + '&orderField='+curOrderField+'&orderDirection='+curOrderDirection;
	}

	var curOrderField, curOrderDirection;
	$('[data-action="sort"]').on('click', function(e){
		curOrderField = $(this).data('title');
		curOrderDirection = $(this).data('direction');
		sendRequest();
	});


	$('#txtCode').val(decodeURIComponent(getNamedParameter('code')||""));
	$('#phoneNumber').val(decodeURIComponent(getNamedParameter('phoneNumber')||""));

	if(decodeURIComponent(getNamedParameter('status')) != null){
		$("#st-" + (decodeURIComponent(getNamedParameter('status')))).prop( "checked", true );
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
