<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/3/2017
 * Time: 10:13 AM
 */
?>

<header class="main-header">
	<!-- Logo -->
	<a href="<?=base_url('/')?>" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>VA</b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg">
			<img src="<?=base_url('/img/vananhshop_transparent_yellow.png')?>" atl="Vân Anh Shop Logo"/>
		</span>
	</a>

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account Menu -->
				<li class="dropdown user user-menu">
					<!-- Menu Toggle Button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!-- The user image in the navbar-->
						<img src="<?=base_url('/img/vananh_new.png')?>" class="user-image" alt="User Image">
						<!-- hidden-xs hides the username on small devices so only the image appears. -->
						<span class="hidden-xs"><?=$this->session->userdata('fullname')?></span>
					</a>
					<ul class="dropdown-menu">
						<!-- The user image in the menu -->
						<li class="user-header">
							<img src="<?=base_url('/img/vananh-sm-icon.png')?>" class="img-circle" alt="User Image">

							<p>
								Vân Anh Online Shop
								<small>Since 01 June. 2026</small>
							</p>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<a href="<?=base_url('/')?>" class="btn btn-default btn-flat">Trang mua hàng</a>
							</div>
							<div class="pull-right">
								<a href="<?=base_url('/dang-xuat.html')?>" class="btn btn-warning btn-flat">Đăng xuất</a>
							</div>
						</li>
					</ul>
				</li>

			</ul>
		</div>
	</nav>
</header>

