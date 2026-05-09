<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 11/24/2023
 * Time: 7:13 PM
 */

class POS_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('loginid')){
			redirect('dang-nhap');
			//$this->session->set_userdata('loginid', 0);
		}
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('date');
		$this->load->helper("seo_url");
		$this->load->library('form_validation');
		$this->load->model('Category_Model');
		$this->load->model('Product_Model');
		$this->load->model('User_Model');
	}

	public function index()
	{
		$this->load->view('pos/index');
	}

	public function loadTabContent(){
		$tabID = $this->input->post('tabID');
		$categories = $this->Category_Model->getCategories();
		$data = $categories;
		$products = $this->Product_Model->loadAvailableProducts(0, 10, null, null, null, null);
		$data['products'] = $products['products'];
		$data['total'] = $products['total'];
		$data['tabID'] = $tabID;
		$this->load->view('pos/tab-content', $data);
	}

	public function loadProductByCatId(){
		$catId = $this->input->post('catId');
		$tabID = $this->input->post('tabID');
		if($catId > 0){
			$products = $this->Product_Model->findByCatId($catId);
		}else{
			$products = $this->Product_Model->loadAvailableProducts(0, 10, null, null, null, null);
		}
		
		$data['products'] = $products['products'];
		$data['total'] = $products['total'];
		$data['tabID'] = $tabID;
		$this->load->view('pos/product-list', $data);
	}

	public function getCustomerList(){
		$keyword = $this->input->post('keyword');
		$tabID = $this->input->post('tabID');
		$results = $this->User_Model->getAllUsers(0, 20, $keyword, "CreatedDate", "DESC");
		$data['users'] = $results['items'];
		$data['tabID'] = $tabID;
		$this->load->view('pos/customer-list', $data);
	}

	public function getCustomerById(){
		$userId = $this->input->post('userId');
		$tabID = $this->input->post('tabID');
		$user = $this->User_Model->getUserById($userId);
		$data['user'] = $user;
		$data['tabID'] = $tabID;
		$this->load->view('pos/customer-info', $data);
	}

	public function getCustomerNameById(){
		$userId = $this->input->post('userId');
		$tabID = $this->input->post('tabID');
		$user = $this->User_Model->getUserById($userId);
		echo $user->FullName;
	}

	public function getProductById(){
		$productId = $this->input->post('productId');
		$product = $this->Product_Model->findById($productId);
		echo json_encode($product);
	}

	public function getCategoryById(){
		$catId = $this->input->post('catId');
		$category = $this->Category_Model->findByNotChildId($catId);
		echo json_encode($category);
	}

}
