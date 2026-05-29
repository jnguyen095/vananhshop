<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 10/3/2023
 * Time: 8:51 PM
 */

class Property_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Property_Model');
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
			$propertyID = $this->input->post("propertyId");
			if($propertyID != null){
				$this->db->delete('property', array('ParentID' => $propertyID));
				$this->db->delete('property', array('PropertyID' => $propertyID));
				$msg = "Xóa danh mục thành công.";
			}
		}
		$data = $this->Property_Model->getProperties();
		$data['message_response'] = $msg;
		$this->load->view("admin/property/list", $data);
	}

	public function add($propertyId = null)
	{
		$data = $this->Property_Model->getProperties();
		if($propertyId != null){
			$data['PropertyID'] = $propertyId;
		}

		if ($this->input->post('crudaction') == "insert") {
			$parentID = $this->input->post("txt_parent");
			$data['txt_parent'] = isset($parentID) ? $parentID : null;
			$data['txt_propertyname'] = $this->input->post("txt_propertyname");
			$data['ch_status'] = $this->input->post("ch_status") == null ? INACTIVE : ACTIVE;
			$data['index'] = 0;

			//set validations
			$this->form_validation->set_rules("txt_propertyname", "Tên khu vực", "trim|required");
			$validateResult = $this->form_validation->run();
			if ($validateResult == TRUE) {
				if($this->Property_Model->findByPropertyName($data['txt_propertyname'], $data['txt_parent']) == null){
					$this->Property_Model->saveOrUpdate($data);
					redirect('admin/property/list');
				}else{
					$data['error_message'] = "Tên khu vực bị trùng.";
				}
			}
		}
		if($propertyId != null){
			$property = $this->Property_Model->findById($propertyId);
			$data['txt_propertyname'] = $property->PropertyName;
			$data['txt_parent'] = $property->ParentID;
			$data['ch_status'] = $property->Status;
		}

		$this->load->view("admin/property/edit", $data);
	}
}
