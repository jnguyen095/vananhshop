<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 9/12/2017
 * Time: 9:31 AM
 */
class OrderShipping_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function findByOrderId($orderId){
		$query = $this->db->select('sh.*')
			->from('ordershipping sh')
			->where('sh.OrderID', $orderId)
			->get();
		$shipping = $query->row();
		return $shipping;
	}

	public function getLatestShippingAddr($userId){
		$query = $this->db->select('s.*')
			->from('myorder m')
			->join('ordershipping s', 'm.OrderID = s.OrderID', 'left')
			->where('m.CreatedBy', $userId)
			->limit(1)
			->order_by('m.CreatedDate', 'DESC')
			->get();

		return $query->row();
	}

	public function update($orderId, $shipping){
			$this->db->set('Receiver', $shipping['Receiver']);
			$this->db->set('Phone', $shipping['Phone']);
			$this->db->set('CityID', $shipping['CityID']);
			$this->db->set('DistrictID', $shipping['DistrictID']);
			$this->db->set('Street', $shipping['Street']);
			$this->db->where('OrderID', $orderId);
			$this->db->update('ordershipping');
	}
}
