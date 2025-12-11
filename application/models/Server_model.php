<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_model extends CI_Model{
    private $_table = "server";

    public function get_all(){
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }
        // ====== fungsi baru untuk tambah data ======
    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function get_available()
    {
        return $this->db
            ->get_where($this->_table, ['status' => 'Available'])
            ->result_array();
    }

    // untuk keperluan edit agar server tidak kosong karena jika menggunakan get_available maka server yang sedang dipakai tidak muncul
    public function get_available_or_current($current_id = null)
    {
        $this->db->from($this->_table); // misal $_table = 'server'

        if ($current_id) {
            // ( status = 'Available' OR id_server = $current_id )
            $this->db->group_start();
            $this->db->where('status', 'Available');
            $this->db->or_where('id_server', $current_id);
            $this->db->group_end();
        } else {
            $this->db->where('status', 'Available');
        }

        return $this->db->get()->result_array();
    }

    public function update_status($id_server, $status)
    {
        $this->db->where('id_server', $id_server);
        $this->db->update($this->_table, ['status' => $status]);
        return $this->db->affected_rows() > 0;
    }

    public function hapus($id)
    {
        $this->db->where('id_server', $id);
        return $this->db->delete($this->_table);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->_table, ['id_server' => $id])->row_array();
    }

    public function update($id, $data)
    {
        $this->db->where('id_server', $id);
        return $this->db->update($this->_table, $data);
    }
}

?>