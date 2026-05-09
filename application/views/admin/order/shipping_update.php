<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 11/18/2017
 * Time: 6:16 PM
 */
?>
<?php
$attributes = array("id" => "frmShipping");
echo form_open("admin/OrderManagement_controller/updateShippingInfo", $attributes);
?>
<!-- Modal -->
<div class="modal-dialog">
	<div class="modal-content">
		<!-- Modal Header -->
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true">&times;</span>
				<span class="sr-only">Đóng</span>
			</button>
			<h4 class="modal-title h4" id="myModalLabel">Cập nhật thông tin người nhận hàng</h4>
		</div>
		<!-- Modal Body -->
		<div class="modal-body">
			<p class="statusMsg"></p>
			<div class="form-group">
				<label for="inputName">Người nhận<span class="required">*</span></label>
				<input name="txt_receiver" type="text" class="form-control" id="txt_receiver" placeholder="Nhập họ tên" value="<?=$shipping->Receiver?>"/>
				<span class="text-danger"><?php echo form_error('txt_receiver'); ?></span>
			</div>
			<div class="form-group">
				<label for="inputPhone">Số điện thoại<span class="required">*</span></label>
				<input name="txt_phone" type="text" class="form-control" id="inputPhone" placeholder="Nhập số điện thoại" value="<?=$shipping->Phone?>"/>
			</div>
			<div class="form-group">
				<label>Thành phố <span class="required">*</span></label>
				<select id="txtCity" class="form-control" name="txt_city">
					<?php
					if($cities != null && count($cities) > 0){
						$str = '';
						foreach ($cities as $ct){
							?>
							<option value="<?=$ct->CityID?>" <?=(isset($shipping->CityID) && $shipping->CityID == $ct->CityID) ? ' selected' : ''?> ><?=$ct->CityName?></option>
							<?php
						}
					}
					?>
				</select>
				<span class="text-danger"><?php echo form_error('txt_city'); ?></span>
			</div>
			<div class="form-group">
				<label>Quận/huyện <span class="required">*</span></label>
				<select id="txtDistrict" class="form-control" name="txt_district">
					<?php
					if(isset($districts) && count($districts) > 0) {
						foreach ($districts as $dt) {
							?>
							<option
								value="<?= $dt->DistrictID ?>" <?= (isset($shipping->DistrictID) && $shipping->DistrictID == $dt->DistrictID) ? ' selected' : '' ?> ><?= $dt->DistrictName ?></option>
							<?php
						}
					}
					?>
				</select>
				<span class="text-danger"><?php echo form_error('txt_district'); ?></span>
			</div>

			<div class="form-group">
				<label>Đường <span class="required">*</span></label>
				<input type="text" id="txt_street" name="txt_street" class="form-control typeahead" value="<?=$shipping->Street?>">
				<span class="text-danger"><?php echo form_error('txt_street'); ?></span>
			</div>
		</div>

		<!-- Modal Footer -->
		<div class="modal-footer">
			<input type="hidden" name="crudaction" value="insert"/>
			<input type="hidden" name="orderId" value="<?=$shipping->OrderID?>"/>
			<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
			<button id="btnUpdateShipping" type="button" class="btn btn-primary submitBtn" onclick="submitUpdateShipping()">Cập nhật</button>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
	function submitUpdateShipping(){
		var dataString = $("#frmShipping").serialize();
		console.log(dataString);
		$.ajax({
			type:'POST',
			url: '<?=base_url('admin/OrderManagement_controller/updateShippingInfo')?>',
			data: dataString,
			beforeSend: function () {
				$('.submitBtn').attr("disabled","disabled");
				$('.modal-body').css('opacity', '.5');
			},
			success:function(msg){
				if(msg == "success"){
					bootbox.alert("Cập nhật thành công", function(){
						window.location.href = '<?=base_url("admin/order/process-{$shipping->OrderID}.html")?>';
					});

				}else{
					$('.statusMsg').html('<span style="color:red;">'+msg+'</span>');
				}
				$('.submitBtn').removeAttr("disabled");
				$('.modal-body').css('opacity', '');
			}
		});
	}

	function loadDistrictByCityId(){
		$("#txtCity").change(function(){
			$(".overlay").show();
			var cityId = $(this).val();
			jQuery.ajax({
				type: "POST",
				url: '<?=base_url('/ajax_controller/findDistrictByCityId')?>',
				dataType: 'json',
				data: {cityId: cityId},
				success: function(res){
					document.getElementById("txtDistrict").options.length = 1;
					for(key in res){
						$("#txtDistrict").append("<option value='"+res[key].DistrictID+"'>"+res[key].DistrictName+"</option>");
					}
					$(".overlay").hide();
				}
			});
		});
	}

	$(document).ready(function() {
		loadDistrictByCityId();
	});
</script>
