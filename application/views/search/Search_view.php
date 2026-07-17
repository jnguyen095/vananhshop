<!DOCTYPE html>
<html lang = "en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Tìm Kiếm Sản Phẩm | Vân Anh Shop</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php $this->load->view('common_header')?>
	<?php $this->load->view('/common/googleadsense')?>
	<?php $this->load->view('/common/facebook-pixel-tracking')?>
	<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
</head>

<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid no-padding-left no-padding-right">

<?php $this->load->view('/theme/header')?>
	<ul itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb">
		<div class="container">
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?=base_url().'trang-chu.html'?>"><span itemprop="name">Trang Chủ</span></a><meta itemprop="position" content="1" /></li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active"><span itemprop="item"><span itemprop="name">Tìm kiếm</span></span><meta itemprop="position" content="2" /></li>
		</div>
	</ul>
	<?php
	$attributes = array("name" => "search", "id" => "search_form", "class" => "custom-input", "method" => "get");
	echo form_open("tim-kiem", $attributes);
	?>
	<div class="container">
		<div class="row no-margin">
			<div class="search-result-panel col-md-12">
				<?=number_format($total)?> kết quả<span class="search-total-result">
					<?php
					$str = '';
					if(isset($query) && strlen($query) > 0){
						$str .= '\''.$query.'\'';
					}
					if(isset($category)){
						if(isset($query)){
							$str .= ', '.$category->CatName;
						}else {
							$str .= $category->CatName;
						}
					}

					echo $str;
					?>
					</span>
			</div>
		</div>

		<div class="row no-margin">
			<div class="col-md-9 no-margin no-padding">

				<div class="product-panel col-md-12 no-margin no-padding">
					<div class="row tight-gutter">
						<?php
						foreach ($products as $product){?>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
								<div class="product-thumb transition">
									<div class="image">
										<a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><img src="<?=base_url($product->Thumb)?>" alt="<?=$product->Title?>"  class="img-responsive" ></a>
									</div>
									<div class="caption">
										<h3><a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><?=$product->Title?></a></h3>
										<h4><?=substr_at_middle($product->Brief, 200)?></h4>
									</div>
									<div class="button-group">
										<div class="button">
											<p class="price">
												<?php if($product->OrgPrice > 0){?>
													<span class="original-price"><?=number_format($product->OrgPrice)?></span>
												<?php } ?>
												<?=number_format($product->Price)?>đ
											</p>
										</div>
										<a href="<?=base_url().seo_url($product->Title).'-p'.$product->ProductID?>.html"><i class="glyphicon glyphicon-shopping-cart"></i> Mua<b class="mobile-hide"> Hàng</b></a>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					if(isset($products) && count($products) > 0) {
						?>
						<div class="row text-center">
							<?php if (isset($pagination)) echo $pagination ?>
						</div>
						<?php
					}else{
						?>
						<div class="alert alert-warning">Không tìm thấy dữ liệu phù hợp, vui lòng chọn danh mục khác.</div>
						<?php
					}
					?>
				</div>
			</div>
			<div class="col-md-3 no-margin-right no-padding-right no-padding-left-mobile">
				<div class="search-panel block-panel">
					<div class="block-header">TÌM KIẾM SẢN PHẨM</div>
					<div class="block-body">
						<div class="row">
							<input id="keyword" type="text" placeholder="Từ khóa" value="<?=isset($query) ? $query : ''?>" name="query"/>
						</div>
						<div class="row">
							<select id="cmCatId" name="category">
								<option value="-1">Tất cả danh mục</option>
								<?php
								if($categories != null && count($categories) > 0){
									foreach ($categories as $c){
										?>
										<option value="<?=$c['CategoryID']?>" <?=((isset($categoryId) && $categoryId == $c['CategoryID']) ? ' selected="selected"' : '')?> ><?=$c['CatName']?></option>
										<?php
										if(count($c['nodes']) > 0){
											foreach ($c['nodes'] as $k){
												?>
												<option value="<?=$k['CategoryID']?>" <?=((isset($categoryId) && $categoryId == $k['CategoryID']) ? ' selected="selected"' : '')?> >&nbsp;&nbsp;&nbsp;&nbsp;<?=$k['CatName']?></option>
												<?php
											}
										}
									}
								}
								?>
							</select>
						</div>
						<div class="row">
							<label><input type="checkbox" class="minimal" name="discount" value="1" <?=(isset($discount) && $discount == 1) ? 'checked' : ''?>/> Tìm sản phẩm có giảm giá</label>
						</div>
						<div class="row text-center">
							<button type="submit" class="btn btn-tindatdai btn-sm"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Tìm Kiếm</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('input[type="checkbox"].minimal').iCheck({
				checkboxClass: 'icheckbox_minimal-blue',
				radioClass   : 'iradio_minimal-blue'
			})
		});
	</script>
	<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
</div>
<?php $this->load->view('/theme/footer')?>
</body>

</html>
