<?php

class Staff extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function count($search = "")
    {
        $this->db->from('user');
        $this->db->join('staff','staff.userID = user.userID', 'inner');
        $this->db->join('stafftype','stafftype.stafftypeID = staff.stafftypeID', 'inner');
        $this->db->where('user.roleID', 4);
        $this->db->order_by('user.userID', 'desc');
        if($search != '')
        {
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
            $this->db->or_like('user.userID', $search);
        }

        return $this->db->count_all_results();
    }

    public function select($limit, $start, $search="")
    {
        $this->db->from('user');
        $this->db->join('staff','staff.userID = user.userID', 'inner');
        $this->db->join('stafftype','stafftype.stafftypeID = staff.stafftypeID', 'inner');
        $this->db->where('user.roleID', 4);
        $this->db->order_by('user.userID', 'desc');
        
        if($search != '')
        {
            $this->db->like('fname',$search);
            $this->db->or_like('mname',$search);
            $this->db->or_like('lname',$search);
            $this->db->or_like('user.userID', $search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($udata)
    {
        // Insert New User
        $this->db->insert('user', $udata);

        // Create Password
        $data['password'] = sha1($this->db->insert_id());
        $last_id = $this->db->insert_id();
        $data['email'] = $last_id.'@email.com';
        $this->db->update('user', $data, array('userID' => $last_id));

        return $last_id;
    }

    public function get_staff($id)
    {
        $this->db->from('user');
        $this->db->join('staff', 'staff.userID = user.userID');
        $this->db->join('stafftype','stafftype.stafftypeID = staff.stafftypeID', 'inner');
        $this->db->where('user.userID',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_title($id)
    {
        $this->db->from('user');
        $this->db->join('staff', 'staff.userID = user.userID');
        $this->db->join('stafftype', 'stafftype.stafftypeID = staff.stafftypeID');
        $this->db->where('user.userID',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_staff($data)
    {
        $this->db->insert('staff', $data);
    }

    public function update($data,$id)
    {
        $this->db->update('user',$data, array('userID' => $id));
    }

    public function update_staff($data,$id)
    {
        $this->db->update('staff',$data, array('userID' => $id));
    }

}