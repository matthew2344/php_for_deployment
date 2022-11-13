<?php

class Gate_settings extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function select()
    {
        $this->db->from('Gate_settings');
        $query = $this->db->get();
        return $query->result();
    }

    
    public function update($data, $id)
    {
        $this->db->update('Gate_settings',$data, array('gate_settingsID' => $id));
    }
}