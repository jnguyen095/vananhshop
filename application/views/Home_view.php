<!DOCTYPE html>
<html lang = "vi">

<head>
	<meta charset="UTF-8">
	<title>Thời Trang, Đồ Lót, Nội Y, Đồ Bộ Mặc Nhà | Vân Anh Shop</title>
	<meta name="description" content="Vân Anh Shop chuyên cung cấp sỉ và lẻ quần lót nữ, áo lót nữ, áo lá học sinh, đồ lót nam chất lượng cao, giá tốt, giao hàng toàn quốc.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="index, follow, max-image-preview:large">
	<link rel="canonical" href="<?php echo rtrim(base_url(), '/'); ?>">

	<meta property="og:locale" content="vi_VN">
	<meta property="og:type" content="website">
	<meta property="og:title" content="Thời Trang, Đồ Lót, Nội Y, Đồ Bộ Mặc Nhà | Vân Anh Shop">
	<meta property="og:description" content="Vân Anh Shop chuyên cung cấp sỉ và lẻ quần lót nữ, áo lót nữ, áo lá học sinh, đồ lót nam chất lượng cao, giá tốt, giao hàng toàn quốc.">
	<meta property="og:url" content="<?php echo rtrim(base_url(), '/'); ?>">
	<meta property="og:site_name" content="Vân Anh Shop">
	<meta property="og:image" content="<?php echo rtrim(base_url(), '/'); ?>/img/vananh-sm-icon.png">
	<meta property="og:image:width" content="152">
	<meta property="og:image:height" content="147">

	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@graph": [
				{
					"@type": "Store",
					"@id": "<?php echo rtrim(base_url(), '/'); ?>",
					"name": "Vân Anh Shop",
					"url": "<?php echo rtrim(base_url(), '/'); ?>",
					"logo": "<?php echo rtrim(base_url(), '/'); ?>/img/vananh_logo.png",
					"image": "<?php echo rtrim(base_url(), '/'); ?>/img/vananh-sm-icon.png",
					"telephone": "0865.053.849",
					"email": "contact@vananhshop.com",
					"priceRange": "$$",
					"address": [
						{
							"@type": "PostalAddress",
							"streetAddress": "C/c 4S, Đường 30, Phường Hiệp Bình",
							"addressLocality": "Thành phố Hồ Chí Minh",
							"addressCountry": "VN"
						},
						{
							"@type": "PostalAddress",
							"streetAddress": "101 Phạm Ngũ Lão",
							"addressLocality": "Buôn Ma Thuột, ĐăkLăk",
							"addressCountry": "VN"
						}
					],
					"sameAs": [
						"https://www.facebook.com/vanhanhshopbmt",
						"http://zalo.me/0865053849"
					]
				},
				{
					"@type": "WebSite",
					"@id": "<?php echo rtrim(base_url(), '/'); ?>",
					"url": "<?php echo rtrim(base_url(), '/'); ?>",
					"name": "Vân Anh Shop",
					"publisher": {
						"@id": "<?php echo rtrim(base_url(), '/'); ?>"
					},
					"potentialAction": {
						"@type": "SearchAction",
						"target": "<?php echo rtrim(base_url(), '/'); ?>/tim-kiem.html?query={search_term_string}",
						"query-input": "required name=search_term_string"
					}
				}
			]
		}
    </script>
	<link rel="icon" sizes="48x48" href="<?=base_url('/img/favicon_va.ico')?>">
	<link rel="stylesheet" href="<?=base_url('/css/jquery.mCustomScrollbar.min.css')?>" />
	<?php $this->load->view('common_header')?>
</head>

<body>

<?php $this->load->view('/common/analyticstracking')?>

<div class="container-fluid no-padding-left no-padding-right">
	<?php $this->load->view('/theme/header')?>

	<div class="container-fluid no-padding-left no-padding-right mobile-hide">
		<div class="row no-margin">
			<div id='carousel-custom' class='carousel slide hot-product' data-interval="5000" data-ride='carousel'>
				<div class='carousel-outer'>
					<ol class="carousel-indicators">
						<?php
						$counter = 0;
						foreach ($topBanners as $banner) {
							?>
							<li data-target="#carousel-custom" data-slide-to="<?=$counter?>" class="<?=$counter == 0 ? 'active' : ''?>"></li>
							<?php
							$counter++;
						}
						?>
					</ol>
					<!-- Wrapper for slides -->
					<div class='carousel-inner'>
						<?php
						$counter = 0;
						foreach ($topBanners as $banner) {
							?>
							<div class="item <?=$counter++ == 0 ? 'active' : ''?>">
								<img style="width: 100%" src="<?=base_url('/img/banner/'.$banner->Image)?>" />
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php foreach ($categoryTree as $catImg) {
					if (count($catImg['nodes']) > 0) {
						?>
						<div class="section-title-container">
							<h4 class="section-title section-title-center">
								<b></b>
								<span class="section-category-main">
									<a href="<?= base_url(seo_url($catImg['CatName'] . '-c' . $catImg['CategoryID']) . '.html') ?>"><?= $catImg['CatName'] ?></a>
								</span>
								<b></b>
							</h4>
						</div>

						<div class='category-head'>
							<ul style="width: <?=count($catImg['nodes'])*225 + 20?>px">
								<?php foreach ($catImg['nodes'] as $item) { ?>
									<li class="category-child">
										<a href="<?= base_url(seo_url($item['CatName'] . '-c' . $item['CategoryID']) . '.html') ?>">
											<div class="cat-wrap text-center"
												 style="background-image: url('<?= base_url('/img/category/' . $item['Image']) ?>');">
												<div class="cat-img"></div>
												<div class="clear-both"></div>
											</div>
											<div class="cat-text"><?= $item['CatName'] ?></div>
										</a>
									</li>
								<?php
								} ?>
							</ul>
						</div>
						<?php
					}
				}
				?>

			</div>


		</div>
		
		<div class="row margin-top-20 mobile-hide">
			<?php
			if(isset($middleBanner)){
				?>
				<img class="middleHorizontalBanner" src="<?=base_url('/img/banner/'.$middleBanner[0]->Image)?>">
			<?php
			}
			?>
		</div>

		<div class="row margin-top-20">
			<div class="section-title-container">
				<h4 class="section-title section-title-center">
					<b></b>
					<span class="section-category-main">
						Sản phẩm mới
					</span>
					<b></b>
				</h4>
			</div>

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
		</div>
	</div>

</div>

<?php $this->load->view('/theme/footer')?>

<!-- SWIPER -->
<script src="<?php echo base_url()?>theme/site/js/swiper-bundle.min.js"></script>
<script src="<?=base_url('/js/jquery.mCustomScrollbar.min.js')?>"></script>
<!-- Custom JS File Link  -->
<!--<script src="--><?php //echo base_url()?><!--theme/site/js/script.js"></script>-->
<script type="text/javascript">
	$(document).ready(function(){
		$('.carousel').carousel();
		$('.category-head').mCustomScrollbar({axis: 'x'});
	});
</script>
</body>

</html>
