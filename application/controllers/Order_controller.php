<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/24/2017
 * Time: 1:19 PM
 */
class Order_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Product_Model');
		$this->load->model('Category_Model');
		$this->load->model('City_Model');
		$this->load->model('CallMeBack_Model');
		$this->load->helper("seo_url");
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper("bootstrap_pagination");
		$this->load->library('pagination');
		$this->load->model('User_Model');
		$this->load->model('MyOrder_Model');
		$this->load->model('OrderTracking_Model');
		$this->load->library('cart');
		$this->load->library('form_validation');
	}

	public function index()
	{
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');

		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}
		$data['categories'] = $categories;
		$txtText = $this->input->post("txtText");
		$this->form_validation->set_rules("txtText", "Mã đơn hàng/Số ĐT", "trim|required");
		$this->form_validation->run();
		$orders = $this->MyOrder_Model->findByOrderCodeOrPhoneOrEmail($txtText);
		$data['orders'] = $orders['items'];
		$data['txtText'] = $txtText;

		$this->load->view('order/list', $data);
	}

	public function viewDetail($orderId){
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}
		$data['categories'] = $categories;

		$order = $this->MyOrder_Model->findByOrderIdAndFetchAll($orderId);
		if(!isset($order) || $order['order'] == null){
			$this->load->view('Notfound_view', $data);
		} else {
			$data['order'] = $order['order'];
			$data['products'] = $order['products'];
			$data['shippingAddr'] = $order['shippingAddr'];
			$this->load->view('order/detail', $data);
		}
	}

	public function callMeBack($page = 0){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('category');
		$footerMenus = $this->cache->file->get('footer');
		if(!$categories){
			$categories = $this->Category_Model->getCategories();
			$this->cache->file->save('category', $categories, 1440);
		}
		if(!$footerMenus) {
			$footerMenus = $this->City_Model->findByTopProductOfCategoryGroupByCity();
			$this->cache->file->save('footer', $footerMenus, 1440);
		}
		$data = $categories;
		$data['footerMenus'] = $footerMenus;
		// end file cached

		$userId = $this->session->userdata('loginid');
		$crudaction = $this->input->post("crudaction");
		if($crudaction == UPDATE) {
			$callMeBackID = $this->input->post("callMeBackID");
			if ($callMeBackID != null && $callMeBackID > 0) {
				$resolved = 'RESOLVED';
				$this->CallMeBack_Model->updateMessage($callMeBackID, $resolved);
				$data['message_response'] = 'Cập nhật thành công.';
			}
		} else if($crudaction == 'update-all'){
			$resolved = 'RESOLVED';
			$this->CallMeBack_Model->updateAllMessage($userId, $resolved);
			$data['message_response'] = 'Cập nhật thành công.';
		}

		$callmebacks = $this->CallMeBack_Model->findByUserId($userId, $page);
		$data['callmebacks'] = $callmebacks['callmebacks'];

		$config = pagination();
		$config['base_url'] = base_url('yeu-cau-goi-lai.html');
		$config['total_rows'] = $callmebacks['total'];
		$config['per_page'] = 10;

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('post/callmeback', $data);
	}
}
