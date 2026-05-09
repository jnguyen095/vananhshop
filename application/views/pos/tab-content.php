<!-- Load category -->
<div class="category-panel col-md-12 affix-top"  data-spy="affix" data-offset-top="90">
		<div class="container mcontainer">
			<ul class="nav pos-navbar-nav" id="navbar-<?=$tabID?>" style="display:none">
				<?php
				foreach($categories as $r) {
					if(count($child[$r->CategoryID]) > 0){
						echo '<li role="presentation" class="pos-dropdown col-sm-2">
							<a href="javascript:void(0);" onclick="loadProduct('.$r->CategoryID. ', \''.$tabID.'\')" role="button" aria-haspopup="true" aria-expanded="false">'.$r->CatName.' </a>
							<ul class="pos-dropdown-menu">';
						foreach ($child[$r->CategoryID] as $k){
							echo '<li><a href="javascript:void(0);" onclick="loadProduct('.$k->CategoryID. ',\''.$tabID.'\')">'.$k->CatName.'</a></li>';
						}

						echo '</ul></li>';
					}else{
						echo ' <li role="presentation" class="pos-dropdown col-sm-2"><a href="javascript:void(0);" onclick="loadProduct('.$r->CategoryID. ', \''.$tabID.'\')">'.$r->CatName.'</a></li>';
					}
				}
				?>
			</ul>
			<a class="btn btn-sm btn-primary" id="cat-<?=$tabID?>"><i class="glyphicon glyphicon-menu-down"></i> </a>
		</div>
	</div>
</div>


<div class="row no-marginn">
	<!-- Load product -->
	<div id="product-<?=$tabID?>" class="col-md-9 no-margin no-padding pos-left-col">
		<?php $this->load->view('/pos/product-list')?>	
	</div>

	<!-- Load order -->
	<div class="col-md-3" style="padding-left: 0px">
		<!-- Modal -->
		<form role="form">
			<div class="modal fade" id="modalCustomerDialog-<?=$tabID?>" role="dialog"><?=$tabID?></div>
		</form>
		<!-- end popup -->
		
		<div class="row text-right no-margin-right">
			<a class="btn btn-primary" id="addcustomer-<?=$tabID?>"><i class="glyphicon glyphicon-user"></i> Khách hàng</a>
			<a class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Thêm</a>
		</div>
		
		<!-- customer infomation -->
		<div id="customer-<?=$tabID?>" class="row text-left customerInfo no-margin-right">
			<?php $this->load->view('/pos/customer-info')?>	
		</div>
		<!-- end -->
		
		<div class="">
			<table id="cart-<?=$tabID?>" class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">#</th>
						<th scope="col">Mặt hàng</th>
						<th scope="col">SL</th>
						<th scope="col">$</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="5" class="text-warning text-center <?=$tabID?>-emptyrow">Chưa có sản phẩm nào</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="row text-right no-margin-right">
			<a class="btn btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> Tạo đơn</a>
			<a class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> In</a>
		</div>
	</div>
</div>
			