<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 11/18/2017
 * Time: 6:16 PM
 */
?>
<?php
$attributes = array("id" => "frmUpdateOrder");
echo form_open("admin/OrderManagement_controller/update", $attributes);
?>
<!-- Modal -->
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<!-- Modal Header -->
		<div class="modal-header bg-info">
			<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true">&times;</span>
				<span class="sr-only">Đóng</span>
			</button>
			<h4 class="modal-title h4" id="myModalLabel">Thay đổi thông tin đơn hàng</h4>
		</div>
		<!-- Modal Body -->
		<div class="modal-body">
			<p class="statusMsg"></p>
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-2 col-form-label">Thêm mặt hàng</label>
				<div class="col-sm-10">
					<input type="text" class="form-control typeahead" id="staticSearch" placeholder="Nhập mã sản phẩm hoặc tên">
				</div>
			</div>
			<div id="tbItems" class="row no-margin">

			</div>
		</div>

		<!-- Modal Footer -->
		<div class="modal-footer">
			<input type="hidden" name="crudaction" value="insert"/>
			<input type="hidden" name="orderId" value="<?=$order->OrderID?>"/>
			<button id="btnReset" type="button" class="btn btn-info submitBtn" onclick="reloadOriginOrder()"><i class="glyphicon glyphicon-refresh"></i>&nbsp;Tải lại</button>
			<button id="btnUpdateOrder" type="button" class="btn btn-primary submitBtn" onclick="submitUpdateOrderForm()">Cập nhật</button>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
	function loadOrderItemsHandler(isReload){
		$(".overlay").show();
		$.ajax({
			type:'POST',
			url: '<?=base_url("admin/OrderManagement_controller/loadOrderItems")?>',
			data: {'orderId': <?=$order->OrderID?>, 'crudaction': isReload},
			success:function(msg) {
				$("#tbItems").html(msg);
				btnRemovePrItemHandling();
				handlingTxtChange();
				$(".overlay").hide();
			}
		});
	}

	function btnRemovePrItemHandling(){
		$(".btnRemovePrItem").unbind('click');
		$(".btnRemovePrItem").click(function(){
			$(".overlay").show();
			var pdId = $(this).data('prid');
			$.ajax({
				type:'POST',
				url: '<?=base_url("admin/OrderManagement_controller/loadOrderItems")?>',
				data: {'orderId': <?=$order->OrderID?>, 'productId': pdId, 'crudaction': 'delete'},
				success:function(msg) {
					$("#tbItems").html(msg);
					btnRemovePrItemHandling();
					handlingTxtChange();
					$(".overlay").hide();
				}
			});


			//$("#row-"+pdId).addClass('bg-danger');
			//$(this).html("<i class=\"glyphicon glyphicon-refresh\"></i>");
		});
	}

	function autocompleteProductNameHandle(){
		$('.typeahead').typeahead({
			hint: true,
			highlight: true,
			minLength: 2
		}, {
			name: 'ProductID',
			async: true,
			displayKey: 'Title',
			source: function (query, process) {
				return $.get('<?=base_url("Ajax_controller/findProductByCodeOrTitle")?>', {query: query}, function (data) {
					if (data != null && data.length > 0) {
						var json = $.parseJSON(data);
						return process(json);
					}

				});

			}
		});
	}
	function autocompletValueSelected(){
		$('.typeahead').on('typeahead:selected', function(evt, item) {
			// do what you want with the item here
			// console.log(item);
			$.ajax({
				type:'POST',
				url: '<?=base_url("admin/OrderManagement_controller/loadOrderItems")?>',
				data: {'orderId': <?=$order->OrderID?>, 'productId': item['ProductID'], 'crudaction': 'add-product'},
				success:function(msg) {
					$("#tbItems").html(msg);
					btnRemovePrItemHandling();
					handlingTxtChange();
				}
			});
		})
	}

	function reloadOriginOrder() {
		bootbox.confirm("Toàn bộ thay đổi mà chưa được cập nhật sẻ bị mất, bạn có muốn tải lại đơn hàng không?", function (result) {
			if (result) {
				loadOrderItemsHandler('reload');
			}
		});
	}

	function submitUpdateOrderForm(){
		bootbox.confirm("Đơn hàng sẻ bị thay đổi, bạn có chắc chắn cập nhật không?", function (result) {
			if (result) {
				$(".overlay").show();
				$.ajax({
					type:'POST',
					url: '<?=base_url("admin/OrderManagement_controller/updateOrderItems")?>',
					data: {'orderId': <?=$order->OrderID?>},
					success:function(msg) {
						$(".overlay").hide();
						if(msg == "success"){
							bootbox.alert("Cập nhật đơn hàng thành công");
							window.location.href = '<?=base_url('/admin/order/process-'.$order->OrderID.'.html')?>';
						} else {
							bootbox.alert("Cập nhật đơn hàng thành công thất bại, có lỗi xảy ra!!!");
						}
					}
				});
			}
		});
	}

	function handlingTxtChange(){
		$('.onblurEventHandling').change(function() {
			$(".overlay").show();
			var newValue = $(this).val();
			var productId = $(this).data('productid');
			var field = $(this).attr('name');
			$.ajax({
				type:'POST',
				url: '<?=base_url("admin/OrderManagement_controller/loadOrderItems")?>',
				data: {'orderId': <?=$order->OrderID?>, 'crudaction': 'field-change', 'field' : field, 'value' : newValue, 'productId': productId},
				success:function(msg) {
					$("#tbItems").html(msg);
					btnRemovePrItemHandling();
					handlingTxtChange();
					$(".overlay").hide();
				}
			});
		});
	}

	$(document).ready(function() {
		loadOrderItemsHandler('NO');
		autocompleteProductNameHandle();
		autocompletValueSelected();
	});
</script>
