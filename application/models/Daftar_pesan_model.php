<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Daftar_pesan_model extends CI_Model{
    private $_table = "daftar_pesan";

    // get all ini berfungsi untuk menampilkan data beserta join ke tabel server / transaksi
    public function get_all()
    {
        $this->db->select('daftar_pesan.*, server.ip_address');
        $this->db->from($this->_table);
        $this->db->join('server', 'server.id_server = daftar_pesan.server', 'left');
        return $this->db->get()->result_array();
    }
            // ====== fungsi baru untuk tambah data ======
    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    // fungsi ini untuk menhandle penambahan ID_Pesan secara otomatis
    public function get_next_id()
    {
        $row = $this->db
            ->select_max('id_pesan')
            ->get($this->_table)
            ->row_array();

        $next = isset($row['id_pesan']) ? (int)$row['id_pesan'] + 1 : 1;
        return $next;
    }

    // >>> fungsi: ambil satu pesanan berdasarkan id
    public function get_by_id($id)
    {
        return $this->db
            ->get_where($this->_table, ['id_pesan' => $id])
            ->row_array();
    }

    public function hapus($id)
    {
        $this->db->where('id_pesan', $id);
        return $this->db->delete($this->_table);
    }   

    // Update data pesanan ( bagian edit yagesya > get id nya dulu > update )
    public function update($id, $data)
    {
        $this->db->where('id_pesan', $id);
        return $this->db->update($this->_table, $data);
    }

}


?>