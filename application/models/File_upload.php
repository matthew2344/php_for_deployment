<?php

class File_upload extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function upload_data($data)
    {
        $this->db->insert('face',$data);
    }
    public function count($uid)
    {
        $this->db->from('user');
        $this->db->join('dataset','dataset.uid = user.id', 'inner');
        $this->db->where('user.id',$uid);
        return $this->db->count_all_results();
    }

    public function get_data($limit, $start,$uid)
    {
        $this->db->from('user');
        $this->db->join('dataset','dataset.uid = user.id', 'inner');
        $this->db->where('user.id',$uid);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }
    

    public function get_where($id)
    {
        $query = $this->db->get_where('dataset', array('id' => $id));
        return $query->result();
    }

    public function delete($id)
    {
        $this->db->delete('dataset', array('id' => $id));
    }

}