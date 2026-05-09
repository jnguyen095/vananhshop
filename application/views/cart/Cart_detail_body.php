<?php foreach ($this->cart->contents() as $item){?>
	<tr>
		<td class="text-center">
			<a href="<?=base_url().seo_url($item['name']).'-p'.$item['id']?>.html">
				<img src="<?=base_url($item['image'])?>" alt="<?=$item['name']?>" title="<?=$item['name']?>" class="img-thumbnail">
			</a>
		</td>
		<td class="text-left">
			<a href="<?=base_url().seo_url($item['name']).'-p'.$item['id']?>.html"><?=$item['name']?></a>
			<?php if($this->cart->has_options($item['rowid']) == TRUE){
				echo "<br>";
				foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
					$i = 1;
					foreach ($option_value as $k => $v){ ?>
						<i><small><?=$v?></small></i>
						<?=$i == 1 ? ':' : ''?>
						<?php
						$i++;
					}
					echo "</br>";
				}
			}?>

		</td>
		<td class="text-left"><?=number_format($item['qty'])?></td>
		<td class="text-right"><?=number_format($item['price'])?></td>
		<td class="text-right"><?=number_format($item['price'] * $item['qty'])?></td>
	</tr>
<?php } ?>
<tr>
	<td class="text-right" colspan="4">Phí giao hàng</td>
	<td class="text-right">-</td>
</tr>
<tr>
	<td class="text-right" colspan="4">Tổng cộng</td>
	<td class="text-right"><?=number_format($this->cart->total())?>(VNĐ)</td>
</tr>
