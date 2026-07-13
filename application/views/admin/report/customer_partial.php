<div class="row">
	<div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Phân bố khách mua lại</h3>
			</div>
			<div class="box-body">
				<div style="height: 320px;">
					<canvas id="repeat-purchase-chart"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">Phân bố đơn hàng theo thành phố</h3>
			</div>
			<div class="box-body">
				<div style="height: 320px;">
					<canvas id="city-purchase-chart"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Top 5 khách hàng tiềm năng</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Tên khách</th>
								<th>Số điện thoại</th>
								<th>Số lần mua</th>
								<th>Tổng giá trị</th>
								<th>Lần mua gần nhất</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($potential_customers)): ?>
								<?php foreach ($potential_customers as $customer): ?>
									<tr>
										<td><?=htmlspecialchars($customer['customer_name'], ENT_QUOTES, 'UTF-8')?></td>
										<td><?=htmlspecialchars($customer['phone'], ENT_QUOTES, 'UTF-8')?></td>
										<td><?=number_format($customer['order_count'], 0, ',', '.')?></td>
										<td><?=number_format($customer['total_value'], 0, ',', '.')?> đ</td>
										<td><?=htmlspecialchars(!empty($customer['last_purchase']) ? date('d/m/Y H:i', strtotime($customer['last_purchase'])) : '-', ENT_QUOTES, 'UTF-8')?></td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Top 5 khách hàng mua hàng nhiều nhất</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Tên khách</th>
								<th>Số điện thoại</th>
								<th>Số lần mua</th>
								<th>Tổng giá trị</th>
								<th>Lần mua gần nhất</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($frequent_buyers)): ?>
								<?php foreach ($frequent_buyers as $customer): ?>
									<tr>
										<td><?=htmlspecialchars($customer['customer_name'], ENT_QUOTES, 'UTF-8')?></td>
										<td><?=htmlspecialchars($customer['phone'], ENT_QUOTES, 'UTF-8')?></td>
										<td><?=number_format($customer['order_count'], 0, ',', '.')?></td>
										<td><?=number_format($customer['total_value'], 0, ',', '.')?> đ</td>
										<td><?=htmlspecialchars($customer['last_purchase'] ? date('d/m/Y H:i', strtotime($customer['last_purchase'])) : '-', ENT_QUOTES, 'UTF-8')?></td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		var repeatChartData = <?=json_encode($repeat_purchase_chart)?>;
		var repeatLabels = repeatChartData.labels || [];
		var repeatValues = repeatChartData.values || [];

		if (repeatLabels.length && repeatValues.length) {
			var repeatCtx = document.getElementById('repeat-purchase-chart').getContext('2d');
			new Chart(repeatCtx, {
				type: 'pie',
				data: {
					labels: repeatLabels,
					datasets: [{
						data: repeatValues,
						backgroundColor: [
							'#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF',
							'#FF9F40', '#C9CBCF', '#66BB6A', '#8D6E63', '#AB47BC'
						],
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						legend: { position: 'bottom' }
					}
				}
			});
		}

		var cityChartData = <?=json_encode($city_purchase_chart)?>;
		var cityLabels = cityChartData.labels || [];
		var cityValues = cityChartData.values || [];

		if (cityLabels.length && cityValues.length) {
			var cityCtx = document.getElementById('city-purchase-chart').getContext('2d');
			new Chart(cityCtx, {
				type: 'pie',
				data: {
					labels: cityLabels,
					datasets: [{
						data: cityValues,
						backgroundColor: [
							'#4BC0C0', '#FF6384', '#36A2EB', '#FFCE56', '#9966FF',
							'#66BB6A', '#8D6E63', '#AB47BC', '#C9CBCF', '#FF9F40'
						],
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					plugins: {
						legend: { position: 'bottom' }
					}
				}
			});
		}
	});
</script>
