<?php

class Stafftype extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {
        $this->db->insert('stafftype',$data);
    }

    public function select()
    {
        $this->db->from('stafftype');
        $query = $this->db->get();
        return $query->result();
    }

    public function select_t($id)
    {
        $this->db->from('stafftype');
        $this->db->where("stafftype.stafftypeID NOT IN (SELECT staff.stafftypeID FROM staff WHERE staff.userID = $id)");

        $query = $this->db->get();
        return $query->result();
    }
}