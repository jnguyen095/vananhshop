<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 10/13/2017
 * Time: 3:54 PM
 */
class Dashboard_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}
	public function countFeedback($isToday){
		$today = date('Y-m-d');
		$query = "select count(*) as Total from feedback fb";
		if(isset($isToday) && $isToday){
			$query .= " where date(fb.CreatedDate) = '{$today}'";
		}
		$result = $this->db->query($query);
		$row = $result->row();
		return $row->Total;
	}

	public function countActiveProducts(){
		$query = "select count(*) as Total from product p where p.Status = 1";
		$result = $this->db->query($query);
		$row = $result->row();
		return $row ? (int)$row->Total : 0;
	}

	public function countOrders($isToday = false){
		$today = date('Y-m-d');
		$query = "select count(*) as Total from myorder m where m.Status <> '".ORDER_STATUS_DELETED."'";
		if($isToday){
			$query .= " and date(m.CreatedDate) = '{$today}'";
		}
		$result = $this->db->query($query);
		$row = $result->row();
		return $row ? (int)$row->Total : 0;
	}

	public function sumRevenue($isToday = false){
		$today = date('Y-m-d');
		$query = "select sum(m.TotalPrice) as TotalRevenue from myorder m where m.Status <> '".ORDER_STATUS_DELETED."'";
		if($isToday){
			$query .= " and date(m.CreatedDate) = '{$today}'";
		}
		$result = $this->db->query($query);
		$row = $result->row();
		return $row && $row->TotalRevenue ? (float)$row->TotalRevenue : 0;
	}

	/**
	 * Get orders count grouped by day for the last $days days.
	 * Returns an array of [ ["YYYY-MM-DD", count], ... ] ordered ascending by date.
	 */
	public function getOrdersCountByDay($days = 7){
		$days = intval($days);
		if($days < 1) $days = 7;
		$start = date('Y-m-d', strtotime('-'.($days-1).' days'));

		// initialize date buckets
		$dates = array();
		for($i = 0; $i < $days; $i++){
			$d = date('Y-m-d', strtotime($start . " +{$i} days"));
			$dates[$d] = 0;
		}

		$query = "select date(m.CreatedDate) as Day, count(*) as Total from myorder m ";
		$query .= " where m.Status <> '".ORDER_STATUS_DELETED."' and date(m.CreatedDate) >= '".$start."' ";
		$query .= " group by date(m.CreatedDate) order by date(m.CreatedDate) asc";
		$result = $this->db->query($query);
		foreach($result->result() as $row){
			$day = $row->Day;
			if(array_key_exists($day, $dates)){
				$dates[$day] = (int)$row->Total;
			}
		}

		// convert to array of [label, value]
		$output = array();
		foreach($dates as $d => $c){
			$output[] = array($d, $c);
		}
		return $output;
	}

	public function topViewedProducts($limit = 5){
		$query = "select p.ProductID, p.Title, p.Code, p.View from product p where p.Status = 1 order by p.View desc limit " . intval($limit);
		$result = $this->db->query($query);
		return $result->result();
	}

	public function countQuotation($isToday = false){
		$today = date('Y-m-d');
		$query = "select count(*) as Total from quotation q";
		if($isToday){
			$query .= " where date(q.RequestedDate) = '{$today}'";
		}
		$result = $this->db->query($query);
		$row = $result->row();
		return $row ? (int)$row->Total : 0;
	}

	public function topOrderedProducts($limit = 5){
		$query = "select p.ProductID, p.Title, p.Code, sum(od.Quantity) as OrderedQuantity from orderdetail od";
		$query .= " inner join myorder m on od.OrderID = m.OrderID";
		$query .= " inner join product p on od.ProductID = p.ProductID";
		$query .= " where m.Status <> '".ORDER_STATUS_DELETED."' and p.Status = 1";
		$query .= " group by p.ProductID, p.Title, p.Code";
		$query .= " order by OrderedQuantity desc limit " . intval($limit);
		$result = $this->db->query($query);
		return $result->result();
	}

}
