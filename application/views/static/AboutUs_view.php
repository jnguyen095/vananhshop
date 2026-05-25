<!DOCTYPE html>
<html lang = "en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="audience" content="general" />
	<meta name="resource-type" content="document" />
	<meta name="abstract" content="Thông tin nhà đất Việt Nam" />
	<meta name="classification" content="Bất động sản Việt Nam" />
	<meta name="area" content="Nhà đất và bất động sản" />
	<meta name="placename" content="Việt Nam" />
	<meta name="author" content="lamvuonvui.com" />
	<meta name="copyright" content="©2025 lamvuonvui.com" />
	<meta name="owner" content="lamvuonvui.com" />
	<meta name="distribution" content="Global" />
	<meta name="description" content="<?=$page->Title?>">
	<meta name="keywords" content="<?=keyword_maker($page->Title)?>">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="follow" />
	<title><?=$page->Title?></title>
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

					<div class="col-lg-7 col-sm-12 product-panel no-margin no-padding">
						<?=$page->Description?>
					</div>
					<div class="col-lg-5 col-sm-12">
						<video controls class="w-25" style="max-width: 100%;">
							<source src="<?=base_url('/attachments/video/myvideo.mp4');?>" type="video/mp4">
							Your browser does not support the video tag.
						</video>
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
