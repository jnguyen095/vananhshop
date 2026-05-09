<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 3:18 PM
 */
class Property_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function getProperties() {
		$this->db->where("ParentID IS NULL");

		$query = $this->db->get("property");

		$data['properties'] = $query->result();
		$child = [];
		foreach ($data as $key=>$value){
			foreach ($data[$key] as $k=>$v){
				$propertyId = $v->PropertyID;
				if($propertyId != null){
					$this->db->where("ParentID = ". $propertyId);
					$query = $this->db->get("property");
					$child[$propertyId] = $query->result();
				}
			}
		}
		$data['child'] = $child;

		return $data;
	}

	public function getRootProperties() {
		$this->db->where("ParentID IS NULL and Active = 1");
		$query = $this->db->get("property");
		$data['properties'] = $query->result();
		return $data;
	}

	public function findById($propertyId){
		$this->db->where("PropertyID = " . $propertyId);
		$query = $this->db->get("property");

		$data = $query->row();
		if(isset($data->ParentID)){
			$this->db->where("PropertyID = " . $data->ParentID);
			$query = $this->db->get("property");

			$data->Parent = $query->row();
		}
		return $data;
	}

	public function findByNotChildId($propertyId){
		$this->db->where("PropertyID = " . $propertyId);
		$query = $this->db->get("property");
		$data = $query->row();
		return $data;
	}

	public function findByPropertyName($propertyName, $propertyId){
		$sql = "select * from property a where a.PropertyName = '{$propertyName}'";

		if($propertyId != null){
			$sql .= " and a.ParentID = {$propertyId}";
		}
		$query = $this->db->query($sql);
		$data = $query->row();
		return $data;
	}

	public function saveOrUpdate($data){
		if($data['PropertyID'] == null){
			$newData = array(
				'PropertyName' => $data['txt_propertyname'],
				'Status' => $data['ch_status'],
				'ParentID' => isset($data['txt_parent']) && strlen($data['txt_parent']) > 0 ? $data['txt_parent'] : NULL
			);
			$this->db->insert('property', $newData);
			$insert_id = $this->db->insert_id();
		} else{
			$this->db->set('PropertyName', $data['txt_propertyname']);
			$this->db->set('Status', $data['ch_status']);
			$this->db->set('ParentID', isset($data['txt_parent']) && strlen($data['txt_parent']) > 0 ? $data['txt_parent'] : NULL);

			$this->db->where('PropertyID', $data['PropertyID']);
			$this->db->update('property');
		}


		return $insert_id;
	}

}
