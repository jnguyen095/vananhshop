<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 12/11/2023
 * Time: 12:20 PM
 */

class MyOrder_Model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	public function createOrder($order, $orderItems, $shippingInfo, $orderTracking){
		$this->db->insert('myorder', $order);
		$orderId = $this->db->insert_id();
		// order detail
		foreach ($orderItems as $item){
			$item['OrderID'] = $orderId;
			$options = $item['Options'];
			unset($item['Options']);

			$this->db->insert('orderdetail', $item);
			$orderDetailId = $this->db->insert_id();
			foreach ($options as $option){
				foreach ($option as $k => $v){
					$op = array(
						'OrderDetailID' => $orderDetailId,
						'Pro' => $k,
						'Val' => $v
					);
					$this->db->insert('orderdetailprop', $op);
				}
			}
		}
		// shipping info
		$shippingInfo['OrderID'] = $orderId;
		$this->db->insert('ordershipping', $shippingInfo);
		$this->db->insert_id();

		// order tracking
		$orderTracking['OrderID'] = $orderId;
		$this->db->insert('ordertracking', $orderTracking);

		return $orderId;
	}

	public function searchByItems($code, $phone, $status, $offset, $limit, $orderField, $orderDirection)
	{
		$sql = 'select m.*,u.FullName, u.Phone from myorder m inner join us3r u on m.CreatedBy = u.Us3rID where 1=1';
		if($code != null && strlen($code) > 0){
			$sql .= ' and m.Code like \'%'.$code.'%\'';
		}
		if($phone != null && strlen($phone) > 0){
			$sql .= ' and u.Phone like \'%'.$phone.'%\'';
		}
		if($status != null && strlen($status) > 0){
			$sql .= ' and m.Status = "'.$status.'"';
		}

		$sql .= ' order by '.$orderField.' '.$orderDirection;
		$sql .= ' limit '.$offset.','.$limit;
		$orders = $this->db->query($sql);
		$total = $this->db->count_all_results('myorder');

		$data['items'] = $orders->result();
		$data['total'] = $total;
		return $data;
	}

	public function findByUserId($userId, $offset=null, $limit=null)
	{
		$sql = 'select m.*,u.FullName from myorder m inner join us3r u on m.CreatedBy = u.Us3rID';
		$sql .= ' where m.CreatedBy = '.$userId;
		$sql .= ' order by m.CreatedDate desc';
		$sql .= ' limit '.$offset.','.$limit;

		$orders = $this->db->query($sql);

		$this->db->where(array("CreatedBy" => $userId));
		$total = $this->db->count_all_results('myorder');

		$data['items'] = $orders->result();
		$data['total'] = $total;
		return $data;
	}

	public function findByOrderIdAndFetchAll($orderId)
	{
		$data = [];
		$sql = 'select m.*,u.FullName, u.Phone from myorder m inner join us3r u on m.CreatedBy = u.Us3rID';
		$sql .= ' where m.OrderID = '. $orderId;
		$query = $this->db->query($sql);
		$order = $query->row();

		// order detail
		$query = $this->db->select('od.*, p.Title as ProductName, p.Thumb, p.Code as ProductCode, concat(\'[\', group_concat(JSON_OBJECT(IFNULL(po.Pro, \'\'), IFNULL(po.Val, \'\'))), \']\') as  Options')
			->from('orderdetail od')
			->join('myorder o', 'od.OrderID = o.OrderID')
			->join('product p', 'p.ProductID = od.ProductID')
			->join('orderdetailprop po', 'po.OrderDetailID = od.OrderDetailID', 'left')
			->where('od.OrderID', $orderId)
			->group_by('od.OrderDetailID')

			->get();

		$products = $query->result();

		// order shipping
		$query = $this->db->select('sh.*, c.CityName, d.DistrictName')
			->from('ordershipping sh')
			->join('myorder o', 'o.OrderID = sh.OrderID')
			->join('city c', 'c.CityID = sh.CityID', 'inner')
			->join('district d', 'd.DistrictID = sh.DistrictID', 'inner')
			->where('sh.OrderID', $order->OrderID)
			->get();
		$shipping = $query->row();

		// order tracking
		$query = $this->db->select('tr.*')
			->from('ordertracking tr')
			->where('tr.OrderID', $order->OrderID)
			->order_by('tr.CreatedDate', 'DESC')
			->get();
		$tracking = $query->result();


		$data['order'] = $order;
		$data['products'] = $products;
		$data['shippingAddr'] = $shipping;
		$data['trackings'] = $tracking;

		return $data;
	}

	public function getNewOrderCode(){
		$sql = 'select o.Code from myorder o';
		$sql .= ' order by o.CreatedDate desc';
		$sql .= ' limit 1';
		$orderCodes = $this->db->query($sql);
		$code = $orderCodes->row();
		if($code != null){
			$newCode = (int)str_replace('O-', '', $code->Code) + 1;
			if($newCode < 10){
				return "O-0000".$newCode;
			} else if($newCode < 100){
				return "O-000".$newCode;
			} else if($newCode < 1000){
				return "O-0".$newCode;
			} else if($newCode < 10000){
				return "O-".$newCode;
			}
		}else {
			return "O-00001";
		}
	}

	public function getCustomerEmailFromOrderId($orderId){
		$sql = "select u.Email, m.Code from myorder m inner join us3r u on m.CreatedBy = u.Us3rID WHERE m.OrderID = ".$orderId." limit 1";
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row;
	}

	public function updateOrderStatus($orderId, $status, $updatedBy){
		$this->db->set('Status', $status);
		$this->db->set('UpdatedDate', 'NOW()', false);
		$this->db->set('UpdatedBy', $updatedBy);
		$this->db->where('OrderID', $orderId);
		$this->db->update('myorder');
	}

	public function updateOrder($orderId, $myOrderSessionTemp){
		$shippingFee = $myOrderSessionTemp['ShippingFee'];
		$discount = $myOrderSessionTemp['Discount'];
		$totalPrice = $myOrderSessionTemp['TotalPrice'];
		$orderItems = $myOrderSessionTemp['OrderItems'];

		// Update order detail
		$totalItems = 0;
		foreach ($orderItems as $item){
			if($item['OrderDetailID'] != null){
				if($item['Remove'] == 'NO'){
					$this->db->set('Quantity', $item['Quantity']);
					$this->db->where('OrderDetailID', $item['OrderDetailID']);
					$this->db->update('orderdetail');
					$totalItems += $item['Quantity'];
				} else if($item['Remove'] == 'YES'){
					$this->db->delete('orderdetail', array('OrderDetailID' => $item['OrderDetailID']));
				}
			} else {
				if($item['Remove'] == 'NO'){
					$orderDetail = array(
						'OrderID' => $orderId,
						'ProductID' => $item['ProductID'],
						'Price' => $item['Price'],
						'Quantity' => $item['Quantity']
					);
					$this->db->insert('orderdetail', $orderDetail);
					$totalItems += $item['Quantity'];
				}
			}
		}

		// Update order
		$this->db->set('ShippingFee', $shippingFee);
		$this->db->set('TotalItems', $totalItems);
		$this->db->set('Discount', $discount);
		$this->db->set('TotalPrice', $totalPrice);
		$this->db->where('OrderID', $orderId);
		$this->db->update('myorder');
	}
}
