<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pesan_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Daftar_pesan_model');   // file: application/models/Daftar_pesan_model.php
        $this->load->model('Server_model');   // <= untuk keperluan ambil data server yang Available
        $this->load->model('Team_model');   // <= untuk keperluan ambil data team 
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
    
<<<<<<< HEAD
    public function tambah_pesanan()
=======
    public function tambah_pesan()
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
    {
        $this->form_validation->set_rules('nama_pembeli', 'Nama Pembeli', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'required');
        $this->form_validation->set_rules('server', 'Server', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required'); // <- handle satuan misal klo DL / Rupiah

        if ($this->form_validation->run() !== FALSE) {
<<<<<<< HEAD
            $this->__simpan_pesanan();
=======
            $this->__simpan_pesan();
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
        } else {
            // hanya server yang Available yang boleh dipilih
            $data['servers'] = $this->Server_model->get_available();
            // bagian data team untuk dropdown di daftar_pesan/tambah
            $data['teams']   = $this->Team_model->get_all();

            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('daftar_pesan/tambah', $data);
            $this->load->view('template/footer');
        }
    }

<<<<<<< HEAD
    private function __simpan_pesanan()
=======
    private function __simpan_pesan()
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
    {
        $id_server = $this->input->post('server'); // ini id_server
        $id_team   = $this->input->post('team');   // ini id_team
        $id_team = empty($id_team) ? NULL : $id_team; // kalau kosong jadiin null

        // ambil satuan (DL / IDR)
        $satuan = $this->input->post('satuan');    // <-- tambahan

        // harga yang dikirim dari form (bisa 30000 atau 30.000)
        $raw_harga = $this->input->post('harga');
        $angka_harga = str_replace('.', '', $raw_harga); // buang titik kalau ada

        $data = [
            'waktu'        => $this->input->post('waktu'),
            'nama_pembeli' => $this->input->post('nama_pembeli'),
            'server'       => $id_server,     // SIMPAN ID di DB
            'team'         => $id_team,         // <-- simpan id team 
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


<<<<<<< HEAD
    public function hapus_pesanan($id)
    {
        // 1. Ambil data pesanan dulu, untuk tahu id_server yang dipakai
=======
    public function hapus_pesan($id)
    {
        // 1. Ambil data pesan dulu, untuk tahu id_server yang dipakai
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
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

<<<<<<< HEAD
            // 3. Jika pesanan punya server, kembalikan status server jadi Available
=======
            // 3. Jika pesan punya server, kembalikan status server jadi Available
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
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

    public function hapus_banyak()
    {
        $ids = $this->input->post('id_pesan'); // array dari checkbox

        if (empty($ids)) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Tidak ada data yang dipilih.</div>');
            return redirect('daftar_pesan');
        }

<<<<<<< HEAD
        // ambil server yang dipakai oleh pesanan yang akan dihapus
=======
        // ambil server yang dipakai oleh pesan yang akan dihapus
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
        $servers = $this->Daftar_pesan_model->get_servers_by_ids($ids);

        // hapus banyak
        $hapus = $this->Daftar_pesan_model->hapus_banyak($ids);

        if ($hapus) {
            // balikin status server jadi Available
            foreach ($servers as $row) {
                if (!empty($row['server'])) {
                    $this->Server_model->update_status($row['server'], 'Available');
                }
            }

<<<<<<< HEAD
            $this->session->set_flashdata('message', '<div class="alert alert-success">Pesanan terpilih berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus pesanan terpilih.</div>');
=======
            $this->session->set_flashdata('message', '<div class="alert alert-success">pesan terpilih berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus pesan terpilih.</div>');
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
        }

        redirect('daftar_pesan');
    }

    public function hapus_semua()
    {
        // ambil semua server dari daftar_pesan (buat dikembalikan)
        $servers = $this->Daftar_pesan_model->get_all_servers();

<<<<<<< HEAD
        // hapus semua pesanan
=======
        // hapus semua pesan
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
        $hapus = $this->Daftar_pesan_model->hapus_semua();

        if ($hapus) {
            foreach ($servers as $row) {
                if (!empty($row['server'])) {
                    $this->Server_model->update_status($row['server'], 'Available');
                }
            }
<<<<<<< HEAD
            $this->session->set_flashdata('message', '<div class="alert alert-success">Semua pesanan berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus semua pesanan.</div>');
=======
            $this->session->set_flashdata('message', '<div class="alert alert-success">Semua pesan berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Gagal menghapus semua pesan.</div>');
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
        }

        redirect('daftar_pesan');
    }
<<<<<<< HEAD



    public function edit_pesanan($id)
=======
    public function test()
{
    echo "CONTROLLER OK";
}
// alias URL: /daftar_pesan/hapus/38
public function hapus($id)
{
    return $this->hapus_pesan($id);
}

// alias URL: /daftar_pesan/edit/38
public function edit($id)
{
    return $this->edit_pesan($id);
}

// alias URL: /daftar_pesan/tambah
public function tambah()
{
    return $this->tambah_pesan();
}

public function export_pilih()
{
    $ids = $this->input->post('id_pesan');

    if (empty($ids)) {
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-warning">Tidak ada data yang dipilih.</div>'
        );
        return redirect('daftar_pesan');
    }

    // ambil data + nama team
    $pesan = $this->Daftar_pesan_model->get_export_by_ids($ids);

    // validasi status
    foreach ($pesan as $row) {
        if ($row['status_pesan'] !== 'Done') {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger">
                    Export gagal! Hanya pesan DONE yang boleh diexport.
                </div>'
            );
            return redirect('daftar_pesan');
        }
    }

    // =============================
    // TRANSAKSI EXPORT
    // =============================
    $this->db->trans_begin();

  foreach ($pesan as $row) {

    $nama_team = (!empty($row['nama_team']))
        ? $row['nama_team']
        : 'Tidak Ada';

    $data = [
        'id_pesan'      => $row['id_pesan'],
        'nama'          => $row['nama_pembeli'],
        'team'          => $nama_team,
        'tanggal'       => date('Y-m-d', strtotime($row['create_at'])), // 🔥 TANGGAL
        'tanggal_pesan' => $row['waktu'],
        'harga'         => $row['harga'],
        'satuan'        => $row['satuan'],
        'status'        => 'Selesai',
  'created_at' => $row['create_at'] // 🔥 JAM PESANAN

    ];

    $this->db->insert('laporan_pembelian', $data);
}


    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger">Export gagal.</div>'
        );
    } else {
        $this->Daftar_pesan_model->hapus_banyak($ids);
        $this->db->trans_commit();

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success">
                Pesan DONE berhasil diexport ke laporan pembelian.
            </div>'
        );
    }

    redirect('daftar_pesan');
}



    public function edit_pesan($id)
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
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
            $data['teams']   = $this->Team_model->get_all();
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('daftar_pesan/edit', $data);
            $this->load->view('template/footer');

        } else {

            $old_server_id = $pesan['server'];
            $new_server_id = $this->input->post('server');
            $id_team       = $this->input->post('team');   // ini id_team    
            $id_team = empty($id_team) ? NULL : $id_team;

            // ---> HITUNG HARGA & SATUAN DI SINI
            $raw_harga   = $this->input->post('harga');
            $angka_harga = str_replace('.', '', $raw_harga);
            $satuan      = $this->input->post('satuan');

            $data_update = [
                'waktu'        => $this->input->post('waktu'),
                'nama_pembeli' => $this->input->post('nama_pembeli'),
                'server'       => $new_server_id,
                'team'         => $id_team,
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

<<<<<<< HEAD
    public function selesai_pesanan($id)
    {
        // Ambil data pesanan berdasarkan ID
=======
    public function selesai_pesan($id)
    {
        // Ambil data pesan berdasarkan ID
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
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

<<<<<<< HEAD
        $id_server = $pesan['server'];   // id_server yang dipakai pesanan ini

        // 1. Update status pesanan jadi Done (TIDAK mengubah kolom server)
=======
        $id_server = $pesan['server'];   // id_server yang dipakai pesan ini

        // 1. Update status pesan jadi Done (TIDAK mengubah kolom server)
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
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
<<<<<<< HEAD
                    Pesanan telah selesai
=======
                    pesan telah selesai
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata('message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
<<<<<<< HEAD
                    Gagal menandai pesanan sebagai selesai
=======
                    Gagal menandai pesan sebagai selesai
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
        }

        redirect('daftar_pesan');
    }

<<<<<<< HEAD
}


=======

}

>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
?>