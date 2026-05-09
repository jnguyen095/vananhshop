<?php
/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/9/2017
 * Time: 2:19 PM
 */
?>
<!DOCTYPE html>
<html>
<head>
	<head>
		<meta charset = "utf-8">
		<title>Vân Anh Shop | Quản yêu cầu gọi lại</title>
		<?php $this->load->view('common_header')?>
		<script src="<?= base_url('/js/createpost.js') ?>"></script>
		<script src="<?=base_url('/js/bootbox.min.js')?>"></script>
		<?php $this->load->view('/common/googleadsense')?>
</head>
</head>
<body>
<?php $this->load->view('/common/analyticstracking')?>
<div class="container-fluid">
	<?php $this->load->view('/theme/header')?>

	<?php $this->load->view('/common/user-menu')?>

	<div class="row no-margin">
		<div class="col-lg-12 col-sm-12">
			<div>
				<div class="float-left h2title">Quản yêu cầu gọi lại</div>
				<div class="float-right">
					<a class="btn btn-info btn-sm" id="btnMarkAllAsRead" href="#">Đánh dấu đã xử lý tất cả</a>
				</div>
				<div class="clear-both"></div>
			</div>
			<hr/>

			<?php if(!empty($message_response)){
				echo '<div class="alert alert-success">';
				echo '<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>';
				echo $message_response;
				echo '</div>';
			}?>

			<?php
			$attributes = array("id" => "frmCallMeBack");
			echo form_open("yeu-cau-goi-lai", $attributes);
			?>
			<!-- content -->
			<div class="col-md-12 no-margin no-padding text-center table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead class="thead-table">
						<tr class="bg-success">
							<th>#</th>
							<th>Tin rao</th>
							<th>Số điện thoại</th>
							<th>Khách hàng</th>
							<th>Ngày yc</th>
							<th class="mobile-hide">Nội dung</th>
							<th class="mobile-hide">Tình trạng</th>
							<th>Thao tác</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(count($callmebacks) < 1) {
						?>
					<tr>
						<td colspan="9">Bạn chưa có yêu cầu nào. </td>
					</tr>
						<?php
					}
					?>
					<?php
						$counter = 1;
						foreach ($callmebacks as $callmeback) {
							?>
							<tr>
								<th scope="row"><?=$counter++?>.</th>
								<td class="text-left"><a href="<?=base_url().seo_url($callmeback->Title).'-p'.$callmeback->ProductID.'.html'?>" target="_blank" title="<?=$callmeback->Title?>"><?=substr_at_middle($callmeback->Title, 50)?></a></td>
								<td><?=$callmeback->PhoneNumber?></td>
								<td><?=$callmeback->FullName?></td>
								<td>
									<?php
									$datestring = '%d/%m/%Y H:i';
									echo date('d/m/Y H:i', strtotime($callmeback->CreatedDate));
									?>
								</td>
								<td><?=$callmeback->Message?></td>
								<td>
									<?php
									if($callmeback->Status == 'WAITING_OWNER'){
										echo '<span class="text-danger">Khách đang chờ trả lời</span>';
									} else if($callmeback->Status == 'RESOLVED'){
										echo '<span class="text-success">Đã trả lời</span>';
									}
									?>
								</td>
								<td>
									<?php
									if($callmeback->Status == 'WAITING_OWNER'){
									?>
									<a href="#" class="read-callmeback" data-callmebackid="<?=$callmeback->CallMeBackID?>" data-toggle="tooltip" title="Đánh dấu đã đọc"><span class="glyphicon glyphicon-eye-open"></span></a>
									<?php
									} else if($callmeback->Status == 'RESOLVED'){
									?>
										<a href="#" class="remove-callmeback" data-callmebackid="<?=$callmeback->CallMeBackID?>" data-toggle="tooltip" title="Xóa yêu cầu"><span class="glyphicon glyphicon-remove"></span></a>
									<?php } ?>

								</td>
							</tr>
							<?php
						}
					?>
					</tbody>
				</table>
				<div class="row text-center">
					<?php if (isset($pagination)) echo $pagination; ?>
				</div>


			</div>
			<!-- end content -->
			<input type="hidden" id="crudaction" name="crudaction">
			<input type="hidden" id="callMeBackID" name="callMeBackID">
			<?php echo form_close(); ?>

			<div class="clear-both"></div>
		</div>
	</div>

	<?php $this->load->view('/theme/footer')?>
</div>

</body>
</html>
