<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{
    // $identity boleh isi email ATAU username (kolom name)
    public function cek_login($identity, $password)
    {
        $this->db->from('user'); // nama tabel: user

        // email atau name
        $this->db->where("(email = " . $this->db->escape($identity) . " 
                          OR name  = " . $this->db->escape($identity) . ")");

        // password disimpan md5 di DB
        $this->db->where('password', md5($password));

        $query = $this->db->get();
        return $query->row(); // ketemu = object, kalau tidak = NULL
    }
}
