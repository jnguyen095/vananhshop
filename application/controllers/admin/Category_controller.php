<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 10/3/2023
 * Time: 8:51 PM
 */

class Category_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Category_Model');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
		$this->load->helper("seo_url");
		$this->load->library('form_validation');
	}

	public function index()
	{
		$msg = "";
		if ($this->input->post('crudaction') == "delete") {
			$categoryId = $this->input->post("categoryId");
			if($categoryId != null){
				$this->Category_Model->deleteCategoryAndSubCategory($categoryId);
				$msg = "Xóa danh mục thành công.";
			}
		}
		$data['categories'] = $this->Category_Model->getCategories();
		$data['message_response'] = $msg;
		$this->load->view("admin/category/list", $data);
	}

	public function add($categoryId = null)
	{
		$data['categories'] = $this->Category_Model->getCategories();
		//print_r($data);
		$data['CategoryID'] = $categoryId;
		if ($this->input->post('crudaction') == "insert") {
			$parentID = $this->input->post("txt_parent");
			$index = $this->input->post("txt_index");
			$data['txt_parent'] = isset($parentID) ? $parentID : null;
			$data['txt_catname'] = $this->input->post("txt_catname");
			$data['ch_status'] = $this->input->post("ch_status") == null ? INACTIVE : ACTIVE;
			$data['index'] = isset($index) ? $index : 0;
			$preImg = $this->input->post("preImg");
			$img = $this->uploadImage();
			if($img == null && $preImg != null){
				$img = $preImg;
			}
			$data['txt_image'] = $img;

			$banner = $this->uploadBanner();
			$data['txt_banner'] = $banner;


			//set validations
			$this->form_validation->set_rules("txt_catname", "Tên danh mục", "trim|required");
			$validateResult = $this->form_validation->run();
			if ($validateResult == TRUE) {
				if($this->Category_Model->findByCatName($data['txt_catname'], $data['CategoryID']) == null){
					$dbid = $this->Category_Model->saveOrUpdate($data);
					$data['categoryID'] = $dbid;
					redirect('admin/category/list');
				}else{
					$data['error_message'] = "The Code field must contain a unique value.";
				}
			}
		}
		if($categoryId != null){
			$category = $this->Category_Model->findById($categoryId);
			$data['txt_catname'] = $category->CatName;
			$data['txt_parent'] = $category->ParentID;
			$data['ch_status'] = $category->Active;
			$data['txt_image'] = $category->Image;
			$data['txt_banner'] = $category->Banner;
			$data['index'] = $category->DisplayIndex;
		}

		$this->load->view("admin/category/edit", $data);
	}

	private function uploadImage(){
		if(!empty($this->input->post("txt_image"))){
			return $this->input->post("txt_image");
		}else{
			$this->allowed_img_types = $this->config->item('allowed_img_types');
			$upath = 'img' . DIRECTORY_SEPARATOR .'category'. DIRECTORY_SEPARATOR;

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
			return $img['file_name'];
		}
	}

	private function uploadBanner(){
		if(!empty($this->input->post("txt_banner"))){
			return $this->input->post("txt_banner");
		}else{
			$this->allowed_img_types = $this->config->item('allowed_img_types');
			$upath = 'img' . DIRECTORY_SEPARATOR .'category'. DIRECTORY_SEPARATOR;

			if (!file_exists($upath)) {
				mkdir($upath, 0777, true);
			}

			$config['upload_path'] = $upath;
			$config['allowed_types'] = $this->allowed_img_types;
			$config['remove_spaces'] = true;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('txt_banner')) {
				log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
			}
			$img = $this->upload->data();
			return $img['file_name'];
		}
	}
}
