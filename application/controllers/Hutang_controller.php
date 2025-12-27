<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hutang_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hutang_model');   // file: application/models/Server_model.php

        // kalau belum login, lempar ke login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['list_hutang'] = $this->Hutang_model->get_all();

        $this->load->view('template/header');     // BUKAN templates
        $this->load->view('template/sidebar');
        $this->load->view('hutang/index', $data);   // view konten server
        $this->load->view('template/footer');
    }

    public function tambah_hutang(){
        $this->form_validation->set_rules('nama_orang', 'nama orang', 'required');
         $this->form_validation->set_rules('total_hutang', 'total hutang', 'required');
          $this->form_validation->set_rules('status_hutang', 'status_hutang', 'required');
        if($this->form_validation->run() !== FALSE){
            $this->__simpan_hutang();
        }else{
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('hutang/tambah');
            $this->load->view('template/footer');
        }
    }


    private function __simpan_hutang(){
        $data = [
        'nama_orang'   => $this->input->post('nama_orang'),
        'total_hutang' => $this->input->post('harga'),      // ✔ angka murni
        'satuan'       => $this->input->post('satuan'),     // ✔ simpan satuan juga
        'status_hutang'=> $this->input->post('status_hutang'),
        'create_at' => date('Y-m-d H:i:s') 
    ];

        $simpan = $this->Hutang_model->tambah($data);

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

        redirect('hutang');
    }

    public function hapus_hutang($id)
    {
        $hapus = $this->Hutang_model->hapus($id);

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

<<<<<<< HEAD
        redirect('hutang');
    }
=======
        redirect('hutang_controller');
    }
    public function export_pdf()
{
    // pakai get_all() yang sama
    $data['hutang'] = $this->Hutang_model->get_all();

    if (empty($data['hutang'])) {
        show_error('Data hutang kosong');
    }

    // load library pdf (mpdf/dompdf)
    $this->load->library('pdf');

    // render view ke HTML
    $html = $this->load->view('hutang/pdf', $data, true);

    // FALSE = buka di tab baru (TIDAK download)
    $this->pdf->createPDF(
        $html,
        'data-hutang-' . date('Y-m-d'),
        false
    );
}

>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)

    public function edit_hutang($id)
    {   
        // Ambil data hutang berdasarkan ID
        $hutang = $this->Hutang_model->get_by_id($id);
        if (!$hutang) {
            show_404();
        }

        // Rules form
        $this->form_validation->set_rules('nama_orang', 'nama orang', 'required');
        $this->form_validation->set_rules('harga', 'total hutang', 'required'); // angka murni
        $this->form_validation->set_rules('status_hutang', 'status hutang', 'required');
        $this->form_validation->set_rules('satuan', 'satuan', 'required');

        // Jika belum submit atau gagal validasi → tampilkan form edit
        if ($this->form_validation->run() === FALSE) {

            $data['hutang'] = $hutang;

            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('hutang/edit', $data);
            $this->load->view('template/footer');
        
        } else {

            // Data yang akan disimpan
            $updateData = [
                'nama_orang'   => $this->input->post('nama_orang', TRUE),
                'total_hutang' => $this->input->post('harga', TRUE),   // angka murni
                'satuan'       => $this->input->post('satuan', TRUE),
                'status_hutang'=> $this->input->post('status_hutang', TRUE),
                'create_at' => date('Y-m-d H:i:s')
            ];

            $update = $this->Hutang_model->update($id, $updateData);

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

            redirect('hutang');
        }
    }


}
?>