<?php

class User extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function count($search="")
    {
        $this->db->from('user');
        $this->db->join('role','role.roleID = user.roleID', 'inner');
        $this->db->where('role.roleID', 1);

        if($search != '')
        {
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
            $this->db->or_like('userID', $search);
        }

        return $this->db->count_all_results();
    }

    public function select($limit, $start, $search="")
    {
        $this->db->from('user');
        $this->db->join('role','role.roleID = user.roleID', 'inner');
        $this->db->where('role.roleID', 1);

        if($search != '')
        {
            $this->db->like('fname',$search);
            $this->db->or_like('mname',$search);
            $this->db->or_like('lname',$search);
            $this->db->or_like('userID', $search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert('User', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function insert1($data)
    {
        $this->db->insert('User', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function get_where($id)
    {
        $this->db->from('user');
        $this->db->where('userID', $id);
        $result = $this->db->get();
        return $result->result();
    }

    public function get()
    {
        $this->db->from('user');
        $this->db->where('role !=', 'Admin');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_this($id)
    {
        $this->db->from('user');
        $this->db->where('userID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_users()
    {
        $this->db->from('user');
        // $this->db->where('role !=', 'Admin');

        return $this->db->count_all_results();
    }

    public function get_users($limit, $start)
    {
        $this->db->from('user');
        // $this->db->where('role !=', 'Admin');

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all()
    {
        $this->db->from('user');
        $query = $this->db->get();
        return $query->result();
    }

    public function login($data)
    {
        $result = $this->db->get_where('user', array('email' => $data['email'], 'password' => $data['password']));
        return $result->result();
    }

    public function login1($data)
    {
        $this->db->from('user');
        $this->db->join('role', 'user.roleID = role.roleID', 'inner');
        $this->db->where('user.userID', $data['userID']);
        $this->db->where('user.password', $data['password']);
        $query = $this->db->get();
        return $query->result();
    }

    public function update($data,$id)
    {
        $this->db->update('user', $data, array('userID' => $id));
    }

    public function activate($data,$id,$activation_code)
    {
        $this->db->update('user', $data, array('userID' => $id, 'activation_code' => $activation_code));
    }

    public function validate_user($data)
    {
        $query = $this->db->get_where('user', array('userID' => $data['id'], 'password' => $data['password']));
        return $query->result();
    }

    public function get_activation_code($id,$activation_code)
    {
        $query = $this->db->get_where('user', array('userID' => $id, 'activation_code' => $activation_code));
        $result = $query->row();
        return $result;
    }

    public function delete($uid)
    {
        $this->db->delete('user', array('userID' => $uid));
    }


    public function get_admin($id)
    {
        $this->db->from('user');
        $this->db->where('user.userID',$id);
        $query = $this->db->get();
        return $query->result();
    }

    
    

}