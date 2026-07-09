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
		$query .= " and m.Status <> '".ORDER_STATUS_CANCELLED."'";
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
		$query .= " and m.Status <> '".ORDER_STATUS_CANCELLED."'";
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
		$query .= " where m.Status <> '".ORDER_STATUS_DELETED."'";
		$query .= " and m.Status <> '".ORDER_STATUS_CANCELLED."'";
		$query .= " and date(m.CreatedDate) >= '".$start."'";
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

	public function getRevenueByDay($days = 7){
		$days = intval($days);
		if($days < 1) $days = 7;
		$start = date('Y-m-d', strtotime('-'.($days-1).' days'));

		$dates = array();
		for($i = 0; $i < $days; $i++){
			$d = date('Y-m-d', strtotime($start . " +{$i} days"));
			$dates[$d] = 0;
		}

		$query = "select date(m.CreatedDate) as Day, sum(m.TotalPrice) as TotalRevenue from myorder m ";
		$query .= " where m.Status <> '".ORDER_STATUS_DELETED."'";
		$query .= " and m.Status <> '".ORDER_STATUS_CANCELLED."'";
		$query .= " and date(m.CreatedDate) >= '".$start."'";
		$query .= " group by date(m.CreatedDate) order by date(m.CreatedDate) asc";
		$result = $this->db->query($query);
		foreach($result->result() as $row){
			$day = $row->Day;
			if(array_key_exists($day, $dates)){
				$dates[$day] = (float)$row->TotalRevenue;
			}
		}

		$output = array();
		foreach($dates as $d => $c){
			$output[] = array($d, $c);
		}
		return $output;
	}

	public function getOrdersCountByMonth($months = 6){
		$months = intval($months);
		if($months < 1) $months = 6;
		$start = date('Y-m-01', strtotime('-'.($months - 1).' months'));

		$dates = array();
		for($i = 0; $i < $months; $i++){
			$d = date('Y-m', strtotime($start . " +{$i} months"));
			$dates[$d] = 0;
		}

		$query = "select date_format(m.CreatedDate, '%Y-%m') as Month, count(*) as Total from myorder m ";
		$query .= " where m.Status <> '".ORDER_STATUS_DELETED."'";
		$query .= " and m.Status <> '".ORDER_STATUS_CANCELLED."'";
		$query .= " and date(m.CreatedDate) >= '".$start."'";
		$query .= " group by Month order by Month asc";
		$result = $this->db->query($query);
		foreach($result->result() as $row){
			$month = $row->Month;
			if(array_key_exists($month, $dates)){
				$dates[$month] = (int)$row->Total;
			}
		}

		$output = array();
		foreach($dates as $d => $c){
			$output[] = array($d, $c);
		}
		return $output;
	}

	public function getRevenueByMonth($months = 6){
		$months = intval($months);
		if($months < 1) $months = 6;
		$start = date('Y-m-01', strtotime('-'.($months - 1).' months'));

		$dates = array();
		for($i = 0; $i < $months; $i++){
			$d = date('Y-m', strtotime($start . " +{$i} months"));
			$dates[$d] = 0;
		}

		$query = "select date_format(m.CreatedDate, '%Y-%m') as Month, sum(m.TotalPrice) as TotalRevenue from myorder m ";
		$query .= " where m.Status <> '".ORDER_STATUS_DELETED."'";
		$query .= " and m.Status <> '".ORDER_STATUS_CANCELLED."'";
		$query .= " and date(m.CreatedDate) >= '".$start."'";
		$query .= " group by Month order by Month asc";
		$result = $this->db->query($query);
		foreach($result->result() as $row){
			$month = $row->Month;
			if(array_key_exists($month, $dates)){
				$dates[$month] = (float)$row->TotalRevenue;
			}
		}

		$output = array();
		foreach($dates as $d => $c){
			$output[] = array($d, $c);
		}
		return $output;
	}

	public function getCustomerReportData(){
		$baseWhere = " where m.Status <> '" . ORDER_STATUS_DELETED . "' and m.Status <> '" . ORDER_STATUS_CANCELLED . "'";
		return array(
			'potential_customers' => $this->getTopPotentialCustomers($baseWhere),
			'frequent_buyers' => $this->getTopFrequentBuyers($baseWhere)
		);
	}

	public function getProductReportData(){
		return array(
			'topProducts' => $this->topViewedProducts(5),
			'topOrderedProducts' => $this->topOrderedProducts(5)
		);
	}

	private function getTopPotentialCustomers($baseWhere){
		$query = "select coalesce(s.Receiver, '') as CustomerName, coalesce(s.Phone, '') as Phone, count(*) as OrderCount, sum(m.TotalPrice) as TotalValue, max(m.CreatedDate) as LastPurchase from myorder m inner join ordershipping s on s.OrderID = m.OrderID {$baseWhere} group by s.Receiver, s.Phone order by TotalValue desc, OrderCount desc limit 5";
		$result = $this->db->query($query);
		$rows = array();
		foreach($result->result() as $row){
			$rows[] = array(
				'customer_name' => $row->CustomerName,
				'phone' => $row->Phone,
				'order_count' => (int)$row->OrderCount,
				'total_value' => (float)$row->TotalValue,
				'last_purchase' => $row->LastPurchase
			);
		}
		return $rows;
	}

	private function getTopFrequentBuyers($baseWhere){
		$query = "select coalesce(s.Receiver, '') as CustomerName, coalesce(s.Phone, '') as Phone, count(*) as OrderCount, sum(m.TotalPrice) as TotalValue, max(m.CreatedDate) as LastPurchase from myorder m inner join ordershipping s on s.OrderID = m.OrderID {$baseWhere} group by s.Receiver, s.Phone order by OrderCount desc, TotalValue desc limit 5";
		$result = $this->db->query($query);
		$rows = array();
		foreach($result->result() as $row){
			$rows[] = array(
				'customer_name' => $row->CustomerName,
				'phone' => $row->Phone,
				'order_count' => (int)$row->OrderCount,
				'total_value' => (float)$row->TotalValue,
				'last_purchase' => $row->LastPurchase
			);
		}
		return $rows;
	}

	public function getReportSummary($period = 'day'){
		$period = ($period === 'month') ? 'month' : 'day';
		$baseWhere = " where m.Status <> '" . ORDER_STATUS_DELETED . "' and m.Status <> '" . ORDER_STATUS_CANCELLED . "'";
		$currentLabel = 'Hôm nay';
		$previousLabel = 'Hôm qua';
		$currentFrom = date('Y-m-d');
		$currentTo = date('Y-m-d');
		$previousFrom = date('Y-m-d', strtotime('-1 day'));
		$previousTo = date('Y-m-d', strtotime('-1 day'));

		if($period === 'month'){
			$currentLabel = 'Tháng này';
			$previousLabel = 'Tháng trước';
			$currentFrom = date('Y-m-01');
			$currentTo = date('Y-m-t');
			$previousFrom = date('Y-m-01', strtotime('first day of previous month'));
			$previousTo = date('Y-m-t', strtotime('last day of previous month'));
		}

		$currentWhere = $baseWhere . " and date(m.CreatedDate) >= '{$currentFrom}' and date(m.CreatedDate) <= '{$currentTo}'";
		$previousWhere = $baseWhere . " and date(m.CreatedDate) >= '{$previousFrom}' and date(m.CreatedDate) <= '{$previousTo}'";

		return array(
			'period' => $period,
			'title' => $period === 'month' ? 'Report theo tháng' : 'Report theo ngày',
			'orders' => $this->buildMetricComparison($currentWhere, $previousWhere, 'orders', $currentLabel, $previousLabel),
			'revenue' => $this->buildMetricComparison($currentWhere, $previousWhere, 'revenue', $currentLabel, $previousLabel),
			'new_users' => $this->buildCustomerMetricComparison($currentFrom, $currentTo, $previousFrom, $previousTo, 'new_users', $currentLabel, $previousLabel),
			'repeat_buyers' => $this->buildCustomerMetricComparison($currentFrom, $currentTo, $previousFrom, $previousTo, 'repeat_buyers', $currentLabel, $previousLabel)
		);
	}

	private function buildMetricComparison($currentWhere, $previousWhere, $metricType, $currentLabel, $previousLabel){
		if($metricType === 'orders'){
			$currentValue = $this->getScalarValue("select count(*) as Total from myorder m {$currentWhere}");
			$previousValue = $this->getScalarValue("select count(*) as Total from myorder m {$previousWhere}");
		} else {
			$currentValue = $this->getScalarValue("select sum(m.TotalPrice) as Total from myorder m {$currentWhere}");
			$previousValue = $this->getScalarValue("select sum(m.TotalPrice) as Total from myorder m {$previousWhere}");
		}

		$difference = $currentValue - $previousValue;
		$percentage = 0;
		if($previousValue > 0){
			$percentage = round(($difference / $previousValue) * 100, 1);
		} else if($currentValue > 0){
			$percentage = 100;
		}

		$trendClass = 'info';
		$trendLabel = 'Không đổi';
		$comparisonText = 'không thay đổi so với kỳ trước';
		if($difference > 0){
			$trendClass = 'success';
			$trendLabel = 'Tăng';
			$comparisonText = 'tăng ' . abs($percentage) . '% so với kỳ trước';
		} else if($difference < 0){
			$trendClass = 'warning';
			$trendLabel = 'Giảm';
			$comparisonText = 'giảm ' . abs($percentage) . '% so với kỳ trước';
		}

		return array(
			'current_value' => $currentValue,
			'previous_value' => $previousValue,
			'difference' => $difference,
			'percentage' => $percentage,
			'trend_class' => $trendClass,
			'trend_label' => $trendLabel,
			'comparison_text' => $comparisonText,
			'current_label' => $currentLabel,
			'previous_label' => $previousLabel
		);
	}

	private function buildCustomerMetricComparison($currentFrom, $currentTo, $previousFrom, $previousTo, $metricType, $currentLabel, $previousLabel){
		$currentValue = $this->countCustomerMetric($metricType, $currentFrom, $currentTo);
		$previousValue = $this->countCustomerMetric($metricType, $previousFrom, $previousTo);

		$difference = $currentValue - $previousValue;
		$percentage = 0;
		if($previousValue > 0){
			$percentage = round(($difference / $previousValue) * 100, 1);
		} else if($currentValue > 0){
			$percentage = 100;
		}

		$trendClass = 'info';
		$trendLabel = 'Không đổi';
		$comparisonText = 'không thay đổi so với kỳ trước';
		if($difference > 0){
			$trendClass = 'success';
			$trendLabel = 'Tăng';
			$comparisonText = 'tăng ' . abs($percentage) . '% so với kỳ trước';
		} else if($difference < 0){
			$trendClass = 'warning';
			$trendLabel = 'Giảm';
			$comparisonText = 'giảm ' . abs($percentage) . '% so với kỳ trước';
		}

		return array(
			'current_value' => $currentValue,
			'previous_value' => $previousValue,
			'difference' => $difference,
			'percentage' => $percentage,
			'trend_class' => $trendClass,
			'trend_label' => $trendLabel,
			'comparison_text' => $comparisonText,
			'current_label' => $currentLabel,
			'previous_label' => $previousLabel
		);
	}

	private function countCustomerMetric($metricType, $from, $to){
		$baseWhere = " where m.Status <> '" . ORDER_STATUS_DELETED . "' and m.Status <> '" . ORDER_STATUS_CANCELLED . "'";
		$rangeWhere = $baseWhere . " and date(m.CreatedDate) >= '{$from}' and date(m.CreatedDate) <= '{$to}' and trim(coalesce(sh.Phone, '')) <> ''";
		$phoneCondition = " sh.Phone = s.Phone ";
		if($metricType === 'new_users'){
			$query = "select count(*) as Total from (select sh.Phone from myorder m inner join ordershipping sh on sh.OrderID = m.OrderID {$rangeWhere} and not exists (select 1 from myorder m2 inner join ordershipping s on s.OrderID = m2.OrderID {$baseWhere} and date(m2.CreatedDate) < '{$from}' and trim(coalesce(s.Phone, '')) <> '' and {$phoneCondition}) group by sh.Phone) as t";
		} else {
			$query = "select count(*) as Total from (select sh.Phone from myorder m inner join ordershipping sh on sh.OrderID = m.OrderID {$rangeWhere} and exists (select 1 from myorder m2 inner join ordershipping s on s.OrderID = m2.OrderID {$baseWhere} and date(m2.CreatedDate) < '{$from}' and trim(coalesce(s.Phone, '')) <> '' and {$phoneCondition}) group by sh.Phone) as t";
		}
		$result = $this->db->query($query);
		$row = $result->row();
		return $row && $row->Total !== null ? (int)$row->Total : 0;
	}

	private function getScalarValue($query){
		$result = $this->db->query($query);
		$row = $result->row();
		return $row && $row->Total !== null ? (float)$row->Total : 0;
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
		$query .= " where m.Status <> '".ORDER_STATUS_DELETED."'";
		$query .= " and m.Status <> '".ORDER_STATUS_CANCELLED."'";
		$query .= " and p.Status = 1";
		$query .= " group by p.ProductID, p.Title, p.Code";
		$query .= " order by OrderedQuantity desc limit " . intval($limit);
		$result = $this->db->query($query);
		return $result->result();
	}

}
