<?php
/**
 * Base controller for all controllers
 * Handles common functionality and admin permission checks
 */

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Check if this is an admin request
        if (strpos($this->uri->uri_string(), 'admin') === 0) {
            // Admin area - check permissions
            if (!$this->session->userdata('loginid')) {
                redirect('dang-nhap');
            }
            // Check if user has admin permissions
            else if ($this->session->userdata('usergroup') != USER_GROUP_ADMIN_CODE) {
                show_error('You do not have permission to access this page.', 403, '403 Forbidden');
                exit;
            }
        }

        // Load common libraries/helpers if needed
        $this->load->library('session');
    }
}