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
