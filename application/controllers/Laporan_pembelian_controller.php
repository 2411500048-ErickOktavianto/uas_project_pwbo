<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_pembelian_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_pembelian_model');
        $this->load->library('session');
    }

  public function index()
{
    // ambil semua data
    $laporan = $this->Laporan_pembelian_model->get_all();

    $laporan_per_bulan = [];

    foreach ($laporan as $row) {

        // key bulan: 2025-12
        $bulanKey = date('Y-m', strtotime($row['created_at']));

        // inisialisasi jika belum ada
        if (!isset($laporan_per_bulan[$bulanKey])) {
            $laporan_per_bulan[$bulanKey] = [
                'items' => [],
                'total_idr' => 0,
                'total_dl'  => 0,
            ];
        }

        // simpan data
        $laporan_per_bulan[$bulanKey]['items'][] = $row;

        // hitung total berdasarkan satuan
        if ($row['satuan'] === 'DL') {
            $laporan_per_bulan[$bulanKey]['total_dl'] += (int) $row['harga'];
        } else {
            $laporan_per_bulan[$bulanKey]['total_idr'] += (int) $row['harga'];
        }
    }

    $data['laporan_per_bulan'] = $laporan_per_bulan;

    // load view
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('laporan_pembelian/index', $data);
    $this->load->view('template/footer');
}


public function export_pdf()
{
    $laporan = $this->Laporan_pembelian_model->get_all();

    if (empty($laporan)) {
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-warning">Data laporan kosong.</div>'
        );
        redirect('laporan_pembelian_controller');
        return;
    }

    // ===== GROUPING PER BULAN =====
    $laporan_per_bulan = [];

    foreach ($laporan as $row) {
        $bulanKey = date('Y-m', strtotime($row['created_at']));

        if (!isset($laporan_per_bulan[$bulanKey])) {
            $laporan_per_bulan[$bulanKey] = [
                'items' => [],
                'total_idr' => 0,
                'total_dl'  => 0,
            ];
        }

        $laporan_per_bulan[$bulanKey]['items'][] = $row;

        if ($row['satuan'] === 'DL') {
            $laporan_per_bulan[$bulanKey]['total_dl'] += (int) $row['harga'];
        } else {
            $laporan_per_bulan[$bulanKey]['total_idr'] += (int) $row['harga'];
        }
    }

    $data['laporan_per_bulan'] = $laporan_per_bulan;

    // ===== LOAD MPDF =====
    $this->load->library('pdf'); // wrapper mpdf kamu

    $html = $this->load->view(
        'laporan_pembelian/pdf',
        $data,
        true
    );

    $this->pdf->createPDF(
        $html,
        'laporan-pembelian-' . date('Y-m-d'),
        true
    );
}

public function hapus_pilih()
{
    $ids = $this->input->post('id_laporan');

    if (empty($ids)) {
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-warning">Tidak ada laporan yang dipilih.</div>'
        );
        redirect('laporan_pembelian_controller');
        return;
    }

    $hapus = $this->Laporan_pembelian_model->hapus_banyak($ids);

    if ($hapus) {
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success">
                Laporan terpilih berhasil dihapus.
            </div>'
        );
    } else {
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-danger">
                Gagal menghapus laporan terpilih.
            </div>'
        );
    }

    redirect('laporan_pembelian_controller');
}



}