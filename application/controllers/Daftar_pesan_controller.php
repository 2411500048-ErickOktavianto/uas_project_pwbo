<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pesan_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Daftar_pesan_model');   // file: application/models/Daftar_pesan_model.php
        $this->load->model('Server_model');   // <= untuk keperluan ambil data server yang Available
        // kalau belum login, lempar ke login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['list_pesan'] = $this->Daftar_pesan_model->get_all();

        $this->load->view('template/header');     // BUKAN templates
        $this->load->view('template/sidebar');
        $this->load->view('daftar_pesan/index', $data);   // view konten daftar pesan
        $this->load->view('template/footer');
    }
    
    public function tambah_pesanan()
    {
        $this->form_validation->set_rules('nama_pembeli', 'Nama Pembeli', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'required');
        $this->form_validation->set_rules('server', 'Server', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required'); // <- handle satuan misal klo DL / Rupiah

        if ($this->form_validation->run() !== FALSE) {
            $this->__simpan_pesanan();
        } else {
            // hanya server yang Available yang boleh dipilih
            $data['servers'] = $this->Server_model->get_available();

            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('daftar_pesan/tambah', $data);
            $this->load->view('template/footer');
        }
    }

    private function __simpan_pesanan()
    {
        $id_server = $this->input->post('server'); // ini id_server

        // ambil satuan (DL / IDR)
        $satuan = $this->input->post('satuan');    // <-- tambahan

        // harga yang dikirim dari form (bisa 30000 atau 30.000)
        $raw_harga = $this->input->post('harga');
        $angka_harga = str_replace('.', '', $raw_harga); // buang titik kalau ada

        $data = [
            'waktu'        => $this->input->post('waktu'),
            'nama_pembeli' => $this->input->post('nama_pembeli'),
            'server'       => $id_server,     // SIMPAN ID di DB
            'status_pesan' => 'Run',          // default Run
            'harga'        => $angka_harga,   // angka polos
            'satuan'       => $satuan,        // <-- simpan satuan
            'create_at'    => date('Y-m-d H:i:s')
        ];

        $simpan = $this->Daftar_pesan_model->tambah($data);

        if ($simpan) {
            // ubah status server jadi USED
            $this->Server_model->update_status($id_server, 'USED');

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

        redirect('daftar_pesan');
    }


    public function hapus_pesanan($id)
    {
        // 1. Ambil data pesanan dulu, untuk tahu id_server yang dipakai
        $pesan = $this->Daftar_pesan_model->get_by_id($id);

        if ( ! $pesan) {
            // kalau datanya tidak ada
            $this->session->set_flashdata('message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data tidak ditemukan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            return redirect('daftar_pesan');
        }

        $id_server = $pesan['server'];   // ini adalah id_server yang tersimpan di tabel daftar_pesan

        // 2. Hapus datanya
        $hapus = $this->Daftar_pesan_model->hapus($id);

        if ($hapus) {

            // 3. Jika pesanan punya server, kembalikan status server jadi Available
            if (!empty($id_server)) {
                $this->Server_model->update_status($id_server, 'Available');
            }

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

        redirect('daftar_pesan');
    }

    public function edit_pesanan($id)
    {
        $pesan = $this->Daftar_pesan_model->get_by_id($id);
        if (!$pesan) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger ...">Data tidak ditemukan</div>');
            return redirect('daftar_pesan');
        }

        $this->form_validation->set_rules('nama_pembeli', 'Nama Pembeli', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'required');
        $this->form_validation->set_rules('server', 'Server', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');

        if ($this->form_validation->run() === FALSE) {
            
            $data['servers'] = $this->Server_model->get_available_or_current($pesan['server']); // ambil server yang ready saja jika tidak ready maka hilangkan
            $data['pesan']   = $pesan;

            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('daftar_pesan/edit', $data);
            $this->load->view('template/footer');

        } else {

            $old_server_id = $pesan['server'];
            $new_server_id = $this->input->post('server');

            // ---> HITUNG HARGA & SATUAN DI SINI
            $raw_harga   = $this->input->post('harga');
            $angka_harga = str_replace('.', '', $raw_harga);
            $satuan      = $this->input->post('satuan');

            $data_update = [
                'waktu'        => $this->input->post('waktu'),
                'nama_pembeli' => $this->input->post('nama_pembeli'),
                'server'       => $new_server_id,
                'status_pesan' => $this->input->post('status_pesan'),
                'harga'        => $angka_harga,
                'satuan'       => $satuan,
            ];

            $update = $this->Daftar_pesan_model->update($id, $data_update);

            if ($update) {
                if ($old_server_id != $new_server_id) {
                    if (!empty($old_server_id)) {
                        $this->Server_model->update_status($old_server_id, 'Available');
                    }
                    if (!empty($new_server_id)) {
                        $this->Server_model->update_status($new_server_id, 'USED');
                    }
                }

                $this->session->set_flashdata('message',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data berhasil diupdate
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
            } else {
                $this->session->set_flashdata('message',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Data gagal diupdate
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');
            }

            redirect('daftar_pesan');
        }
    }

    public function selesai_pesanan($id)
    {
        // Ambil data pesanan berdasarkan ID
        $pesan = $this->Daftar_pesan_model->get_by_id($id);

        if ( ! $pesan) {
            // kalau datanya tidak ada
            $this->session->set_flashdata('message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data tidak ditemukan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            return redirect('daftar_pesan');
        }

        $id_server = $pesan['server'];   // id_server yang dipakai pesanan ini

        // 1. Update status pesanan jadi Done (TIDAK mengubah kolom server)
        $update = $this->Daftar_pesan_model->update($id, [
            'status_pesan' => 'Done'
        ]);

        // 2. Kembalikan server jadi Available
        if (!empty($id_server)) {
            $this->Server_model->update_status($id_server, 'Available');
        }

        // 3. Flash message
        if ($update) {
            $this->session->set_flashdata('message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Pesanan telah selesai
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata('message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Gagal menandai pesanan sebagai selesai
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
        }

        redirect('daftar_pesan');
    }

}


?>