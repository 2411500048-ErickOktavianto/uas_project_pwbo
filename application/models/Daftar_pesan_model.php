<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pesan_model extends CI_Model
{
    private $_table = "daftar_pesan";

    // ambil semua data + join server & team
    public function get_all()
    {
        return $this->db
            ->select('daftar_pesan.*, server.ip_address, team.nama_team')
            ->from($this->_table)
            ->join('server', 'server.id_server = daftar_pesan.server', 'left')
            ->join('team', 'team.id_team = daftar_pesan.team', 'left')
            ->get()
            ->result_array();
    }

    public function tambah($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->affected_rows() === 1;
    }

    public function get_next_id()
    {
        $row = $this->db
            ->select_max('id_pesan')
            ->get($this->_table)
            ->row_array();

        return isset($row['id_pesan']) ? (int)$row['id_pesan'] + 1 : 1;
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where($this->_table, ['id_pesan' => $id])
            ->row_array();
    }

    public function hapus($id)
    {
        return $this->db
            ->where('id_pesan', $id)
            ->delete($this->_table);
    }

    public function update($id, $data)
    {
        return $this->db
            ->where('id_pesan', $id)
            ->update($this->_table, $data);
    }

    // ambil server dari beberapa id (untuk balikin status)
    public function get_servers_by_ids($ids)
    {
        return $this->db
            ->select('id_pesan, server')
            ->from($this->_table)
            ->where_in('id_pesan', $ids)
            ->get()
            ->result_array();
    }

    public function hapus_banyak($ids)
    {
        return $this->db
            ->where_in('id_pesan', $ids)
            ->delete($this->_table);
    }

    public function get_all_servers()
    {
        return $this->db
            ->select('server')
            ->from($this->_table)
            ->get()
            ->result_array();
    }

    public function hapus_semua()
    {
        return $this->db->query("DELETE FROM {$this->_table}");
    }

    // ===============================
    // EXPORT (JOIN TEAM)
    // ===============================
  public function get_export_by_ids($ids)
{
    return $this->db
        ->select('daftar_pesan.*, team.nama_team')
        ->from('daftar_pesan')
        ->join('team', 'team.id_team = daftar_pesan.team', 'left')
        ->where_in('daftar_pesan.id_pesan', $ids)
        ->get()
        ->result_array();
}



}
