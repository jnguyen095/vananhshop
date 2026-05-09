<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 11/17/2017
 * Time: 5:36 PM
 */
class BrandManagement_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Brand_Model');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
		$this->load->helper("seo_url");
		$this->load->library('form_validation');
	}

	public function index()
	{
		$config = pagination($this);
		$config['base_url'] = base_url('admin/brand/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "BrandID";
			$config['orderDirection'] = "DESC";
		}
		$results = $this->Brand_Model->findAndFilter($config['page'], $config['per_page'], $config['searchFor'], $config['orderField'], $config['orderDirection']);
		$data['brands'] = $results['items'];
		$config['total_rows'] = $results['total'];

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view("admin/brand/list", $data);
	}

	public function edit($brandId = null){
		$data = [];
		$data['BrandID'] = $brandId;

		if($this->input->post('crudaction') == "insert"){
			$this->form_validation->set_rules("BrandName", "Tên nhà cung cấp", "trim|required");
			$data['BrandName'] = $this->input->post('BrandName');
			$data['Description'] = $this->input->post('Description');
			if ($this->form_validation->run()) {
				$img = $this->uploadImage();
				if($img != null){
					$data['Thumb'] = $img;
				}

				$dbRow = $this->Brand_Model->findByName($data['BrandName'], $brandId);
				if($dbRow == null){
					$this->Brand_Model->saveOrUpdate($data, $brandId);
					$data['message_response'] = "Nhà cung cấp đã lưu mới thành công";
				} else {
					$data['error_message'] = "Nhà cung cấp này đã có trong hệ thống";
				}
			}
		}

		if($brandId != null){
			$data['brand'] = $this->Brand_Model->findById($brandId);
		}

		$this->load->view("admin/brand/edit", $data);
	}


	private function uploadImage(){
		if(!empty($this->input->post("txt_image"))){
			return $this->input->post("txt_image");
		}else{
			$this->allowed_img_types = $this->config->item('allowed_img_types');
			// $upath = 'img' . DIRECTORY_SEPARATOR .'product'. DIRECTORY_SEPARATOR;
			$upath = 'img' . DIRECTORY_SEPARATOR .'brand' . DIRECTORY_SEPARATOR;

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
}
