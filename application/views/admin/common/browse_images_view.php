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
    <title>Hình Ảnh | Vân Anh Shop</title>
	<link rel="icon" sizes="48x48" href="<?=base_url('/img/favicon_short.ico')?>">
    <style>
body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        .gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px; }
        .img-card { background: #fff; padding: 10px; border-radius: 5px; text-align: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: 0.2s; }
        .img-card:hover { transform: scale(1.05); box-shadow: 0 4px 10px rgba(0,0,0,0.15); }
        .img-card img { max-width: 100%; height: 120px; object-fit: cover; border-radius: 3px; }
        .img-card p { font-size: 12px; margin: 8px 0 0; color: #555; word-break: break-all; }
    </style>
</head>
<body>

    <h3>Chọn hình ảnh:</h3>
    <div class="gallery">
        <?php
        if(!empty($files)):
			foreach($files as $file):
				// Ignore nested folders or empty values if any
				if(is_array($file)) continue;

				$file_url = base_url('uploads/' . $file);
				?>
				<!-- When clicked, execute the returnImage function -->
				<div class="img-card" onclick="returnImage('<?php echo $file_url; ?>')">
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
	// Sends the clicked image URL back into CKEditor window instance
	function returnImage(fileUrl) {
		const funcNum = "<?php echo $data['CKEditorFuncNum'] ?? $_GET['CKEditorFuncNum']; ?>";
		window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
		window.close(); // Automatically closes the browser window popup
	}
</script>

</body>
</html>
