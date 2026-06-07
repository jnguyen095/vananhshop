<!DOCTYPE html>
<html lang = "en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Đặt Hàng Thành Công | Vân Anh Shop</title>
	<?php $this->load->view('common_header')?>
	<link rel="stylesheet" href="<?=base_url('/css/jquery.mCustomScrollbar.min.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
	<link rel="stylesheet" href="<?=base_url('/css/carousel-custom.css')?>" />
	<link rel="stylesheet" href="<?=base_url('/css/magnific-popup.css')?>" />
	<script src="<?=base_url('/js/jquery.mCustomScrollbar.min.js')?>"></script>

</head>

<body>
<div class="container-fluid no-padding-left no-padding-right">
<?php $this->load->view('/theme/header')?>

<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb always">
	<div class="container">
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo base_url('/')?>"><span itemprop="name">Trang chủ</span></a></li>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active mobile-hide"><span itemprop="item"><span itemprop="name">Đặt hàng thành công</span></span></li>
	</div>
</ul>


<div class="container">
	<div class="row">
		<div class="col-lg-12 mobile-hide ">
			<div class="container-fluid text-center border-bottom">
				<div class="progresses">
					<div class="steps active">
						<span class="font-weight-bold"><i class="glyphicon glyphicon-ok"></i></span>
					</div>
					<span class="last-line"><label class="label3 success-info">Đặt Hàng Thành Công</label></span>

				</div>

			</div>
		</div>

		<div class="col-lg-12">
			<div class="alert alert-success" role="alert">
				<strong>Cảm ơn, bạn đã đặt hàng thành công!</strong> Chúng tôi sẻ tiến hành xử lý đơn hàng của bạn.
				<p class="margin-top-20"><i class="glyphicon glyphicon-chevron-right"></i> Bạn có thể theo dõi đơn hàng vừa mua tại đây: <a href="<?=base_url('don-hang-'. $_GET['orderId'].'.html')?>">Xem đơn hàng</a> </p>
				<p><i class="glyphicon glyphicon-chevron-right"></i> Liên hệ với chúng tôi tại đây: <a id="contactVAS" href="#">Liên Hệ</a>, hoặc qua SĐT/Zalo: <b><a href="http://zalo.me/0865053849">0865.053.849</a></b> nếu cần.</p>
			</div>
		</div>

		<div class="col-lg-12 text-right margin-bottom-20">
			<a href="<?=base_url('/theo-doi-don-hang.html')?>"><i class="glyphicon glyphicon-menu-right"></i> Tra cứu đơn hàng</a>
			<a href="<?=base_url('/')?>"><i class="glyphicon glyphicon-menu-right"></i> Tiếp tục mua hàng</a>
		</div>


	</div>
</div>

	<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
	<script src="<?=base_url('/js/jquery.magnific-popup.min.js')?>"></script>
	<?php $this->load->view('/common/analyticstracking')?>
</div>

<?php $this->load->view('/theme/footer')?>
<script type="text/javascript">
	$(document).ready(function() {
		gtag('event', 'placed_order_success', {
			'app_name': 'Vân Anh Shop',
			'screen_name': 'Tạo đơn hàng thành công!'
		});
	});
</script>
</body>

</html>
