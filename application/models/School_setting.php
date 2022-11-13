<?php

class School_setting extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function select($id="")
    {
        $this->db->from('school_setting');
        $this->db->join('schoolyear','schoolyear.schoolyearID = school_setting.schoolyearID', 'inner');
        if($id != "")
        {
            $this->db->where('schoolyear.schoolyearID', $id);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_activated()
    {
        $this->db->from('school_setting');
        $this->db->join('schoolyear','schoolyear.schoolyearID = school_setting.schoolyearID', 'inner');
        $this->db->where('school_setting.active_setting', 1);
        $query = $this->db->get();
        return $query->result();
    }


    public function insert_update()
    {
        $this->db->from('school_setting');
    }
}