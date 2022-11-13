<?php

class Subject extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {
        $this->db->insert('subject', $data);
    }

    public function update($data, $id)
    {
        $this->db->update('subject', $data, array('subjectID' => $id));
    }

    public function delete($id)
    {
        $this->db->delete('subject', array('subjectID' => $id));
    }

    public function select()
    {
        $this->db->from('subject');
        $query = $this->db->get();
        return $query->result();
    }

    public function count($search = "")
    {
        $this->db->from('subject');
        $this->db->join('gradelevel','gradelevel.gradelevelID = subject.gradelevelID', 'inner');


        if($search != '')
        {
            // $this->db->like('fname', $search);
            // $this->db->or_like('mname', $search);
            // $this->db->or_like('lname', $search);
        }

        return $this->db->count_all_results();
    }

    public function paginate($limit, $start, $search="")
    {
        $this->db->from('subject');
        $this->db->join('gradelevel','gradelevel.gradelevelID = subject.gradelevelID', 'inner');


        if($search != '')
        {
            // $this->db->like('fname',$search);
            // $this->db->or_like('mname',$search);
            // $this->db->or_like('lname',$search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_by_level($id)
    {
        $this->db->from('subject');
        $this->db->join('gradelevel','gradelevel.gradelevelID = subject.gradelevelID', 'inner');
        $this->db->where('gradelevel.gradelevelID',$id);

        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_subject($id)
    {
        $this->db->from('schedule');
        $this->db->join('subject', 'subject.subjectID = schedule.subjectID', 'inner');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID', 'inner');
        $this->db->join('student', 'student.sectionID = section.sectionID', 'inner');
        $this->db->where('student.userID', $id);
        $this->db->group_by('subject.subjectID');

        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_this_subject($id)
    {
        $this->db->from('subject');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = subject.gradelevelID', 'inner');
        $this->db->where('subject.subjectID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_this_subject_new($id,$sectionID)
    {
        $this->db->from('subject');
        $this->db->join('schedule', 'schedule.subjectID = subject.subjectID', 'inner');
        $this->db->join('teach', 'teach.scheduleID = schedule.scheduleID', 'inner');
        $this->db->join('user', 'user.userID = teach.userID', 'inner');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->where('subject.subjectID', $id);
        $this->db->where('section.sectionID', $sectionID);
        $query = $this->db->get();
        return $query->result();
    }


}
