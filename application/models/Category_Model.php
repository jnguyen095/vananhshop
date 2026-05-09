<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 3:18 PM
 */
class Category_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function getCategories() {
		$this->db->where("ParentID IS NULL");
		$this->db->order_by("DisplayIndex", "ASC");
		$query = $this->db->get("category");
		$roots = $query->result();

		$json_response = array();
		foreach ($roots as $parent){
			$row_array = array();
			$row_array['CategoryID'] = $parent->CategoryID;
			$row_array['CatName'] = $parent->CatName;
			$row_array['Active'] = $parent->Active;
			$row_array['nodes'] = array();
			$newlevel = $parent->CategoryID;

			$childs = $this->db
				->select('CategoryID, CatName, Active')
				->where('ParentID = '.$newlevel)
				->get('category')
				->result();
			if(count($childs) > 0){
				$row_array['nodes'] = array();
				foreach ($childs as $row) {
					array_push($row_array['nodes'],  [
						'CategoryID' => $row->CategoryID,
						'CatName' => $row->CatName,
						'Active' => $row->Active
					]);
				}
			}
			array_push($json_response, $row_array);
		}

		return $json_response;
	}

	public function getActiveCategories() {
		$this->db->where("ParentID IS NULL AND Active = 1");
		$this->db->order_by("DisplayIndex", "ASC");
		$query = $this->db->get("category");
		$roots = $query->result();

		$json_response = array();
		foreach ($roots as $parent){
			$row_array = array();
			$row_array['CategoryID'] = $parent->CategoryID;
			$row_array['CatName'] = $parent->CatName;
			$row_array['nodes'] = array();
			$newlevel = $parent->CategoryID;

			$childs = $this->db
				->select('CategoryID, CatName')
				->where('ParentID = '.$newlevel . ' AND Active = 1')
				->get('category')
				->result();
			if(count($childs) > 0){
				foreach ($childs as $row) {
					$row_array['nodes'][] = array(
						'CategoryID' => $row->CategoryID,
						'CatName' => $row->CatName
					);
				}
			}
			array_push($json_response, $row_array);
		}

		return $json_response;
	}

	public function getCategoryTree() {
		$this->db->where("ParentID IS NULL AND Active = 1");
		$this->db->order_by("DisplayIndex", "ASC");
		$query = $this->db->get("category");
		$rows = $query->result();

		$json_response = array();
		foreach ($rows as $row){
			$row_array = array();
			$row_array['CategoryID'] = $row->CategoryID;
			$row_array['CatName'] = $row->CatName;
			$row_array['nodes'] = array();
			$newlevel = $row->CategoryID;

			$childs = $this->db
				->select('CategoryID, CatName, Image')
				->where('ParentID = '.$newlevel.' AND Image <> \'\'')
				->get('category')
				->result();
			if(count($childs) > 0){
				foreach ($childs as $row) {
					$row_array['nodes'][] = array(
						'CategoryID' => $row->CategoryID,
						'CatName' => $row->CatName,
						'Image' => $row->Image,
					);
				}
			}
			array_push($json_response, $row_array);
		}

		return $json_response;
	}

	public function getRootCategories() {
		$this->db->where("ParentID IS NULL and Active = 1");
		$this->db->order_by("DisplayIndex", "ASC");
		$query = $this->db->get("category");
		$data['categories'] = $query->result();
		return $data;
	}

	public function findById($catId){
		$this->db->where("CategoryID = " . $catId);
		$query = $this->db->get("category");

		$data = $query->row();
		if(isset($data->ParentID)){
			$this->db->where("CategoryID = " . $data->ParentID);
			$query = $this->db->get("category");

			$data->Parent = $query->row();
		}
		return $data;
	}

	public function findByNotChildId($catId){
		$this->db->where("CategoryID = " . $catId);
		$query = $this->db->get("category");
		$data = $query->row();
		return $data;
	}


	public function findByParentId($parentId=null, $currentId=null){
		//$this->output->enable_profiler(TRUE);
		if($parentId != null){
			$sql = 'select c.*, (select count(*) from product p where p.categoryid = c.categoryid) as total from category c where c.ParentID = '. $parentId;
			if($currentId != null){
				$sql .= ' and c.CategoryID != '. $currentId;
			}
			$query = $this->db->query($sql);
			return $query->result();
		}else if($currentId != null){
			$sql = 'select c.*, (select count(*) from product p where p.categoryid = c.categoryid) as total from category c where c.ParentID = '. $currentId;
			$query = $this->db->query($sql);
			return $query->result();
		}
	}

	public function findByCatName($catName, $categoryId){
		$this->db->where("CatName = '" . $catName . "'");
		if($categoryId != null){
			$this->db->where("CategoryID <> {$categoryId}");
		}

		$query = $this->db->get("category");
		$data = $query->row();
		return $data;
	}

	public function saveOrUpdate($data){
		if($data['CategoryID'] == null){
			$newData = array(
				'CatName' => $data['txt_catname'],
				'Active' => $data['ch_status'],
				'DisplayIndex' => $data['index'],
				'Image' => $data['txt_image'],
				'Banner' => $data['txt_banner'],
				'ParentID' => isset($data['txt_parent']) && strlen($data['txt_parent']) > 0 ? $data['txt_parent'] : NULL
			);
			$this->db->insert('category', $newData);
			$insert_id = $this->db->insert_id();
		} else{
			$this->db->set('CatName', $data['txt_catname']);
			$this->db->set('Active', $data['ch_status']);
			$this->db->set('DisplayIndex', $data['index']);
			$this->db->set('ParentID', isset($data['txt_parent']) && strlen($data['txt_parent']) > 0 ? $data['txt_parent'] : NULL);
			if(isset($data['txt_image']) && strlen($data['txt_image']) > 0){
				$this->db->set('Image', $data['txt_image']);
			}
			if(isset($data['txt_banner']) && strlen($data['txt_banner']) > 0){
				$this->db->set('Banner', $data['txt_banner']);
			}

			$this->db->where('CategoryID', $data['CategoryID']);
			$this->db->update('category');
		}


		return $insert_id;
	}

	public function deleteCategoryAndSubCategory($categoryId){
		$this->db->delete('category', array('ParentID' => $categoryId));
		$this->db->delete('category', array('CategoryID' => $categoryId));
	}

}
