<?php

class Face extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function count_face()
    {
        $this->db->from('face');
        return $this->db->count_all_results();
    }

    public function insert($data)
    {
        $this->db->insert('face',$data);
    }
}
