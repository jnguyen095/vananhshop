<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 11:17 AM
 */
class Home_controller extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('cart');
		$this->load->model('Category_Model');
		$this->load->model('Product_Model');
		$this->load->helper("seo_url");
		$this->load->helper('text');
		$this->load->helper("my_date");
		$this->load->model('Banner_Model');
		$this->load->helper('form');

	}

	public function index() {
		$categories = $this->Category_Model->getActiveCategories();
		$data['categories'] = $categories;
		$newProducts = $this->Product_Model->topBestSellerProducts(12);
		$data['products'] = $newProducts;
		$data['topBanners'] = $this->Banner_Model->loadListByCode('BANNER_HOME_0');
		$data['middleBanner'] = $this->Banner_Model->loadListByCode('BANNER_HOME_1');
		$data['categoryTree'] = $this->Category_Model->getCategoryTree();
		$this->load->helper('url');
		$this->load->view('Home_view', $data);
	}

}
