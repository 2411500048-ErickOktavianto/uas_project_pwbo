<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('session');
        $this->load->helper(['url','form']);
    }

    // tampilkan form login
    public function index()
    {
        // kalau sudah login, langsung ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('login');
    }

    // INI YANG DICARI OLEH URL /login/proses
    public function proses()
    {
        $identity = $this->input->post('identity', TRUE); // email / username
        $password = $this->input->post('password', TRUE);

        $user = $this->Login_model->cek_login($identity, $password);

        if ($user) {
            $this->session->set_userdata([
                'id_user'   => $user->id_user,
                'name'      => $user->name,
                'email'     => $user->email,
                'logged_in' => TRUE
            ]);

            redirect('dashboard'); // ke BASE_URL/index.php/dashboard
        } else {
            $this->session->set_flashdata('error', 'Email/Username atau password salah');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
