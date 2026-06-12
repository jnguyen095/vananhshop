<?php foreach ($details as $item){?>
	<tr>
		<td class="text-center">
			<a href="<?=base_url().seo_url($item->ProductName).'-p'.$item->ProductID?>.html">
				<img src="<?=base_url($item->Thumb)?>" alt="<?=$item->ProductName?>" title="<?=$item->ProductName?>" class="img-thumbnail checkout-imgs">
			</a>
		</td>
		<td class="text-left">
			<a href="<?=base_url().seo_url($item->ProductName).'-p'.$item->ProductID?>.html"><?=$item->ProductName?></a>
		</td>
		<td class="text-left"><?=number_format($item->Quantity)?></td>
		<td class="text-right"><?=number_format($item->OfferPrice)?></td>
		<td class="text-right"><?=number_format($item->OfferPrice * $item->Quantity)?></td>
	</tr>
<?php } ?>
<tr>
	<td class="text-right" colspan="4">Phí giao hàng</td>
	<td class="text-right"><?=number_format($quote->ShippingFee)?></td>
</tr>
<tr>
	<td class="text-right" colspan="4" >Giảm giá</td>
	<td class="text-right" id="discountAmount"><?=number_format($quote->Discount)?></td>
</tr>
<tr>
	<td class="text-right" colspan="4">Tổng cộng</td>
	<td class="text-right"><strong id="totalPrice"><?=number_format($quote->TotalPrice)?></strong>(VNĐ)</td>
</tr>
