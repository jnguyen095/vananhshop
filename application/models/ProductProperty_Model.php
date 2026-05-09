<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 11/24/2023
 * Time: 5:07 PM
 */

class ProductProperty_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function savingProductProperties($productId, $data){
		$sqlDel = "delete pp from productproperty pp where pp.ProductID = {$productId}";
		$this->db->query($sqlDel);

		foreach($data as $k => $v){
			if($v != null && $v > 0){
				$newData = array(
					'ProductID' => $productId,
					'PropertyID' => $k
				);

				$this->db->insert('productproperty', $newData);
			}
		}
	}

	public function findByProductId($productId){
		$sql = "select pp.PropertyID from productproperty pp where pp.ProductID = {$productId}";
		$query = $this->db->query($sql);
		return $query->result();
	}
}
