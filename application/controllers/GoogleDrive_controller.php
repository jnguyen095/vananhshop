<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 16/08/2018
 * Time: 2:04 PM
 */
class GoogleDrive_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('google');
	}

	public function index(){
		$this->view->load("post/gdrive");
	}
}
