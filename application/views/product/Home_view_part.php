<?php
foreach ($products as $product){?>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
		<div class="product-thumb transition">
			<div class="image">
				<a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><img src="<?=base_url($product->Thumb)?>" class="img-responsive" ></a>
			</div>
			<div class="caption">
				<h3><a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><?=$product->Title?></a></h3>
				<h4><?=substr_at_middle($product->Brief, 200)?></h4>
			</div>
			<div class="button-group">
				<div class="button"><p class="price"><?=number_format($product->Price)?>đ</p></div>
				<a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><i class="glyphicon glyphicon-shopping-cart"></i> Mua<b class="mobile-hide"> Hàng</b> </a>
			</div>
		</div>
	</div>
<?php
}
?>
