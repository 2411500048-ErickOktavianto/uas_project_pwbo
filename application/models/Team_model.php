<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team_model extends CI_Model{
    private $_table = "team";

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

    // // untuk keperluan edit agar server tidak kosong karena jika menggunakan get_available maka server yang sedang dipakai tidak muncul

    public function hapus($id)
    {
        $this->db->where('id_team', $id);
        return $this->db->delete($this->_table);
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->_table, ['id_team' => $id])->row_array();
    }

    public function update($id, $data)
    {
        $this->db->where('id_team', $id);
        return $this->db->update($this->_table, $data);
    }
}

?>