<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 12/7/2023
 * Time: 3:19 PM
 */

class ShoppingCart_controller extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('cart');
		$this->load->model('Category_Model');
		$this->load->model('Product_Model');
		$this->load->helper("seo_url");
		$this->load->helper('text');
		$this->load->library('form_validation');
		$this->load->helper("my_date");
		$this->load->helper('form');
		$this->load->model('City_Model');
		$this->load->model('User_Model');
		$this->load->model('District_Model');
		$this->load->model('MyOrder_Model');
		$this->load->model('OrderShipping_Model');
		$this->load->model('ShippingFee_Model');
		$this->load->model('Promotion_Model');
		$this->load->helper('my_email');
	}

	public function success(){
		$this->cart->destroy();
		$this->session->set_userdata("shippingAddr", []);
		$data['categories'] = $this->Category_Model->getActiveCategories();
		$this->load->view('cart/Cart_success', $data);
	}

	public function checkOut(){
		$data['categories'] = $this->Category_Model->getActiveCategories();
		$fee = $this->ShippingFee_Model->findInRange($this->cart->total());
		$data['ShippingFee'] = $fee;
		$crudaction = $this->input->post('crudaction');
		if($crudaction == 'insert'){
			$data['txt_receiver'] = $this->input->post("txt_receiver");
			$data['txt_phone'] = $this->input->post("txt_phone");
			$data['txt_city'] = $this->input->post("txt_city");
			$data['txt_district'] = $this->input->post("txt_district");
			$data['street'] = $this->input->post("txt_street");
			$data['note'] = $this->input->post("note");
			$proCode = trim($this->input->post("proCode"));
			$data['proCode'] = $proCode;
			$discount = 0;
			if (!empty($proCode)) {
				$validationResult = $this->Promotion_Model->validatePromotion($proCode, $this->cart->total());
				$data['promotion'] = $validationResult;
				if ($validationResult['valid']) {
					$appliedPromotion = $validationResult['promotion'];
					$discount = $this->Promotion_Model->calculateDiscount($appliedPromotion, $this->cart->total(), $fee);
				}
			}
			$data['discount'] = $discount;

			$this->form_validation->set_rules("txt_receiver", "Người nhận hàng", "trim|required");
			$this->form_validation->set_rules("txt_phone", "Số điện thoại", "trim|required");
			$this->form_validation->set_rules("txt_city", "Thành phố", "numeric|required");
			$this->form_validation->set_rules("txt_district", "Quận", "numeric|required");
			$this->form_validation->set_rules("txt_street", "Số nhà/căn hộ/đường", "required");
			$validateResult = $this->form_validation->run();
			if($validateResult == TRUE){
				// shipping
				$shippingInfo = array(
					'Receiver' => $data['txt_receiver'],
					'Phone' => $data['txt_phone'],
					'CityID' => $data['txt_city'],
					'DistrictID' => $data['txt_district'],
					'Street' => $data['street']
				);
				// $this->session->set_userdata("shippingAddr", $shippingAddr);
				$newOrder = [];
				$newOrder['Status'] = ORDER_STATUS_NEW;
				$newOrder['ShippingFee'] = $fee;
				$newOrder['TotalItems'] = $this->cart->total_items();
				$newOrder['Note'] = $data['note'];
				$newOrder['Payment'] = 'COD';
				$newOrder['CreatedDate'] = date('Y-m-d H:i:s');
				$newOrder['UpdatedDate'] = date('Y-m-d H:i:s');
				$newOrder['Code'] = $this->MyOrder_Model->getNewOrderCode();
				$newOrder['Discount'] = $discount;
				$newOrder['TotalPrice'] = $this->cart->total() + $fee - $discount;

				// order items
				$orderItems = [];
				foreach ($this->cart->contents() as $item){
					$options = [];
					// property
					if($this->cart->has_options($item['rowid']) == TRUE) {
						foreach ($this->cart->product_options($item['rowid']) as $option_attr => $option_val) {
							$option = [];
							$option[$option_val['key']] = $option_val['attr'];
							array_push($options, $option);
						}
					}

					$orderItem = array(
						'ProductID' => $item['id'],
						'Price' => $item['price'],
						'Quantity' => $item['qty'],
						'Options' => $options
					);
					array_push($orderItems, $orderItem);
				}

				// tracking
				$trackingMessage = '<b>'.$data['txt_receiver']. '</b> tạo đơn hàng';
				if (isset($note) && strlen($note) > 0) {
					$trackingMessage .= ' với ghi chú: <i>'. $note .'</i>';
				}
				if ($appliedPromotion) {
					$trackingMessage .= ' (Mua khuyến mãi: ' . $appliedPromotion->Name . ', giảm giá: ' . number_format($discount) . 'đ)';
				}
				$orderTracking = array(
					'CreatedDate' => date('Y-m-d H:i:s'),
					'Message' => $trackingMessage
				);

				$orderId = $this->MyOrder_Model->createOrder($newOrder, $orderItems, $shippingInfo, $orderTracking);

				// Record promotion application if applied
				if ($appliedPromotion && $discount > 0) {
					$this->Promotion_Model->recordPromotionApplication($appliedPromotion->PromotionsID, $orderId, $discount);
				}

				//return;
				redirect('/check-out/success?orderId=' . $orderId);
			}
		} else{
			$shippingAddr = $this->session->userdata("shippingAddr");
			if($shippingAddr != null){
				$data['txt_receiver'] = $shippingAddr['txt_receiver'];
				$data['txt_phone'] = $shippingAddr['txt_phone'];
				$data['txt_city'] = $shippingAddr['txt_city'];
				$data['txt_district'] = $shippingAddr['txt_district'];
				$data['street'] = $shippingAddr['street'];
			} else {
				//get latest shipping address from last order
				$loginID = $this->session->userdata('loginid');
				if($loginID != null){
					$shippingAddr = $this->OrderShipping_Model->getLatestShippingAddr($loginID);
					if($shippingAddr != null){
						$data['txt_receiver'] = $shippingAddr->Receiver;
						$data['txt_phone'] = $shippingAddr->Phone;
						$data['txt_city'] = $shippingAddr->CityID;
						$data['txt_district'] = $shippingAddr->DistrictID;
						$data['street'] = $shippingAddr->Street;
					} else {
						//get part of info from current user
						$user = $this->User_Model->getUserById($loginID);
						$data['txt_receiver'] = $user->FullName;
						$data['txt_phone'] = $user->Phone;
					}
				}
			}

		}

		$cities = $this->City_Model->getAllActive();
		$data['cities'] = $cities;
		if(isset($data['txt_city']) && $data['txt_city'] != null){
			$districts = $this->District_Model->findByCityId($data['txt_city']);
			$data['districts'] = $districts;
		}
		$this->load->view('cart/Cart_checkout', $data);
	}

	public function addItemToCart(){
		$productId = $_POST['productId'];
		$qty = $_POST['qty'];
		$options = isset($_POST['options']) ? $_POST['options'] : [];
		$product = $this->Product_Model->findById($productId);
		$price = $product->Price;
		$data = array(
			'id' => $productId,
			'qty' => $qty,
			'price' => $price,
			'image' => $product->Thumb,
			'options' => $options,
			'name' => $product->Title
		);
		$this->cart->insert($data);
		echo $this->reloadHeadCart();
	}

	public function removeItemToCart()
	{
		$rowid = $_POST['rowid'];
		$this->cart->update(array('rowid' => $rowid, 'qty' => 0));
		echo $this->reloadHeadCart();
	}

	public function reloadHeadCart()
	{
		$html = '<i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;'.$this->cart->total_items().' sản phẩm '.number_format($this->cart->total()).'đ';
		$html .= ' <span class="caret"></span>';
		return $html;
	}

	public function reloadMiniCart()
	{
		$html = '<li>
					<a>
						<table class="table table-bordered table-responsive">
							<tr class="bg-info">
								<td>Sản phẩm</td>
								<td>SL</td>
								<td>Thành tiền</td>
								<td>Xóa</td>
							</tr>';
							foreach ($this->cart->contents() as $item){
								$html .= '<tr>';
								$html .= '<td>' . substr_at_middle($item['name'], 120);
								// property
								if($this->cart->has_options($item['rowid']) == TRUE){
									$html .= '<br/>';
									foreach ($this->cart->product_options($item['rowid']) as $option_name => $option_value){
										$i = 1;
										foreach ($option_value as $k => $v){
											$html .= '<i>'.$v . '</i>';
											$html .= $i == 1 ? ':' : '';
											$i++;
										}
										$html .= '<br/>';
									}
								}
								//
								$html .= '</td>';
								$html .= '<td class="text-center">' . $item['qty'] .'</td>';
								$html .= '<td class="text-right">'. number_format($item['price']) .  '</td>';
								$html .= '<td><a class="remove-cart-item glyphicon glyphicon-remove-circle text-red" rowid="'. $item['rowid'] .'" style="color: #ff0000"></a></td>';
								$html .= '</tr>';
							}
							$html .= '<tr>';
							if(count($this->cart->contents()) > 0){
								$html .='<td colspan="4" class="text-right"><a href="'.base_url('/check-out.html'). '" class="btn-primary btn-sm">Đặt Hàng</a></td>';
							} else {
								$html .='<td colspan="4" class="text-center"><i>Chưa có sản phẩm!</i></td>';
							}
							$html .= '</tr>';
					$html .= '</table>';
					$html .= '</a>';
					$html .= '</li>';

		echo $html;
	}

	public function validatePromoCode(){
		$this->output->set_content_type('application/json');
		$proCode = trim($this->input->post("proCode"));
		$cartTotal = (float)$this->input->post("cartTotal");
		$shippingFee = (float)$this->input->post("shippingFee");
		$loginID = $this->session->userdata('loginid');

		$result = array('valid' => false, 'message' => 'Lỗi không xác định');

		if (empty($proCode)) {
			$result = array('valid' => false, 'message' => 'Vui lòng nhập mã khuyến mãi');
		} else {
			$validationResult = $this->Promotion_Model->validatePromotion($proCode, $cartTotal, $loginID);
			if ($validationResult['valid']) {
				$promotion = $validationResult['promotion'];
				$discount = $this->Promotion_Model->calculateDiscount($promotion, $cartTotal, $shippingFee);
				$result = array(
					'valid' => true,
					'message' => 'Áp dụng khuyến mãi thành công',
					'promotionName' => $promotion->Name,
					'discountAmount' => $discount,
					'discountFormatted' => number_format($discount)
				);
			} else {
				$result = $validationResult;
			}
		}

		echo json_encode($result);
	}

}
