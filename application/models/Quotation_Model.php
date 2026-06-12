<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 3:18 PM
 */
class Quotation_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function save($data){
		$quoteDetail = $data['products'];

		$quote = array(
			"Code" => $this->getNewQuotationCode(),
			"UUID" => $data['UUID'],
			"Name" => $data['name'],
			"Phone" => $data['phone'],
			"Email" => $data['email'],
			"Address" => $data['address'],
			"Note" => $data['note'],
			"Status" => QUOTE_STATUS_NEW,
			"RequestedDate" => date('Y-m-d H:i:s'),
			"ShippingFee" => 0,
			"Discount" => 0,
			"TotalPrice" => 0,
			"TotalProduct" => $data['totalProducts'],
			"TotalItems" => $data['totalItems']
		);
		$this->db->insert('quotation', $quote);
		$quotation_id = $this->db->insert_id();
		// insert quotation detail

		foreach ($quoteDetail as $item){
			$detail = array(
				"QuotationID" => $quotation_id,
				"ProductID" => $item['ProductID'],
				"Quantity" => $item['Quantity'],
				"Price" => 0,
				"OfferPrice" => 0
			);
			$this->db->insert('quotationdetail', $detail);
		}

		return $quotation_id;
	}

	private function getNewQuotationCode(){
		$sql = 'select q.Code from quotation q';
		$sql .= ' order by q.RequestedDate desc';
		$sql .= ' limit 1';
		$productCodes = $this->db->query($sql);
		$code = $productCodes->row();
		if($code != null){
			$newCode = (int)str_replace('VAQ-', '', $code->Code) + 1;
			if($newCode < 10){
				return "VAQ-0000".$newCode;
			} else if($newCode < 100){
				return "VAQ-000".$newCode;
			} else if($newCode < 1000){
				return "VAQ-0".$newCode;
			} else if($newCode < 10000){
				return "VAQ-".$newCode;
			}
		}else {
			return "VAQ-00001";
		}
	}

	function findAndFilter($offset, $limit, $status, $orderField, $orderDirection){
		// $this->output->enable_profiler(TRUE);

		if($status != null && $status > -1){
			$this->db->where('q.Status', $status);
		}

		$query = $this->db->select('q.*')
			->from('quotation q')
			->limit($limit, $offset)
			->order_by($orderField, $orderDirection)
			->get();

		$result['items'] = $query->result();

		if($status != null && $status > -1){
			$this->db->where('Status', $status);
		}
		$query = $this->db->get('quotation');
		$result['total'] = $query->num_rows();
		return $result;
	}

	function findByUUID($uuid){
		$this->db->where(array("UUID" => $uuid));
		$query = $this->db->get("quotation");
		$quote = $query->row();
		$quoteId = $quote->QuotationID;

		$query = $this->db->select('qd.QuotationDetailID, qd.Quantity, qd.OfferPrice, qd.ProductID, qd.Note, p.Title as ProductName, p.Thumb, p.ProductID, p.Code as ProductCode, p.Price as ReferencePrice, q.ValidDate')
			->from('quotationdetail qd')
			->join('quotation q', 'q.QuotationID = qd.QuotationID', 'inner')
			->join('product p', 'p.ProductID = qd.ProductID', 'inner')
			->where('qd.QuotationID', $quoteId)
			->get();
		$quoteDetail = $query->result();


		return ["quote" => $quote, "details" => $quoteDetail];
	}

	function findById($quoteId){
		$this->db->where(array("QuotationID" => $quoteId));
		$query = $this->db->get("quotation");
		$quote = $query->row();

		$query = $this->db->select('qd.QuotationDetailID, qd.Quantity, qd.OfferPrice, qd.ProductID, qd.Note, p.Title as ProductName, p.Code as ProductCode, p.Price as ReferencePrice')
			->from('quotationdetail qd')
			->join('quotation q', 'q.QuotationID = qd.QuotationID', 'inner')
			->join('product p', 'p.ProductID = qd.ProductID', 'inner')
			->where('qd.QuotationID', $quoteId)
			->get();
		$quoteDetail = $query->result();


		return ["quote" => $quote, "details" => $quoteDetail];
	}

	function deleteById($quoteId){
		$this->db->delete('quotationdetail', array('QuotationID' => $quoteId));
		$this->db->delete('quotation', array('QuotationID' => $quoteId));
	}

	function updateQuote($quoteId, $loginId, $shippingFee, $discount, $validDate, $quoteItems){
		$totalPrice = 0;
		foreach ($quoteItems as $quotationDetailID => $item){
			$totalPrice += ($item['Quantity'] * $item['OfferPrice']);
			$newdata = array(
				'OfferPrice' => $item['OfferPrice'],
				'Note' => $item['Note']
			);
			$this->db->where('QuotationDetailID', $quotationDetailID );
			$this->db->update('quotationdetail', $newdata);
		}

		$validDate = DateTime::createFromFormat("d/m/Y", $validDate);
		$newdata = array(
			'TotalPrice' => ($totalPrice + $shippingFee - $discount),
			'ShippingFee' => $shippingFee,
			'Discount' => $discount,
			'UpdatedDate' => date('Y-m-d H:i:s'),
			'UpdatedBy' => $loginId,
			'ValidDate' => $validDate->format('Y-m-d'),
			'Status' => QUOTE_STATUS_UPDATE
		);
		$this->db->where('QuotationID', $quoteId );
		$this->db->update('quotation', $newdata);
	}

	function updateStatus($status, $loginId, $quoteId){
		$newdata = array(
			"Status" => $status,
			"UpdatedDate" => date('Y-m-d H:i:s'),
			"UpdatedBy" => $loginId
		);
		$this->db->where('QuotationID', $quoteId );
		$this->db->update('quotation', $newdata);
	}

}
