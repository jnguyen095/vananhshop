<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 11:27 AM
 */
class Product_controller extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('Category_Model');
		$this->load->model('Product_Model');
		$this->load->model('City_Model');
		$this->load->model('District_Model');
		$this->load->model('Brand_Model');
		$this->load->model('Banner_Model');
		$this->load->helper("seo_url");
		$this->load->helper("my_date");
		$this->load->helper("bootstrap_pagination");
		$this->load->library('pagination');
		$this->load->library('cart');
		$this->load->helper('form');
	}

	public function listItem($catId, $offset=0) {
		$data['categories'] = $this->Category_Model->getActiveCategories();
		$search_data = $this->Product_Model->findByCatIdFetchChildren($catId, $offset, MAX_PAGE_ITEM);
		$data = array_merge($data, $search_data);

		$thisCat = $this->Category_Model->findById($catId);
		$data['category'] = $thisCat;
		$data['sameLevels'] = $this->Category_Model->findByParentId($thisCat->ParentID, $catId);

		$config = pagination();
		$config['base_url'] = base_url(seo_url($data['category']->CatName).'-c'.$catId.'.html');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = MAX_PAGE_ITEM;

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->helper('url');
		$this->load->view('product/Product_list', $data);
	}

	public function detailItem($productId) {
		// $categories = $this->Category_Model->getCategories();
		$data['categories'] = $this->Category_Model->getActiveCategories();
		$product = $this->Product_Model->findByDetailId($productId);
		$data['product'] = $product;
		// print_r($product);
		$category = $this->Category_Model->findById($product->CategoryID);
		$data['category'] = $category;

		if(!isset($product) || $product->ProductID == null){
			// redirect("/khong-tim-thay");
			 $this->load->view('Notfound_view', $data);
		}
		$this->load->view('product/Product_detail', $data);
	}

	public function justUpdateItems($offset=0) {
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('category');
		$footerMenus = $this->cache->file->get('footer');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('category', $categories, 1440);
		}
		if(!$footerMenus) {
			$footerMenus = $this->City_Model->findByTopProductOfCategoryGroupByCity();
			$this->cache->file->save('footer', $footerMenus, 1440);
		}
		$data['categories'] = $categories;
		$data['footerMenus'] = $footerMenus;
		// end file cached

		$totalProduct = $this->Product_Model->countAllProduct();
		$justUpdateItems = $this->Product_Model->findJustUpdate($offset, MAX_PAGE_ITEM);
		$data['products'] = $justUpdateItems;

		$config = pagination();
		$config['base_url'] = base_url('/bat-dong-san-moi-cap-nhat.html');
		$config['total_rows'] = $totalProduct;
		$config['per_page'] = MAX_PAGE_ITEM;

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['cities'] = $this->City_Model->getAllActive();
		$data['topcityhasproduct'] = $this->City_Model->findTopCityHasProduct(20);
		$data['topbranchhasproduct'] = $this->Brand_Model->findTopBranchHasProduct(20);

		$this->load->helper('url');
		$this->load->view('product/Product_just_update', $data);
	}

	public function underOneBillion($offset=0){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('category');
		$footerMenus = $this->cache->file->get('footer');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('category', $categories, 1440);
		}
		if(!$footerMenus) {
			$footerMenus = $this->City_Model->findByTopProductOfCategoryGroupByCity();
			$this->cache->file->save('footer', $footerMenus, 1440);
		}
		$data['categories'] = $categories;
		$data['footerMenus'] = $footerMenus;
		// end file cached

		$totalProduct = $this->Product_Model->countProductUnderOneBillion();
		$underOneBillionItems = $this->Product_Model->findUnderOneBillion($offset, MAX_PAGE_ITEM);
		$data['products'] = $underOneBillionItems;

		$config = pagination();
		$config['base_url'] = base_url('/nha-dat-duoi-mot-ty.html');
		$config['total_rows'] = $totalProduct;
		$config['per_page'] = MAX_PAGE_ITEM;

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['cities'] = $this->City_Model->getAllActive();
		$data['topcityhasproduct'] = $this->City_Model->findTopCityHasProduct(20);
		$data['topbranchhasproduct'] = $this->Brand_Model->findTopBranchHasProduct(20);

		$this->load->helper('url');
		$this->load->view('product/Product_under_one_billion', $data);
	}
}
