<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 12/25/2023
 * Time: 1:39 PM
 */

class OrderManagement_controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->helper("seo_url");
		$this->load->model('Category_Model');
		$this->load->model('MyOrder_Model');
		$this->load->model('Product_Model');
		$this->load->model('City_Model');
		$this->load->model('User_Model');
		$this->load->model('District_Model');
		$this->load->model('OrderShipping_Model');
		$this->load->model('OrderTracking_Model');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
		$this->load->helper("my_email");
	}

	public function index()
	{
		$config = pagination($this);
		$config['base_url'] = base_url('admin/order/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "CreatedDate";
			$config['orderDirection'] = "DESC";
		}

		$code = $this->input->get('code');
		$phoneNumber = $this->input->get('phoneNumber');
		$status = $this->input->get('status');
		$searchOrders = $this->MyOrder_Model->searchByItems($code, $phoneNumber, $status, $config['page'], $config['per_page'], $config['orderField'], $config['orderDirection']);
		$orders = $searchOrders['items'];
		$total = $searchOrders['total'];
		$data['orders'] = $orders;

		$config['total_rows'] = $total;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('admin/order/Order_list', $data);
	}

	public function process($orderId)
	{
		$crudaction = $this->input->post("crudaction");
		$loginID = $this->session->userdata('loginid');
		if($crudaction == ORDER_STATUS_CONFIRM){
			$this->MyOrder_Model->updateOrderStatus($orderId, ORDER_STATUS_CONFIRM, $loginID);
			$data['message_response'] = 'Cập nhật tình trạng đơn hàng thành công.';
			$user = $this->User_Model->getUserById($loginID);
			$orderTracking = array(
				'OrderID' => $orderId,
				'CreatedDate' => date('Y-m-d H:i:s'),
				'Message' => '<b>'. $user->FullName. '</b> đã tiếp nhận đơn hàng'
			);
			$this->OrderTracking_Model->insert($orderTracking);

			// send email to inform customer
			$emailNCode = $this->MyOrder_Model->getCustomerEmailFromOrderId($orderId);
			$customerEmail = $emailNCode->Email;
			$orderCode = $emailNCode->Code;

			if($customerEmail != null && strlen($customerEmail) > 0){
				my_send_email($customerEmail, "Vân Anh Shop - Tiếp nhận đơn hàng ".$orderCode, "<p>Đơn hàng: ".$orderCode." đã tiếp nhận từ: " . APP_DOMAIN . "</p><p>Theo dõi đơn hàng tại đây: " . APP_DOMAIN . "/don-hang-". $orderId."html</p>" );
			}
		} else if($crudaction == ORDER_STATUS_SHIPPING){
			$this->MyOrder_Model->updateOrderStatus($orderId, ORDER_STATUS_SHIPPING, $loginID);
			$data['message_response'] = 'Cập nhật tình trạng đơn hàng thành công.';
			$user = $this->User_Model->getUserById($loginID);
			$orderTracking = array(
				'OrderID' => $orderId,
				'CreatedDate' => date('Y-m-d H:i:s'),
				'Message' => '<b>'. $user->FullName. '</b> đã cập nhật đơn hàng, đơn hàng đang trên dường giao'
			);
			$this->OrderTracking_Model->insert($orderTracking);

			// send email to inform customer
			$emailNCode = $this->MyOrder_Model->getCustomerEmailFromOrderId($orderId);
			$customerEmail = $emailNCode->Email;
			$orderCode = $emailNCode->Code;

			if($customerEmail != null && strlen($customerEmail) > 0){
				my_send_email($customerEmail,"Vân Anh Shop - Đơn hàng ".$orderCode. " đang được giao", "<p>Đơn hàng: ".$orderCode." đang được giao đến khách hàng</p><p>Theo dõi đơn hàng tại đây: " . APP_DOMAIN . "/don-hang-". $orderId."html</p>" );
			}
		} else if($crudaction == ORDER_STATUS_COMPLETED){
			$this->MyOrder_Model->updateOrderStatus($orderId, ORDER_STATUS_COMPLETED, $loginID);
			$data['message_response'] = 'Cập nhật tình trạng đơn hàng thành công.';
			$user = $this->User_Model->getUserById($loginID);
			$orderTracking = array(
				'OrderID' => $orderId,
				'CreatedDate' => date('Y-m-d H:i:s'),
				'Message' => '<b>'. $user->FullName. '</b> đã cập nhật đơn hàng, đơn hàng đã giao xong'
			);
			$this->OrderTracking_Model->insert($orderTracking);

			// send email to inform customer
			$emailNCode = $this->MyOrder_Model->getCustomerEmailFromOrderId($orderId);
			$customerEmail = $emailNCode->Email;
			$orderCode = $emailNCode->Code;

			if($customerEmail != null && strlen($customerEmail) > 0){
				my_send_email($customerEmail, "Vân Anh Shop - Đơn hàng ".$orderCode. " được giao thành công", "<p>Đơn hàng: ".$orderCode." đã giao đến khách hàng thành công</p><p>Theo dõi đơn hàng tại đây: " . APP_DOMAIN . "/don-hang-". $orderId."html</p>" );
			}
		}

		$order = $this->MyOrder_Model->findByOrderIdAndFetchAll($orderId);
		$this->load->view('admin/order/Order_detail', $order);
	}

	public function update()
	{
		$crudaction = $this->input->post("crudaction");
		$orderId = $this->input->post('orderId');
		if($crudaction == "insert-update"){
			echo 'success';
		}
		$order = $this->MyOrder_Model->findByOrderIdAndFetchAll($orderId);
		$this->load->view('admin/order/Order_update', $order);
	}

	public function loadOrderItems(){
		$orderId = $this->input->post('orderId');
		$crudaction = $this->input->post('crudaction');
		$myOrderSessionTemp = $this->session->userdata('Order-'.$orderId);
		if($crudaction == 'reload' || $myOrderSessionTemp == null){
			$orderInfo = $this->MyOrder_Model->findByOrderIdAndFetchAll($orderId);
			$order = $orderInfo['order'];
			$orderProducts = $orderInfo['products'];

			// Put data into session
			$this->session->unset_userdata('Order-'.$order->OrderID);
			$items = array();
			foreach ($orderProducts as $orderProduct){
				$item = ['ProductID' => 	$orderProduct->ProductID,
						'ProductCode' => $orderProduct-> ProductCode,
						'ProductName' => 	$orderProduct->ProductName,
						'Quantity' => 	$orderProduct->Quantity,
						'Price' => 	$orderProduct->Price,
						'Subtotal' =>  ($orderProduct->Price * $orderProduct->Quantity),
						'Remove' => 'NO',
						'OrderDetailID' => $orderProduct->OrderDetailID
					];
				array_push($items, $item);
			}
			$myOrderSessionTemp = [
				'Order-'.$order->OrderID => [
					'ShippingFee' => $order->ShippingFee,
					'Discount' => $order->Discount,
					'TotalPrice' => $order->TotalPrice,
					'OrderItems' => $items
				]
			];

			$this->session->set_userdata($myOrderSessionTemp);
			$myOrderSessionTemp = $myOrderSessionTemp['Order-'.$orderId];
		}

		if($crudaction == 'add-product'){
			$proudctId = $this->input->post('productId');
			$product = $this->Product_Model->findById($proudctId);
			$item = ['ProductID' => 	$proudctId,
				'ProductCode' => $product-> Code,
				'ProductName' => 	$product->Title,
				'Quantity' => 1,
				'Price' => 	$product->Price,
				'Subtotal' =>  $product->Price,
				'Remove' => 'NO',
				'OrderDetailID' => null
			];
			$updatedPrice = $myOrderSessionTemp['TotalPrice'] + $product->Price;
			array_push($myOrderSessionTemp['OrderItems'], $item);
			$myOrderSessionTemp['TotalPrice'] = $updatedPrice;

			$this->session->unset_userdata('Order-'.$orderId);
			$this->session->set_userdata('Order-'.$orderId, $myOrderSessionTemp);
		} else if($crudaction == 'delete'){
			$proudctId = $this->input->post('productId');
			$orderItems = $myOrderSessionTemp['OrderItems'];
			foreach ($orderItems as &$item){
				if($item['ProductID'] == $proudctId){
					if($item['Remove'] == 'NO'){
						$item['Remove'] = 'YES';
						$myOrderSessionTemp['TotalPrice'] = $myOrderSessionTemp['TotalPrice'] - $item['Subtotal'];
						$item['Subtotal'] = 0;
					} else if($item['Remove'] == 'YES'){
						$item['Remove'] = 'NO';
						$item['Subtotal'] = $item['Quantity'] * $item['Price'];
						$myOrderSessionTemp['TotalPrice'] = $myOrderSessionTemp['TotalPrice'] + $item['Subtotal'];
					}

					break;
				}
			}
			unset($item);
			$myOrderSessionTemp['OrderItems'] = $orderItems;

			$this->session->unset_userdata('Order-'.$orderId);
			$this->session->set_userdata('Order-'.$orderId, $myOrderSessionTemp);
		} else if($crudaction == 'field-change'){
			$field = $this->input->post('field');
			$value = $this->input->post('value');
			$productId = $this->input->post('productId');

			if($field == 'ShippingFee'){
				$myOrderSessionTemp['TotalPrice'] = $myOrderSessionTemp['TotalPrice'] - $myOrderSessionTemp['ShippingFee'];
				$myOrderSessionTemp['ShippingFee'] = $value;
				$myOrderSessionTemp['TotalPrice'] = $myOrderSessionTemp['TotalPrice'] + $value;

				$this->session->unset_userdata('Order-'.$orderId);
				$this->session->set_userdata('Order-'.$orderId, $myOrderSessionTemp);
			} else if($field == 'Discount'){
				$myOrderSessionTemp['TotalPrice'] = $myOrderSessionTemp['TotalPrice'] + $myOrderSessionTemp['Discount'];
				$myOrderSessionTemp['Discount'] = $value;
				$myOrderSessionTemp['TotalPrice'] = $myOrderSessionTemp['TotalPrice'] - $value;

				$this->session->unset_userdata('Order-'.$orderId);
				$this->session->set_userdata('Order-'.$orderId, $myOrderSessionTemp);
			} else if($field == 'Quantity' && $productId != null){
				$orderItems = $myOrderSessionTemp['OrderItems'];
				foreach ($orderItems as &$item){
					if($item['ProductID'] == $productId){
						$myOrderSessionTemp['TotalPrice'] = $myOrderSessionTemp['TotalPrice'] - $item['Subtotal'];
						$item['Quantity'] = $value;
						$item['Subtotal'] = $value * $item['Price'];
						$myOrderSessionTemp['TotalPrice'] = $myOrderSessionTemp['TotalPrice'] + $item['Subtotal'];

						break;
					}
				}
				unset($item);
				$myOrderSessionTemp['OrderItems'] = $orderItems;
				$this->session->unset_userdata('Order-'.$orderId);
				$this->session->set_userdata('Order-'.$orderId, $myOrderSessionTemp);
			}
		}

		$myOrderSessionTemp['OrderID'] = $orderId;
		$data['data'] = $myOrderSessionTemp;
		$this->load->view('admin/order/Order_update_items', $data);
	}

	public function updateOrderItems(){
		$orderId = $this->input->post('orderId');
		$myOrderSessionTemp = $this->session->userdata('Order-'.$orderId);
		if($myOrderSessionTemp != null){
			$this->MyOrder_Model->updateOrder($orderId, $myOrderSessionTemp);
			$this->session->unset_userdata('Order-'.$orderId);

			// tracking
			$loginID = $this->session->userdata('loginid');
			$user = $this->User_Model->getUserById($loginID);
			$orderTracking = array(
				'OrderID' => $orderId,
				'CreatedDate' => date('Y-m-d H:i:s'),
				'Message' => '<b>'.$user->FullName. '</b> cập nhật thông tin của đơn hàng'
			);
			$this->OrderTracking_Model->insert($orderTracking);

			// send email to inform customer
			$emailNCode = $this->MyOrder_Model->getCustomerEmailFromOrderId($orderId);
			$customerEmail = $emailNCode->Email;
			$orderCode = $emailNCode->Code;

			if($customerEmail != null && strlen($customerEmail) > 0){
				my_send_email($customerEmail,"Vân Anh Shop - Đơn hàng ".$orderCode. " đã bị được thay đổi", "<p>Đơn hàng: ".$orderCode." đã được thay đổi bởi nhân viên <b>".$user->FullName."</b></p><p>Theo dõi đơn hàng tại đây: " . APP_DOMAIN . "/don-hang-". $orderId."html</p>" );
			}
			echo 'success';
		} else {
			echo 'fail';
		}

	}

	public function updateShippingInfo(){
		$crudaction = $this->input->post('crudaction');

		if($crudaction == 'insert'){
			$orderId = $this->input->post("orderId");
			$receiver = $this->input->post("txt_receiver");
			$phone = $this->input->post("txt_phone");
			$city = $this->input->post("txt_city");
			$district = $this->input->post("txt_district");
			$street = $this->input->post("txt_street");

			$shippingInfo = array(
				'Receiver' => $receiver,
				'Phone' => $phone,
				'CityID' => $city,
				'DistrictID' => $district,
				'Street' => $street
			);
			$this->OrderShipping_Model->update($orderId, $shippingInfo);

			// tracking
			$loginID = $this->session->userdata('loginid');
			$user = $this->User_Model->getUserById($loginID);
			$orderTracking = array(
				'OrderID' => $orderId,
				'CreatedDate' => date('Y-m-d H:i:s'),
				'Message' => '<b>'. $user->FullName. '</b> cập nhật thông tin giao hàng'
			);
			$this->OrderTracking_Model->insert($orderTracking);


			echo "success";
		}else{
			$orderId = $this->input->post('orderId');
			$shipping = $this->OrderShipping_Model->findByOrderId($orderId);
			$cities = $this->City_Model->getAllActive();
			$districts = $this->District_Model->findByCityId($shipping->CityID);

			$data = [];
			$data['shipping'] = $shipping;
			$data['cities'] = $cities;
			$data['districts'] = $districts;

			return $this->load->view('admin/order/shipping_update', $data);
		}
	}


}
