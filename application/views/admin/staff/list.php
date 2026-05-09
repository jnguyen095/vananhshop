
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
				Quản lý nhân viên
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Quản lý nhân viên</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content container-fluid">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Danh sách nhân viên</h3>
				</div>

				<!-- /.box-header -->
				<div class="box-body">
					<div class="top-buttons"><a class="btn btn-primary" href="<?=base_url('/admin/staff/add.html')?>">Thêm Mới</a> </div>
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Họ tên</th>
								<th>Tên Đăng Nhập</th>
								<th>Tình Trạng</th>
								<th>Email</th>
								<th>Last Login</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if(isset($staffs) && count($staffs) > 0) {
							foreach ($staffs as $staff) {
								?>
								<tr>
									<td><?=$staff->FullName?></td>
									<td><?=$staff->Phone?></td>
									<td>
										<?php
											if($staff->Status == 1) {
												?>
												<span class="label label-success">Đang hoạt động</span>
												<?php
											}else {
												?>
												<span class="label label-danger">Không hoạt động</span>
												<?php
											}
										?>
									</td>
									<td><?=$staff->Email?></td>
									<td><?=date('d/m/Y m:s', strtotime($staff->LastLogin)) ?></td>
									<td>
										<a data-toggle="tooltip" title="Cập nhật thông tin" href="<?=base_url('/admin/staff/add-'.$staff->Us3rID.'.html')?>"><i class="	glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php
							}
						}
						?>
						</tbody>
					</table>
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

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
<script type="text/javascript">
</script>
</body>
</html>
