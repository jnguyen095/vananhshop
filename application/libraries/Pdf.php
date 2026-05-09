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
		$this->render();
	}

	protected function ci() {
		return get_instance();
	}
}

?>
