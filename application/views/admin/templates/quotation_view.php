<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Báo Giá | Vân Anh Shop</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
<div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 20px; border-radius: 5px;">
	<!-- Dynamic data parsed from controller -->
	<h2 style="color: #333333;">Xin chào, <?php echo $quote->Name; ?>!</h2>
	<p style="color: #666666; line-height: 1.5;">
		Chúng tôi đã xem xét đề nghị báo giá của quý khách, hãy vào đường dẫn bên dưới để xem chi tiết và đặt hàng.
	</p>
	<div style="text-align: center; margin: 20px 0;">
		<!-- If you want to embed an image or QR code link -->
		<a href="<?=base_url('/bao-gia/'.$quote->UUID.'/xem-chi-tiet.html')?>">Báo Giá: <?php echo $quote->Code?></a>
		<img src="<?php echo base_url('/img/qrcode/quote/'.$quote->UUID.'.png'); ?>" alt="QR Code" style="width: 150px;">
	</div>
	<p style="color: #999999; font-size: 12px; text-align: center;">
		Hãy bỏ qua email này nếu bạn không yêu cầu nó.
	</p>
</div>
</body>
</html>
