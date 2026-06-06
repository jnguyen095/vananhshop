<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 11/18/2017
 * Time: 6:16 PM
 */
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
			<h4 class="modal-title h4" id="myModalLabel">Liên Hệ Với Vân Anh Shop</h4>
		</div>
		<!-- Modal Body -->
		<div id="contactBodyId" class="modal-body">
			<?php $this->load->view('/contact/contact-body')?>
		</div>

		<!-- Modal Footer -->
		<div class="modal-footer">
			<input type="hidden" name="crudaction" value="insert"/>
			<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
			<button id="btnSendFeedBack" type="button" class="btn btn-primary submitBtn"
					onclick="submitContactForm()">Gửi
			</button>
		</div>
	</div>
</div>
