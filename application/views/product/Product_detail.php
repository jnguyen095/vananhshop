<!DOCTYPE html>
<html lang = "en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?=$product->Title?>">
	<meta name="keywords" content="<?=keyword_maker($product->Title)?>">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="follow" />
	<title><?php echo $product->Title?> | Vân Anh Shop</title>
	<?php $this->load->view('common_header')?>
	<link rel="stylesheet" href="<?=base_url('/css/jquery.mCustomScrollbar.min.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
	<link rel="stylesheet" href="<?=base_url('/css/carousel-custom.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/magnific-popup.css')?>" />
	<script src="<?=base_url('/js/jquery.mCustomScrollbar.min.js')?>"></script>

</head>

<body>

<?php $this->load->view('/common/analyticstracking')?>

<div class="container-fluid productDetailPage no-padding-left no-padding-right">
<?php $this->load->view('/theme/header')?>

	<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb always">
		<div class="container">
		<?php
			$position = 1;
			if(isset($category->Parent)){
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.base_url().seo_url($category->Parent->CatName).'-c'.$category->Parent->CategoryID.'.html"><span itemprop="name">'.$category->Parent->CatName.'</span></a><meta itemprop="position" content="'.$position++.'" /></li>';
			}
		?>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo base_url().seo_url($category->CatName).'-c'.$category->CategoryID?>.html"><span itemprop="name"><?php echo $category->CatName?></span></a><meta itemprop="position" content="<?=$position++?>" /></li>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active mobile-hide"><span itemprop="item"><span itemprop="name"><?php echo $product->Title?></span></span><meta itemprop="position" content="<?=$position++?>" /></li>
		</div>
	</ul>
	
	<div class="container">
	<div class="row margin-bottom-20 margin-top-20">
		<div class="col-lg-6">
				<?php
				if(count($product->Assets) > 0){
					?>
					<div class="thumbnails thumbnail-scroll">
						<ul class="popup-gallery">
						<?php foreach ($product->Assets as $asset) {
						?>
							<li class="thumbnail"> <a href="<?php echo base_url(str_replace('_thumb', '', $asset->Url))?>" class="image-link" title="<?=$product->Title?>"> <img  src="<?php echo base_url($asset->Url)?>"?></a></li>
						<?php
						}
						?>
						</ul>
					</div>
				<?php
				}
				?>
			<div class="main-image">
				<img src="<?=base_url(str_replace('_thumb', '', $product->Thumb))?>" class="img-responsive-large" >
			</div>
			<div class="clear-both"></div>
		</div>
		<div class="col-lg-6">
			<div class="product-title">
				<h1 class="h1Class" itemprop="name"><?php echo $product->Title?></h1>
			</div>
			<div class="product-price">
				<p class="price"><?=number_format($product->Price)?>đ</p>
			</div>
			<div class="product-property">
				<?php
				foreach ($product->Properties as $k => $v){
					?>
					<div class="product-property-group">
						<div class="property-name"><?=($k)?></div>
					<?php
					$i = 1;
					foreach ($v as $property){
						?>
						<div class="property-item">
							<label class="radio"><input type="radio" <?= $i==1? 'checked': '' ?> name="property[<?=$property['ParentID']?>]" parent="<?=$k?>" value="<?=$property['Name']?>"> <?=$property['Name']?></label>
						</div>
					<?php
						$i++;
					}
					?>
					</div>
					<?php
				}
				?>
				<div class="clear-both"></div>
			</div>
			<div class="row margin-top-20">
				<div class="col-lg-12 inline-btns">
					<label class="form-check-label" for="inlineFormCheck">
						Số lượng:
					</label>
					<form class="inde-value">
						<div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
						<input type="number" id="quantity" name="quantity" value="1" class="form-control"/>
						<div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
					</form>
					<a id="btnBuy" productId="<?=$product->ProductID?>" href="#" class="btn btn-primary buyableBtn">Thêm Vào Giỏ Hàng</a>
				</div>
			</div>

			<div class="row productDetails">
				<?=$product->Brief?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="product-detail">
				<?=$product->Description?>
			</div>
		</div>
	</div>



	<div class="overlay" style="display: none"><img src="<?=base_url('/img/spinner.gif')?>"/></div>

		<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
		<script src="<?=base_url('/js/jquery.magnific-popup.min.js')?>"></script>
	</div>
</div>

<?php $this->load->view('/theme/footer')?>

<script type="text/javascript">
	$(document).ready(function() {
		
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
		$('.popup-gallery').magnificPopup({
			delegate: 'a',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
			},
			image: {
				tError: 'could not be loaded.',
				titleSrc: function (item) {
					return item.el.attr('title');
				}
			}
		});

		$('.thumbnail-scroll').mCustomScrollbar({axis: 'y'});
	});
</script>

</body>

</html>
