<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/3/2017
 * Time: 9:35 AM
 */
class Admin_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_Model');
		$this->load->library('session');
	}

	public function index() {
		$data = [
			'totalActiveProducts' => $this->Dashboard_Model->countActiveProducts(),
			'totalOrderToday' => $this->Dashboard_Model->countOrders(true),
			'totalOrderAll' => $this->Dashboard_Model->countOrders(false),
			'revenueToday' => $this->Dashboard_Model->sumRevenue(true),
			'revenueAll' => $this->Dashboard_Model->sumRevenue(false),
			'quotationToday' => $this->Dashboard_Model->countQuotation(true),
			'quotationAll' => $this->Dashboard_Model->countQuotation(false),
			'feedbackToday' => $this->Dashboard_Model->countFeedback(true),
			'feedbackAll' => $this->Dashboard_Model->countFeedback(false),
			'topProducts' => $this->Dashboard_Model->topViewedProducts(5),
			'topOrderedProducts' => $this->Dashboard_Model->topOrderedProducts(5),
			// orders chart data for last 7 days (array of [date, count])
			'ordersChart' => json_encode($this->Dashboard_Model->getOrdersCountByDay(7))
		];
		$this->load->view('admin/dashboard', $data);
	}

	public function deleteAllCaptcha(){
		$files = glob('img/captcha/*.jpg'); // get all file names
		foreach($files as $file){ // iterate files
			if(is_file($file)) {
				unlink($file); // delete file
			}
		}
		echo json_encode('success');
	}
}
