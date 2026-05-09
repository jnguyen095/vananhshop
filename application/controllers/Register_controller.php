<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/24/2017
 * Time: 4:13 PM
 */
class Register_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('date');
		//$this->load->database();
		$this->load->library('form_validation');
		//load the login model
		$this->load->model('Login_Model');
		$this->load->model('User_Model');
		$this->load->model('City_Model');
		$this->load->model('Category_Model');
		$this->load->helper("seo_url");
		$this->load->library('cart');
		$this->load->helper('my_email');
	}

	public function index()
	{
		// begin file cached
		$this->load->driver('cache');
		$categories = $this->cache->file->get('categories');
		$footerMenus = $this->cache->file->get('footer');
		if(!$categories){
			$categories = $this->Category_Model->getActiveCategories();
			$this->cache->file->save('categories', $categories, 1440);
		}
		$data['categories'] = $categories;
		// end file cached

		if($this->input->post('crudaction') == "register"){
			$this->form_validation->set_message('txt_fullname', 'Họ tên không được để trống');

			$this->form_validation->set_rules("txt_fullname", "Họ tên", "trim|required");
			$this->form_validation->set_rules("txt_password", "Mật khẩu", "trim|required");
			$this->form_validation->set_rules("txt_email", "Email", "valid_email");
			$this->form_validation->set_rules('txt_phone', 'Số điện thoại', 'trim|required|regex_match[/^[0-9]{10,11}$/]'); //{10} for 10 or 11 digits number

			if ($this->form_validation->run()) {
				$fullname = $this->input->post('txt_fullname');
				$password = $this->input->post('txt_password');
				$email = $this->input->post('txt_email');
				$phone = $this->input->post('txt_phone');

				$count = $this->User_Model->checkExistUserName($phone);
				if($count > 0){
					$data['error_response'] = 'Số điện thoại này đã có trong hệ thống, vui lòng kiểm tra lại';
					// $this->load->view('login/register', $data);
				}else{
					$newdata['Us3rID'] = null;
					$newdata['fullname'] = $fullname;
					$newdata['password'] = $password;
					$newdata['email'] = $email;
					$newdata['phone'] = $phone;

					$this->User_Model->addNewUser($newdata, USER_GROUP_CUSTOMER);
					$this->session->set_flashdata('message_response', 'Đăng ký tài khoản thành công, hãy đăng nhập');
					if($email != null && valid_email($email)){
						my_send_email($email,"Lamnongvui.com - Đăng ký tài khoản thành công", "<p>Đăng nhập tại đây: https://lamnongvui.com/dang-nhap.html</p>" );
					}
					redirect('dang-nhap');
				}
			}
		}
		$this->load->view('login/register', $data);
	}
}
