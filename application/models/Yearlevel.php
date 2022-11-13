<?php

class Yearlevel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function select()
    {
        $this->db->from('year_level');
        $query = $this->db->get();
        return $query->result();
    }
}