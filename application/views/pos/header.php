<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/19/2017
 * Time: 11:17 AM
 */
?>


<nav class="navbar navbar-default m-navbar navbar-fixed-top"/>
	<div class="container-fluid">
		<a class="navbar-brand brandName ipad-mini-hide hidden-md" href="<?=base_url('/')?>">
			<img src="<?=base_url('/img/logo2.png')?>" atl="Van Anh Shop Logo"/>
		</a>
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar4">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div id="navbar4" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li role="presentation"><a href="<?=base_url('nha-mau-dep.html')?>">Nhà Mẫu Đẹp</a> </li>
				<li role="presentation"><a href="<?=base_url('tin-tuc.html')?>">Tin Tức</a> </li>
				<li role="presentation"><a href="<?=base_url('bao-gia-dich-vu.html')?>">Báo giá</a> </li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php
				if($this->session->userdata('username') != null){
					?>
					<li role="presentation" class="dropdown">
						<a href="<?=base_url('/thong-tin-ca-nhan.html')?>" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="glyphicon glyphicon-user"></i>&nbsp;<?=$this->session->userdata('fullname')?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<?php
							if($this->session->userdata('usergroup') != null && $this->session->userdata('usergroup') == 'ADMIN') {
								?>
								<li><a href="<?= base_url('/admin/dashboard.html') ?>">Admin</a></li>
								<?php
							}
							?>
							<li><a href="<?= base_url('/quan-ly-tin-rao.html') ?>">Quản lý tin rao</a></li>
							<li><a href="<?= base_url('/quan-ly-giao-dich.html') ?>">Giao dịch</a></li>
							<li><a href="<?= base_url('/thong-tin-ca-nhan.html') ?>">Thông tin cá nhân</a></li>
							<li><a href="<?=base_url('/dang-xuat.html')?>">Đăng xuất</a></li>
						</ul>
					</li>

					<?php
				}else{
					?>
					<li><a href="<?=base_url('/dang-nhap.html')?>">Đăng nhập</a></li>
					<?php
				}
				?>
				<li><a href="<?=base_url('/dang-tin.html')?>">Đăng Tin</a></li>
			</ul>
		</div>
		<!--/.nav-collapse -->
	</div>
	<!--/.container-fluid -->
</nav>
