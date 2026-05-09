<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/27/2017
 * Time: 11:11 PM
 */

?>

<div class="search-panel block-panel">
	<div class="block-header">TÌM KIẾM SẢN PHẨM</div>
	<?php
	$attributes = array("name" => "search", "id" => "search_form", "class" => "custom-input");
	echo form_open("tim-kiem", $attributes);
	?>
	<div class="block-body">
		<div class="row">
			<input id="keyword" type="text" placeholder="Từ khóa" value="<?=isset($keyword) ? $keyword : ''?>" name="keyword"/>
		</div>
		<div class="row">
			<select id="cmCatId" name="cmCatId">
				<option value="-1">Tất cả danh mục</option>
				<?php
				if($categories != null && count($categories) > 0){
					foreach ($categories as $c){
						?>
						<option value="<?=$c['CategoryID']?>" <?=((isset($cmCatId) && $cmCatId == $c['CategoryID']) ? ' selected="selected"' : '')?> ><?=$c['CatName']?></option>
						<?php
						if(count($c['nodes']) > 0){
							foreach ($c['nodes'] as $k){
								?>
								<option value="<?=$k['CategoryID']?>" <?=((isset($cmCatId) && $cmCatId == $k['CategoryID']) ? ' selected="selected"' : '')?> >&nbsp;&nbsp;&nbsp;&nbsp;<?=$k['CatName']?></option>
								<?php
							}
						}
					}
				}
				?>
			</select>
		</div>

		<div class="row text-center">
			<a id="btnSearch" class="btn btn-tindatdai btn-sm"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Tìm Kiếm</a>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
