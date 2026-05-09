<div class="modal-dialog">
	<div class="modal-content">
		<!-- Modal Header -->
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true">&times;</span>
				<span class="sr-only">Đóng</span>
			</button>
			<h4 class="modal-title h4" id="myModalLabel">Tìm kiếm khách hàng</h4>
		</div>
		<!-- Modal Body -->
		<div class="modal-body">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Khách hàng</th>
						<th scope="col">Số đt</th>
						<th scope="col">Địa chỉ</th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach ($users as $customer) {?>
						<tr>
							<th><?=$customer->FullName?></th>
							<td><?=$customer->Phone?></td>
							<td><?=$customer->Address?></td>
							<td><a href="#" onclick="selectCustomer(<?=$customer->Us3rID?>, '<?=$tabID?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
						</tr>
				<?php }
				?>
				</tbody>
			</table>
		</div>

		<!-- Modal Footer -->
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
		</div>
	</div>
</div>
