<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/26/2017
 * Time: 5:42 PM
 */
class Search_controller extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Category_Model');
		$this->load->model('Product_Model');
		$this->load->model('City_Model');
		$this->load->model('Brand_Model');
		$this->load->model('District_Model');
		$this->load->model('User_Model');
		$this->load->helper("seo_url");
		$this->load->helper('text');
		$this->load->helper("my_date");
		$this->load->helper("bootstrap_pagination");
		$this->load->library('pagination');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->library('cart');
	}

	public function index($offset=0){
		// begin file cached
		$data['categories'] = $this->Category_Model->getActiveCategories();

		$query = $this->input->get("query");
		$catId = $this->input->get("category");
		$discount = $this->input->get("discount");

		$config = pagination($this);
		$config['base_url'] = base_url('tim-kiem.html');
		$config['per_page'] = 18;

		$search_data = $this->Product_Model->searchByProperties($query, $catId, $discount, $config['page'], $config['per_page']);
		$data = array_merge($data, $search_data);

		$data['query'] = $query;
		$data['categoryId'] = $catId;
		$data['discount'] = $discount;
		if($catId != null && $catId > 0){
			$category = $this->Category_Model->findByNotChildId($catId);
			$data['category'] = $category;
		}

		$config['total_rows'] = $data['total'];
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$this->load->helper('url');

		$this->load->view('/search/Search_view', $data);
	}
}
