<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 6/20/2026
 * Time: 4:57 PM
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chon Hình Ảnh | Vân Anh Shop</title>
	<link rel="icon" sizes="48x48" href="<?=base_url('/img/favicon_short.ico')?>">
	<style>
		body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
		.gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; }
		.img-card { position: relative; background: #fff; padding: 10px; border-radius: 5px; text-align: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: 0.2s; }
		.img-card:hover { transform: scale(1.05); box-shadow: 0 4px 10px rgba(0,0,0,0.15); }
		.img-card img { max-width: 100%; height: 120px; object-fit: cover; border-radius: 3px; }
		.img-card p { font-size: 12px; margin: 8px 0 0; color: #555; word-break: break-all; }

		/* Delete Button Styling */
		.delete-btn {
			position: absolute;
			top: 5px;
			right: 5px;
			background: #ff4d4d;
			color: white;
			border: none;
			border-radius: 50%;
			width: 24px;
			height: 24px;
			font-weight: bold;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 16px;
			line-height: 1;
			transition: background 0.2s;
			box-shadow: 0 2px 4px rgba(0,0,0,0.2);
			z-index: 10;
		}
		.delete-btn:hover { background: #cc0000; }
	</style>
</head>
<body>

<h3>Chọn hình ảnh: </h3>
<div class="gallery">
	<?php
	if(!empty($files)):
		foreach($files as $file):
			if(is_array($file)) continue;
			$file_url = base_url('uploads/' . $file);
			?>
			<div class="img-card" onclick="returnImage('<?php echo $file_url; ?>')">
				<!-- Delete Button Trigger -->
				<button type="button" class="delete-btn" onclick="deleteImage(event, '<?php echo $file; ?>')">&times;</button>

				<img src="<?php echo $file_url; ?>" alt="Uploaded file">
				<p><?php echo $file; ?></p>
			</div>
			<?php
		endforeach;
	else:
		echo "<p>Chưa có hình ảnh nào.</p>";
	endif;
	?>
</div>

<script>
	// Select and pass image back to CKEditor
	function returnImage(fileUrl) {
		const funcNum = "<?php echo $CKEditorFuncNum; ?>";
		window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
		window.close();
	}

	// Handle file deletion using Fetch API
	function deleteImage(event, fileName) {
		// Stops the click from hitting the .img-card parent element
		event.stopPropagation();

		if (confirm('Bạn chắc chắn xóa hình này chưa?')) {
			const targetUrl = '<?php echo base_url("admin/ImageUpload_controller/delete_image"); ?>/' + fileName;

			fetch(targetUrl, { method: 'POST' })
				.then(response => response.json())
		.then(data => {
				if (data.status === 'success') {
				// Refresh the entire popup window to update the grid gallery layout
				window.location.reload();
			} else {
				alert('Lỗi: ' + data.message);
			}
		})
		.catch(error => {
				console.error('Error:', error);
			alert('Có lỗi xãy ra, không thể thực hiện thao tác.');
		});
		}
	}
</script>

</body>
</html>
