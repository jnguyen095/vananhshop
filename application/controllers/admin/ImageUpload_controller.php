<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 6/20/2026
 * Time: 4:05 PM
 */

class ImageUpload_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// Ensure the helper is loaded to generate absolute return URLs
		$this->load->helper('url');
	}

	public function ckeditor_image() {
		if (isset($_FILES['upload']['name'])) {

			// 1. Initial Upload Configuration
			$config['upload_path']   = './uploads/';
			$config['allowed_types']  = 'jpg|jpeg|png|gif|webp';
			$config['max_size']       = 0; // 0 sets size to unlimited so large images don't get rejected upfront
			$config['file_name']      = time() . '_' . $_FILES['upload']['name'];

			$this->load->library('upload', $config);
			$function_number = $this->input->get('CKEditorFuncNum');

			if (!$this->upload->do_upload('upload')) {
				$error = strip_tags($this->upload->display_errors());
				echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '', '$error');</script>";
			} else {
				// Get information about the newly uploaded file
				$upload_data = $this->upload->data();
				$file_path = $upload_data['full_path'];

				// 2. Size Check (2MB = 2048 KB)
				// If the file size is greater than 2048KB, automatically scale it down
				if ($upload_data['file_size'] > 2048) {

					// Initialize CodeIgniter's Image Library
					$this->load->library('image_lib');

					// Configure resizing settings to downscale resolution and drop quality to save space
					$img_config['image_library']  = 'gd2';
					$img_config['source_image']   = $file_path;
					$img_config['maintain_ratio'] = TRUE;

					// Calculate scale reduction if the photo has massive resolution layout boundaries
					if ($upload_data['image_width'] > 1920) {
						$img_config['width']  = 1920;
						$img_config['height'] = 1080;
					}

					// Lower quality percentage slightly (80% retains great clarity while stripping file size heavily)
					$img_config['quality'] = '80%';

					$this->image_lib->initialize($img_config);

					if (!$this->image_lib->resize()) {
						// Optional fallback error handling if optimization engine crashes
						$resize_error = strip_tags($this->image_lib->display_errors());
						echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '', 'Resize failed: $resize_error');</script>";
						return;
					}

					// Clear the image library configuration cache memory
					$this->image_lib->clear();
				}

				// 3. Return Successful Endpoint URL back to frontend dialog screen
				$file_url = base_url('uploads/' . $upload_data['file_name']);
				echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$file_url', 'Image uploaded and optimized successfully!');</script>";
			}
		} else {
			$function_number = $this->input->get('CKEditorFuncNum');
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '', 'No file detected.');</script>";
		}
	}



	public function browse_images() {
		// Load directory and file helpers to analyze extensions
		$this->load->helper('directory');
		$this->load->helper('file');

		$upload_path = './uploads/';
		$all_files = directory_map($upload_path);
		$image_files = array();

		// Define allowed image extensions
		$allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

		if (!empty($all_files)) {
			foreach ($all_files as $file) {
				// Skip subdirectories if any exist
				if (is_array($file)) continue;

				// Get file extension and convert to lowercase
				$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

				// Only add to the list if the extension matches an image type
				if (in_array($ext, $allowed_extensions)) {
					$image_files[] = $file;
				}
			}
		}

		// Pass the filtered image array and CKEditor tracking number to the view
		$data['files'] = $image_files;
		$data['CKEditorFuncNum'] = $this->input->get('CKEditorFuncNum');

		$this->load->view('admin/common/browse_images_view', $data);
	}

	public function delete_image($file_name = NULL) {
		// Basic file validation checklist framework
		if (empty($file_name)) {
			echo json_encode(['status' => 'error', 'message' => 'No filename provided.']);
			return;
		}

		// Security check: Sanitizes directory traversal attacks like ../../
		$file_name = basename($file_name);
		$file_path = './uploads/' . $file_name;

		// Verify file physical placement location details on storage framework disk
		if (file_exists($file_path)) {
			if (unlink($file_path)) {
				echo json_encode(['status' => 'success', 'message' => 'File deleted successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Permission issue: Unable to delete asset file.']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'File tracking asset location not found.']);
		}
	}

}

