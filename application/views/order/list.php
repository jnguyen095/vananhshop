<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/9/2017
 * Time: 2:19 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
	<head>
		<meta charset = "utf-8">
		<title>Vân Anh Shop | Quản Lý Đơn Hàng</title>
		<?php $this->load->view('common_header')?>
		<script src="<?= base_url('/js/homeland.js') ?>"></script>
		<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
		<?php $this->load->view('/common/googleadsense')?>
</head>
</head>
<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid">
	<?php $this->load->view('/theme/header')?>

	<div class="container no-padding">
		<?php $this->load->view('/common/user-menu')?>

		<div class="row no-margin">
			<div class="col-lg-12 col-sm-12">
				<div>
					<div class="float-left h2title">Quản lý đơn hàng</div>
					<div class="clear-both"></div>
				</div>
				<hr/>

				<?php if(!empty($message_response)){
					echo '<div class="alert alert-success">';
					echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
					echo $message_response;
					echo '</div>';
				}?>

				<?php
				$attributes = array("id" => "frmOrder");
				echo form_open("quan-ly-don-hang", $attributes);
				?>
				<!-- content -->
				<div class="col-md-12 no-margin no-padding text-center table-responsive">
					<table class="table table-bordered table-hover table-striped">
						<thead class="thead-table">
							<tr class="bg-info">
								<th class="text-center">#</th>
								<th class="text-center">Mã Đơn Hàng</th>
								<th class="text-center">Ngày mua</th>
								<th class="text-center">Số lượng</th>
								<th class="text-center">Tổng cộng</th>
								<th class="text-center">Tình trạng</th>
								<th class="text-center">Chỉnh sửa</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if(count($orders) < 1) {
							?>
						<tr>
							<td colspan="10">Chưa có đơn hàng nào, <a href="<?=base_url('/')?>" class="btn btn-info">Mua Hàng</a>. </td>
						</tr>
							<?php
						}
						?>
						<?php
							$counter = 1;
							foreach ($orders as $order) {
								?>
								<tr>
									<th scope="row"><?=$counter++?>.</th>
									<td><a href="<?=base_url('/don-hang-' . $order->OrderID . '.html')?>"><?=$order->Code?></a></td>
									<td>
										<?php
										$datestring = '%d/%m/%Y %H:%i';
										echo mdate($datestring, strtotime($order->CreatedDate));
										?>
									</td>
									<td><?=number_format($order->TotalItems)?></td>
									<td><?=number_format($order->TotalPrice)?></td>
									<td>
										<?php
										if($order->Status == ORDER_STATUS_NEW){
											echo '<span class="label label-primary">Chờ xác nhận</span>';
										} else if($order->Status == ORDER_STATUS_CANCEL){
											echo '<span class="label label-danger">Đã hủy</span>';
										} else if($order->Status == ORDER_STATUS_CONFIRM){
											echo '<span class="label label-info">Chờ giao hàng</span>';
										} else if($order->Status == ORDER_STATUS_SHIPPING){
											echo '<span class="label label-warning">Đang giao hàng</span>';
										} else if($order->Status == ORDER_STATUS_COMPLETED){
											echo '<span class="label label-default">Đã giao</span>';
										}
										?>
									</td>
									<td class="mobile-hide">
										<a data-toggle="tooltip" title="Xem chi tiết đơn hàng" href="<?=base_url('/don-hang-' . $order->OrderID . '.html')?>"><i class="glyphicon glyphicon-info-sign"></i></a>
										<?php
										if($order->Status == ORDER_STATUS_NEW) {
											?>
											&nbsp;|&nbsp;<a data-toggle="tooltip" title="Hủy đơn hàng" href="javascript:void(0);" style="text-decoration: none" onclick="cancelOrder('<?= $order->OrderID ?>')">
												<i class="glyphicon glyphicon-remove-circle text-danger"></i>
											</a>
											<?php
										}else{
											?>
											&nbsp;|&nbsp;<a data-toggle="tooltip" title="Không được hủy đơn hàng" style="cursor: not-allowed;text-decoration: none" disabled href="javascript:void(0);" >
												<i disabled="true" class="glyphicon glyphicon-remove-circle text-warning "></i>
											</a>
											<?php
										}
										?>
									</td>
								</tr>
								<?php
							}
						?>
						</tbody>
					</table>
					<div class="row text-center no-margin">
						<?php if (isset($pagination)) echo $pagination; ?>
					</div>


				</div>
				<!-- end content -->
				<input type="hidden" id="crudaction" name="crudaction">
				<input type="hidden" id="orderId" name="orderId">
				<?php echo form_close(); ?>

				<div class="clear-both"></div>
			</div>
		</div>
	</div>

	<?php $this->load->view('/theme/footer')?>
</div>

</body>
</html>
