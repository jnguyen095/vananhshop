<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/19/2017
 * Time: 11:17 AM
 */

?>
<a id="myBtn" href="javascript:void(0);" class="mobile-hide" title="Go to top"><img src="<?=base_url().'/img/gotop.png'?>" alt="Go Top"/></a>

<nav class="navbar navbar-default m-navbar">
	<div class="container-fluid">
		<div class="container">
			<div class="footer row no-margin">
				<!--
				<div class="quickLink mobile-hide">
					<div class="clear-both"></div>
				</div>
				-->
				<div class="menu_bottom">
					<ul>
						<li><a href="<?=base_url('/bao-gia-si.html')?>">Báo giá</a></li>
						<li><a href="<?=base_url('/dieu-khoan-su-dung.html')?>">Điều khoản thỏa thuận</a></li>
						<li><a href="<?=base_url('/quy-che-hoat-dong.html')?>">Quy chế hoạt động</a></li>
						<li><a href="<?=base_url('/cau-hoi-thuong-gap.html')?>">Câu hỏi thường gặp</a></li>
						<li><a href="javascript:void(0);" id="contactModalForm">Liên hệ - góp ý</a></li>
						<li><a href="<?=base_url('/tuyen-dung.html')?>">Tuyển dụng</a></li>

					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container container-bottom">
		<div class="copyright text-center">
			<div>Vân Anh Shop © 2026</div>
			<div>Hotline: <b>0865.053.860</b> | Email: info@vananhshop.com</div>
			<div>
				<a href="http://zalo.me/0778763790"><i class="fa fa-zalo"></i>
				<a href="https://www.facebook.com/vanhanhshopbmt" target="_blank"><i class="fa fa-face"></i></a>
			</div>
			<div>Mua sỉ liên hệ zalo hoặc vào đây <a class="text-primary" href="<?=base_url('/bao-gia-si.html')?>">BÁO GIÁ</a> để chọn sản phẩm gửi báo giá</div>
		</div>
	</div>
</nav>

<!-- Modal -->
<form id="modalForm" role="form">
	<div class="modal fade" id="modalFormDialog" role="dialog">

	</div>
</form>

<script>
	var urls = {
		social_login_url: '<?=base_url('/login_controller/socialLogin')?>',
		uploadOthersImages: '<?= base_url('/post_controller/do_upload_others_images') ?>',
		loadOthersImages: '<?= base_url('/post_controller/loadOthersImages') ?>',
		removeSecondaryImage: '<?= base_url('/post_controller/removeSecondaryImage') ?>',
		loadDistrictByCityId: '<?= base_url('/ajax_controller/findDistrictByCityId') ?>',
		loadWardByDistrictId: '<?= base_url('/ajax_controller/findWardByDistrictId') ?>',
		findStreetByNameUrl: '<?= base_url('/ajax_controller/findStreetByName') ?>',
		updateCoordinatorMapUrl: '<?= base_url('/ajax_controller/updateCoordinator') ?>',
		loadGeoFromAddrUrl: '<?= base_url('/ajax_controller/getGeoFromAddress') ?>',
		loadCaptchaUrl: '<?= base_url('/ajax_controller/getCaptchaImg') ?>',
		base_url: '<?=base_url()?>',
		loadPrice4Package: '<?=base_url('/ajax_controller/loadPrice4Package')?>'

	};
</script>
<script src="<?php echo base_url()?>js/mcustome.js"></script>

