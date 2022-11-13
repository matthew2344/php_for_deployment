<?php

class Teach extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // public function insert($data)
    // {
    //     // Insert data
    //     $this->db->insert('user', $data);
        
    //     // Create password
    //     $data['password'] = sha1($this->db->insert_id());
    //     $last_id = $this->db->insert_id();
    //     $data['email'] = $last_id.'@email.com';
    //     $this->db->update('user', $data, array('userID' => $last_id));
    //     return $last_id;
    // }

    public function insert($data)
    {
        $this->db->insert('teach', $data);
    }

    public function select($id)
    {
        $this->db->from('teach');
        $this->db->join('schedule', 'schedule.scheduleID = teach.scheduleID', 'inner');
        $this->db->where('teach.userID', $id);

        $query = $this->db->get();
        return $query->result();
    }

    public function select_subject($id)
    {
        $this->db->from('schedule');
        $this->db->where('schedule.scheduleID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function select_teach($id)
    {
        $this->db->from('teach');
        $this->db->join('schedule', 'schedule.scheduleID = teach.scheduleID', 'inner');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID');
        $this->db->join('subject', 'subject.subjectID = schedule.subjectID');
        $this->db->where('teach.userID', $id);
        $this->db->order_by('schedule.schedule_start','asc');
        $this->db->group_by('subject.subjectID');

        $query = $this->db->get();
        return $query->result();
    }
    public function select_teach_subject($id)
    {
        $this->db->from('teach');
        $this->db->join('schedule', 'schedule.scheduleID = teach.scheduleID', 'inner');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID');
        $this->db->join('subject', 'subject.subjectID = schedule.subjectID');
        $this->db->where('teach.userID', $id);
        $this->db->order_by('schedule.schedule_start','asc');;

        $query = $this->db->get();
        return $query->result();
    }
    

    // public function select()
    // {
    //     $this->db->from('teach');
    //     $this->db->join('user', 'user.userID = teach.teacherID', 'inner');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function insert_teach($data)
    {
        $this->db->insert('teach', $data);
    }

    public function count($search = "")
    {
        $this->db->from('user');
        $this->db->join('teach','teach.teacherID = user.userID', 'inner');

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
        $this->db->join('teach','teach.teacherID = user.userID', 'inner');

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

    public function get_teacher($id)
    {
        $this->db->from('user');
        $this->db->join('teach', 'teach.teacherID = user.userID');

        $this->db->where('user.userID',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update($data,$id)
    {
        $this->db->update('user',$data, array('userID' => $id));
    }

    public function select_student($id)
    {
        $this->db->from('user');
        $this->db->join('student', 'student.userID = user.userID', 'inner');
        $this->db->join('section', 'section.sectionID = student.sectionID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID', 'inner');
        $this->db->order_by('user.lname');
  
        $this->db->where('section.sectionID', $id);

        $query = $this->db->get();
        return $query->result();
    }

    public function select_student_class($id, $date)
    {
        $this->db->from('user');
        $this->db->join('student', 'student.userID = user.userID', 'inner');
        $this->db->join('section', 'section.sectionID = student.sectionID', 'inner');
        $this->db->join('schedule', 'schedule.sectionID = section.sectionID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID', 'inner');
        $this->db->join('attendance', 'attendance.scheduleID = schedule.scheduleID', 'inner');
        $this->db->order_by('user.lname');
        $this->db->group_by('user.userID');
        
  
        $this->db->where('schedule.scheduleID', $id);
        $this->db->where('attendance.date', $date);

        $query = $this->db->get();
        return $query->result();
    }

    public function delete($teachID)
    {
        $this->db->delete('teach', array('teachID' => $teachID));
    }

    public function get_attendance_status()
    {
        $this->db->from('attendance_status');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_sched($id)
    {
        $this->db->from('schedule');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject', 'subject.subjectID = schedule.subjectID', 'inner');
        $this->db->where('schedule.scheduleID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function check_attendance($data)
    {
        $result = $this->db->get_where('attendance',
         array('date' => $data['date'], 'userID' => $data['userID'], 'scheduleID' => $data['scheduleID']));
        return $result->result();
    }

    public function get_subject($id)
    {
        $this->db->from('subject');
        $this->db->join('schedule', 'schedule.subjectID = subject.subjectID', 'inner');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->where('subject.subjectID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_section_subject($id)
    {
        $this->db->from('subject');
        $this->db->join('schedule', 'schedule.subjectID = subject.subjectID', 'inner');
        $this->db->join('section', 'section.sectionID = schedule.sectionID', 'inner');
        $this->db->where('subject.subjectID', $id);
        $this->db->where('section.sectionID', $id);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_subject_sched($subjectID, $sectionID, $weekday)
    {
        $this->db->from('schedule');
        $this->db->where('schedule.subjectID', $subjectID);
        $this->db->where('schedule.sectionID', $sectionID);
        $this->db->where('schedule.weekday', $weekday);
        
        $query = $this->db->get();
        return $query->result();
    }


}
