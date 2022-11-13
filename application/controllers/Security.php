<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Security extends CI_Controller
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
		$data['title'] = "Security Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/home');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function profile()
	{
		$this->check_session();
		$data['title'] = "security Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/profile');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

    public function facial_recognition()
    {
        $this->check_session();
        $this->load->model('User');
        $data['Users'] = $this->User->get_all();
        $data['title'] = "Security Face Recognition";
        $this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/facial_recognition');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }

	public function edit_profile()
	{
		$this->check_session();
		$data['title'] = "security Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/edit_profile');
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
            redirect('security/profile');
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
            redirect('security/profile');
        }
    }

    public function face_data()
    {
        $this->check_session();
		$data['title'] = "Security Dashboard";
        $this->load->model('User');
        
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Security/face_data";
		$config["total_rows"] = $this->User->count_users();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['Users'] = $this->User->get_users($config["per_page"], $page);

		$this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/train_data');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }

    public function face_submission($id)
    {

        $this->check_session();
		$data['title'] = "Security Dashboard";
        $this->load->model('User');
        $data['user'] = $this->User->get_this($id);

        $this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/face_submission');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }


    public function camera_capture($userID)
    {
        $this->check_session();
        $upload_path = "./python_app/train_img/$userID";
        if(!is_dir($upload_path))
		{
			mkdir($upload_path,777,TRUE);
		}

        $filename = date('Ymdhis');

        $result = move_uploaded_file($_FILES['webcam']['tmp_name'], $upload_path);



		$data = array(
            'userID' => $userID,
            'image' => $filename,
            'date_uploaded' => date('Y-m-d H:i:s'),
        );
        $this->load->model('File_upload','file');
        $this->file->upload_data($data);
    }


    public function train_data()
    {
        $this->check_session();

        $this->load->model('Face');
        $count = $this->Face->count_face();
        if($count == 0)
        {
            $this->session->set_flashdata('ERROR_TRAINING', 'THERE ARE NO EXISTING IMAGES');
            $this->face_data();
        }
		else
		{
			$this->session->set_flashdata('TRAINING', 'THERE ARE NO EXISTING IMAGES');
			$this->face_data();
		}
    }

    public function upload_dataset($uid)
	{
		$this->check_session();
		$this->load->model('User');

		$data = [];
		$count_uploaded_files = 0;
		$count_error_files = 0;
		$count = count($_FILES['files']['name']);
		for($i = 0; $i < $count; $i++)
		{
			if(!empty($_FILES['files']['name'][$i]))
			{
				$_FILES['file']['name'] = $_FILES['files']['name'][$i];
				$_FILES['file']['type'] = $_FILES['files']['type'][$i];
				$_FILES['file']['size'] = $_FILES['files']['size'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['files']['error'][$i];
	
				$upload_status = $this->uploaddata('file',$uid);
				if($upload_status!=false)
				{
					$count_uploaded_files++;
					$this->load->model('File_upload','file');
					$data = array(
						'userID' => $uid,
						'image' => $upload_status,
						'date_uploaded' => date('Y-m-d H:i:s'),
					);
					$this->file->upload_data($data);
				}
				else
				{
					$count_error_files++;
				}
			}
			else
			{
				$this->session->set_flashdata('upload_error', 'NO FILES');
				$this->face_submission($uid);
			}

		}
		$this->session->set_flashdata('upload_status', 'Files uploaded. SUCCESS -'.$count_uploaded_files.'; ERROR -'.$count_error_files);
		$this->face_submission($uid);
	}

    public function uploaddata($name,$uid)
	{
		$this->check_session();
		$upload_path = "./python_app/train_img/$uid";
		if(!is_dir($upload_path))
		{
			mkdir($upload_path,777,TRUE);
		}

		$config = array(
            'upload_path' =>  $upload_path,
            'allowed_types' => $this->config->item('Img_types'),
            'max_size' => $this->config->item('Max_img_size'),
			'encrypt_name' => TRUE,
        );

		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		if($this->upload->do_upload($name))
		{
			$filedata = $this->upload->data();
			return $filedata['file_name'];
		}
		else
		{
			$this->session->set_flashdata('upload_error', $this->upload->display_errors());
		}

	}

	public function insert_gate($id)
	{
		$this->check_session();
		$this->load->model('Gatelog');
		$today = date('Y-m-d');
		$gatedata = $this->Gatelog->check_log($id, $today);
		if($gatedata == 0)
		{
			$data = array(
				'userID' => $id,
				'date' => $today,
				'entry_time' => date("G:i:s")
			);
			$this->Gatelog->insert($data);
		}
		
	}

	public function gatelogs()
	{
		$this->check_session();
		$date_value = date('Y-m-d');
		$this->load->model("Gatelog");
		$data['date_value'] = $date_value;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "security/gatelogs/";
		$config["total_rows"] = $this->Gatelog->all_count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->all_get($config["per_page"], $page);
		$data['title'] = "Manage Logs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/gatelogs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function all_logs()
	{
		$this->check_session();
		$this->load->model("Gatelog");
		$date = ($this->input->post("date_select"))? $this->input->post("date_select"): date('Y-m-d');
		$date = ($this->uri->segment(3)) ? $this->uri->segment(3) : $date;
		$data['date_value'] = $date;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "security/all_logs/$date";
		$config["total_rows"] = $this->Gatelog->all_count($date);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->all_get($config["per_page"], $page, $date);
		$data['title'] = "Manage Logs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/gatelogs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function filterdata(&$str)
	{
		$str = preg_replace("/\t/", "\\t", $str);
		$str = preg_replace("/\r?\n/", "\\n", $str);
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	}

	public function dl_excel($date , $role = "")
	{
		$this->check_session();
		$a = ($date == "all") ? "ALL" : $date;
		$filename = "gatelog-".$a."xls";
		$fields = array('USERID', 'NAME' , 'DATE', 'ENTRY-TIME', 'EXIT-TIME');
		$excelData = implode("\t", array_values($fields))."\n";
		$this->load->model('Gatelog');
		$query = $this->Gatelog->dl($date, $role);
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

	public function student_logs()
	{
		$this->check_session();
		$date_value = date('Y-m-d');
		$this->load->model("Gatelog");
		$data['date_value'] = $date_value;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "security/gate_logs/";
		$config["total_rows"] = $this->Gatelog->student_count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->student_get($config["per_page"], $page);
		$data['title'] = "Manage Student Logs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/student_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function employee_logs()
	{
		$this->check_session();
		$date_value = date('Y-m-d');
		$this->load->model("Gatelog");
		$data['date_value'] = $date_value;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Security/gate_logs/";
		$config["total_rows"] = $this->Gatelog->employee_count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->employee_get($config["per_page"], $page);
		$data['title'] = "Manage Attendance";
		$this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/employee_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function student_date()
	{
		$this->check_session();
		$this->load->model("Gatelog");
		$date = ($this->input->post("date_select"))? $this->input->post("date_select"): date('Y-m-d');
		$date = ($this->uri->segment(3)) ? $this->uri->segment(3) : $date;
		$data['date_value'] = $date;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Security/student_date/$date";
		$config["total_rows"] = $this->Gatelog->student_count($date);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->student_get($config["per_page"], $page, $date);
		$data['title'] = "Manage Attendance";
		$this->load->view('dashboard/header',$data);
		$this->load->view('security/side_nav');
		$this->load->view('security/nav');
		$this->load->view('security/pages/student_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}
	
	public function check_session()
	{
        // ---[FUNCTION DESCRIPTION & USE CASE SCENARIO]---
		// SESSION CHECKER FOR security LOGINS; LIMITS ACCESS TO OTHER USERTYPES
		// REDIRECTS TO LOGIN PAGE 
		if($this->session->userdata['security_logged_in'] == FALSE)
		{
            redirect('Login');
		}
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



	public function insert_gate_log()
	{
		$this->check_session();
		$this->load->model('Gatelog');
		$data = array(
			'userID' => $this->input->post('userID'),
			'date' => date('Y-m-d'),
			'entry_time' => date('H:i:s'),
		);
		$this->Gatelog->insert($data);
	}
}
