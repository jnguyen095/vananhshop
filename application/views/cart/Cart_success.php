<!DOCTYPE html>
<html lang = "en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Giỏ Hàng</title>
	<?php $this->load->view('common_header')?>
	<link rel="stylesheet" href="<?=base_url('/css/jquery.mCustomScrollbar.min.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
	<link rel="stylesheet" href="<?=base_url('/css/carousel-custom.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/magnific-popup.css')?>" />
	<script src="<?=base_url('/js/jquery.mCustomScrollbar.min.js')?>"></script>

</head>

<body>
<div class="container">
<?php $this->load->view('/theme/header')?>

<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb always">
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo base_url('/')?>"><span itemprop="name">Trang chủ</span></a></li>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="mobile-hide"><span itemprop="item"><span itemprop="name"><a itemprop="item" href="<?=base_url('/check-out.html')?>">Giỏ hàng</a></span></span></li>
	<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active mobile-hide"><span itemprop="item"><span itemprop="name">Đặt hàng thành công</span></span></li>
</ul>
<div class="row">
	<div class="col-lg-12 mobile-hide ">
		<div class="container-fluid text-center border-bottom">
			<div class="progresses">
				<div class="steps active">
					<span><i class="glyphicon glyphicon-ok"></i></span>
				</div>

				<span class="line active"><label class="label1">Xem đơn hàng</label></span>

				<div class="steps active">
					<span class="font-weight-bold"><i class="glyphicon glyphicon-ok"></i></span>
				</div>

				<span class="line active"><label class="label2">Địa chỉ giao hàng</label></span>

				<div class="steps active">
					<span class="font-weight-bold"><i class="glyphicon glyphicon-ok"></i></span>
				</div>
				<span class="last-line"><label class="label3">Hoàn thành</label></span>

			</div>

		</div>
	</div>

	<div class="col-lg-12">
		<div class="alert alert-success" role="alert">
			<strong>Cảm ơn, bạn đã đặt hàng thành công!</strong> Chúng tôi sẻ tiến hành xử lý đơn hàng của bạn.
			<p>Kiểm tra đơn hàng vừa mua tại đây: <a href="<?=base_url('don-hang-'. $_GET['orderId'].'.html')?>">Xem đơn hàng</a> </p>
		</div>
	</div>

	<div class="col-lg-12 text-right margin-bottom-20">
		<a href="<?=base_url('/quan-ly-don-hang.html')?>"><i class="glyphicon glyphicon-menu-right"></i> Quản lý đơn hàng</a>
		<a href="<?=base_url('/')?>"><i class="glyphicon glyphicon-menu-right"></i> Tiếp tục mua hàng</a>
	</div>


</div>

<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script src="<?=base_url('/js/jquery.magnific-popup.min.js')?>"></script>

</div>

<?php $this->load->view('/theme/footer')?>

</body>

</html>
