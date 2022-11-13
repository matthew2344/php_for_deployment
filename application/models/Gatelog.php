<?php

class Gatelog extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {
        $this->db->insert('gatelog',$data);
    }

    public function check_log($id, $date)
    {
        $this->db->from('gatelog');
        $this->db->where( array( 'userID' => $id, 'date' => $date ) );
        return $this->db->count_all_results();
    }

    public function all_count($date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->order_by("gatelog.gatelogID", "desc");
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }

        return $this->db->count_all_results();
    }

    public function all_get($limit, $start, $date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->order_by("gatelog.gatelogID", "desc");
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function dl($date, $role)
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->join('role', 'role.roleID = user.roleID', 'inner');
        $this->db->order_by("gatelog.gatelogID", "desc");
        if($role != "")
        {
            $this->db->where('user.roleID', $role);
        }

        if($date != "all")
        {
            $this->db->where('gatelog.date', $date);
        } 
        
        $query = $this->db->get();
        return $query->result();
    }

    public function student_count($date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->where('user.roleID', 2);
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }

        return $this->db->count_all_results();
    }

    public function student_get($limit, $start, $date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->where('user.roleID', 2);
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function teacher_count($date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->where('user.roleID', 3);
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }


        return $this->db->count_all_results();
    }

    public function teacher_get($limit, $start, $date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->where('user.roleID', 3);
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }


    public function staff_count($date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->where('user.roleID', 4);
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }


        return $this->db->count_all_results();
    }

    public function staff_get($limit, $start, $date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->where('user.roleID', 4);
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function id_count($id)
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->order_by("gatelog.entry_time", "desc");
        $this->db->where('user.userID',$id);

        return $this->db->count_all_results();
    }

    public function id_get($limit, $start, $id)
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->order_by("gatelog.entry_time", "desc");
        $this->db->where('user.userID',$id);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_id($id, $date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->order_by("gatelog.entry_time", "desc");
        $this->db->where('user.userID',$id);
        if($date != "")
        {
            $this->db->where('gatelog.date', $date);
        } 
        $query = $this->db->get();
        return $query->result();
    }


    public function my_log_count($id, $date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->order_by("gatelog.gatelogID", "desc");
        $this->db->where('user.userID', $id);
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }
        return $this->db->count_all_results();
    }

    public function my_log_get($limit, $start, $id, $date = "")
    {
        $this->db->from('user');
        $this->db->join('gatelog', 'gatelog.userID = user.userID', 'inner');
        $this->db->order_by("gatelog.gatelogID", "desc");
        $this->db->where('user.userID', $id);
        if($date == '')
        {
            $this->db->where('gatelog.date', Date('Y-m-d'));
        } else {
            $this->db->where('gatelog.date', $date);
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }
}