<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/3/2017
 * Time: 10:25 AM
 */
class UserManagement_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('User_Model');
		$this->load->model('UserGroup_Model');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
	}

	public function index()
	{
		$config = pagination($this);
		$config['base_url'] = base_url('admin/user/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "CreatedDate";
			$config['orderDirection'] = "DESC";
		}
		$results = $this->User_Model->getAllUsers($config['page'], $config['per_page'], $config['searchFor'], $config['orderField'], $config['orderDirection']);
		$data['users'] = $results['items'];
		$config['total_rows'] = $results['total'];

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view("admin/user/list", $data);
	}

	public function staff()
	{
		$config = pagination($this);
		$config['base_url'] = base_url('admin/staff/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "CreatedDate";
			$config['orderDirection'] = "DESC";
		}
		$results = $this->User_Model->getAllStaff($config['page'], $config['per_page'], $config['searchFor'], $config['orderField'], $config['orderDirection']);
		$data['staffs'] = $results['items'];
		$config['total_rows'] = $results['total'];

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view("admin/staff/list", $data);
	}

	public function addStaff($staffId = null){

		$data = [];
		$data["userGroups"] = $this->UserGroup_Model->getAllUserGroup();
		$data["staffId"] = $staffId;
		$data["ch_status"] = 1;
		if($staffId != null){
			$staff = $this->User_Model->getUserById($staffId);
			$data['staffID'] = $staff->Us3rID;
			$data['txt_fullname'] = $staff->FullName;
			$data['txt_password'] = $staff->Password;
			$data['txt_email'] = $staff->Email;
			$data['txt_phone'] = $staff->Phone;
			$data['txt_userGroupID'] = $staff->UserGroupID;
			$data["ch_status"] = $staff->Status;
		}
		if($this->input->post('crudaction') == "insert"){
			$this->form_validation->set_message('txt_fullname', 'Họ tên không được để trống');
			$this->form_validation->set_rules("txt_userGroupID", "Nhóm người dùng", "trim|required");
			$this->form_validation->set_rules("txt_fullname", "Họ tên", "trim|required");
			if($staffId == null){
				$this->form_validation->set_rules("txt_password", "Mật khẩu", "trim|required");
			}

			$this->form_validation->set_rules("txt_email", "Email", "valid_email");
			$this->form_validation->set_rules('txt_phone', 'Số điện thoại', 'regex_match[/^[0-9]{10,11}$/]'); //{10} for 10 or 11 digits number

			if ($this->form_validation->run() == FALSE)
			{
				$data['txt_userGroupID'] = $this->input->post('txt_userGroupID');
				//validation fails
				$this->load->view('admin/staff/add', $data);
			}else{
				$fullname = $this->input->post('txt_fullname');
				$password = $this->input->post('txt_password');
				$email = $this->input->post('txt_email');
				$phone = $this->input->post('txt_phone');
				$address = $this->input->post('txt_address');
				$status = $this->input->post('ch_status');
				$usergroup = $this->input->post('txt_userGroupID');

				$count = $this->User_Model->checkExistUserNameAddGroup($phone, $usergroup, $staffId);
				if($count > 0){

					$data['error_message'] = 'Tên đăng nhập đã tồn tại.';
					$this->load->view('admin/staff/add', $data);
				}else{
					$newdata['fullname'] = $fullname;
					$newdata['password'] = $password;
					$newdata['email'] = $email;
					$newdata['phone'] = $phone;
					$newdata['address'] = $address;
					$newdata['usergroup'] = $usergroup;
					$newdata['status'] = $status;

					if($staffId == null){
						$this->User_Model->addNewUser($newdata, $usergroup);
					}else{
						$this->User_Model->updateExistingUser($staffId, $newdata);
					}

					$data['message_response'] = 'Đăng ký thành công';
					redirect('admin/staff/list');
				}
			}
		}

		$this->load->view("admin/staff/add", $data);
	}

	public function addUser($userId = null){
		$data = [];
		$fullname = $this->input->post('txt_fullname');
		$password = $this->input->post('txt_password');
		$email = $this->input->post('txt_email');
		$phone = $this->input->post('txt_phone');
		$userGroupID = $this->input->post('txt_usergroup');
		$status = $this->input->post('ch_status');


		$data['txt_fullname'] = $fullname;
		$data['txt_password'] = $password;
		$data['txt_email'] = $email;
		$data['txt_phone'] = $phone;
		$data['txt_usergroup'] = $userGroupID;
		$data['ch_status'] = isset($status) ? $status : ACTIVE;


		if($userId != null){
			$staff = $this->User_Model->getUserById($userId);
			$data['staffID'] = $staff->Us3rID;
			$data['txt_fullname'] = $staff->FullName;
			$data['txt_password'] = $staff->Password;
			$data['txt_email'] = $staff->Email;
			$data['txt_phone'] = $staff->Phone;
			$data['txt_usergroup'] = $staff->UserGroupID;
			$data['ch_status'] = $staff->Status;
		}
		if($this->input->post('crudaction') == "insert"){
			$this->form_validation->set_message('txt_fullname', 'Họ tên không được để trống');
			$this->form_validation->set_rules("txt_fullname", "Họ tên", "trim|required");

			if($userId == null){
				$this->form_validation->set_rules("txt_password", "Mật khẩu", "trim|required");
			}
			$this->form_validation->set_rules("txt_email", "Email", "valid_email");
			$this->form_validation->set_rules('txt_phone', 'Số điện thoại', 'trim|required|regex_match[/^[0-9]{10,11}$/]'); //{10} for 10 or 11 digits number
			$this->form_validation->set_rules("txt_usergroup", "Nhóm người dùng", "required");

			if ($this->form_validation->run()) {
				$count = $this->User_Model->checkExistUserNameAddGroup($phone, $userGroupID, $userId);
				if($count > 0){
					$data['error_message'] = 'Tên đăng nhập đã tồn tại.';
					$this->load->view('admin/user/add', $data);
				}else{
					$newdata['Us3rID'] = $userId;
					$newdata['fullname'] = $fullname;
					$newdata['password'] = $password;
					$newdata['email'] = $email;
					$newdata['phone'] = $phone;
					$newdata['status'] = $status;

					$this->User_Model->addNewUser($newdata, $userGroupID);
					if($userId != null){
						$this->session->set_flashdata('message_response', 'Cập nhật tài khoản tài khoản thành công');
					} else {
						$this->session->set_flashdata('message_response', 'Thêm tài khoản tài khoản thành công');
					}
					redirect('admin/user/list');
				}
			}
		}

		$this->load->view("admin/user/add", $data);
	}
}
