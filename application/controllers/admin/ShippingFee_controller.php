<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 1/8/2024
 * Time: 2:22 PM
 */

class ShippingFee_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Product_Model');
		$this->load->model('ProductAsset_Model');
		$this->load->model('Category_Model');
		$this->load->model('User_Model');
		$this->load->model('Property_Model');
		$this->load->model('ProductProperty_Model');
		$this->load->model('ShippingFee_Model');
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
		$crudaction = $this->input->post('crudaction');
		$data = [];
		if($crudaction == 'insert-update'){
			$fees = $this->input->post('fees');
			$this->ShippingFee_Model->insert($fees);
			$data['message_response'] = "Thêm mới phí giao hàng thành công";
		}
		$fees = $this->ShippingFee_Model->findAll();
		$data['fees'] = $fees;
		$this->load->view("admin/shippingfee/list", $data);
	}
}
