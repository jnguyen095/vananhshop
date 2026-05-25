<!DOCTYPE html>
<html lang = "en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="Sản phẩm không tìm thấy">
	<meta name="keywords" content="Sản, phẩm, không, tìm, thấy">
	<meta name="revisit-after" content="1 days" />
	<meta name="robots" content="follow" />
	<title>Không tìm thấy | Vân Anh Shop</title>
	<?php $this->load->view('common_header')?>
	<link rel="stylesheet" href="<?=base_url('/css/jquery.mCustomScrollbar.min.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/carousel-custom.css')?>" />
	<script src="<?=base_url('/js/jquery.mCustomScrollbar.min.js')?>"></script>
	<?php $this->load->view('/common/googleadsense')?>
	<?php $this->load->view('/common/facebook-pixel-tracking')?>
</head>

<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid no-padding-left no-padding-right">
<?php $this->load->view('/theme/header')?>

<ul class="breadcrumb always">
	<div class="container">
		<li><a href="<?php echo base_url()?>">Trang chủ</a></li>
		<li class="active">Không tìm thấy</li>
	</div>
</ul>

	<div class="container">
		<div class="row no-margin">
			<div class="col-md-9 no-margin no-padding product-detail">
				<div class="product-title"><h1 itemprop="name" class="h1Class">Không tìm thấy</h1></div>
				<div class="row no-margin">
					<div class="alert alert-danger" role="alert">
						<strong>Thật Tiếc!</strong> Sản phẩm bạn muốn xem đã ngưng bán hoặc không còn tồn tại.
					</div>
				</div>
			</div>
			<div class="col-md-3 no-margin-right no-padding-right no-padding-left-mobile">
				<?php $this->load->view('/common/Search_filter') ?>
				<?php $this->load->view('/common/sample_house') ?>
				<div class="clear-both"></div>
			</div>

		</div>
	</div>

<?php $this->load->view('/theme/footer')?>
</div>

<!-- Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>
</body>

</html>
