<?php

class Student extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function count($search = "")
    {
        $this->db->from('user');
        $this->db->join('student','student.userID = user.userID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = student.gradelevelID', 'inner');
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
        $this->db->join('student','student.userID = user.userID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = student.gradelevelID', 'inner');
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

        $this->db->insert('user', $udata);

        $last_id = $this->db->insert_id();

        return $last_id;
    }

    public function get_student($id)
    {
        $this->db->from('user');
        $this->db->join('student', 'student.userID = user.userID', 'inner');
        $this->db->join('guardian', 'guardian.userID = user.userID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = student.gradelevelID', 'inner');
        $this->db->join('previous_school', 'previous_school.userID = user.userID', 'left');
        $this->db->where('user.userID',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update($data,$id)
    {
        $this->db->update('user',$data, array('userID' => $id));
    }

    public function update_student($data,$id)
    {
        $this->db->update('student',$data, array('userID' => $id));
    }


    public function insert_student($data)
    {
        $this->db->insert('student', $data);
    }


    public function get_subject($id)
    {
        $this->db->from('schedule');
        $this->db->join('subject', 'subject.subjectID = schedule.subjectID', 'inner');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID', 'inner');
        $this->db->join('student', 'student.sectionID = section.sectionID', 'inner');
        $this->db->where('student.userID', $id);
        $this->db->order_by('schedule.schedule_start','asc');

        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_the_subject($id)
    {
        $this->db->from('subject');
        $this->db->join('schedule','schedule.subjectID = subject.subjectID', 'inner');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->where('schedule.scheduleID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_this_subject($id,$sectionID)
    {
        $this->db->from('subject');
        $this->db->join('schedule', 'schedule.subjectID = subject.subjectID', 'inner');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->where('subject.subjectID', $id);
        $this->db->where('section.sectionID', $sectionID);
        $query = $this->db->get();
        return $query->result();
    }


    

}