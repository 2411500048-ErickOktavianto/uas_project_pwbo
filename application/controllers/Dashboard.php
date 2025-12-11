<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // cek session, kalau belum login lempar ke login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $this->load->view("template/header");
        $this->load->view("template/sidebar");
        $this->load->view("dashboard");
        $this->load->view("template/footer");
    }
}
