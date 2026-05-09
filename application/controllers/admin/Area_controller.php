<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 10/3/2023
 * Time: 8:51 PM
 */

class Area_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Area_Model');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
		$this->load->helper("seo_url");
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data = $this->Area_Model->getAreas();
		$this->load->view("admin/area/list", $data);
	}

	public function add($areaId = null)
	{
		$data = $this->Area_Model->getAreas();
		if($areaId != null){
			$data['AreaID'] = $areaId;
		}

		if ($this->input->post('crudaction') == "insert") {
			$parentID = $this->input->post("txt_parent");
			$data['txt_parent'] = isset($parentID) ? $parentID : null;
			$data['txt_areaname'] = $this->input->post("txt_areaname");
			$data['ch_status'] = $this->input->post("ch_status") == null ? INACTIVE : ACTIVE;
			$data['index'] = 0;

			//set validations
			$this->form_validation->set_rules("txt_areaname", "Tên khu vực", "trim|required");
			$validateResult = $this->form_validation->run();
			if ($validateResult == TRUE) {
				if($this->Area_Model->findByAreaName($data['txt_areaname'], $data['txt_parent']) == null){
					$this->Area_Model->saveOrUpdate($data);
					redirect('admin/area/list');
				}else{
					$data['error_message'] = "Tên khu vực bị trùng.";
				}
			}
		}
		if($areaId != null){
			$area = $this->Area_Model->findById($areaId);
			$data['txt_areaname'] = $area->AreaName;
			$data['txt_parent'] = $area->ParentID;
			$data['ch_status'] = $area->Status;
		}

		$this->load->view("admin/area/edit", $data);
	}
}
