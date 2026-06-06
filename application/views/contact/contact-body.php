<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 11/18/2017
 * Time: 6:16 PM
 */
?>


<?php if(isset($status) && $status != 'OK') {
	?>
	<p class="statusMsg alert alert-dismissible<?=($status == 'NA' ? ' alert-info' : (($status == 'NOK') ? ' alert-danger' : 'alert-success'))?>"><?=$statusMsg?></p>
	<div class="form-group">
		<label for="inputName">Họ tên<span class="required">*</span></label>
		<input name="fullName" type="text" class="form-control" id="fullName"
			   value="<?= isset($fullName) ? $fullName : '' ?>" placeholder="Nhập họ tên"/>
		<span class="text-danger"><?php echo form_error('fullName'); ?></span>
	</div>
	<div class="form-group">
		<label for="inputPhone">Số điện thoại<span class="required">*</span></label>
		<input name="phoneNumber" type="text" class="form-control" id="inputPhone"
			   value="<?= isset($phoneNumber) ? $phoneNumber : '' ?>" placeholder="Nhập số điện thoại"/>
		<span class="text-danger"><?php echo form_error('phoneNumber'); ?></span>
	</div>
	<div class="form-group">
		<label for="inputEmail">Email</label>
		<input type="email" name="email" class="form-control" id="inputEmail" value="<?= isset($email) ? $email : '' ?>"
			   placeholder="Nhập địa chỉ email"/>
		<span class="text-danger"><?php echo form_error('email'); ?></span>
	</div>
	<div class="form-group">
		<label for="inputMessage">Nội dung<span class="required">*</span></label>
		<textarea name="content" class="form-control" id="inputMessage"
				  placeholder="Nhập nội dung"><?= isset($content) ? $content : '' ?></textarea>
		<span class="text-danger"><?php echo form_error('content'); ?></span>
	</div>
	<div class="form-group">
		<label for="inputMessage">Mã xác nhận<span class="required">*</span></label>
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-4">
				<input id="txtCaptcha" name="txt_captcha" class="form-control"
					   value="<?= (isset($txt_captcha) ? $txt_captcha : '') ?>"/>
				<span class="text-danger"><?php echo form_error('txt_captcha'); ?></span>
			</div>
			<div class="col-md-8 col-sm-8 col-xs-8">
				<span id="captchaImg"><?= $capchaImg ?></span>
				<a id="changeCaptcha" data-toggle="tooltip" title="Đổi mã xác thực khác" class="margin-left-10"><i
						class="glyphicon glyphicon-refresh"></i> </a>
			</div>
		</div>
	</div>
	<?php
} else {?>
	<div class="alert alert-success" role="alert">
		<h4 class="alert-heading">Gửi thành công!</h4>
		<p>Cảm ơn bạn đã liên hệ với Vân Anh Shop, chúng tôi sẻ trả lời và liên hệ ngay khi có thể.</p>
		<hr>
		<p class="mb-0">Ngoài ra, bạn cũng có thể liên hệ với chúng tôi qua số điện thoại: <b>0865.053.849</b> hoặc email về: <b>contact@vananhshop.com</b></p>.
	</div>
<?php
}
?>
