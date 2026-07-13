<?php
$renderTrendBadge = function ($metric) {
	$icon = '<i class="fa fa-minus-circle"></i>';
	$class = 'label label-default';
	$text = 'Không đổi';
	if ($metric['difference'] > 0) {
		$icon = '<i class="fa fa-arrow-up"></i>';
		$class = 'label label-success';
		$text = 'Tăng ' . abs($metric['percentage']) . '%';
	} elseif ($metric['difference'] < 0) {
		$icon = '<i class="fa fa-arrow-down"></i>';
		$class = 'label label-danger';
		$text = 'Giảm ' . abs($metric['percentage']) . '%';
	}
	return '<span class="' . $class . '">' . $icon . ' ' . $text . '</span>';
};
?>

<h3 class="box-title"><?=htmlspecialchars($title, ENT_QUOTES, 'UTF-8')?></h3>
<div class="row">
	<div class="col-md-6">
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title"><?=( $period === 'month' ? 'Đơn hàng 6 tháng qua' : 'Đơn hàng 7 ngày qua' )?></h3>
			</div>
			<div class="box-body">
				<div class="chart-responsive" style="position: relative; height:240px;">
					<canvas id="orders-trend-chart"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title"><?=( $period === 'month' ? 'Doanh thu 6 tháng qua' : 'Doanh thu 7 ngày qua' )?></h3>
			</div>
			<div class="box-body">
				<div class="chart-responsive" style="position: relative; height:240px;">
					<canvas id="revenue-trend-chart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="application/json" id="ordersChartData"><?=json_encode($ordersChartData)?></script>
<script type="application/json" id="revenueChartData"><?=json_encode($revenueChartData)?></script>

