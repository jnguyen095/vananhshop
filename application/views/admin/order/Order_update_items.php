<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 11/18/2017
 * Time: 6:16 PM
 */
?>
<?php
$attributes = array("id" => "frmUpdateOrderItems");
echo form_open("admin/order/update-".$data['OrderID'], $attributes);
?>
<table class="table">
	<caption>Danh sách hàng hóa:</caption>
	<thead>
	<tr>
		<th scope="col" class="col-lg-1">Mã hàng</th>
		<th scope="col">Sản phẩm</th>
		<th scope="col" class="col-lg-1">SL</th>
		<th scope="col" class="col-lg-2">Đơn giá</th>
		<th scope="col" class="col-lg-2">Thành tiền</th>
		<th scope="col" class="col-lg-1">Xóa</th>
	</tr>
	</thead>
	<tbody>
<?php foreach ($data['OrderItems'] as $item){
	?>
	<tr id="row-<?=$item['ProductID']?>" class="<?=$item['Remove'] == 'YES' ? 'bg-danger' : ''?>">
		<td><?=$item['ProductCode']?></td>
		<td><a href="<?=base_url().seo_url($item['ProductName']).'-p'.$item['ProductID']?>.html" target="_blank"><?=$item['ProductName']?></a></td>
		<td><input type="number" name="Quantity" data-productid="<?=$item['ProductID']?>" class="form-control onblurEventHandling" value="<?=$item['Quantity']?>"/></td>
		<td><?=number_format($item['Price'])?></td>
		<td><?=number_format($item['Subtotal'])?></td>
		<td>
			<input type="hidden" name="OrderItems[<?=$item['ProductID']?>][ProductName]" value="<?=$item['ProductName']?>"/>
			<input type="hidden" name="OrderItems[<?=$item['ProductID']?>][ProductCode]" value="<?=$item['ProductCode']?>"/>
			<input type="hidden" name="OrderItems[<?=$item['ProductID']?>][ProductID]" value="<?=$item['ProductID']?>"/>
			<input type="hidden" name="OrderItems[<?=$item['ProductID']?>][Remove]" value="NO"/>
			<a class="btnRemovePrItem" title="Xóa sản phẩm này" data-toggle="title" data-prid="<?=$item['ProductID']?>">
				<?php
				if($item['Remove'] == 'NO') {
					?>
					<i class="glyphicon glyphicon-trash"></i>
					<?php
				} else {
				?>
					<i class="glyphicon glyphicon-refresh"></i>
					<?php
				}
				?>
			</a>
		</td>
	</tr>
<?php
}
?>
	<tr>
		<td colspan="4" class="text-right">Phí giao hàng</td>
		<td><input class="form-control onblurEventHandling" name="ShippingFee" value="<?=$data['ShippingFee']?>"/></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4" class="text-right">Giảm giá</td>
		<td><input class="form-control onblurEventHandling" name="Discount" value="<?=$data['Discount']?>"/></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4" class="text-right">Tổng cộng</td>
		<td><b><?=number_format($data['TotalPrice'])?></b></td>
		<td></td>
	</tr>
	</tbody>
</table>
<input type="hidden" id="crudaction" name="orderId" value="<?=$data['OrderID']?>">
<?php echo form_close(); ?>
<script type="text/javascript">
	$(document).ready(function() {
	});
</script>
