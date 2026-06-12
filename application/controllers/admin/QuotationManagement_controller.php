<?php
/**
 * Created by Khang Nguyen
 * User: nguyennhukhangvn@gmail.com
 * Date: 10/3/2023
 * Time: 8:51 PM
 */

class QuotationManagement_controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Quotation_Model');
		$this->load->helper('form');
		$this->load->library('pagination');
		$this->load->helper("bootstrap_pagination_admin");
		$this->load->helper("seo_url");
		$this->load->library('form_validation');
		$this->load->helper("my_email");
	}

	public function index()
	{
		$config = pagination($this);
		$config['base_url'] = base_url('admin/quote/list.html');
		if(!$config['orderField']){
			$config['orderField'] = "RequestedDate";
			$config['orderDirection'] = "DESC";
		}
		$crucation = $this->input->post("crudaction");
		if($crucation != null && $crucation == 'send-mail'){
			$quoteId = $this->input->post("quoteId");
			$quotation = $this->Quotation_Model->findById($quoteId);
			$quote = $quotation['quote'];
			$customerEmail = $quote->Email;
			$code = $quote->Code;

			if($customerEmail != null && strlen($customerEmail) > 0){
				$html_message = $this->load->view('admin/templates/quotation_view', $quotation, TRUE);
				my_send_email($customerEmail, "Vân Anh Shop - Báo Giá: ".$code, $html_message );
				$data['message_response'] = 'Gửi báo giá thành công.';
			}
		} else if($crucation != null && $crucation == 'delete'){
			$quoteId = $this->input->post("quoteId");
			$this->Quotation_Model->deleteById($quoteId);
			$data['message_response'] = 'Xóa báo giá thành công.';
		}

		$status = $this->input->get('status');
		$results = $this->Quotation_Model->findAndFilter($config['page'], $config['per_page'], $status, $config['orderField'], $config['orderDirection']);
		$data['quotes'] = $results['items'];
		$config['total_rows'] = $results['total'];

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view("admin/quote/list", $data);
	}

	public function view($quoteId)
	{
		$crucation = $this->input->post("crudaction");
		$msg = '';
		$loginId = $this->session->userdata('loginid');
		if($crucation != null && $crucation == 'update'){
			$quotes = $this->input->post("quotes");
			$shippingFee = $this->input->post("ShippingFee");
			$discount = $this->input->post("Discount");
			$validDate = $this->input->post("valid_date");
			$this->form_validation->set_rules("valid_date", "Ngày hiệu lực", "required");
			if ($this->form_validation->run()){
				$this->Quotation_Model->updateQuote($quoteId, $loginId, $shippingFee, $discount, $validDate, $quotes);
				$msg = "Đã cập nhật báo giá thành công";
			}
		} else if($crucation != null && $crucation == 'approved'){
			$this->Quotation_Model->updateStatus(QUOTE_STATUS_APPROVED, $loginId, $quoteId);
			$msg = "Đã cập nhật báo giá thành công";
		}

		$results = $this->Quotation_Model->findById($quoteId);
		$results['quotationId'] = $quoteId;
		$results['message_response'] = $msg;
		$this->load->view("admin/quote/view", $results);
	}
}
