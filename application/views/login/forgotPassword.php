<!DOCTYPE html>
<html>
<head>
	<head>
		<meta charset = "utf-8">
		<title>Vân Anh Shop - Quên Mật Khẩu</title>
		<?php $this->load->view('common_header')?>
		<?php $this->load->view('/common/googleadsense')?>
		<link rel="stylesheet" href="<?=base_url('/css/iCheck/all.css')?>">
	</head>
</head>
<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid no-padding-left no-padding-right">
	<?php $this->load->view('/theme/header')?>

	<div class="row no-margin">
		<div class="col-lg-6 col-lg-offset-3 col-sm-6 no-background well login-panel">
			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>
			<?php if(!empty($error_message)){
				echo '<div class="alert alert-danger">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
				echo $error_message;
				echo '</div>';
			}?>
			<?php
				$attributes = array("class" => "form-horizontal", "id" => "forgotpwform", "name" => "loginform");
				echo form_open("quen-mat-khau", $attributes);
			?>

			<fieldset>
				<legend class="text-center">QUÊN MẬT KHẨU</legend>
				<div class="form-group">
					<div class="row colbox no-margin">
						<div class="col-lg-4 col-sm-4">
							<label for="txt_username" class="control-label">Số điện thoại <span class="required">*</span></label>
						</div>
						<div class="col-lg-8 col-sm-8">
							<input class="form-control" id="txt_phone" name="txt_phone" placeholder="Số điện thoại" type="text" value="<?php echo set_value('txt_phone'); ?>" />
							<span class="text-danger"><?php echo form_error('txt_phone'); ?></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row colbox no-margin">
						<div class="col-lg-4 col-sm-4">
							<label for="txt_username" class="control-label">Email <span class="required">*</span></label>
						</div>
						<div class="col-lg-8 col-sm-8">
							<input class="form-control" id="txt_email" name="txt_email" placeholder="Email" type="text" value="<?php echo set_value('txt_email'); ?>" />
							<span class="text-danger"><?php echo form_error('txt_email'); ?></span>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-8 col-sm-8 col-lg-offset-4 text-left">
						<input type="hidden" name="crudaction" value="submit"/>
						<input id="btn_login" name="btn_login" type="submit" class="btn btn-info" value="Lấy Lại Mật Khẩu" />
					</div>
				</div>

			</fieldset>
			<?php echo form_close(); ?>
			<?php echo $this->session->flashdata('msg'); ?>
		</div>
	</div>
	<script type="text/javascript">
		var loginServerCallback = function(res){
			if(res.success){
				window.location.href = '<?=base_url('/trang-chu.html')?>';
			}
		}

		function checkFacebookLoginState() {
			FB.login(function(response) {
				if (response.status == 'connected') {
					var accessToken = response.authResponse.accessToken;
					var userID = response.authResponse.userID;
					FB.api('/me?fields=email,name,picture', function(response) {
						var email = response.email;
						var fullName = response.name;
						socialLogin(email, userID, fullName, loginServerCallback);
					});
				} else {
					console.log('User cancelled login or did not fully authorize.');
				}
			}, {scope: 'email,public_profile'});
		}

		function googleLoginCallback(result)
		{
			if(result['status']['signed_in'])
			{
				var request = gapi.client.plus.people.get({
					'userId': 'me'
				});
				request.execute(function(resp) {
					var email = '';
					if(resp['emails'])
					{
						for(i = 0; i < resp['emails'].length; i++)
						{
							if(resp['emails'][i]['type'] == 'account')
							{
								email = resp['emails'][i]['value'];
							}
						}
					}

					var fullName = resp['displayName'];
					var email = email;
					var userID = resp['id'];
					socialLogin(email, userID, fullName, loginServerCallback);
				});
			}
		}

		function checkGoogleLoginState(){
			var myParams = {
				'clientid' : '<?=GOOGLE_ID?>',
				'cookiepolicy' : 'single_host_origin',
				'callback' : 'googleLoginCallback',
				'approvalprompt':'force',
				'scope' : 'profile email',
				'fetch_basic_profile': true
			};

			gapi.auth.signIn(myParams);
		}

		$(document).ready(function(){
			$("#loginBtnFacebook").click(function(){
				checkFacebookLoginState();
			})

			$("#loginBtnGoogle").click(function(){
				checkGoogleLoginState();
			});
			$('input[type="checkbox"].minimal').iCheck({
				checkboxClass: 'icheckbox_minimal-blue',
				radioClass   : 'iradio_minimal-blue'
			})
		});
	</script>

	<?php $this->load->view('/theme/footer')?>
</div>
<script src="<?=base_url('/css/iCheck/icheck.min.js')?>"></script>
</body>
</html>
