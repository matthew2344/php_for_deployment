<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('session','form_validation', 'pagination'));
	}

    public function index()
	{
		$this->check_session();
        $this->load->model('Subject');
		$data['my_subject'] = $this->Subject->get_subject($this->session->userdata['uid']);
		$data['title'] = "Student Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/home');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function profile()
	{
		$this->check_session();
		$data['title'] = "Student Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/profile');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_profile()
	{
		$this->check_session();
		$data['title'] = "Student Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/edit_profile');
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
            redirect('Student/profile');
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
            redirect('Student/profile');
        }
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
		$query = $this->Gatelog->get_by_id($id, $date);
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
		$config["base_url"] =  base_url() . "Student/my_attendance/$id";
		$config["total_rows"] = $this->Gatelog->my_log_count($id);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->my_log_get($config["per_page"], $page, $id);
        $data['title'] = 'My Attendance';
        $this->load->view('dashboard/header',$data);
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/my_attendance');
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
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/my_attendance');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

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

	public function this_class($id, $sectionID)
	{
		$this->check_session();
		$this->load->model('Subject');
        $data['title'] = "View Student";
		$awit = $this->Subject->get_this_subject_new($id,$sectionID);
		foreach($awit as $i)
		{
			$title_view = "($i->section_name) - $i->subject_name ";
			$description = $i->subject_description;
			$prof = "$i->fname $i->mname $i->lname";
		}
		$data['schedule_subject'] = $this->Subject->get_this_subject_new($id,$sectionID);
		$data['title_viewed'] = $title_view;
		$data['subject_description'] = $description;
		$data['teacher'] = $prof;
		$data['view_subject'] = true;
		$this->load->view('dashboard/header',$data);
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/manage_class');
		$this->load->view('student/pages/my_class');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function this_class_attendance($id, $sectionID)
	{
		$this->check_session();
		$this->load->model('Subject');
		$this->load->model('Attendance');
        $data['title'] = "View Student";
		$awit = $this->Subject->get_this_subject_new($id,$sectionID);
		foreach($awit as $i)
		{
			$title_view = "($i->section_name) - $i->subject_name ";
			
		}
		$data['my_attendance'] = $this->Attendance->student_get_attendance($id,$this->session->userdata['uid']);
		$data['title_viewed'] = $title_view;
		
		$data['subject_attendance'] = true;
		$this->load->view('dashboard/header',$data);
		$this->load->view('student/side_nav');
		$this->load->view('student/nav');
		$this->load->view('student/pages/manage_class');
		$this->load->view('student/pages/class_attendance');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function check_session()
	{
		if($this->session->userdata['student_logged_in'] == FALSE)
		{
            redirect('Login');
		}
	}
}
