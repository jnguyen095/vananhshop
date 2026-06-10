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
		<title>Theo Dõi Đơn Hàng | Vân Anh Shop</title>
		<?php $this->load->view('common_header')?>
		<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
		<?php $this->load->view('/common/googleadsense')?>
</head>
</head>
<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid no-padding-left no-padding-right">
	<?php $this->load->view('/theme/header')?>
	<div class="col-lg-12 col-sm-12 no-padding-left no-padding-right">
		<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb always">
			<div class="container">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo base_url('/')?>"><span itemprop="name">Trang chủ</span></a></li>
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name">Đơn hàng</span></span></li>
			</div>
		</ul>
	</div>


	<div class="container">
		<div class="row no-margin">
			<div class="col-lg-12 col-sm-12">
				<div class="row">
					<div class="h2title col-lg-6 col-sm-12">Theo dõi đơn hàng</div>
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
				$attributes = array("id" => "frmCheckingOrder");
				echo form_open("theo-doi-don-hang", $attributes);
				?>
				<!-- content -->
				<div class="row">
					<div class="col-lg-12 text-right check-order">
						<a id="btnChecking" class="btn btn-primary float-right"><i class="glyphicon glyphicon-search"></i> Tìm Kiếm</a>
						<input class="form-control" name="txtText" placeholder="Mã đơn hàng/Số ĐT" value="<?=isset($txtText) ? $txtText : ''?>">
						<span class="text-danger"><?php echo form_error('txtText'); ?></span>
						<div class="clear-both"></div>
					</div>
					<div class="clear-both"></div>
				</div>
				<div class="col-md-12 no-margin no-padding text-center table-responsive margin-bottom-20">
					<table class="table table-bordered table-hover table-striped">
						<thead class="thead-table">
							<tr class="bg-info">
								<th class="text-center">#</th>
								<th class="text-center">Mã Đơn Hàng</th>
								<th class="text-center">Tình trạng</th>
								<th class="text-center">Ngày mua</th>
								<th class="text-center">Số lượng</th>
								<th class="text-center">Tổng cộng</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if(count($orders) < 1) {
							?>
						<tr>
							<td colspan="10"><?=(!isset($txtText) || empty($txtText))? '<i>Hãy nhập mã đơn hàng hoặc số điện thoại để tìm đơn hàng!</i>' : '<span class="text-danger">Không tìm thấy đơn hàng nào.</span>' ?></td>
						</tr>
							<?php
						}
						?>
						<?php
							$counter = 1;
							foreach ($orders as $order) {
								?>
								<tr>
									<td scope="row"><?=$counter++?>.</td>
									<td><a href="<?=base_url('/don-hang-' . $order->OrderID . '.html')?>"><?=$order->Code?></a></td>
									<td>
										<?php
										if($order->Status == ORDER_STATUS_NEW){
											echo '<span class="label label-primary">Chờ xác nhận</span>';
										} else if($order->Status == ORDER_STATUS_CANCELLED){
											echo '<span class="label label-danger">Đã hủy</span>';
										} else if($order->Status == ORDER_STATUS_CONFIRM){
											echo '<span class="label label-info">Chờ giao hàng</span>';
										} else if($order->Status == ORDER_STATUS_SHIPPING){
											echo '<span class="label label-warning">Đang giao hàng</span>';
										} else if($order->Status == ORDER_STATUS_COMPLETED){
											echo '<span class="label label-success">Đã giao</span>';
										}
										?>
									</td>
									<td>
										<?php
										$datestring = '%d/%m/%Y %H:%i';
										echo mdate($datestring, strtotime($order->CreatedDate));
										?>
									</td>
									<td><?=number_format($order->TotalItems)?></td>
									<td><?=number_format($order->TotalPrice)?></td>
								</tr>
								<?php
							}
						?>
						</tbody>
					</table>

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
	<script>
		$(document).ready(function(){
			$("#btnChecking").click(function(){
				$("#frmCheckingOrder").submit();
			})
		});
	</script>
</div>

</body>
</html>
