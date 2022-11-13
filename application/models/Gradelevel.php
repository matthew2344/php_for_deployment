<?php

class Gradelevel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function select()
    {
        $this->db->from('gradelevel');
        $query = $this->db->get();
        return $query->result();
    }

    public function select_t($id)
    {
        $this->db->from('gradelevel');
        $this->db->where("gradelevel.gradelevelID NOT IN (SELECT student.gradelevelID FROM student WHERE student.userID = $id)");

        $query = $this->db->get();
        return $query->result();
    }
}