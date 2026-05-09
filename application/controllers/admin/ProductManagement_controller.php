<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/3/2017
 * Time: 10:25 AM
 */
class ProductManagement_controller extends MY_Controller
{
	private $allowed_img_types;
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Product_Model');
		$this->load->model('ProductAsset_Model');
		$this->load->model('Category_Model');
		$this->load->model('User_Model');
		$this->load->model('Property_Model');
		$this->load->model('Brand_Model');
		$this->load->model('ProductProperty_Model');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
		$this->load->helper("seo_url");
		$this->load->library('form_validation');
		$this->load->helper('security');
	}

	public function index()
	{
		$crudaction = $this->input->post("crudaction");
		$data['categories'] = $this->Category_Model->getActiveCategories();
		if($crudaction == DELETE){
			$productId = $this->input->post("productId");
			$this->deleteProductById($productId);
			$data['message_response'] = 'Xóa tin rao thành công.';
		}else if($crudaction == "delete-multiple"){
			$productIds = $this->input->post("checkList");
			foreach ($productIds as $productId){
				$this->deleteProductById($productId);
			}
			$data['message_response'] = 'Xóa tin rao thành công.';
		}
		$config = pagination($this);
		$config['base_url'] = base_url('admin/product/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "ModifiedDate";
			$config['orderDirection'] = "DESC";
		}
		$categoryId = $this->input->get('sl_category');
		$createdById = $this->input->get('createdById');
		$status = $this->input->get('status');
		$results = $this->Product_Model->findAndFilter($config['page'], $config['per_page'], $config['searchFor'], $categoryId, $status, $config['orderField'], $config['orderDirection']);
		$data['products'] = $results['items'];
		$config['total_rows'] = $results['total'];

		if($createdById != null){
			$user = $this->User_Model->getUserById($createdById);
			$data['user'] = $user;
		}

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view("admin/product/list", $data);
	}

	public function edit($productId = null){
		$categories = $this->Category_Model->getActiveCategories();
		$property = $this->Property_Model->getProperties();
		$product = [];
		if($productId == null){
			$productId = $this->input->post('ProductID');
		}
		$product['ProductID'] = $productId;
		$product['Code'] = $this->Product_Model->getNewProductCode(); // uniqid('P-');

		$data['brands'] = $this->Brand_Model->findAll();
		$data['categories'] = $categories;
		$data['properties'] = $property;
		if($this->input->post('crudaction') == "insert"){
			$this->form_validation->set_rules("sl_category", "Danh mục", "trim|required");
			$this->form_validation->set_rules("Title", "Tên sản phẩm", "trim|required");
			$this->form_validation->set_rules("Price", "Gián bán", "trim|required");
			$this->form_validation->set_rules("Brief", "Mô tả ngắn sản phẩm", "trim|required");
			$this->form_validation->set_rules("Description", "Mô tả chi tiết sản phẩm", "trim|required");

			$product['Code'] = $this->input->post('Code');
			$product['CategoryID'] = $this->input->post('sl_category');
			$product['Title'] = $this->input->post('Title');
			$product['Price'] = $this->input->post('Price');
			$product['Brief'] = $this->input->post('Brief');
			$product['Description'] = $this->input->post('Description');
			$product['Status'] = $this->input->post('Status');
			$product['Code'] = $this->input->post('Code');
			$product['CreatedByID'] = $this->session->userdata('loginid');
			$product['Thumb'] = $this->input->post('txt_image');
			$product['BrandID'] = $this->input->post('sl_brand');
			$otherImgs = $this->input->post('otherImages');

			if($product['Price'] != null) {
				$this->form_validation->set_rules('Price', 'Giá bán', 'regex_match[/^\d+(\.\d{2})?$/]'); //{10} for 10 or 11 digits number
			}

			if ($this->form_validation->run() == FALSE) {
				$data['message_response'] = "Dữ liệu chưa đúng, kiểm tra lại";
			}else{
				$count = $this->Product_Model->checkNewProductIsValid($product);
				if($count < 1){
					$preImg = $this->input->post("txt_image");
					$img = $this->uploadImage();
					if($img == null && $preImg != null){
						$img = $preImg;
					}
					$product['Thumb'] = $img;
					$id = $this->Product_Model->addOrUpdateProduct($product, $otherImgs);
					if($id == null){
						$id = $productId;
					}
					$this->ProductProperty_Model->savingProductProperties($id, $this->input->post('properties'));
					$data['message_response'] = "Thêm mới sản phẩm thành công";
					redirect('admin/product/list');
				}else{
					$data['message_response'] = "Sản phẩm này đã tồn tại, vui lòng chọn tên sản phẩm hoặc danh mục khác";
				}


			}
		}else if($productId != null){
			$product = $this->Product_Model->findById($productId);
			$properties = [];
			$productProperties = $this->ProductProperty_Model->findByProductId($productId);
			if(count($productProperties) > 0){
				foreach ($productProperties as $property){
					$properties[$property->PropertyID] = $property->PropertyID;
				}
			}
			$data['other_images'] = $this->loadOthersImages($productId);
			$data['productProperties'] = $properties;
		}

		$data['product'] = (object)$product;
		$this->load->view("admin/product/edit", $data);
	}

	private function deleteProductById($productId){
		if($productId != null && $productId > 0) {
			//$product = $this->Product_Model->findById($productId);
			//$folder = $product->code;
			//$upath = 'attachments' . DIRECTORY_SEPARATOR .'u'. $product->CreatedByID . DIRECTORY_SEPARATOR. $folder;
			// delete db first
			$this->Product_Model->deleteById($productId);
			//if (file_exists($upath)){
				//$this->delete_directory($upath);
			//}
		}
	}

	public function pushPostUp(){
		$productId = $this->input->post('productId');
		$this->Product_Model->pushPostUp($productId);
		echo json_encode('success');
	}

	private function delete_directory($dirname) {
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname."/".$file))
					unlink($dirname."/".$file);
				else
					delete_directory($dirname.'/'.$file);
			}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}

	private function uploadImage(){
		if(!empty($this->input->post("txt_image"))){
			return $this->input->post("txt_image");
		}else{
			$this->allowed_img_types = $this->config->item('allowed_img_types');
			// $upath = 'img' . DIRECTORY_SEPARATOR .'product'. DIRECTORY_SEPARATOR;
			$upath = 'attachments' . DIRECTORY_SEPARATOR .'u'. $_POST['txt_pimg'] . DIRECTORY_SEPARATOR;

			if (!file_exists($upath)) {
				mkdir($upath, 0777, true);
			}

			$config['upload_path'] = $upath;
			$config['allowed_types'] = $this->allowed_img_types;
			$config['remove_spaces'] = true;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('txt_image')) {
				log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
			}
			$img = $this->upload->data();
			if ($img['file_name'] != null) {
				// Resize image
				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image'] = $upath.$img['file_name'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']     = 180;

				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->resize();

				$imgDetailArray = explode('.', $img['file_name']);
				$thumbimgname = $imgDetailArray[0].'_thumb'.'.'.$imgDetailArray[1];
				// unlink($upath.$img['file_name']);
				return "/".$upath.$thumbimgname;
			}
		}
	}

	public function do_upload_others_images()
	{
		if ($this->input->is_ajax_request()) {
			$upath = 'attachments' . DIRECTORY_SEPARATOR .'u'. $_POST['txt_folder'] . DIRECTORY_SEPARATOR .'details'. DIRECTORY_SEPARATOR;
			if (!file_exists($upath)) {
				mkdir($upath, 0777, true);
			}

			$this->load->library('upload');

			$files = $_FILES;
			$cpt = count($_FILES['others']['name']);
			$is_OK = true;
			for ($i = 0; $i < $cpt; $i++) {
				unset($_FILES);
				$_FILES['others']['name'] = $files['others']['name'][$i];
				$_FILES['others']['type'] = $files['others']['type'][$i];
				$_FILES['others']['tmp_name'] = $files['others']['tmp_name'][$i];
				$_FILES['others']['error'] = $files['others']['error'][$i];
				$_FILES['others']['size'] = $files['others']['size'][$i];

				$this->upload->initialize(array(
					'upload_path' => $upath,
					'allowed_types' => $this->config->item('allowed_img_types'),
					'remove_spaces' => true
				));
				if(!$this->upload->do_upload('others')){
					$error = array('error' => $this->upload->display_errors(), 'upload_path' => $upath, 'allowed_types' => $this->config->item('allowed_img_types'));
					echo json_encode($error);
					$is_OK = false;
				}
				// Resize images
				$img = $this->upload->data();
				if ($img['file_name'] != null) {
					// Resize image
					$this->load->library('image_lib');
					$config['image_library'] = 'gd2';
					$config['source_image'] = $upath.$img['file_name'];
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['width']     = 100;

					$this->image_lib->clear();
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
				}
			}
			if($is_OK){
				echo json_encode(array('success' => true));
			}

		}
	}

	public function loadOthersImages($productId = null)
	{
		$output = '';
		if (isset($_POST['txt_folder']) && $_POST['txt_folder'] != null) {
			$dir = 'attachments' . DIRECTORY_SEPARATOR .'u'. $_POST['txt_folder'] . DIRECTORY_SEPARATOR .'details'. DIRECTORY_SEPARATOR;
			//$output = $dir;
			if (is_dir($dir)) {
				if ($dh = opendir($dir)) {
					$i = 0;
					while (($file = readdir($dh)) !== false) {
						if (is_file($dir . $file)) {
							if (strpos($file, '_thumb.') == true) {
								$output .= '
                                <div class="other-img" id="image-container-' . $i . '">
                                    <img src="' . base_url($dir . $file ) . '">
                                    <input type="hidden" name="otherImages[]" value="\'/' . $dir . $file . '\'"/>
                                    <a href="javascript:void(0);" onclick="removeSecondaryProductImage(\'' . $file . '\', \'' . $_POST['txt_folder'] . '\', ' . $i . ')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                               ';
							}
							$i++;
						}
					}
					closedir($dh);
				}
			}else{
				//$output = '<h2>Not valid</h2>'.$dir;
			}
		}else{
			//$output = '<h2>Not folder</h2>';
			if($productId != null){
				$productAssets = $this->ProductAsset_Model->findByProductIdFetchProductCode($productId);
				foreach ($productAssets as $asset){
					$output .= '
                                <div class="other-img" id="image-container-' . $asset->ProductAssetID . '">
                                    <img src="' . base_url($asset->Url) . '" >
                                    <input type="hidden" name="otherImages[]" value="\'/' . $asset->Url . '\'"/>
                                    <a href="javascript:void(0);" onclick="removeSecondaryProductImage(\'' . $asset->Name . '\', \''. $asset->Code . '\',\''. $asset->ProductAssetID.'\')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                                ';
				}
				
			}
		}
		if ($this->input->is_ajax_request()) {
			echo $output;
		} else {
			return $output;
		}
	}

	public function removeSecondaryImage(){
		if ($this->input->is_ajax_request()) {
			$img = 'attachments' . DIRECTORY_SEPARATOR .'u'. $_POST['txt_folder'] . DIRECTORY_SEPARATOR . $_POST['image'];
			unlink($img);
		}
	}
}
