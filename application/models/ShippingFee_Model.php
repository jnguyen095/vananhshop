<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 3:18 PM
 */
class ShippingFee_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	function insert($fees){
		$this->db->empty_table('shippingfee');

		foreach ($fees as $fee){
			$data = array(
				'OrderValueFrom' => $fee['from'],
				'OrderValueTo' => $fee['to'],
				'ShippingFee' => $fee['fee'],
				'Status' => ACTIVE,
			);
			$this->db->insert('shippingfee', $data);
		}
	}

	function findAll(){
		$this->db->order_by('OrderValueFrom', 'ASC');
		$query = $this->db->get('shippingfee');
		return $query->result();
	}
}
