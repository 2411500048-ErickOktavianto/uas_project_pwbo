<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_pembelian_model extends CI_Model {

    private $table = 'laporan_pembelian';

    public function get_all()
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }
    public function hapus_banyak($ids)
{
    $this->db->where_in('id', $ids);
    return $this->db->delete($this->table);
}
public function get_all_for_pdf()
{
    return $this->db
        ->select('id_pesan,nama,team,created_at,tanggal_pesan,harga,satuan,status')
        ->from('laporan_pembelian')
        ->order_by('created_at', 'DESC')
        ->limit(50) // ⬅⬅⬅ KUNCI KECEPATAN
        ->get()
        ->result_array();
}


}
