<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CityManagement_controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('upload');
        $this->load->library('session');
        $this->load->dbforge();
    }

    public function index() {
        $this->load->view('admin/city/list');
    }

    public function import() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['max_size'] = 2048; // 2MB

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('excel_file')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('admin/city/index', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $file_path = $data['upload_data']['full_path'];

            // Load PhpSpreadsheet
            require_once FCPATH . 'vendor/autoload.php';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Skip header row
            array_shift($rows);

            foreach ($rows as $row) {
            	$city_code = trim($row[1]); // City Code column
                $city_name = trim($row[2]); // City column
				$district_code = trim($row[3]); // District Code column
                $district_name = trim($row[4]); // District column

                if (!empty($city_name) && !empty($district_name)) {
                    // Check if city exists
                    $city = $this->db->get_where('city', array('Code' => $city_code))->row();
                    if (!$city) {
                        $this->db->insert('city', array('Code' => $city_code,'CityName' => $city_name));
                        $city_id = $this->db->insert_id();
                    } else {
                        $city_id = $city->CityID;
                    }

                    // Insert district
					$district = $this->db->get_where('district', array('Code' => $district_code))->row();
                    if(!$district){
						$this->db->insert('district', array('Code' => $district_code,'DistrictName' => $district_name, 'CityID' => $city_id));
					}

                }
            }

            // Delete uploaded file
            unlink($file_path);

            $this->session->set_flashdata('success', 'Import successful');
            redirect('admin/CityManagement_controller');
        }
    }
}
?>
