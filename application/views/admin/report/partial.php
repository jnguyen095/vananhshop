<h3 class="box-title"><?=htmlspecialchars($title, ENT_QUOTES, 'UTF-8')?></h3>
<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Đơn hàng</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-sm-6 col-xs-6">
						<h4><?=htmlspecialchars($orders['current_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($orders['current_value'], 0, ',', '.')?></p>
					</div>
					<div class="col-sm-6 col-xs-6">
						<h4><?=htmlspecialchars($orders['previous_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($orders['previous_value'], 0, ',', '.')?></p>
					</div>
				</div>
				<div class="alert alert-<?=htmlspecialchars($orders['trend_class'], ENT_QUOTES, 'UTF-8') ?>">
					<strong><?=htmlspecialchars($orders['trend_label'], ENT_QUOTES, 'UTF-8')?></strong>: <?=htmlspecialchars($orders['comparison_text'], ENT_QUOTES, 'UTF-8')?>
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
				<div class="row">
					<div class="col-sm-6 col-xs-6">
						<h4><?=htmlspecialchars($revenue['current_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($revenue['current_value'], 0, ',', '.')?> đ</p>
					</div>
					<div class="col-sm-6 col-xs-6">
						<h4><?=htmlspecialchars($revenue['previous_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($revenue['previous_value'], 0, ',', '.')?> đ</p>
					</div>
				</div>
				<div class="alert alert-<?=htmlspecialchars($revenue['trend_class'], ENT_QUOTES, 'UTF-8') ?>">
					<strong><?=htmlspecialchars($revenue['trend_label'], ENT_QUOTES, 'UTF-8')?></strong>: <?=htmlspecialchars($revenue['comparison_text'], ENT_QUOTES, 'UTF-8')?>
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
				<div class="row">
					<div class="col-sm-6 col-xs-6">
						<h4><?=htmlspecialchars($new_users['current_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($new_users['current_value'], 0, ',', '.')?></p>
					</div>
					<div class="col-sm-6 col-xs-6">
						<h4><?=htmlspecialchars($new_users['previous_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($new_users['previous_value'], 0, ',', '.')?></p>
					</div>
				</div>
				<div class="alert alert-<?=htmlspecialchars($new_users['trend_class'], ENT_QUOTES, 'UTF-8') ?>">
					<strong><?=htmlspecialchars($new_users['trend_label'], ENT_QUOTES, 'UTF-8')?></strong>: <?=htmlspecialchars($new_users['comparison_text'], ENT_QUOTES, 'UTF-8')?>
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
				<div class="row">
					<div class="col-sm-6 col-xs-6">
						<h4><?=htmlspecialchars($repeat_buyers['current_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($repeat_buyers['current_value'], 0, ',', '.')?></p>
					</div>
					<div class="col-sm-6 col-xs-6">
						<h4><?=htmlspecialchars($repeat_buyers['previous_label'], ENT_QUOTES, 'UTF-8')?></h4>
						<p class="lead"><?=number_format($repeat_buyers['previous_value'], 0, ',', '.')?></p>
					</div>
				</div>
				<div class="alert alert-<?=htmlspecialchars($repeat_buyers['trend_class'], ENT_QUOTES, 'UTF-8') ?>">
					<strong><?=htmlspecialchars($repeat_buyers['trend_label'], ENT_QUOTES, 'UTF-8')?></strong>: <?=htmlspecialchars($repeat_buyers['comparison_text'], ENT_QUOTES, 'UTF-8')?>
				</div>
			</div>
		</div>
	</div>
</div>
