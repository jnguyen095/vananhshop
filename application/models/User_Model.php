<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/15/2017
 * Time: 2:50 PM
 */
class User_Model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();

	}

	function getUserById($id)
	{
		$sql = "select * from us3r where Us3rID = ". $id;
		$query = $this->db->query($sql);
		return $query->row();
	}

	function checkExistUserName($phone)
	{
		$this->db->where('Phone', $phone);
		$query = $this->db->get('us3r');
		return $query->num_rows();
	}

	function checkExistUserNameAddGroup($phone, $groupId, $userId){
		$this->db->where('Phone', $phone);
		$this->db->where('UserGroupID', $groupId);
		if($userId != null){
			$this->db->where('Us3rID !=', $userId);
		}
		$query = $this->db->get('us3r');
		return $query->num_rows();
	}

	function addNewUser($data, $groupId)
	{
		$userId = $data['Us3rID'];
		if($userId == null){
			$newdata = array(
				'FullName' => $data['fullname'],
				'Password' => md5($data['password']),
				'Email' => $data['email'],
				'Phone' => $data['phone'],
				'CreatedDate' => date('Y-m-d H:i:s'),
				'UpdatedDate' => date('Y-m-d H:i:s'),
				'Status' => (isset($data['status']) ? $data['status'] : ACTIVE),
				'UserGroupID' => $groupId
			);
			$this->db->insert('us3r', $newdata);
			$userId = $this->db->insert_id();
		} else {
			$newdata = array(
				'FullName' => $data['fullname'],
				'UserGroupID' => $groupId,
				'Email' => $data['email'],
				'Status' => $data['status'],
				'Phone' => $data['phone'],
				'UpdatedDate' => date('Y-m-d H:i:s')
			);
			if(isset($data['password']) && strlen($data['password']) > 0) {
				$newdata['Password'] = md5($data['password']);
			}
			$this->db->where('Us3rID', $userId);
			$this->db->update('us3r', $newdata);
		}

		return $userId;

	}

	function updateUser($data)
	{
		$userId = $data['UserId'];

		$newdata = array(
			'FullName' => $data['txt_fullname'],
			'Email' => $data['txt_email'],
			'Phone' => $data['txt_phone'],
			'UpdatedDate' => date('Y-m-d H:i:s')
		);
		$this->db->where('Us3rID', $userId);
		$this->db->update('us3r', $newdata);
	}

	function getAllUsers($offset, $limit, $st, $orderField, $orderDirection){
		//$this->output->enable_profiler(TRUE);
		$query = $this->db->select('u.*')
			->from('us3r u')
			//->join('product p', 'u.Us3rID = p.CreatedByID', 'left')
			->where_in('UserGroupID', [USER_GROUP_CUSTOMER, USER_GROUP_ADMIN])
			->group_start()
			->like('u.FullName', $st)
			->or_like('u.Email', $st)
			->or_like('u.Phone', $st)
			->group_end()
			->limit($limit, $offset)
			->group_by('u.Us3rID')
			->order_by($orderField, $orderDirection)
			->get();

		// $query = $this->db->or_like('FullName', $st)->or_like('Email', $st)->or_like('Phone', $st)->limit($limit, $offset)->order_by($orderField, $orderDirection)->get('us3r');
		$result['items'] = $query->result();
		$query = $this->db->where_in('UserGroupID', [USER_GROUP_CUSTOMER, USER_GROUP_ADMIN])->like('FullName', $st)->or_like('Email', $st)->or_like('Phone', $st)->get('us3r');
		$result['total'] = $query->num_rows();
		return $result;
	}

	function getAllStaff($offset, $limit, $st, $orderField, $orderDirection){
		//$this->output->enable_profiler(TRUE);
		$query = $this->db->select('u.*')
			->from('us3r u')
			//->join('product p', 'u.Us3rID = p.CreatedByID', 'left')
			->where_in('UserGroupID', [USER_GROUP_STAFF])
			->limit($limit, $offset)
			->group_by('u.Us3rID')
			->order_by($orderField, $orderDirection)
			->get();

		// $query = $this->db->or_like('FullName', $st)->or_like('Email', $st)->or_like('Phone', $st)->limit($limit, $offset)->order_by($orderField, $orderDirection)->get('us3r');
		$result['items'] = $query->result();
		$query = $this->db->where_in('UserGroupID', [USER_GROUP_STAFF])->get('us3r');
		$result['total'] = $query->num_rows();
		return $result;
	}

	function changePassword($userId, $newPw){
		$newdata = array(
			'Password' => md5($newPw),
			'UpdatedDate' => date('Y-m-d H:i:s')
		);
		$this->db->where('Us3rID', $userId);
		$this->db->update('us3r', $newdata);
	}

	function checkIfPhoneAndEmailExisting($phone, $email){
		$user = $this->db->select('Us3rID')
			->from('us3r')
			->where(array('Email' => $email, 'Phone' => $phone))
			->get()
			->row();
		return $user != null ? $user -> Us3rID : null;
	}

	function updatePasswordByEmail($email, $password){
		$newdata = array(
			'Password' => $password,
			'UpdatedDate' => date('Y-m-d H:i:s')
		);
		$this->db->where('Email', $email);
		$this->db->update('us3r', $newdata);
	}

	function deleteByUserId($userId){
		$this->db->delete('us3r', array('Us3rID' => $userId));
		// TODO: delete reference tables
	}

}
