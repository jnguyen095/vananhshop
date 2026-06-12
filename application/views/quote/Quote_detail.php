<!DOCTYPE html>
<html lang = "en">
<meta charset="UTF-8">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" sizes="48x48" href="<?=base_url('/img/favicon_short.ico')?>">
	<title>Báo giá cho yêu cầu: <?=$quote->Code?></title>
	<link rel="stylesheet" href="<?php echo base_url('/css/bootstrap.min.css')?>">
	<style rel="stylesheet">
		body,h4{
			font-family: firefly, DejaVu Sans, sans-serif;
			font-size: 12px
		}
		@media print {
			.btn {
				display: none;
			}
		}
	</style>
</head>
<body>
	<div style="margin-top:10px" >
		<table style="width: 100%;margin-bottom: 10px">
			<tr>
				<td style="width: 150px; text-align: center"><a href="<?=base_url('/')?>"><img style="width: 120px" src="<?=base_url('/img/vananh_logo_trans.png')?>" alt="Vân Anh Shop Logo"/><br/>https://vananhshop.com</a></td>
				<td style="font-size: 28px;text-align: center;vertical-align: middle;">Báo Giá</td>
			</tr>
		</table>

		<table style="width: 100%;margin-top: 12px">
			<tr>
				<td style="width: 120px">Mã báo giá</td>
				<td><?=$quote->Code?></td>
			</tr>
			<tr>
				<td style="width: 120px">Tên người yêu cầu</td>
				<td><?=$quote->Name?></td>
			</tr>
			<tr>
				<td style="width: 120px">Số điện thoại</td>
				<td><?=$quote->Phone?></td>
			</tr>
			<tr>
				<td style="width: 120px">Ngày yêu cầu</td>
				<td><?=date('d/m/Y', strtotime($quote->RequestedDate))?></td>
			</tr>
		</table>
		<table class="table table-bordered" style="width: 100%;margin-bottom: 10px">>
			<thead>
			<tr style="background-color: #00c0ef ">
				<td>#</td>
				<td>Mã SP</td>
				<td>Tên sản phẩm</td>
				<td>Giá</td>
				<td>Số lượng</td>
				<td>Thành tiền</td>
				<td>Ghi chú</td>
			</tr>
			</thead>
			<tbody>
			<?php
			$index = 1;
			foreach ($details as $item){
				?>
				<tr >
					<td style="border-bottom: solid 1px #dddddd"><?=$index++?></td>
					<td style="border-bottom: solid 1px #dddddd"><?=$item->ProductCode?></td>
					<td style="border-bottom: solid 1px #dddddd"><?=$item->ProductName?></td>
					<td style="text-align: right;border-bottom: solid 1px #dddddd"><?=number_format($item->OfferPrice)?></td>
					<td style="text-align: right;border-bottom: solid 1px #dddddd"><?=$item->Quantity?></td>
					<td style="text-align: right;border-bottom: solid 1px #dddddd"><?=number_format($item->OfferPrice * $item->Quantity)?></td>
					<td style="max-width: 100px;border-bottom: solid 1px #dddddd"><i><?=$item->Note?></i></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="5" style="text-align: right">Phí giao hàng</td>
				<td style="text-align: right"><?=number_format($quote->ShippingFee)?></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right">Giảm giá</td>
				<td style="text-align: right"><?=number_format($quote->Discount)?></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: right">Tổng cộng</td>
				<td style="text-align: right"><b><?=number_format($quote->TotalPrice)?> VNĐ</b></td>
				<td></td>
			</tr>
			</tbody>

		</table>

		<table style="width: 100%;">
			<tr>
				<td style="width: 150px; text-align: center;vertical-align: middle">
					<a href="<?=base_url('/check-out/'.$quote->UUID.'.html')?>">Đặt Hàng</a> <img src="<?=base_url($qrcode)?>" alt="qrcode mua hàng" style="width: 160px"/>
				</td>
				<td class="text-right" style="vertical-align: top;"><i>Lưu ý: Báo giá này chỉ có hiệu lực đến ngày <?=date('d/m/Y', strtotime($quote->ValidDate))?></i></td>
			</tr>
		</table>
	</div>

</body>
</html>
