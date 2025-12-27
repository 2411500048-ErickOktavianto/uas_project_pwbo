<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Team_model');   // file: application/models/Server_model.php

        // kalau belum login, lempar ke login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['list_team'] = $this->Team_model->get_all();

        $this->load->view('template/header');     // BUKAN templates
        $this->load->view('template/sidebar');
        $this->load->view('team/index', $data);   // view konten server
        $this->load->view('template/footer');
    }

    public function tambah_team(){
        $this->form_validation->set_rules('nama_team', 'nama team', 'required');
        if($this->form_validation->run() !== FALSE){
            $this->__simpan_team();
        }else{
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('team/tambah');
            $this->load->view('template/footer');
        }
    }


    private function __simpan_team(){
        $data = [
            'nama_team' => $this->input->post('nama_team')
        ];

        $simpan = $this->Team_model->tambah($data);

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

        redirect('team');
    }

    public function hapus_team($id)
    {
        $hapus = $this->Team_model->hapus($id);

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

        redirect('team');
    }

    public function edit_team($id)
    {
        // ambil data server berdasar ID
        $team = $this->Team_model->get_by_id($id);
        if (!$team) {
            show_404();
        }

        // rules form
        $this->form_validation->set_rules('nama_team','nama team', 'required');

        if ($this->form_validation->run() === FALSE) {
            // tampilkan form edit dengan data lama
            $data['team'] = $team;

            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('team/edit', $data);
            $this->load->view('template/footer');
        } else {
            // simpan perubahan
            $updateData = [
                'nama_team' => $this->input->post('nama_team', TRUE)
            ];

            $update = $this->Team_model->update($id, $updateData);

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

            redirect('team');
        }

    }

}
?>