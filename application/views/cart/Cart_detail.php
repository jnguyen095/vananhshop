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
<div class="container-fluid no-padding-left no-padding-right">
<?php $this->load->view('/theme/header')?>

<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb always">
	<div class="container">
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo base_url('/')?>"><span itemprop="name">Trang chủ</span></a></li>
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="mobile-hide"><span itemprop="item"><span itemprop="name">Giỏ hàng</span></span></li>
	</div>
</ul>

<div class="container">
	<div class="row">
		<div class="col-lg-12 mobile-hide ">
			<div class="container-fluid text-center border-bottom">
				<div class="progresses">
					<div class="steps step in-progress">
						<span class="font-weight-bold">1</span>
					</div>

					<span class="line"><label class="label1">Xem đơn hàng</label></span>

					<div class="steps">
						<span>2</span>
					</div>

					<span class="line"><label class="label2">Địa chỉ giao hàng</label></span>

					<div class="steps">
						<span>3</span>
					</div>
					<span class="last-line"><label class="label3">Hoàn thành</label></span>

				</div>

			</div>
		</div>

		<div class="col-lg-12">
			<table class="table table-bordered">
				<thead class="thead-default">
					<tr class="bg-info">
						<td class="text-center">Hình ảnh</td>
						<td class="text-left">Tên sản phẩm</td>
						<td class="text-left">Số lượng</td>
						<td class="text-right">Đơn Giá</td>
						<td class="text-right">Tổng cộng</td>
					</tr>
				</thead>
				<tbody id="cartBody">
					<?php $this->load->view('/cart/Cart_detail_body')?>
				</tbody>
			</table>
		</div>

		<div class="col-lg-12 margin-bottom-20">
			<?php
			if(!$this->session->userdata('loginid')){
				?>
				<div class="row no-margin">
					<div class="alert alert-danger" role="alert">
						<strong>Bạn cần đăng nhập để tạo đơn hàng!</strong> <a href="<?=base_url('/dang-nhap.html')?>"> đăng nhập</a>
						<p>Nếu chưa có tài khoản, hãy đăng ký: <a href="<?=base_url('dang-ky.html')?>">đăng ký tài khoản</a> </p>
					</div>
				</div>
			<?php
			}
			?>
			<div class="row no-margin text-right">
				<a class="btn btn-primary" href="<?=base_url('/check-out/address.html')?>">Tiếp Theo <i class="glyphicon glyphicon-menu-right"></i> </a>
			</div>
		</div>
	</div>
</div>

<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
<script src="<?=base_url('/js/jquery.magnific-popup.min.js')?>"></script>

</div>

<?php $this->load->view('/theme/footer')?>

<script type="text/javascript">
	$(document).ready(function() {
		initiateBtnIncrease();
		initiateBtnDecrease();
	});

	function initiateBtnIncrease(){
		$(".increaseBtn").unbind('click');
		$(".increaseBtn").click(function(){
			var pId = $(this).data('pid');
			var currentVal = parseInt($("#quantity-" + pId).val());
			$("#quantity-" + pId).val(currentVal + 1)
		});
	}
	function initiateBtnDecrease(){
		$(".decreaseBtn").unbind('click');
		$(".decreaseBtn").click(function(){
			var pId = $(this).data('pid');
			var currentVal = parseInt($("#quantity-" + pId).val());
			$("#quantity-" + pId).val(currentVal < 2 ? 1 : currentVal - 1)
		});
	}
</script>

</body>

</html>
