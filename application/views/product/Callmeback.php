<?php
/**
 * Created by IntelliJ IDEA.
 * User: nguyennhukhangvn@gmail.com
 * Date: 6/16/2021
 * Time: 10:35 PM
 */
?>
<!-- begin popup -->
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<div class="float-left"><h5 class="modal-title" id="exampleModalLabel">Yêu cầu người đăng tin liên hệ theo thông tin bên dưới</h5></div>
			<div class="text-right">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		<div class="modal-body">
			<p class="statusMsg">
				<?php
				if($success == 'SUCCESS'){
					echo '<div class="alert alert-success">Gửi thành công, tác giả bài đăng sẻ liên hệ với bạn.</div>';
				} else if($success == 'EXISTED'){
					echo '<div class="alert alert-danger">Số điện thoại này đã được đăng ký, vui lòng chờ liên hệ.</div>';
				}
				?>
			</p>
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-4 col-form-label">Họ và tên</label>
				<div class="col-sm-8">
					<input type="text" name="txt_fullname" class="form-control" id="staticEmail" placeholder="Họ và tên">
				</div>
			</div>
			<div class="form-group row">
				<label for="inputPassword" class="col-sm-4 col-form-label">Số điện thoại <span class="required">*</span></label>
				<div class="col-sm-8">
					<input type="text" name="txt_phonenumber" class="form-control" id="inputPassword" placeholder="Số điện thoại">
					<span class="text-danger"><?php echo form_error('txt_phonenumber'); ?></span>
				</div>
			</div>
			<div class="form-group row">
				<label for="inputPassword" class="col-sm-4 col-form-label">Lời nhắn</label>
				<div class="col-sm-8">
					<textarea name="txt_message" rows="3" style="resize: none;text-align: left" class="form-control">Tôi muốn biết thêm thông tin bất động sản này.</textarea>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<input type="hidden" name="crudaction" value="insert"/>
			<input type="hidden" name="postid" value="<?=$postid?>"/>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			<button id="submitBtn" type="button" class="btn btn-primary" onclick="submitCallMeBackForm()">Gửi tin nhắn</button>
		</div>
	</div>
</div>
<!-- end popup -->
