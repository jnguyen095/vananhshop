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
	<title>Quản Lý Người Dùng | Vân Anh Shop</title>
	<?php $this->load->view('/admin/common/header-js') ?>
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
				Quản lý người dùng
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Quản lý người dùng</li>
			</ol>
		</section>

		<?php
		$attributes = array("id" => "frmUser");
		echo form_open("admin/user/list", $attributes);
		?>
		<!-- Main content -->
		<section class="content container-fluid">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách người dùng</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row search-filter">
						<div class="col-sm-4">
							<div class="form-group">
								<input type="text" name="searchFor" placeholder="Tìm theo tên, số điện thoại, email, địa chỉ..." class="form-control" id="searchKey" onchange="sendRequest();">
							</div>
						</div>
						<div class="top-buttons text-right"><a class="btn btn-primary" href="<?=base_url('/admin/user/add.html')?>">Thêm Mới</a> </div>
					</div>

					<div class="table-responsive">
						<table class="admin-table table table-bordered table-striped">
							<thead>
								<tr>
									<th></th>
									<th>Nhóm</th>
									<th data-action="sort" data-title="FullName" data-direction="ASC"><span>Họ Tên</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="Phone" data-direction="ASC"><span>Điện Thoại</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="Email" data-direction="ASC"><span>Email</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="CreatedDate" data-direction="ASC"><span>Ngày Tạo</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th data-action="sort" data-title="LastLogin" data-direction="ASC"><span>Đăng Nhập Gần Nhất</span><i class="glyphicon glyphicon-triangle-bottom"></i></th>
									<th>Xử lý</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$counter = 1;
							foreach ($users as $user) {
								?>
								<tr>
									<td><?=$counter++?></td>
									<td><?=($user->UserGroupID == USER_GROUP_ADMIN ? 'Quản trị' : 'Người dùng')?></td>
									<td><?=$user->FullName?></td>
									<td><?=$user->Phone?></td>
									<td><?=$user->Email?></td>
									<td><?=date('d/m/Y H:i', strtotime($user->CreatedDate))?></td>
									<td><?=date('d/m/Y H:i', strtotime($user->LastLogin))?></td>
									<td>
										<a data-toggle="tooltip" title="Chỉnh sửa" href="<?=base_url('/admin/user/add-'.$user->Us3rID.'.html')?>"><i class="glyphicon glyphicon-edit"></i></a>
										&nbsp;|&nbsp;<a class="remove-user" data-userid="<?=$user->Us3rID?>" data-toggle="tooltip" title="Xóa người dùng"><i class="glyphicon glyphicon-remove"></i></a>
									</td>
								</tr>
								<?php
							}
							?>
							</tbody>
						</table>

					</div>

					<div class="row text-center">
						<?php echo $pagination; ?>
					</div>
				</div>
			</div>

		</section>

		<input type="hidden" id="crudaction" name="crudaction">
		<input type="hidden" id="userId" name="userId">
		<?php echo form_close(); ?>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- Main Footer -->
	<?php $this->load->view('/admin/common/admin-footer')?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<?php $this->load->view('/admin/common/include-javascripts')?>


<script type="text/javascript">
	var sendRequest = function(){
		var searchKey = $('#searchKey').val()||"";
		window.location.href = '<?=base_url('admin/user/list.html')?>?query='+searchKey+ '&orderField='+curOrderField+'&orderDirection='+curOrderDirection;
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


	function deleteUserHandler(){
		$('.remove-user').click(function(){
			var userId = $(this).data('userid');
			bootbox.confirm("Bạn đã chắc chắn người dùng này chưa?", function(result){
				if(result){
					$("#userId").val(userId);
					$("#crudaction").val("delete");
					$("#frmUser").submit();
				}
			});
		});
	}

	$(document).ready(function(){
		deleteUserHandler();
	});
</script>
</body>
</html>
