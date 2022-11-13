<?php

class Studentsection extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {
        // Insert data
        $this->db->insert('user', $data);
        
        // Create password
        $data['password'] = sha1($this->db->insert_id());
        $last_id = $this->db->insert_id();
        $data['email'] = $last_id.'@email.com';
        $this->db->update('user', $data, array('userID' => $last_id));
        return $last_id;
    }

    public function select()
    {
        $this->db->from('studentsection');
        $this->db->join('user', 'user.userID = studentsection.studentID', 'inner');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_student($data)
    {
        $this->db->insert('studentsection', $data);
    }

    public function count($search = "")
    {
        $this->db->from('user');
        $this->db->join('student','student.userID = user.userID', 'inner');


        if($search != '')
        {
            $this->db->like('fname', $search);
            $this->db->or_like('mname', $search);
            $this->db->or_like('lname', $search);
        }

        return $this->db->count_all_results();
    }

    public function paginate($limit, $start, $search="")
    {
        $this->db->from('user');
        $this->db->join('student','student.userID = user.userID', 'inner');


        if($search != '')
        {
            $this->db->like('fname',$search);
            $this->db->or_like('mname',$search);
            $this->db->or_like('lname',$search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_student($id)
    {
        $this->db->from('user');
        $this->db->join('studentsection', 'studentsection.studentID = user.userID', 'inner');
        $this->db->join('section', 'section.sectionID = studentsection.sectionID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID', 'inner');
        $this->db->where('user.userID',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update($data,$id)
    {
        $this->db->update('user',$data, array('userID' => $id));
    }


}