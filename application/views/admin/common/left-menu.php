<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/3/2017
 * Time: 10:04 AM
 */
?>
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?=base_url('/theme/admin/img/user2-160x160.jpg')?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?=$this->session->userdata('fullname')?></p>
				<!-- Status -->
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- search form (Optional) -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
			</div>
		</form>
		<!-- /.search form -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">HEADER</li>
			<li class="active"><a href="<?=base_url('/admin/dashboard.html')?>"><i class="fa fa-link"></i> <span>Dashboard</span></a></li>
			<li><a href="<?=base_url('/admin/order/list.html')?>"><i class="fa fa-shopping-cart"></i> <span>Quản lý đơn hàng</span></a></li>
			<li><a href="<?=base_url('/admin/user/list.html')?>"><i class="fa fa-user-o"></i> <span>Người dùng</span></a></li>
			<li><a href="<?=base_url('/admin/quote/list.html')?>"><i class="fa fa-list"></i> <span>Báo giá sỉ</span></a></li>
			<li class="treeview menu-open">
				<a href="#"><i class="fa fa-gear"></i> <span>Dữ liệu nền</span>
					<span class="pull-right-container">
                		<i class="fa fa-angle-left pull-right"></i>
              		</span>
				</a>
				<ul class="treeview-menu" style="display: block">
					<li><a href="<?=base_url('/admin/staff/list.html')?>"><i class="fa fa-users"></i> <span>Nhân viên</span></a></li>
					<li><a href="<?=base_url('/admin/category/list.html')?>"><i class="fa fa-folder"></i> <span>Quản lý danh mục</span></a></li>
					<li><a href="<?=base_url('/admin/property/list.html')?>"><i class="fa fa-list"></i> <span>Quản lý thuộc tính sản phẩm</span></a></li>
					<li><a href="<?=base_url('/admin/product/list.html')?>"><i class="fa fa-product-hunt"></i> <span>Quản lý sản phẩm</span></a></li>
					<li><a href="<?=base_url('/admin/area/list.html')?>"><i class="fa fa-map"></i> <span>Quản lý khu vực</span></a></li>
					<li><a href="<?=base_url('/admin/shipping-fee/list.html')?>"><i class="fa fa-truck"></i> <span>Phí giao hàng</span></a></li>
					<li><a href="<?=base_url('/admin/promotion/list.html')?>"><i class="fa fa-truck"></i> <span>Khuyến mãi</span></a></li>
					<li><a href="<?=base_url('/admin/brand/list.html')?>"><i class="fa fa-handshake-o"></i> <span>Nhà cung cấp</span></a></li>
<!--					<li><a href="--><?//=base_url('/admin/city/import.html')?><!--"><i class="fa fa-handshake-o"></i> <span>Địa Chính</span></a></li>-->
				</ul>
			</li>
			<!-- Optionally, you can add icons to the links -->
			<li><a href="<?=base_url('/admin/static-page/list.html')?>"><i class="fa fa-newspaper-o"></i> <span>Trang tĩnh</span></a></li>
			<li><a href="<?=base_url('/admin/banner/list.html')?>"><i class="fa fa-picture-o"></i> <span>Banner</span></a></li>
			<li><a href="<?=base_url('/admin/feedback/list.html')?>"><i class="fa ion-email-unread"></i> <span>Liên hệ</span></a></li>

		</ul>
		<!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>
