<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 8/24/2017
 * Time: 3:22 PM
 */
class ProductAsset_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function findByProductId($productId) {
		$this->db->where(array("ProductID" => $productId));
		$query = $this->db->get("productasset");
		$productassets = $query->result();
		return $productassets;
	}

	public function findByProductIdFetchProductCode($productId) {
		$sql = 'select pa.ProductAssetID, pa.Url, pa.Name, p.Code from productasset pa left join product p on pa.ProductID = p.ProductID';
		$sql .= ' where pa.ProductId = '. $productId;
		$query = $this->db->query($sql);
		return $query->result();
	}
}
