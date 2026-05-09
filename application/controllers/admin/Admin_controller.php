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
		$data = [];
		$this->load->view('admin/dashboard', $data);
	}
	public function updateStandardForPreviousPost(){
		$this->Dashboard_Model->updateStandardForPreviousPost();
		echo json_encode('success');
	}
	public function retainCrawlerVip(){
		$crawlerPost = !true;
		$this->Dashboard_Model->retainPreviousVip($crawlerPost);
		echo json_encode('success');
	}
	public function retainOwnerVip(){
		$owner = true;
		$this->Dashboard_Model->retainPreviousVip($owner);
		echo json_encode('success');
	}
	public function replaceThumbs(){
		$thumbs = ["https://file1.batdongsan.com.vn/images/no-photo.jpg", "https://dothi.net/Images/no-photo170.png", "https://nhadat.cafeland.vn/images/ico/cafeland.jpg"];
		$this->Dashboard_Model->updateProductHasNoThumb($thumbs, "/img/no_image.png");
		echo json_encode('success');
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
