<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 3:18 PM
 */
class OrderTracking_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function findByOrderId($orderId){
		$sql = 'select * from ordertracking ot where ot.OrderID = '. $orderId. ' order by ot.CreatedDate DESC';
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function insert($orderTracking){
		// order tracking
		$this->db->insert('ordertracking', $orderTracking);
	}
}
