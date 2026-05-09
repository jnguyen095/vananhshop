<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/17/2017
 * Time: 10:39 AM
 */
class Ajax_controller extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('District_Model');
		$this->load->helper("seo_url");
		$this->load->model('Street_Model');
		$this->load->model('Product_Model');
		$this->load->model('FeedBack_Model');
		$this->load->model('User_Model');
		$this->load->model('CallMeBack_Model');
		$this->load->helper('captcha');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->helper('form');
	}

	public function findStreetByName(){
		$streetName = $this->input->get('query');
		$streetNames = $this->Street_Model->findByName($streetName);
		echo json_encode($streetNames);
	}

	public function findDistrictByCityId(){
		$cityId = $this->input->post('cityId');
		$districts = $this->District_Model->findByCityId($cityId);
		echo json_encode($districts);
	}

	public function findProductByCodeOrTitle(){
		$query = $this->input->get('query');
		$catId = $this->input->get('categoryId');
		$products = $this->Product_Model->findProductByCodeOrTitle($query, $catId);
		echo json_encode($products);
	}

	public function updateCoordinator(){
		$productId = $this->input->post('productId');
		$longitude = $this->input->post('lng');
		$latitude = $this->input->post('lat');
		$this->Product_Model->updateCoordinator($productId, $longitude, $latitude);
		echo json_encode('{success: true}');
	}

	public function updateViewForProductIdManual(){
		$productId = $this->input->post('productId');
		$view = $this->input->post('view');
		$this->Product_Model->updateViewForProductIdManual($productId, $view);
		echo json_encode('success');
	}

	public function updateVipPackageForProductId(){
		$productId = $this->input->post('productId');
		$vip = $this->input->post('vip');
		$this->Product_Model->updateVipPackageForProductId($productId, $vip);
		echo json_encode('success');
	}
	public function getGeoFromAddress(){
		$addr = $this->input->post('address');
		$address = $addr.', Việt Nam';
		$geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='. GOOGLE_MAP_KEY);
		// Convert the JSON to an array
		$geo = json_decode($geo, true);

		$latitude = 0;
		$longitude = 0;
		if ($geo['status'] == 'OK') {
			// Get Lat & Long
			$latitude = $geo['results'][0]['geometry']['location']['lat'];
			$longitude = $geo['results'][0]['geometry']['location']['lng'];
		}
		echo json_encode(array($longitude, $latitude));
	}

	public function getCaptchaImg(){
		$captcha = $this->generateCaptcha();
		$data['capchaImg'] = $captcha['image'];
		$this->session->set_userdata('captcha', $captcha['word']);
		echo json_encode(array($data));
	}

	private function generateCaptcha(){
		$config = array(
			'img_id'		=> 'captcha',
			'img_path'      => 'img/captcha/',
			'img_url'       => 'img/captcha/',
			'font_path'		=> 'admin/fonts/arial.ttf',
			'img_width'     => '150',
			'expiration'    => 7200,
			'img_height'    => 30,
			'word_length'   => 6,
			'font_size'     => 18,
			'line_count'	=> 10,
			'colors'        => array(
				'background' => array(255, 255, 255),
				'border' => array(204, 204, 204),
				'text' => array(255, 93, 14),
				'grid' => array(204, 204, 204)
			)
		);
		$captcha = create_captcha($config);
		return $captcha;
	}

	public function loadPrice4Package(){
		$package = $this->input->post('package');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$loginId = $this->session->userdata('loginid');

		if($package == 'standard'){
			$result["status"] = "free_cost";
			$result["val"] = "0";
			echo json_encode($result);
		}else{
			if(!isset($loginId) || $loginId == null){
				$result["status"] = "no_authenticated";
				$result["val"] = 0;
				echo json_encode($result);
			}else{
				$loginUser = $this->User_Model->getUserById($loginId);
				$availableMoney = $loginUser->AvailableMoney;

				if(isset($from_date) && $from_date != null && isset($to_date) && $to_date != null){
					$dateOne = DateTime::createFromFormat("d/m/Y", $from_date);
					$dateTwo = DateTime::createFromFormat("d/m/Y", $to_date);
					$interval = $dateOne->diff($dateTwo);
					$diffDay = $interval->days;
					$cost = 0;
					if($package == "vip0"){
						$cost = $diffDay * COST_VIP_0_PER_DAY;
					}else if($package == "vip1"){
						$cost = $diffDay * COST_VIP_1_PER_DAY;
					}else if($package == "vip2"){
						$cost = $diffDay * COST_VIP_2_PER_DAY;
					}else if($package == "vip3"){
						$cost = $diffDay * COST_VIP_3_PER_DAY;
					}
					$result["val"] = number_format($cost);
					if($availableMoney >= $cost){
						$result["status"] = "valid_payment";
					}else{
						$result["status"] = "not_enough_quota";
					}
					echo json_encode($result);
				}else{
					$result["status"] = "not_qualify_input";
					$result["val"] = 0;
					echo json_encode($result);
				}
			}
		}
	}

	public function contactFormHandler(){
		$crudaction = $this->input->post('crudaction');

		if($crudaction == 'insert'){
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('fullName','Họ tên', 'required');
			$this->form_validation->set_rules('phoneNumber','Số điện thoại', 'required');
			$this->form_validation->set_rules('email','Email','valid_email');
			$this->form_validation->set_rules('content','Nội dung','required');
			$this->form_validation->set_rules("txt_captcha", "Mã xác thực", "callback_validateCaptcha");
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}else{
				$fullName = $this->input->post('fullName');
				$phoneNumber = $this->input->post('phoneNumber');
				$email = $this->input->post('email');
				$content = $this->input->post('content');
				$ipAddress = $this->input->ip_address();
				$data['fullName'] = $fullName;
				$data['phoneNumber'] = $phoneNumber;
				$data['email'] = $email;
				$data['content'] = $content;
				$data['ipAddress'] = $ipAddress;
				$insert_id = $this->FeedBack_Model->addNewFeedBack($data);
				if($insert_id != null && $insert_id > 0){
					echo 'success';
				}else{
					echo 'failure';
				}
			}
		}else{
			$data = [];
			$captcha = $this->generateCaptcha();
			//print_r($captcha);
			//$data['captcha'] = $captcha;
			$data['capchaImg'] = $captcha['image'];
			$this->session->set_userdata('captcha', $captcha['word']);
			return $this->load->view('/contact/contact', $data);
		}

	}

	public function validateCaptcha($str){
		if($str != $this->session->userdata['captcha'])
		{
			$this->form_validation->set_message('validateCaptcha', '{field} không khớp');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function submitCallMeBack(){
		$crudaction = $this->input->post('crudaction');
		$postid = $this->input->post('postid');
		$data['success'] = 'FALSE';
		$data['postid'] = $postid;
		if($crudaction == 'insert'){
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('txt_phonenumber','Số điện thoại', 'required');
			if ($this->form_validation->run() == FALSE) {
				// echo validation_errors();
			}else{
				$fullName = $this->input->post('txt_fullname');
				$phoneNumber = $this->input->post('txt_phonenumber');
				$message = $this->input->post('txt_message');

				$data['fullName'] = $fullName;
				$data['phoneNumber'] = $phoneNumber;
				$data['message'] = $message;
				$data['status'] = 'WAITING_OWNER';
				$records = $this->CallMeBack_Model->checkExisting($data);
				if($records > 0){
					$data['success'] = 'EXISTED';
				} else {
					$insert_id = $this->CallMeBack_Model->addNew($data);
					if($insert_id != null && $insert_id > 0){
						$data['success'] = 'SUCCESS';
					}
				}
			}
		}

		return $this->load->view('/product/Callmeback', $data);
	}


}
