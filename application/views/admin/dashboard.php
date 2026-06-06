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
	<title>Vân Anh Shop | Dashboard</title>
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
				Dashboard
				<small>Tổng quan Vân Anh Shop</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content container-fluid">
			<div class="row">

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel<?=$totalOrderToday > 0 ? ' panel-success' : ' panel-danger' ?> ">
						<div class="panel-heading">Đơn hàng hôm nay</div>
						<div class="panel-body text-center">
							<h2><?=$totalOrderToday?></h2>
							<p>Orders created today</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel <?=$totalOrderToday > 0 ? ' panel-success' : ' panel-danger' ?> ">
						<div class="panel-heading">Doanh thu hôm nay</div>
						<div class="panel-body text-center">
							<h2><?=number_format($revenueToday, 0, ',', '.')?></h2>
							<p>Revenue today</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel panel-warning">
						<div class="panel-heading">Tổng đơn hàng</div>
						<div class="panel-body text-center">
							<h2><?=$totalOrderAll?></h2>
							<p>Orders created all time</p>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Doanh thu tích lũy</div>
						<div class="panel-body text-center">
							<h2><?=number_format($revenueAll, 0, ',', '.')?></h2>
							<p>Revenue all time</p>
						</div>
					</div>
				</div>
			</div>
			<div class="row hidden">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel panel-info">
						<div class="panel-heading">Yêu cầu báo giá hôm nay</div>
						<div class="panel-body text-center">
							<h2><?=$quotationToday?></h2>
							<p>Quotation requests today</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel panel-warning">
						<div class="panel-heading">Tổng yêu cầu báo giá</div>
						<div class="panel-body text-center">
							<h2><?=$quotationAll?></h2>
							<p>Quotation requests all time</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel panel-danger">
						<div class="panel-heading">Phản hồi hôm nay</div>
						<div class="panel-body text-center">
							<h2><?=$feedbackToday?></h2>
							<p>Customer feedback today</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">Tổng phản hồi</div>
						<div class="panel-body text-center">
							<h2><?=$feedbackAll?></h2>
							<p>Customer feedback all time</p>
						</div>
					</div>
				</div>
			</div>
			<!-- Orders chart (last 7 days) -->
			<div class="row mobile-hide">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">Orders created (last 7 days)</div>
						<div class="panel-body">
							<div id="orders-week-chart" style="height:260px;"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">Top 5 sản phẩm được đặt nhiều nhất</div>
						<div class="panel-body">
							<table class="table table-bordered table-striped table-condensed">
								<thead>
								<tr>
									<th>#</th>
									<th>Sản phẩm</th>
									<th class="text-center">Số lần mua</th>
								</tr>
								</thead>
								<tbody>
								<?php if(!empty($topOrderedProducts)): ?>
									<?php foreach($topOrderedProducts as $index => $product): ?>
										<tr>
											<td><?= $index + 1 ?></td>
											<td><?= html_escape($product->Title) ?> <small>(<?= html_escape($product->Code) ?>)</small></td>
											<td class="text-center"><?= number_format($product->OrderedQuantity, 0, ',', '.') ?></td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr><td colspan="3" class="text-center">Không có sản phẩm</td></tr>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">Top 5 sản phẩm có lượt xem cao nhất</div>
						<div class="panel-body">
							<table class="table table-bordered table-striped table-condensed">
								<thead>
									<tr>
										<th>#</th>
										<th>Sản phẩm</th>
										<th class="text-center">Lượt xem</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($topProducts)): ?>
										<?php foreach($topProducts as $index => $product): ?>
											<tr>
												<td><?= $index + 1 ?></td>
												<td><?= html_escape($product->Title) ?> <small>(<?= html_escape($product->Code) ?>)</small></td>
												<td class="text-center"><?= number_format($product->View, 0, ',', '.') ?></td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr><td colspan="3" class="text-center">Không có sản phẩm</td></tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
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
<script src="<?=base_url('/theme/admin/js/jquery.flot.js')?>"></script>
<script src="<?=base_url('/theme/admin/js/jquery.flot.categories.js')?>"></script>

<script type="text/javascript">
 	$(document).ready(function() {
		try{
			var ordersChart = <?=$ordersChart?> || [];
			var plotData = [];
			for(var i=0;i<ordersChart.length;i++){
				plotData.push([ordersChart[i][0], ordersChart[i][1]]);
			}

			$.plot('#orders-week-chart', [ plotData ], {
				series: { bars: { show: true, barWidth: 0.6, align: 'center' } },
				xaxis: { mode: 'categories', tickLength: 0 }
			});
		} catch(e){
			console.error('Failed to render orders chart', e);
		}
 	});
</script>
</body>
</html>
