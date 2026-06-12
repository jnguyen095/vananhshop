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
	<title>Vân Anh Shop | Quản lý báo giá</title>
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
				Quản lý báo giá
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Quản lý báo giá</li>
			</ol>
		</section>

		<!-- Main content -->
		<?php
		$attributes = array("id" => "frmQuote");
		echo form_open("admin/quote/list", $attributes);
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

					<div class="table-responsive">
						<table class="admin-table table table-bordered table-striped">
							<thead>
								<tr>
									<th><input name="checkAll" value="1" type="checkbox" ></th>
									<th data-action="sort" data-title="RequestedDate" data-direction="ASC"><span>Ngày gửi</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="Code" data-direction="ASC"><span>Mã</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="Name" data-direction="ASC"><span>Người gửi</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="Phone" data-direction="ASC"><span>SĐT</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="Email" data-direction="ASC"><span>Email</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="Status" data-direction="ASC"><span>Status</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="TotalProduct" data-direction="ASC"><span>Sản Phẩm</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="TotalItems" data-direction="ASC"><span>SL</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th class="text-center">Cập nhật</th>
								</tr>
							</thead>
							<tbody>

							<?php
							$counter = 1;
							foreach ($quotes as $quote) {
								?>
								<tr>
									<td><input name="checkList[]" type="checkbox" value="<?=$quote->QuotationID?>"></td>
									<td><?=date('d/m/Y H:i', strtotime($quote->RequestedDate))?></td>
									<td><?=$quote->Code?></td>
									<td><?=$quote->Name?></td>
									<td><?=$quote->Phone?></td>
									<td><?=$quote->Email?></td>
									<td>
										<?php
											if($quote->Status == QUOTE_STATUS_NEW){
												echo '<span class="label label-info">Mới</span>';
											} else if($quote->Status == QUOTE_STATUS_UPDATE){
												echo '<span class="label label-warning">Đang cập nhật</span>';
											} else if($quote->Status == QUOTE_STATUS_APPROVED){
												echo '<span class="label label-success">Sẵn sàng gửi</span>';
											}
										?>
									</td>
									<td><?=number_format($quote->TotalProduct)?></td>
									<td><?=number_format($quote->TotalItems)?></td>
									<td  class="text-center">
										<a href="<?=base_url('/admin/quote/view-'.$quote->QuotationID.'.html')?>" data-toggle="tooltip" title="Cập nhật báo giá"><i class="glyphicon glyphicon-edit"></i></a>

										<?php
										if($quote->Status == QUOTE_STATUS_APPROVED) {
											?>
											&nbsp;|&nbsp;<a href="#" class="send-mail" data-toggle="tooltip" data-quoteid="<?=$quote->QuotationID?>" title="Gửi mail cho khách"><i class="glyphicon glyphicon glyphicon-envelope"></i></a>
											&nbsp;|&nbsp;<a
												href="<?= base_url('/bao-gia/'.$quote->UUID.'/xem-chi-tiet.html') ?>"
												data-toggle="tooltip" title="Xem file báo giá"><i
													class="glyphicon glyphicon glyphicon-open-file"></i></a>
											<?php
										}
										?>
										&nbsp;|&nbsp;<a href="#" class="remove-post" data-toggle="tooltip" data-quoteid="<?=$quote->QuotationID?>" title="Xóa"><i class="glyphicon glyphicon glyphicon-remove"></i></a>
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
		<input type="hidden" id="quoteId" name="quoteId">
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
		var status = $('input[name=status]:checked').val();
		window.location.href = '<?=base_url('admin/quote/list.html')?>?status=' + status + '&orderField='+curOrderField+'&orderDirection='+curOrderDirection;
	}

	var curOrderField, curOrderDirection;
	$('[data-action="sort"]').on('click', function(e){
		curOrderField = $(this).data('title');
		curOrderDirection = $(this).data('direction');
		sendRequest();
	});

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

	function deleteQuotationHandler(){
		$('.remove-post').click(function(){
			var quoteId = $(this).data('quoteid');
			bootbox.confirm("Bạn đã chắc chắn xóa báo giá này chưa?", function(result){
				if(result){
					$("#quoteId").val(quoteId);
					$("#crudaction").val("delete");
					$("#frmQuote").submit();
				}
			});
		});
	}

	function sendMailHandler(){
		$('.send-mail').click(function(){
			var quoteid = $(this).data('quoteid');
			bootbox.confirm("Bạn đã chắc chắn gửi mail báo giá này chưa?", function(result){
				if(result){
					$("#quoteId").val(quoteid);
					$("#crudaction").val("send-mail");
					$("#frmQuote").submit();
				}
			});
		});
	}

	$(document).ready(function(){
		deleteQuotationHandler();
		sendMailHandler();
	});
</script>
</body>
</html>
