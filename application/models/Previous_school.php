<?php
class Previous_school extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {
        $this->db->insert('previous_school', $data);
    }

    public function update($data,$id)
    {
        $this->db->update('previous_school',$data, array('userID' => $id));
    }
}