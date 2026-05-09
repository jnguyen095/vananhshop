<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/5/2017
 * Time: 12:58 PM
 */
class StaticPage_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('StaticPage_Model');
		$this->load->model('Category_Model');
		$this->load->model('City_Model');
		$this->load->helper("seo_url");
		$this->load->helper('form');
		$this->load->library('cart');
		$this->load->library('form_validation');
		$this->load->helper('my_email');
	}

	// Dieu khoan su dung
	public function term(){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}
		$data['categories'] = $categories;
		$cities = $this->cache->file->get('cities');
		if(!$cities){
			$cities = $this->City_Model->getAllActive();
			$this->cache->file->save('cities', $cities, 1440);
		}
		$data['cities'] = $cities;
		// end file cached

		$page = $this->StaticPage_Model->findByCode('TERM');
		$data['page'] = $page;
		$this->StaticPage_Model->updateViewForPageWithCode('TERM');
		$this->load->view("/static/Dynamic_view", $data);
	}

	// Quy che hoat dong
	public function used(){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}
		$data['categories'] = $categories;
		$cities = $this->cache->file->get('cities');
		if(!$cities){
			$cities = $this->City_Model->getAllActive();
			$this->cache->file->save('cities', $cities, 1440);
		}
		$data['cities'] = $cities;
		// end file cached

		$page = $this->StaticPage_Model->findByCode('USED');
		$data['page'] = $page;
		$this->StaticPage_Model->updateViewForPageWithCode('USED');
		$this->load->view("/static/Dynamic_view", $data);
	}

	// tuyen dung
	public function carer(){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}

		$data['categories'] = $categories;
		$cities = $this->cache->file->get('cities');
		if(!$cities){
			$cities = $this->City_Model->getAllActive();
			$this->cache->file->save('cities', $cities, 1440);
		}
		$data['cities'] = $cities;
		// end file cached

		$page = $this->StaticPage_Model->findByCode('CARER');
		$data['page'] = $page;
		$this->StaticPage_Model->updateViewForPageWithCode('CARER');
		$this->load->view("/static/Dynamic_view", $data);
	}

	// thanh toan
	public function payment(){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}
		$data['categories'] = $categories;

		$cities = $this->cache->file->get('cities');
		if(!$cities){
			$cities = $this->City_Model->getAllActive();
			$this->cache->file->save('cities', $cities, 1440);
		}
		$data['cities'] = $cities;
		// end file cached

		$page = $this->StaticPage_Model->findByCode('PAYMENT');
		$data['page'] = $page;
		$this->StaticPage_Model->updateViewForPageWithCode('PAYMENT');
		$this->load->view("/static/Dynamic_view", $data);
	}

	// cau hoi thuong gap
	public function qna(){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}

		$data['categories'] = $categories;
		// end file cached

		$page = $this->StaticPage_Model->findByCode('QNA');
		$data['page'] = $page;
		$this->StaticPage_Model->updateViewForPageWithCode('QNA');
		$this->load->view("/static/Dynamic_view", $data);
	}

	// cau hoi thuong gap
	public function about(){
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}

		$data['categories'] = $categories;
		// end file cached

		$page = $this->StaticPage_Model->findByCode('ABOUTUS');
		$data['page'] = $page;
		$this->StaticPage_Model->updateViewForPageWithCode('ABOUTUS');
		$this->load->view("/static/Dynamic_view", $data);
	}
}
