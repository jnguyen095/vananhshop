<?php

class CallMeBack_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function checkExisting($data) {
		$this->db->where(array("PhoneNumber" => $data['phoneNumber'], "ProductID" => $data['postid']));
		$total = $this->db->count_all_results('callmeback');
		return $total;
	}

	function addNew($data)
	{
		$newdata = array(
			'FullName' => $data['fullName'],
			'Message' => $data['message'],
			'PhoneNumber' => $data['phoneNumber'],

			'CreatedDate' => date('Y-m-d H:i:s'),
			'UpdatedDate' => date('Y-m-d H:i:s'),
			'Status' => $data['status'],
			'ProductID' => $data['postid']
		);
		$this->db->insert('callmeback', $newdata);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function findByUserId($userId, $page) {
		$query = $this->db->select('cm.*,p.ProductID, p.Title')
			->from('callmeback cm')
			->join('product p', 'p.ProductID = cm.ProductID')
			->where('p.CreatedByID', $userId)
			->limit(10, $page)
			->order_by("CreatedDate", "desc")
			->get();
		$data['callmebacks'] = $query->result();

		$this->db->select('cm.*')
			->from('callmeback cm')
			->join('product p', 'p.ProductID = cm.ProductID')
			->where('p.CreatedByID', $userId);
		$total = $this->db->count_all_results();
		$data['total'] = $total;
		return $data;
	}

	public function updateMessage($callMeBackID, $status){
		$now = date('Y-m-d H:i:s');
		$this->db->set('Status', $status);
		$this->db->set('UpdatedDate', $now);
		$this->db->where('CallMeBackID', $callMeBackID);
		$this->db->update('callmeback');
	}

	public function updateAllMessage($userId, $status){
		$query = "update callmeback set UpdatedDate = now(), Status = '". $status . "' where Status = 'WAITING_OWNER' and ProductID in(select p.ProductID from product p where p.CreatedByID = " . $userId . ")";
		$this->db->query($query);
	}
}

