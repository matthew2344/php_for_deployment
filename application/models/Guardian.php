<?php
class Guardian extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {
        $this->db->insert('guardian', $data);
    }

    public function update($data, $id)
    {
        $this->db->update('guardian', $data, array('userID' => $id));
    }
}