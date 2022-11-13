<?php
class Section extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function select()
    {
        $this->db->from('Section');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID', 'inner');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert('section',$data);
    }

    public function count($search = '')
    {
        $this->db->from('Section');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID', 'inner');
        $this->db->join('user', 'user.userID = section.section_adviser', 'inner');

        if($search != '')
        {
            $this->db->like('section.section_name', $search);
            $this->db->or_like('section.sectionID', $search);
            $this->db->or_like('section.max_capacity', $search);
            $this->db->or_like('user.userID', $search);
            $this->db->or_like('user.fname', $search);
            $this->db->or_like('user.mname', $search);
            $this->db->or_like('user.lname', $search);
            $this->db->or_like('gradelevel.grade_title', $search);
        }

        return $this->db->count_all_results();
    }

    public function paginate($limit, $start, $search = '')
    {
        $this->db->from('Section');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID', 'inner');
        $this->db->join('user', 'user.userID = section.section_adviser', 'inner');

        if($search != '')
        {
            $this->db->like('section.section_name', $search);
            $this->db->or_like('section.sectionID', $search);
            $this->db->or_like('section.max_capacity', $search);
            $this->db->or_like('user.userID', $search);
            $this->db->or_like('user.fname', $search);
            $this->db->or_like('user.mname', $search);
            $this->db->or_like('user.lname', $search);
            $this->db->or_like('gradelevel.grade_title', $search);
        }

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function get($id)
    {
        $select = array(
            '*',
            'count(student.userID) as total_student',
            'section.sectionID as sectionID',
            'gradelevel.gradelevelID as gradelevelID',
        );
        $this->db->select($select);
        $this->db->from('section');
        $this->db->join('user', 'user.userID = section.section_adviser', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = section.gradelevelID', 'inner');
        $this->db->join('student', 'student.sectionID = section.sectionID', 'inner');
        $this->db->where('section.sectionID',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function update($data,$id)
    {
        $this->db->update('section',$data, array('sectionID' => $id));
    }

    public function delete($id)
    {
        $this->db->delete('section', array('sectionID' => $id));
    }

    public function get_student($gradelevel)
    {
        $this->db->from('Student');
        $this->db->join('user', 'user.userID = student.userID', 'inner');
        $this->db->where('gradelevelID', $gradelevel);
        $this->db->where('sectionID', 0);
        $query = $this->db->get();
        return $query->result();
    }



    public function put_student($data, $userID)
    {
        $this->db->update('student', $data,  array('userID' => $userID));
    }


    public function count_student($id, $search = '')
    {
        $this->db->from('user');
        $this->db->join('student', 'student.userID = user.userID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = student.gradelevelID', 'inner');
        $this->db->where('student.sectionID', $id);

        if($search != '')
        {
            $this->db->like('user.userID', $search);
            $this->db->or_like('user.fname', $search);
            $this->db->or_like('user.mname', $search);
            $this->db->or_like('user.lname', $search);
            $this->db->or_like('gradelevel.grade_title', $search);
        }

        return $this->db->count_all_results();
    }

    public function get_section_student($limit, $start, $id, $search = '')
    {
        $this->db->from('user');
        $this->db->join('student', 'student.userID = user.userID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = student.gradelevelID', 'inner');
        $this->db->where('student.sectionID', $id);

        if($search != '')
        {
            $this->db->like('user.userID', $search);
            $this->db->or_like('user.fname', $search);
            $this->db->or_like('user.mname', $search);
            $this->db->or_like('user.lname', $search);
            $this->db->or_like('gradelevel.grade_title', $search);
        }

        

        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_section_student_all($id)
    {
        $this->db->from('user');
        $this->db->join('student', 'student.userID = user.userID', 'inner');
        $this->db->join('gradelevel', 'gradelevel.gradelevelID = student.gradelevelID', 'inner');
        $this->db->where('student.sectionID', $id);
        $this->db->order_by('user.lname', 'asc');

        $query = $this->db->get();
        return $query->result();
    }
}