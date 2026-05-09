<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 3:18 PM
 */
class Area_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function getAreas() {
		$this->db->where("ParentID IS NULL");

		$query = $this->db->get("area");

		$data['areas'] = $query->result();
		$child = [];
		foreach ($data as $key=>$value){
			foreach ($data[$key] as $k=>$v){
				$areaId = $v->AreaID;
				if($areaId != null){
					$this->db->where("ParentID = ". $areaId);
					$query = $this->db->get("area");
					$child[$areaId] = $query->result();
				}
			}
		}
		$data['child'] = $child;

		return $data;
	}

	public function getRootAreas() {
		$this->db->where("ParentID IS NULL and Active = 1");
		$query = $this->db->get("area");
		$data['areas'] = $query->result();
		return $data;
	}

	public function findById($catId){
		$this->db->where("AreaID = " . $catId);
		$query = $this->db->get("area");

		$data = $query->row();
		if(isset($data->ParentID)){
			$this->db->where("AreaID = " . $data->ParentID);
			$query = $this->db->get("area");

			$data->Parent = $query->row();
		}
		return $data;
	}

	public function findByNotChildId($catId){
		$this->db->where("AreaID = " . $catId);
		$query = $this->db->get("area");
		$data = $query->row();
		return $data;
	}

	public function findByAreaName($areaName, $arearId){
		$sql = "select * from area a where a.AreaName = '{$areaName}'";

		if($arearId != null){
			$sql .= " and a.ParentID = {$arearId}";
		}
		$query = $this->db->query($sql);
		$data = $query->row();
		return $data;
	}

	public function saveOrUpdate($data){
		if($data['AreaID'] == null){
			$newData = array(
				'AreaName' => $data['txt_areaname'],
				'Status' => $data['ch_status'],
				'ParentID' => isset($data['txt_parent']) && strlen($data['txt_parent']) > 0 ? $data['txt_parent'] : NULL
			);
			$this->db->insert('area', $newData);
			$insert_id = $this->db->insert_id();
		} else{
			$this->db->set('AreaName', $data['txt_areaname']);
			$this->db->set('Status', $data['ch_status']);
			$this->db->set('ParentID', isset($data['txt_parent']) && strlen($data['txt_parent']) > 0 ? $data['txt_parent'] : NULL);

			$this->db->where('AreaID', $data['AreaID']);
			$this->db->update('area');
		}


		return $insert_id;
	}

}
