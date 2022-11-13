<?php

class Schedule extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data)
    {
        $this->db->insert('schedule', $data);
    }

    public function update($data,$id)
    {
        $this->db->update('schedule', $data, array('schedule.scheduleID' => $id));
    }

    public function count($id,$search = "")
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->where('section.sectionID', $id);
        $this->db->order_by('schedule.schedule_start','asc');
        if($search != '')
        {
            // $this->db->like('fname', $search);
            // $this->db->or_like('mname', $search);
            // $this->db->or_like('lname', $search);
        }

        return $this->db->count_all_results();
    }

    public function select($limit, $start, $id, $search="")
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->where('section.sectionID', $id);
        $this->db->order_by('schedule.schedule_start','asc');
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

    public function glsection($gradeID, $sectionID)
    {
        $this->db->from('subject');
        $this->db->where('subject.gradelevelID', $gradeID);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_schedule($sectionID)
    {
        $this->db->from('schedule');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->where('schedule.sectionID', $sectionID);
        $this->db->order_by('schedule.schedule_start','asc');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_sched($id)
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->where("schedule.scheduleID NOT IN (SELECT teach.scheduleID FROM teach WHERE teach.userID = $id)");
        $this->db->order_by('section.sectionID','asc');
        $this->db->group_by('subject.subjectID');
        $this->db->group_by('section.sectionID');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_all_subject($id)
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->where("schedule.scheduleID NOT IN (SELECT teach.scheduleID FROM teach WHERE teach.userID = $id)");
        $this->db->order_by('section.sectionID','asc');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_monday($id)
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->order_by('schedule.schedule_start','asc');
        $this->db->where('schedule.weekday', 'Monday');
        $this->db->where('schedule.sectionID', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_tuesday($id)
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->order_by('schedule.schedule_start','asc');
        $this->db->where('schedule.weekday', 'Tuesday');
        $this->db->where('schedule.sectionID', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_wednesday($id)
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->order_by('schedule.schedule_start','asc');
        $this->db->where('schedule.weekday', 'Wednesday');
        $this->db->where('schedule.sectionID', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_thursday($id)
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->order_by('schedule.schedule_start','asc');
        $this->db->where('schedule.weekday', 'Thursday');
        $this->db->where('schedule.sectionID', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_friday($id)
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->order_by('schedule.schedule_start','asc');
        $this->db->where('schedule.weekday', 'Friday');
        $this->db->where('schedule.sectionID', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_saturday($id)
    {
        $this->db->from('schedule');
        $this->db->join('section','section.sectionID = schedule.sectionID', 'inner');
        $this->db->join('subject','subject.subjectID = schedule.subjectID', 'inner');
        $this->db->order_by('schedule.schedule_start','asc');
        $this->db->where('schedule.weekday', 'Saturday');
        $this->db->where('schedule.sectionID', $id);
        $query = $this->db->get();
        return $query->result();
    }
}
