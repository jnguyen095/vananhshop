
<?php
foreach ($products as $product) {?>
	<div class="col-sm-3">
		<div class="productItem">
			<div class="col-sm-6 no-padding productImg">
				<img src="<?=base_url('/img/product/').$product->Thumb?>" width="100%"/>
			</div>
			<div class="col-sm-6 no-padding">
				<div class="productName"><?=$product->Title?></div>
				<div>
					<div class="productPrice float-left price"><?=number_format($product->Price)?></div>
					<div class="float-right"><a class="btn btn-sm btn-primary add2Cart" onclick="add2Cart(<?=$product->ProductID?>, '<?=$tabID?>')"><i class="icon glyphicon-plus"></i></a></div>
					<div class="clear-both"></div>
				</div>
			</div>
		</div>
	</div>
<?php }
?>
