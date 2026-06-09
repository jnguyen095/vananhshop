<!DOCTYPE html>
<html lang = "vi">

<head>
	<title><?php echo $category->CatName?> | Vân Anh Shop</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?=$category->CatName?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="<?=base_url().seo_url($category->CatName).'-c'.($category->CategoryID).'.html'?>" />

	<meta property="og:type" content="object">
	<meta property="og:title" content="<?php echo $category->CatName?> | Vân Anh Shop">
	<meta property="og:description" content="<?php echo $category->CatName?> | Vân Anh Shop">
	<meta property="og:url" content="<?=base_url().seo_url($category->CatName).'-c'.($category->CategoryID).'.html'?>">
	<meta property="og:image" content="<?=base_url('/img/category/'.$category->Image)?>">

	<?php $this->load->view('common_header')?>
	<?php $this->load->view('/common/googleadsense')?>
	<?php $this->load->view('/common/facebook-pixel-tracking')?>
</head>

<body>

<?php $this->load->view('/common/analyticstracking')?>

<div class="container-fluid no-padding-left no-padding-right">

<?php $this->load->view('/theme/header')?>

	<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb">
		<div class="container">
		<?php
			$position = 1;
			if(isset($category->Parent)){
				echo '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="'.base_url().seo_url($category->Parent->CatName).'-c'.$category->Parent->CategoryID.'.html"><span itemprop="name">'.$category->Parent->CatName.'</span></a><meta itemprop="position" content="'.$position++.'" /></li>';
			}
		?>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name"><?php echo $category->CatName?></span></span><meta itemprop="position" content="<?=$position++?>" /></li>
		<?php $this->load->view('/common/quick-search')?>
		</div>
	</ul>

	<div class="container">

	<div class="row">
		<?php
		if(isset($category->Banner) && !empty($category->Banner)){
			?>
		<div class="col-md-12 no-margin no-padding">
			<img class="cat-image" src="<?=base_url('/img/category/'.$category->Banner)?>"/>
		</div>
		<?php
		} else if(isset($category->Parent->Banner) && !empty($category->Parent->Banner)){
			?>
			<div class="col-md-12 no-margin no-padding">
				<img class="cat-image" src="<?=base_url('/img/category/'.$category->Parent->Banner)?>"/>
			</div>
			<?php
		}
		?>

		<div class="col-md-12">
			<div class="collections">
				<ul class="ul-cate-collections">
					<?php
					if(isset($sameLevels) && count($sameLevels) > 0){
						foreach ($sameLevels as $level){
							echo '<li><a href="'.base_url().seo_url($level->CatName).'-c'.$level->CategoryID.'.html">';
							if(empty($level->Image)){
								echo '<div class="sub-cat-img"><img src="'.base_url('/img/no_image.webp').'" class="img-responsive" alt="'.$level->CatName.'"></div>';
							}else{
								echo '<div class="sub-cat-img"><img src="'.base_url('/img/category/'.$level->Image).'" class="img-responsive" alt="'.$level->CatName.'"></div>';
							}
							echo '<p class="sub-cat-name">'.$level->CatName.'</p>';
							echo '</a></li>';
						}
					}
					?>
					<div class="clear-both"></div>
				</ul>
			</div>
			

			<div class="product-panel col-md-12  no-margin no-padding">
				<?php
				if(count($products) < 1){
					?>
					<div class="col-lg-12 alert alert-warning" role="alert">
						Sản phẩm đang trong quá trình cập nhật, quý khách vui lòng quay lại sau.
					</div>
					<?php
				}
				?>

				<div class="row">
					<?php
					$schema_items = array();
					$position = 1;
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
									<a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><i class="glyphicon glyphicon-shopping-cart"></i>  Mua<b class="mobile-hide"> Hàng</b></a>
								</div>
							</div>
						</div>
						<?php
						$schema_items[] = array(
							"@type" => "ListItem",
							"position" => $position,
							"url" => base_url().seo_url($product->Title).'-p'.$product->ProductID.'.html',
							"name" => htmlspecialchars($product->Title, ENT_QUOTES, 'UTF-8')
						);
						$position++;
					}
					?>
				</div>
				<div class="row text-center">
					<?php echo $pagination ?>
				</div>
			</div>

		</div>
	</div>
</div>

<?php if (!empty($schema_items)): ?>
	<script type="application/ld+json">
	{
	  "@context": "https://schema.org",
	  "@type": "ItemList",
	  "numberOfItems": <?php echo count($schema_items); ?>,
	  "itemListElement": <?php echo json_encode($schema_items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
	}
	</script>
<?php endif; ?>

</div>

<?php $this->load->view('/theme/footer')?>

</body>

</html>
