<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf extends Dompdf
{
	public function __construct()
	{
		 parent::__construct();
	}

	public function load_view($view, $data = array()) {
		$html = $this->ci()->load->view($view, $data, TRUE);
		$this->loadHtml($html, 'UTF-8');
		$this->setPaper('A4', 'portrait');
		$this->getOptions()->setIsRemoteEnabled(TRUE);
		// Thêm đoạn này để cấu hình bỏ qua xác thực SSL context --> hiễn thị đc hình ảnh trên https
		$contxt = stream_context_create([
			'ssl' => [
				'verify_peer' => FALSE,
				'verify_peer_name' => FALSE,
				'allow_self_signed' => TRUE
			]
		]);
		$this->setHttpContext($contxt);

		$this->render();
	}

	protected function ci() {
		return get_instance();
	}
}

?>
