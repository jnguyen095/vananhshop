<?php

class Report_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_Model');
        $this->load->library('session');
    }

    public function index()
    {
        $this->load->view('admin/report/index');
    }

    public function load()
    {
        $type = $this->input->get('type', true);
        $period = in_array($type, array('month'), true) ? 'month' : 'day';
        $data = $this->Dashboard_Model->getReportSummary($period);
        $this->load->view('admin/report/partial', $data);
    }
}
