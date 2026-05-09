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
	<title>Quản Lý Thuộc Tính Sản Phẩm</title>
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
				Quản Lý Thuộc Tính Sản Phẩm
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Quản Lý Thuộc Tính Sản Phẩm</li>
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
				<div class="box-header">
					<h3 class="box-title">Quản Lý Thuộc Tính Sản Phẩm</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="text-left categories">
						<div class="row no-margin">
							<a class="btn btn-primary" href="<?=base_url('/admin/property/add.html');?>">Thêm thuộc tính</a>
						</div>
						<?php
						foreach ($properties as $property) {
						?>
						<div class="category-level0" catid="<?=$property->PropertyID?>">
							<span class="category-status-<?=$property->Status?>"> <?=$property->PropertyName;?></span> <a data-toggle="tooltip" title="Chỉnh sửa" href="<?=base_url("/admin/property/add-".$property->PropertyID).".html"?>"><i class="glyphicon glyphicon-edit"></i> </a>
							<?php
							if(count($child[$property->PropertyID]) > 0){
								foreach ($child[$property->PropertyID] as $k){?>
									<div class="category-level1" catid="<?=$k->PropertyID?>"><span class="category-status-<?=$k->Status?>"><?=$k->PropertyName?></span> <a data-toggle="tooltip" title="Chỉnh sửa" href="<?=base_url("/admin/property/add-".$k->PropertyID).".html"?>"><i class="glyphicon glyphicon-edit"></i> </a></div>
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

</script>
</body>
</html>
