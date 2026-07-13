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
	<title>Dashboard | Vân Anh Shop</title>
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
			<!-- Orders and revenue charts (last 7 days) -->
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">Đơn hàng 7 ngày qua</div>
						<div class="panel-body">
							<div class="chart-responsive" style="position: relative; height:260px;">
								<canvas id="orders-week-chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">Doanh thu 7 ngày qua</div>
						<div class="panel-body">
							<div class="chart-responsive" style="position: relative; height:260px;">
								<canvas id="daily-revenue-chart"></canvas>
							</div>
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
<?php $this->load->view('/admin/common/include-javascripts')?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<script type="text/javascript">
 	$(document).ready(function() {
		try {
			var ordersChart = <?=$ordersChart?> || [];
			var labels = [];
			var values = [];
			for (var i = 0; i < ordersChart.length; i++) {
				labels.push(ordersChart[i][0]);
				values.push(ordersChart[i][1]);
			}

			var ctx = document.getElementById('orders-week-chart').getContext('2d');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: labels,
					datasets: [{
						label: 'Orders',
						data: values,
						backgroundColor: 'rgba(54, 162, 235, 0.7)',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1,
						roundness: 0.4,
						borderRadius: 6,
						maxBarThickness: 48
					}]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						legend: { display: false },
						title: { display: false }
					},
					scales: {
						x: {
							ticks: { color: '#555' },
							grid: { display: false }
						},
						y: {
							beginAtZero: true,
							ticks: { color: '#555', precision: 0 },
							grid: { color: 'rgba(0,0,0,0.05)' }
						}
					}
				}
			});

			var revenueChart = <?=$revenueChart?> || [];
			var revenueLabels = [];
			var revenueValues = [];
			for (var j = 0; j < revenueChart.length; j++) {
				revenueLabels.push(revenueChart[j][0]);
				revenueValues.push(revenueChart[j][1]);
			}

			var revenueCtx = document.getElementById('daily-revenue-chart').getContext('2d');
			new Chart(revenueCtx, {
				type: 'line',
				data: {
					labels: revenueLabels,
					datasets: [{
						label: 'Revenue',
						data: revenueValues,
						fill: true,
						backgroundColor: 'rgba(75, 192, 192, 0.15)',
						borderColor: 'rgba(75, 192, 192, 1)',
						pointBackgroundColor: 'rgba(75, 192, 192, 1)',
						pointBorderColor: '#fff',
						pointRadius: 4,
						borderWidth: 2,
						tension: 0.3
					}]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						legend: { display: false },
						title: { display: false }
					},
					scales: {
						x: {
							ticks: { color: '#555' },
							grid: { display: false }
						},
						y: {
							beginAtZero: true,
							ticks: { color: '#555', callback: function(value) { return value.toLocaleString(); } },
							grid: { color: 'rgba(0,0,0,0.05)' }
						}
					}
				}
			});
		} catch (e) {
			console.error('Failed to render orders chart', e);
		}
 	});
</script>
</body>
</html>
