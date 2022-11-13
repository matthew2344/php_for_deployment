<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// 
// ---[TEACHER CONTROLLER]---
// --FUNCTIONS--[TOTAL OF 07]
// TEACHER DASHBOARD AND PROFILE -> LINE 18-155
// SESSION CHECKER [TEACHER] -> LINE 157-166
// [OTHER FUNCTIONS ARE WORK IN PROGRESS]
class Teacher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form'));
        $this->load->library(array('session','upload','form_validation','pagination'));
    }

    // ---[TEACHER DASHBOARD AND PROFILE]---
	// 			---[START]---
    public function index()
    {
        $this->check_session();
        $data['title'] = 'Teacher Dashboard';
		$this->load->model('Teach');
		$data['teach'] = $this->Teach->select_teach($this->session->userdata['uid']);


        $this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/home');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }

	public function this_class($id,$sectionID)
	{
		$this->check_session();
		$this->load->model('Teach');
        $data['title'] = "View Student";
		$awit = $this->Teach->get_subject($id);
		$data['subject'] = $this->Teach->get_subject($id);
		foreach($awit as $i)
		{
			$title_view = "($i->section_name) - $i->subject_name ";
		}
		$data['students'] = $this->Teach->select_student($sectionID);
		$data['title_viewed'] = $title_view;
		$data['view_student'] = true;
		$this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/manage_class');
		$this->load->view('teacher/pages/view_class');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function mark_attendance($id,$sectionID)
	{
		$this->check_session();
		$this->load->model('Teach');
		$awit = $this->Teach->get_subject($id);
		$data['subject'] = $this->Teach->get_subject($id);
		foreach($awit as $i)
		{
			$title_view = "($i->section_name) - $i->subject_name ";
		}
		$data['title_viewed'] = $title_view;
        $data['title'] = "Mark Attendance";
		$data['mark_student'] = true;
		$this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/manage_class');
		$this->load->view('teacher/pages/mark_attendance');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}



	public function mark_date($id,$sectionID)
	{
		$this->check_session();
		$this->load->model('Teach');
		$this->load->model('Attendance');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$validate = $this->Attendance->date_exist($id,$sectionID,$this->input->post('date'));

		if($validate)
		{
			$this->session->set_flashdata('Danger', 'Attendance Already Exist in Database');
			$this->mark_attendance($id,$sectionID);
		}
		if(!$this->form_validation->run())
		{
			$this->mark_attendance($id,$sectionID);
		}
		else
		{
			
			$this->check_session();
			$input_date = $this->input->post('date');
			$date = date('Y-m-d', strtotime($input_date));
			$weekday = date('l', strtotime($date));
			$query_success = $this->Teach->get_subject_sched($id, $sectionID, $weekday);
			if($query_success)
			{
				$date_value = $this->input->post('date');
				$data['date_value'] = $date_value;
				$data['attendance_status'] = $this->Teach->get_attendance_status();
				$data['students'] = $this->Teach->select_student($id);
				$data['schedule'] = $query_success;
			}
			$awit = $this->Teach->get_subject($id);
			foreach($awit as $i)
			{
				$title_view = "($i->section_name) - $i->subject_name ";
			}
			$data['mark_mode'] = true;
			$data['title_viewed'] = $title_view;
			$data['title'] = "Mark Attendance";
			$data['mark_student'] = true;
			$this->load->view('dashboard/header',$data);
			$this->load->view('teacher/side_nav');
			$this->load->view('teacher/nav');
			$this->load->view('teacher/pages/manage_class');
			$this->load->view('teacher/pages/mark_attendance');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');

		}
	}

	public function create_attendance($id,$sectionID)
	{
		$this->check_session();
		$this->load->model('Attendance');
		$count = count($this->input->post('student'));
		$attendance_data = array(
			'date' => $this->input->post('date'),
			'scheduleID' => $this->input->post('scheduleID'),
			'subjectID' => $id,
			'sectionID' => $sectionID,
		);
		$attendanceID = $this->Attendance->insert($attendance_data);
		for($i = 0; $i < $count; $i++)
		{
			$attendance_data = array(
				'userID' => $this->input->post('student')[$i],
				'attendance_status' => $this->input->post('status')[$i],				
				'attendanceID' => $attendanceID,				
			);

			$this->Attendance->stud_attendance($attendance_data);
		}
		$this->session->set_flashdata('Success', 'Attendance Applied succesfully');
		$this->mark_attendance($id,$sectionID);
	}


	public function view_attendance($id,$sectionID)
	{
		$this->check_session();
		$this->load->model('Teach');
		$this->load->model('Attendance');
		$data['attendance'] = $this->Attendance->get_attendance($id,$sectionID);
		$data['schedule'] = $this->Teach->get_sched($id);
		$awit = $this->Teach->get_subject($id);
		foreach($awit as $i)
		{
			$title_view = "($i->section_name) - $i->subject_name ";
		}
		$data['title_viewed'] = $title_view;
        $data['title'] = "View Attendance";
		$data['view_attendance'] = true;
		$this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/manage_class');
		$this->load->view('teacher/pages/view_attendance');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function edit_attendance($subjectID,$sectionID,$attendanceID)
	{
		$this->check_session();
		$this->load->model('Teach');
		$this->load->model('Attendance');
		$data['students'] = $this->Teach->select_student($attendanceID);
		$data['attendance'] = $this->Attendance->get_attendance_by_id($attendanceID);
		$data['attendance_status'] = $this->Attendance->get_attendance_status();
        $data['title'] = "View Student";
		$awit = $this->Teach->get_sched($attendanceID);
		foreach($awit as $i)
		{
			$title_view = "($i->section_name) - $i->subject_name ";
		}

		$data['student'] = $this->Attendance->get_attendance_new($attendanceID);
		$data['title_viewed'] = $title_view;
		$data['view_attendance'] = true;
		$this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/manage_class');
		$this->load->view('teacher/pages/edit_attendance');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_attendance($subjectID,$sectionID,$attendanceID)
	{
		$this->check_session();
		$this->load->model('Attendance');
		$student_id = $this->input->post('studID');
		$edit_data = $this->input->post('attendance');


		foreach($edit_data as $i => $idata)
		{
			$update_data = array(
				'attendance_status' => $idata,
			);
			$this->Attendance->update($update_data, $student_id[$i]);
		}

		$this->session->set_flashdata('Success', 'Update attendance success');
		$this->edit_attendance($subjectID,$sectionID,$attendanceID);
	}



    public function profile()
    {
        $this->check_session();
        $data['title'] = 'Teacher Dashboard';
        $this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/profile');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }

    public function edit_profile()
    {
        $this->check_session();
        $data['title'] = 'Teacher Dashboard';
        $this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/edit_profile');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }
    
    public function update_profile($uid)
    {
        $this->check_session();
        $this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
        if(!$this->form_validation->run())
        {
            $this->edit_profile();
        }
        else
        {
            $data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
            );

            $this->session->set_userdata(
                array(
                    'fname' => $this->input->post('fname'),
                    'mname' => $this->input->post('mname'),
                    'lname' => $this->input->post('lname'),
                )
            );

            $this->User->update($data,$uid);
            redirect('Teacher/profile');
        }
    }

	public function update_password($uid)
    {
        $this->check_session();
        $this->load->model('User');
        $this->form_validation->set_rules('oldpassword', 'Old Password', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
        if(!$this->form_validation->run())
        {
            $this->edit_profile();
        }
        else
        {
			$data['id'] = $uid;
            $results = $this->User->get_where($data);
            foreach($results as $result)
            {
                $oldpass = $result->password;
            }

            if($oldpass != sha1($this->input->post('oldpassword')))
            {
                $this->edit_profile();
                $this->session->set_flashdata('incorrect', 'Old password is incorrect');
            }
            else
            {
                $data = array('password' => sha1($this->input->post('password')));
    
                
                $this->User->update($data,$uid);
                redirect('Logout');
            }
        }
    }

	public function update_avatar($uid)
    {
        $this->check_session();
        $config = array(
            'upload_path' =>  $this->config->item('Upload_path'),
            'allowed_types' => $this->config->item('Img_types'),
            'max_size' => $this->config->item('Max_img_size'),
        );

        $this->load->library('upload');
        $this->upload->initialize($config);

        if(!$this->upload->do_upload('avatar'))
        {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            $this->profile();
        }
        else
        {
            $upload_data = $this->upload->data();

            $data['avatar'] = $upload_data['file_name'];

            $this->load->model('User');
            $this->User->update($data,$uid);

            $this->session->set_userdata(array ('avatar' => $upload_data['file_name']));
            redirect('Teacher/profile');
        }
    }

    public function my_class()
    {
        $this->check_session();
        
        $data['title'] = 'My Class';
        $this->load->model('Attendance');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Teacher/my_class";
		$config["total_rows"] = $this->Attendance->count();
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
        $data['face_data'] = $this->file->get_data($config["per_page"], $page);

        $this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/my_class');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }
    // ---[TEACHER DASHBOARD AND PROFILE]---
	// 			---[END]---

    public function bootstrap_pagination()
	{
		// BOOTSTRAP 
		return array(
			'full_tag_open' => '<ul class="pagination">',        
			'full_tag_close' => '</ul>',        
			'first_link' => 'First',    
			'last_link' => 'Last',        
			'first_tag_open' => '<li class="page-item"><span class="page-link">',        
			'first_tag_close' => '</span></li>',        
			'prev_link' => '&laquo',        
			'prev_tag_open' => '<li class="page-item"><span class="page-link">',        
			'prev_tag_close' => '</span></li>',        
			'next_link' => '&raquo',        
			'next_tag_open' => '<li class="page-item"><span class="page-link">',        
			'next_tag_close' => '</span></li>',        
			'last_tag_open' => '<li class="page-item"><span class="page-link">',        
			'last_tag_close' => '</span></li>',        
			'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',        
			'cur_tag_close' => '</a></li>',       
			'num_tag_open' => '<li class="page-item"><span class="page-link">',        
			'num_tag_close' => '</span></li>',
		);
		// BOOTSTRAP
	}

    public function filterdata(&$str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}

	public function dl_excel($id, $date = "")
	{
		$this->check_session();
		$filename = "gatelog-".$date."xls";
		$fields = array('USERID', 'NAME' , 'DATE', 'ENTRY-TIME', 'EXIT-TIME');
		$excelData = implode("\t", array_values($fields))."\n";
		$this->load->model('Gatelog');
		$query = $this->Gatelog->get_by_id($id ,$date);
		if($query)
		{
			foreach($query as $i)
			{
				$linedata = array(
					$i->userID,
					"$i->fname $i->mname $i->lname",
					$i->date,
					($i->entry_time == "00:00:00") ? "N/A" : $i->entry_time ,
					($i->exit_time == "00:00:00") ? "N/A" : $i->exit_time ,
				);
				array_walk($linedata, array($this, 'filterdata'));
				$excelData .= implode("\t", array_values($linedata)). "\n";
			}
		}else{
			$excelData .= 'No records found...'."\n";
		}
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		echo $excelData;
		exit;
	}


    public function my_attendance()
    {
        $this->check_session();
        $id = $this->session->userdata('uid');
        $date_value = date('Y-m-d');
		$this->load->model("Gatelog");
		$data['date_value'] = $date_value;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Teacher/my_attendance/$id";
		$config["total_rows"] = $this->Gatelog->my_log_count($id);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->my_log_get($config["per_page"], $page, $id);
        $data['title'] = 'My Attendance';
        $this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/my_attendance');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }

    public function from_date()
	{
		$this->check_session();
        $id = $this->session->userdata('uid');
		$this->load->model("Gatelog");
		$date = ($this->input->post("date_select"))? $this->input->post("date_select"): date('Y-m-d');
		$date = ($this->uri->segment(3)) ? $this->uri->segment(3) : $date;
		$data['date_value'] = $date;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Teacher/from_date/$id";
		$config["total_rows"] = $this->Gatelog->my_log_count($id, $date);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->my_log_get($config["per_page"], $page, $id, $date);
		$data['title'] = "Manage Attendance";
		$this->load->view('dashboard/header',$data);
		$this->load->view('teacher/side_nav');
		$this->load->view('teacher/nav');
		$this->load->view('teacher/pages/my_attendance');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}



    public function check_session()
    {
        if($this->session->userdata['teacher_logged_in'] == FALSE)
		{
			redirect('Login');
		}
    }
}