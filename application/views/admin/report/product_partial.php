<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Top 5 sản phẩm được đặt nhiều nhất</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
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
	</div>
	<div class="col-md-6">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Top 5 sản phẩm có lượt xem cao nhất</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
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
</div>
