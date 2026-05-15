<!DOCTYPE html>
<html lang = "en">

<head>
	<title>Vân Anh Shop - Thời Trang, Đồ Lót, Nội Y, Đồ Bộ Mặc Nhà</title>
	<link rel="icon" sizes="48x48" href="<?=base_url('/img/favicon_va.ico')?>">

	<?php $this->load->view('common_header')?>
</head>

<body>

<?php $this->load->view('/common/analyticstracking')?>

<div class="container-fluid no-padding-left no-padding-right">
	<?php $this->load->view('/theme/header')?>

	<div class="container-fluid no-padding-left no-padding-right">
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
								<img style="height: 400px; width: 100%" src="<?=base_url('/img/banner/'.$banner->Image)?>" />
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
				<?php
				foreach ($categoryTree as $catImg){
					// print_r($catImg);
					?>
					<div class="section-title-container">
						<h4 class="section-title section-title-center">
							<b></b>
								<span class="section-category-main">
									<a href="<?=base_url(seo_url($catImg['CatName'].'-c'.$catImg['CategoryID']).'.html')?>"><?=$catImg['CatName']?></a>
								</span>
							<b></b>
						</h4>
					</div>

					<div id='carousel-category-<?=$catImg['CategoryID']?>' class='carousel slide carousel-category' data-interval="false" data-ride='carousel'>
						<div class='carousel-outer'>
							<!-- Wrapper for slides -->
							<div class="carousel-inner">
								<?php
								$index = 0;
								foreach ($catImg['nodes'] as $item){
									if($index % 4 == 0){
										?>
											<div class="item <?=$index == 0 ? 'active' : ''?>">
												<div class="row">
									<?php
									}
									?>

									<div class="col-lg-3">
										<div class="cat-wrap text-center">
											<div class="cat-img"><a href="<?=base_url(seo_url($item['CatName'].'-c'.$item['CategoryID']).'.html')?>"><img src="<?=base_url('/img/category/'.$item['Image'])?>"></a></div>
											<div class="cat-header-title text-center">
												<a href="<?=base_url(seo_url($item['CatName'].'-c'.$item['CategoryID']).'.html')?>"><?=$item['CatName']?></a>
											</div>
										</div>
									</div>

									<?php

									if(($index + 1) % 4 == 0){
										?>
												</div>
											</div>
										<?php
									}

									$index++;
								}

								if($index % 4 != 0){
								?>
												</div>
											</div>
									<?php
								}
								?>

							</div>

							<?php
							if(count($catImg['nodes']) > 4) {
								?>
								<a class="carousel-control-prev" href="#carousel-category-<?= $catImg['CategoryID'] ?>"
								   role="button" data-slide="prev">
									<span class="carousel-control-prev-icon glyphicon glyphicon-chevron-left"
										  aria-hidden="true"></span>
									<span class="sr-only">Previous</span>
								</a>
								<a class="carousel-control-next" href="#carousel-category-<?= $catImg['CategoryID'] ?>"
								   role="button" data-slide="next">
									<span class="carousel-control-next-icon glyphicon glyphicon-chevron-right"
										  aria-hidden="true"></span>
									<span class="sr-only">Next</span>
								</a>
								<?php
							}
							?>
						</div>
					</div>
				<?php
				}
				?>


			</div>
		</div>
		
		<div class="row margin-top-20">
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
						Top sản phẩm bán chạy
					</span>
					<b></b>
				</h4>
			</div>

			<?php
			foreach ($products as $product){?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
							<a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><i class="glyphicon glyphicon-shopping-cart"></i> Mua Hàng</a>
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
<!-- Custom JS File Link  -->
<!--<script src="--><?php //echo base_url()?><!--theme/site/js/script.js"></script>-->
<script type="text/javascript">
	$(document).ready(function(){
		$('.carousel').carousel();
		$(".carousel-category").mouseenter(function(){
			$('.carousel-control-prev-icon').css('opacity', '1');
			$('.carousel-control-next-icon').css('opacity', '1');
		});
		$(".carousel-category").mouseleave(function(){
			$('.carousel-control-prev-icon').css('opacity', '0');
			$('.carousel-control-next-icon').css('opacity', '0');
		});
	});
</script>
</body>

</html>
