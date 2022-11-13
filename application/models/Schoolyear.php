<?php

class Schoolyear extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function select()
    {
        $this->db->from('schoolyear');
        $query = $this->db->get();
        return $query->result();
    }


    public function update($data, $id)
    {
        $this->db->update('schoolyear',$data, array('schoolyearID' => $id));
    }


}