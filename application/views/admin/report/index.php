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
					<li class="active"><a href="#" class="report-tab-link" data-report-type="day" title="Report theo ngày"><i class="fa fa-calendar tab-icon"></i><span class="tab-label">Report theo ngày</span></a></li>
					<li><a href="#" class="report-tab-link" data-report-type="month" title="Report theo tháng"><i class="fa fa-calendar-check-o tab-icon"></i><span class="tab-label">Report theo tháng</span></a></li>
					<li><a href="#" class="report-tab-link" data-report-type="customer" title="Customer Report"><i class="fa fa-users tab-icon"></i><span class="tab-label">Customer Report</span></a></li>
					<li><a href="#" class="report-tab-link" data-report-type="product" title="Product Report"><i class="fa fa-cube tab-icon"></i><span class="tab-label">Product Report</span></a></li>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
	var reportCharts = {
		orders: null,
		revenue: null
	};

	function destroyReportCharts() {
		if (reportCharts.orders) {
			reportCharts.orders.destroy();
			reportCharts.orders = null;
		}
		if (reportCharts.revenue) {
			reportCharts.revenue.destroy();
			reportCharts.revenue = null;
		}
	}

	function renderReportCharts() {
		destroyReportCharts();

		var ordersChartDataEl = document.getElementById('ordersChartData');
		var revenueChartDataEl = document.getElementById('revenueChartData');
		if (!ordersChartDataEl || !revenueChartDataEl) {
			return;
		}

		var ordersChartData = JSON.parse(ordersChartDataEl.textContent || '[]');
		var revenueChartData = JSON.parse(revenueChartDataEl.textContent || '[]');

		var ordersLabels = ordersChartData.map(function(item) {
			return item[0];
		});
		var ordersValues = ordersChartData.map(function(item) {
			return item[1];
		});
		var revenueLabels = revenueChartData.map(function(item) {
			return item[0];
		});
		var revenueValues = revenueChartData.map(function(item) {
			return item[1];
		});

		var ordersCtx = document.getElementById('orders-trend-chart');
		if (ordersCtx) {
			reportCharts.orders = new Chart(ordersCtx, {
				type: 'bar',
				data: {
					labels: ordersLabels,
					datasets: [{
						label: 'Đơn hàng',
						data: ordersValues,
						backgroundColor: 'rgba(54, 162, 235, 0.55)',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1,
						borderRadius: 6,
						maxBarThickness: 36
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
						x: { ticks: { color: '#555' }, grid: { display: false } },
						y: { beginAtZero: true, ticks: { color: '#555', precision: 0 }, grid: { color: 'rgba(0,0,0,0.05)' } }
					}
				}
			});
		}

		var revenueCtx = document.getElementById('revenue-trend-chart');
		if (revenueCtx) {
			reportCharts.revenue = new Chart(revenueCtx, {
				type: 'line',
				data: {
					labels: revenueLabels,
					datasets: [{
						label: 'Doanh thu',
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
						x: { ticks: { color: '#555' }, grid: { display: false } },
						y: { beginAtZero: true, ticks: { color: '#555', callback: function(value) { return value.toLocaleString(); } }, grid: { color: 'rgba(0,0,0,0.05)' } }
					}
				}
			});
		}
	}

	$(function () {
		function loadReport(type) {
			$('#reportContent').html('<div class="text-center" style="padding: 40px;"><i class="fa fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>');
			$.ajax({
				url: '<?=base_url('/admin/report/load.html')?>',
				type: 'GET',
				data: { type: type },
				success: function (html) {
					$('#reportContent').html(html);
					renderReportCharts();
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
