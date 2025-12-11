<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Server_model');   // file: application/models/Server_model.php

        // kalau belum login, lempar ke login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['list_server'] = $this->Server_model->get_all();

        $this->load->view('template/header');     // BUKAN templates
        $this->load->view('template/sidebar');
        $this->load->view('server/index', $data);   // view konten server
        $this->load->view('template/footer');
    }

    public function tambah_server(){
        $this->form_validation->set_rules('ip_address', 'IP Address', 'required');
        if($this->form_validation->run() !== FALSE){
            $this->__simpan_server();
        }else{
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('server/tambah');
            $this->load->view('template/footer');
        }
    }


    private function __simpan_server(){
        $data = [
            'ip_address' => $this->input->post('ip_address'),
            'expired' => $this->input->post('expired'),
            'status' => 'Available',
            'create_at' => date('Y-m-d H:i:s') 
        ];

        $simpan = $this->Server_model->tambah($data);

        if ($simpan) {
            $this->session->set_flashdata('message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data berhasil ditambahkan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata('message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data gagal ditambahkan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
        }

        redirect('server');
    }

    public function hapus_server($id)
    {
        $hapus = $this->Server_model->hapus($id);

        if ($hapus) {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data berhasil dihapus
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data gagal dihapus!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
        }

        redirect('server');
    }

    public function edit_server($id)
    {
        // ambil data server berdasar ID
        $server = $this->Server_model->get_by_id($id);
        if (!$server) {
            show_404();
        }

        // rules form
        $this->form_validation->set_rules('ip_address', 'IP Address', 'required');
        $this->form_validation->set_rules('expired', 'Expired', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            // tampilkan form edit dengan data lama
            $data['server'] = $server;

            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('server/edit', $data);
            $this->load->view('template/footer');
        } else {
            // simpan perubahan
            $updateData = [
                'ip_address' => $this->input->post('ip_address', TRUE),
                'expired'    => $this->input->post('expired', TRUE),
                'status'     => $this->input->post('status', TRUE),
            ];

            $update = $this->Server_model->update($id, $updateData);

            if ($update) {
                $this->session->set_flashdata('message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data berhasil diupdate
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
            } else {
                $this->session->set_flashdata('message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Data gagal diupdate
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
            }

            redirect('server');
        }

    }

}
?>