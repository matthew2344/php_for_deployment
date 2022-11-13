<?php

class Attendance extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function attendance_count($search = "")
    {
        $this->db->from('attendance');
        $this->db->join('user', 'user.id = attendance.uid', 'inner');

        if($search != '')
        {
            $this->db->like('date', $search);
        }

        return $this->db->count_all_results();
    }

    public function select($limit, $start, $search = "")
    {
        $this->db->from('attendance');
        $this->db->join('user', 'user.id = attendance.uid', 'inner');

        if($search != '')
        {
            $this->db->like('date', $search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function attendance_stud_count($search)
    {
        $this->db->from('user');
        $this->db->join('attendance','attendance.uid = user.id', 'inner');
        $this->db->where('user.type','Student');

        if($search != '')
        {
            $this->db->like('fname', $search);
            $this->db->like('mname', $search);
            $this->db->like('lname', $search);
        }

        return $this->db->count_all_results();
    }

    public function get_attendance_stud($limit, $start, $search)
    {
        $this->db->from('user');
        $this->db->join('attendance','attendance.uid = user.id', 'inner');
        $this->db->where('user.type','Student');

        if($search != '')
        {
            $this->db->like('fname', $search);
            $this->db->like('mname', $search);
            $this->db->like('lname', $search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function stud_attendance($data)
    {
        $this->db->insert('student_attendance',$data);
    }

    
    public function insert($data)
    {
        $this->db->insert('attendance', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function get_where($data)
    {
        $query = $this->db->get_where('attendance', array('uid' => $data['uid'],'date' => $data['date']));
        return $query->result();
    }


    public function view_student_attendance($id)
    {
        $this->db->from('user');
        $this->db->join('student', 'student.userID = user.userID', 'inner');
        $query = $this->db->get();
        return $query->result();
    }
    

    public function get_attendance_status()
    {
        $this->db->from('attendance_status');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_attendance($sectionID, $subjectID)
    {
        $this->db->from('attendance');
        $this->db->where('sectionID', $sectionID);
        $this->db->where('subjectID', $subjectID);
        $this->db->order_by('date','asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_attendance_by_id($attendanceID)
    {
        $this->db->from('attendance');
        $this->db->where('attendanceID', $attendanceID);
        $this->db->order_by('date','asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_attendance_new($id)
    {
        $this->db->from('student_attendance');
        $this->db->join('attendance_status', 'attendance_status.attendance_status = student_attendance.attendance_status', 'inner');
        $this->db->join('user', 'user.userID = student_attendance.userID', 'inner');
        $this->db->where('student_attendance.attendanceID', $id);

        $query = $this->db->get();
        return $query->result();
    }

    public function date_exist($subjectID,$sectionID,$date)
    {
        $this->db->from('attendance');
        $this->db->where('sectionID', $subjectID);
        $this->db->where('subjectID', $sectionID);
        $this->db->where('date', $date);

        $query = $this->db->get();
        return $query->result();
    }

    public function update($data, $id)
    {
        $this->db->update('student_attendance', $data, array('student_attendanceID' => $id));
    }

    public function student_get_attendance($subjectID, $userID)
    {
        $this->db->from('attendance');
        $this->db->join('student_attendance', 'student_attendance.attendanceID = attendance.attendanceID', 'inner');
        $this->db->join('user', 'user.userID = student_attendance.userID', 'inner');
        $this->db->join('attendance_status', 'attendance_status.attendance_status = student_attendance.attendance_status' ,'inner');
        $this->db->where('attendance.subjectID', $subjectID);
        $this->db->where('user.userID', $userID);
        $this->db->order_by('date');

        
        $query = $this->db->get();
        return $query->result();
    }
}