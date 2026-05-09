<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/22/2017
 * Time: 2:50 PM
 */
class Brand_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function findAll(){
		$query = $this->db->query("select * from brand order by BrandName ASC");
		return $query->result();
	}

	public function findById($branchId){
		$this->db->where("BrandID", $branchId);
		$query = $this->db->get("brand");
		return $query->row();
	}

	function findAndFilter($offset, $limit, $st, $orderField, $orderDirection){
		$query = $this->db->select('b.*')
			->from('brand b')
			->like('BrandName', isset($st) ? $st : "")
			->limit($limit, $offset)
			->order_by($orderField, $orderDirection)
			->get();

		$result['items'] = $query->result();


		$query = $this->db->like('BrandName', $st)->get('brand');
		$result['total'] = $query->num_rows();
		return $result;
	}

	function findByName($brandName, $brandId = null){
		$where = "BrandName like '%".$brandName. "%'";
		if($brandId != null){
			$where .= " AND BrandID <> ".$brandId;
		}
		$query = $this->db->select('b.*')
			->from('brand b')
			->where($where)
			->get();
		return $query->row();
	}

	public function saveOrUpdate($data){
		if(isset($data['BrandID']) && $data['BrandID'] == null){
			$newData = array(
				'BrandName' => $data['BrandName'],
				'Description' => $data['Description'],
				'Thumb' => $data['Thumb'],
				'ModifiedDate' => date('Y-m-d H:i:s')
			);
			$this->db->insert('brand', $newData);
		} else{
			$this->db->set('BrandName', $data['BrandName']);
			$this->db->set('Description', $data['Description']);
			$this->db->set('ModifiedDate', date('Y-m-d H:i:s'));
			if(isset($data['Thumb']) && strlen($data['Thumb']) > 0){
				$this->db->set('Thumb', $data['Thumb']);
			}
			$this->db->where('BrandID', $data['BrandID']);
			$this->db->update('brand');
		}
	}

	function updateHotForBrand($brandId, $hot){
		$this->db->set('Hot', $hot);
		$this->db->set('ModifiedDate', 'NOW()', false);
		$this->db->where('BrandID', $brandId);
		$this->db->update('brand');
	}

}
