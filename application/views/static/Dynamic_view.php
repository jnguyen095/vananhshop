<!DOCTYPE html>
<html lang = "en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="audience" content="general" />
	<meta name="resource-type" content="document" />
	<meta name="description" content="<?=$page->Title?>">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="follow" />

	<meta property="og:locale" content="vi_VN">
	<meta property="og:type" content="website">
	<meta property="og:title" itemprop="name" content="<?=$page->Title?> | Vân Anh Shop">
	<meta property="og:description" content="<?=$page->Title?> | Vân Anh Shop">
	<meta property="og:url" content="<?php echo rtrim(base_url(seo_url($page->Title).'.html'), '/'); ?>">
	<meta property="og:site_name" content="Vân Anh Shop">
	<meta property="og:image" content="<?php echo rtrim(base_url(), '/'); ?>/img/vananhshop_logo_hr.png">
	<meta property="og:image:width" content="152">
	<meta property="og:image:height" content="147">
	<title><?=$page->Title?> | Vân Anh Shop</title>
	<?php $this->load->view('common_header')?>
	<?php $this->load->view('/common/googleadsense')?>
	<?php $this->load->view('/common/facebook-pixel-tracking')?>
</head>

<body>
<?php $this->load->view('/common/analyticstracking')?>
	<div class="container-fluid no-padding-left no-padding-right">

		<?php $this->load->view('/theme/header')?>

		<ul class="breadcrumb">
			<div class="container">
				<li><a href="<?=base_url().'trang-chu.html'?>">Trang Chủ</a></li>
				<li class="active"><?=$page->Title?></li>	
			</div>
		</ul>

		<div class="container">
			<div class="row no-margin">
				<div class="search-result col-md-9 no-margin no-padding">

				</div>
				<div class="col-md-9 no-margin no-padding">
					<div class="search-result-panel col-md-12"><?=$page->Title?></div>
					<div class="product-panel col-md-12 no-margin no-padding">
						<?=$page->Description?>
					</div>
				</div>
				<div class="col-md-3 no-margin-right no-padding-right no-padding-left-mobile">
					<?php $this->load->view('/common/branch-left') ?>
					<?php $this->load->view('/common/Search_filter') ?>
				</div>
			</div>
		</div>
	<?php $this->load->view('/theme/footer')?>
</body>	
		

</html>
