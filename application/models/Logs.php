<?php

class Logs extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



    public function inner_count($id, $search = "")
    {
        $this->db->from('user');
        $this->db->join('student','student.userID = user.id', 'inner');
        $this->db->join('class', 'class.classID = student.section', 'inner');

        $this->db->where('student.section', $id);
        
        if($search != '')
        {
            $this->db->group_start();
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
            $this->db->group_end();
        }


        return $this->db->count_all_results();
    }

    public function inner_get($limit, $start,$id,$search = "")
    {
        $this->db->from('user');
        $this->db->join('student','student.userID = user.id', 'inner');
        $this->db->join('class', 'class.classID = student.section', 'inner');

        $this->db->where('student.section', $id);

        if($search != '')
        {
            $this->db->group_start();
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
            $this->db->group_end();
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function emp_count($type, $search = "")
    {
        $this->db->from('user');


        $this->db->where('type', $type);
        
        if($search != '')
        {
            $this->db->group_start();
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
            $this->db->group_end();
        }


        return $this->db->count_all_results();
    }

    public function emp_get($limit, $start,$type,$search = "")
    {
        $this->db->from('user');


        $this->db->where('type', $type);

        if($search != '')
        {
            $this->db->group_start();
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
            $this->db->group_end();
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function student_count()
    {
        $this->db->from('user');
        $this->db->join('gate_logs', 'gate_logs.userID = user.id', 'inner');


        return $this->db->count_all_results();
    }
    
    public function student_get($limit, $start)
    {
        $this->db->from('user');
        $this->db->join('gate_logs', 'gate_logs.userID = user.id', 'inner');


        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }


}