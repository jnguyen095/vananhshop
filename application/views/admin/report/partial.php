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
<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Đơn hàng</h3>
			</div>
			<div class="box-body">
				<div class="row text-center">
					<div class="col-sm-4 col-xs-4">
						<h4><?=htmlspecialchars($orders['current_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($orders['current_value'], 0, ',', '.')?></p>
					</div>
					<div class="col-sm-4 col-xs-4">
						<h4><?=htmlspecialchars($orders['previous_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($orders['previous_value'], 0, ',', '.')?></p>
					</div>
					<div class="col-sm-4 col-xs-4">
						<h4>Xu hướng</h4>
						<p class="lead"><?= $renderTrendBadge($orders) ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Doanh thu</h3>
			</div>
			<div class="box-body">
				<div class="row text-center">
					<div class="col-sm-4 col-xs-4">
						<h4><?=htmlspecialchars($revenue['current_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($revenue['current_value'], 0, ',', '.')?> đ</p>
					</div>
					<div class="col-sm-4 col-xs-4">
						<h4><?=htmlspecialchars($revenue['previous_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($revenue['previous_value'], 0, ',', '.')?> đ</p>
					</div>
					<div class="col-sm-4 col-xs-4">
						<h4>Xu hướng</h4>
						<p class="lead"><?= $renderTrendBadge($revenue) ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">User mới</h3>
			</div>
			<div class="box-body">
				<div class="row text-center">
					<div class="col-sm-4 col-xs-4">
						<h4><?=htmlspecialchars($new_users['current_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($new_users['current_value'], 0, ',', '.')?></p>
					</div>
					<div class="col-sm-4 col-xs-4">
						<h4><?=htmlspecialchars($new_users['previous_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($new_users['previous_value'], 0, ',', '.')?></p>
					</div>
					<div class="col-sm-4 col-xs-4">
						<h4>Xu hướng</h4>
						<p class="lead"><?= $renderTrendBadge($new_users) ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">Người mua lại</h3>
			</div>
			<div class="box-body">
				<div class="row text-center">
					<div class="col-sm-4 col-xs-4">
						<h4><?=htmlspecialchars($repeat_buyers['current_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($repeat_buyers['current_value'], 0, ',', '.')?></p>
					</div>
					<div class="col-sm-4 col-xs-4">
						<h4><?=htmlspecialchars($repeat_buyers['previous_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($repeat_buyers['previous_value'], 0, ',', '.')?></p>
					</div>
					<div class="col-sm-4 col-xs-4">
						<h4>Xu hướng</h4>
						<p class="lead"><?= $renderTrendBadge($repeat_buyers) ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
