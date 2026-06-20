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

			$config['upload_path']   = './uploads/';
			$config['allowed_types']  = 'jpg|jpeg|png|gif|webp';
			$config['max_size']       = 2048; // 2MB
			$config['file_name']      = time() . '_' . $_FILES['upload']['name'];

			$this->load->library('upload', $config);

			// 1. Get the dynamic callback tracking number from CKEditor's GET request
			$function_number = $this->input->get('CKEditorFuncNum');

			if (!$this->upload->do_upload('upload')) {
				$error = strip_tags($this->upload->display_errors());

				// 2. Alert the error back to the CKEditor dialog
				echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '', '$error');</script>";
			} else {
				$upload_data = $this->upload->data();
				$file_url = base_url('uploads/' . $upload_data['file_name']);

				// 3. Send the absolute image URL straight to CKEditor's input field
				echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$file_url', 'Image uploaded successfully!');</script>";
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
}

