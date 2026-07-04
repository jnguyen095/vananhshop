<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('/admin/common/header-js') ?>
	<title>Báo cáo | Vân Anh Shop</title>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<?php $this->load->view('/admin/common/admin-header') ?>
	<?php $this->load->view('/admin/common/left-menu') ?>

	<div class="content-wrapper">
		<section class="content-header">
			<h1>Báo cáo</h1>
			<ol class="breadcrumb">
				<li><a href="<?=base_url('/admin/dashboard.html')?>"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
				<li class="active">Báo cáo</li>
			</ol>
		</section>

		<section class="content">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#" data-report-type="day">Report theo ngày</a></li>
					<li><a href="#" data-report-type="month">Report theo tháng</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="reportContent">
						<div class="text-center" style="padding: 40px;">
							<i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<?php $this->load->view('/admin/common/admin-footer') ?>
</div>

<?php $this->load->view('/admin/common/include-javascripts')?>

<script>
	$(function () {
		function loadReport(type) {
			$('#reportContent').html('<div class="text-center" style="padding: 40px;"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>');
			$.ajax({
				url: '<?=base_url('/admin/report/load.html')?>',
				type: 'GET',
				data: { type: type },
				success: function (html) {
					$('#reportContent').html(html);
				},
				error: function () {
					$('#reportContent').html('<div class="alert alert-danger">Không thể tải dữ liệu báo cáo.</div>');
				}
			});
		}

		$('.nav-tabs a').on('click', function (e) {
			e.preventDefault();
			var type = $(this).data('report-type');
			$('.nav-tabs li').removeClass('active');
			$(this).parent().addClass('active');
			loadReport(type);
		});

		loadReport('day');
	});
</script>
</body>
</html>
