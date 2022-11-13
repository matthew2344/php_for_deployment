<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form','string'));
		$this->load->library(array ('form_validation', 'upload', 'session', 'pagination'));
	}

	// ---[ADMIN DASHBOARD AND PROFILE]---
	// 			---[START]---
    public function index()
    {
		$this->check_session();
		$config = array();
		$config = $this->bootstrap_pagination();
		$this->load->model(array('User','Face'));
		$config["base_url"] =  base_url() . "Admin/";
		$config["total_rows"] = $this->User->count();
		$config["per_page"] = 7;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$data['face_count'] = $this->Face->count_face();
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['admin'] = $this->User->select($config["per_page"], $page);
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/home');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
    }

	public function train_data()
    {
        $this->check_session();

        $this->load->model('Face');
        $count = $this->Face->count_face();
        if($count == 0)
        {
            $this->session->set_flashdata('ERROR_TRAINING', 'THERE ARE NO EXISTING IMAGES');
            $this->index();
        }
		else
		{
			$this->session->set_flashdata('TRAINING', 'Preparing....');
			$this->index();
		}
    }

	public function profile()
	{
		$this->check_session();
		$data['title'] = "Admin Profile";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/profile');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_profile()
	{
		$this->check_session();
		$data['title'] = "Admin Edit Profile";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/edit_profile');
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
            redirect('Admin/profile');
        }
    }

	public function update_email($uid)
	{
		$this->load->model('User');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
		if(!$this->form_validation->run())
        {
            $this->edit_profile();
        }
		else
		{
			$data = array('email' => $this->input->post('email'));
			$this->session->set_userdata(array('email' => $this->input->post('email')));
			$this->User->update($data,$uid);
			redirect('Admin/profile');
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
            $results = $this->User->get_where($uid);
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
            redirect('Admin/profile');
        }
    }


	public function update_status_student($id)
	{
		$this->check_session();
		$this->load->model('User');
		$update_data = array('status' => $this->input->post('status'));
		$this->User->update($update_data, $id);

		$this->session->set_flashdata('Success', 'Status Update Success');
		$this->view_student($id);
	}

	public function update_status_teacher($id)
	{
		$this->check_session();
		$this->load->model('User');
		$update_data = array('status' => $this->input->post('status'));
		$this->User->update($update_data, $id);

		$this->session->set_flashdata('Success', 'Status Update Success');
		$this->view_teacher($id);
	}

	public function update_status_staff($id)
	{
		$this->check_session();
		$this->load->model('User');
		$update_data = array('status' => $this->input->post('status'));
		$this->User->update($update_data, $id);

		$this->session->set_flashdata('Success', 'Status Update Success');
		$this->view_staff($id);
	}

	public function update_status_admin($id)
	{
		$this->check_session();
		$this->load->model('User');
		$update_data = array('status' => $this->input->post('status'));
		$this->User->update($update_data, $id);

		$this->session->set_flashdata('Success', 'Status Update Success');
		$this->view_admin($id);
	}

	public function delete_user($id)
	{
		$this->check_session();
		$this->load->model('User');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if(!$this->form_validation->run())
		{
			$this->edit_profile();
		}
		else
		{
			$data = array(
				'id' => $id,
				'password' => sha1($this->input->post('password')),
			);
			if($result = $this->User->validate_user($data))
			{
				foreach($result as $i)
				{
					$file = $i->avatar;
				}
				if($file != 'profile_pic.jpg')
				{
					unlink("./uploads/".$file);
				}
				$this->User->delete($id);
				redirect('Logout');
			}else{
				$this->session->set_flashdata('error', 'Invalid Credentials');
				$this->edit_profile();
			}
		}

	}

	public function admin()
	{
		$this->check_session();
		$data['title_viewed'] = "Manage Admin";
		$config = array();
		$this->load->model('User');

		$data['in_admin'] = true;
		$data['in_admin_list'] = true;
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/student";
		$config["total_rows"] = $this->User->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['admins'] = $this->User->select($config["per_page"], $page);

		$data['title'] = "Manage admin";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_admin');
		$this->load->view('admin/pages/admin_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function add_admin()
	{
		$this->check_session();
		$data['in_admin'] = true;
		$data['in_admin_add'] = true;
		$data['title_viewed'] = "Create Admin";
		$data['form_title'] = 'Admin';
		$data['form_url'] = 'create_admin';
		$data['title'] = "Add Admin";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_admin');
		$this->load->view('admin/pages/create_teacher');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	
	public function create_admin()
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]');
		$this->form_validation->set_rules('phone', 'Phone number', 'required|regex_match[/^(09|\+639)\d{9}$/]');
		$this->form_validation->set_rules('bday', 'Birth date', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|max_length[4]|numeric');

        $data = array(
            'fname' => $this->input->post('fname'),
            'mname' => $this->input->post('mname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'bday' => $this->input->post('bday'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),
        );

		if(!$this->form_validation->run())
		{
			$this->check_session();
			$data['in_admin'] = true;
			$data['in_admin_add'] = true;
			$data['title_viewed'] = "Create Admin";
			$data['form_title'] = 'Admin';
			$data['form_url'] = 'create_admin';
			$data['title'] = "Add Admin";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/manage_admin');
			$this->load->view('admin/pages/create_teacher');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
			$access_code = random_string('alnum', 8);
            $user_data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'bday' => $this->input->post('bday'),
                'access_code' => $access_code,
                'status' => 1,
                'roleID' => 1,
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
                'avatar' => 'profile_pic.jpg',
                'datecreated' => date('Y-m-d'),
                'password' => sha1($access_code),
            );

            $this->User->insert($user_data);

			$this->session->set_flashdata('Success', 'Creation Success');
			redirect('Admin/add_admin');
			
		}

		
	}

	public function view_admin($id)
	{
		$this->check_session();
		$this->load->model('User');

		$data['in_admin'] = true;
		$data['view_user'] = true;

		$data['back_url'] = 'Admin/admin';
		$data['view_link'] = 'Admin/view_admin/';
		$data['edit_link'] = 'Admin/edit_admin/';
		$data['title_viewed'] = "View Admin";


		$data['view_text'] = "Admin View";
		$data['edit_text'] = "Edit Admin";

		$data['admin'] = $this->User->get_admin($id);
		$data['title'] = "Admin Manage Staff";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_user');
		$this->load->view('admin/pages/view_user_detail');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_admin($id)
	{
		$this->check_session();
		$this->load->model('User');

		$data['title_viewed'] = "Edit Admin";
		$data['title_viewed'] = "View Admin";

		$data['in_admin'] = true;
		$data['edit_user'] = true;

		$data['back_url'] = 'Admin/admin';
		$data['view_link'] = 'Admin/view_admin/';
		$data['edit_link'] = 'Admin/edit_admin/';
		$data['form_update'] = 'Admin/update_admin';


		$data['view_text'] = "Admin View";
		$data['edit_text'] = "Edit Admin";
		


		$data['admin'] = $this->User->get_admin($id);
		$data['title'] = "Manage Admin";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_user');
		$this->load->view('admin/pages/edit_user');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_admin($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
		$this->form_validation->set_rules('phone', 'Phone number', 'required|regex_match[/^(09|\+639)\d{9}$/]');
		$this->form_validation->set_rules('bday', 'Birth date', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|max_length[4]|numeric');

        $data = array(
            'fname' => $this->input->post('fname'),
            'mname' => $this->input->post('mname'),
            'lname' => $this->input->post('lname'),
            'phone' => $this->input->post('phone'),
            'bday' => $this->input->post('bday'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),
        );

		if(!$this->form_validation->run())
		{
			$this->check_session();
			$this->load->model('User');
			$data['title_viewed'] = "Edit Admin";
	
			$data['in_admin'] = true;
			$data['edit_user'] = true;
	
			$data['back_url'] = 'Admin/admin';
			$data['view_link'] = 'Admin/view_admin/';
			$data['edit_link'] = 'Admin/edit_admin/';
			$data['title_viewed'] = "View Admin";
			$data['form_update'] = 'Admin/update_admin';

			$data['view_text'] = "Admin View";
			$data['edit_text'] = "Edit Admin";
	
	
			$data['admin'] = $this->User->get_admin($id);
			$data['title'] = "Manage Admin";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/view_user');
			$this->load->view('admin/pages/edit_user');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
            $user_data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'phone' => $this->input->post('phone'),
                'bday' => $this->input->post('bday'),
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_admin($id);
			
		}
	}

	public function update_admin_email($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');

		if(!$this->form_validation->run())
		{
			$this->edit_admin($id);
		}
		else
		{
            $user_data = array(
                'email' => $this->input->post('email'),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_admin($id);
			
		}
	}

	public function update_teacher_email($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');

		if(!$this->form_validation->run())
		{
			$this->edit_teacher($id);
		}
		else
		{
            $user_data = array(
                'email' => $this->input->post('email'),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_teacher($id);
			
		}
	}

	public function update_staff_email($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');

		if(!$this->form_validation->run())
		{
			$this->edit_staff($id);
		}
		else
		{
            $user_data = array(
                'email' => $this->input->post('email'),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_staff($id);
			
		}
	}

	public function update_student_email($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');

		if(!$this->form_validation->run())
		{
			$this->edit_student($id);
		}
		else
		{
            $user_data = array(
                'email' => $this->input->post('email'),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_student($id);
			
		}
	}

	public function update_guardian_email($id)
	{
		$this->check_session();
		$this->load->model('Guardian');
        $this->form_validation->set_rules('g_email', 'Guardian Email', 'required|valid_email|is_unique[guardian.g_email]');

		if(!$this->form_validation->run())
		{
			$this->edit_student($id);
		}
		else
		{
            $user_data = array(
                'g_email' => $this->input->post('g_email'),
            );

            $this->Guardian->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_student($id);
			
		}
	}

	public function update_admin_password($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[8]');
        $this->form_validation->set_rules('cpassword', 'Confirm password', 'required|matches[password]');

		if(!$this->form_validation->run())
		{
			$this->edit_admin($id);
		}
		else
		{
            $user_data = array(
                'password' => sha1($this->input->post('password')),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_admin($id);
			
		}
	}

	public function update_teacher_password($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[8]');
        $this->form_validation->set_rules('cpassword', 'Confirm password', 'required|matches[password]');

		if(!$this->form_validation->run())
		{
			$this->edit_teacher($id);
		}
		else
		{
            $user_data = array(
                'password' => sha1($this->input->post('password')),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_teacher($id);
			
		}
	}

	public function update_staff_password($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[8]');
        $this->form_validation->set_rules('cpassword', 'Confirm password', 'required|matches[password]');

		if(!$this->form_validation->run())
		{
			$this->edit_staff($id);
		}
		else
		{
            $user_data = array(
                'password' => sha1($this->input->post('password')),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_staff($id);
			
		}
	}

	public function update_student_password($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('password', 'password', 'required|min_length[8]');
        $this->form_validation->set_rules('cpassword', 'Confirm password', 'required|matches[password]');

		if(!$this->form_validation->run())
		{
			$this->edit_student($id);
		}
		else
		{
            $user_data = array(
                'password' => sha1($this->input->post('password')),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_student($id);
			
		}
	}



	public function insert_face_user($id)
	{
		$this->check_session();
		$this->load->model('User');
		$data['back_url'] = 'Admin/admin';
		$data['view_link'] = 'Admin/view_admin/';
		$data['edit_link'] = 'Admin/edit_admin/';
		$data['title_viewed'] = "View Admin";


		$data['view_text'] = "Admin View";
		$data['edit_text'] = "Edit Admin";
		
		$data['this_link'] = 'insert_face_user';
		$data['insert_face'] = true;
		$data['admin'] = $this->User->get_this($id);
		$data['user'] = $this->User->get_this($id);
		$data['title_viewed'] = 'Insert Face';
		$data['title'] = "Manage Admin";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_user');
		$this->load->view('admin/pages/insert_face');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function insert_face_student($id)
	{
		$this->check_session();
		$this->load->model('User');
		$data['this_link'] = 'insert_face_student';
		$data['insert_face'] = true;
		$data['student'] = $this->User->get_this($id);
		$data['user'] = $this->User->get_this($id);
		$data['title_viewed'] = 'Insert Face';
		$data['title'] = "Manage Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_student');
		$this->load->view('admin/pages/insert_face');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function insert_face_teacher($id)
	{
		$this->check_session();
		$this->load->model('User');
		$data['this_link'] = 'insert_face_teacher';
		$data['insert_face'] = true;
		$data['teacher'] = $this->User->get_this($id);
		$data['user'] = $this->User->get_this($id);
		$data['title_viewed'] = 'Insert Face';
		$data['title'] = "Manage Teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_teacher');
		$this->load->view('admin/pages/insert_face');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function insert_face_staff($id)
	{
		$this->check_session();
		$this->load->model('User');
		$data['this_link'] = 'insert_face_staff';
		$data['insert_face'] = true;
		$data['staff'] = $this->User->get_this($id);
		$data['user'] = $this->User->get_this($id);
		$data['title_viewed'] = 'Insert Face';
		$data['title'] = "Manage Staff";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_staff');
		$this->load->view('admin/pages/insert_face');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

		
	public function capture($id)
	{
		$this->check_session();
		$upload_path = "./python_app/train_img/$id";
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

		if($this->upload->do_upload('webcam'))
		{
			$filedata = $this->upload->data();

			$face_data = array(
				'userID' => $id,
				'image' => $filedata['file_name'],
				'date_uploaded' => date('Y-m-d H:i:s'),
			);

			$this->load->model('Face');
			$this->Face->insert($face_data);
			
		}


	}

	public function upload_dataset($uid)
	{
		$this->check_session();
		$this->load->model('User');
		$link = $this->input->post('link');
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
				redirect("Admin/$link/$uid");
			}

		}
		$this->session->set_flashdata('upload_status', 'Files uploaded. SUCCESS -'.$count_uploaded_files.'; ERROR -'.$count_error_files);
		redirect("Admin/$link/$uid");
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






	// ---[STUDENT MANAGEMENT FUNCTION]---
	// 			---[START]---
	public function student()
	{
		$this->check_session();
		$this->session->set_userdata('referred_from', current_url());
		$data['title_viewed'] = "Manage Student";
		$config = array();
		$this->load->model('Student');


		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/student";
		$config["total_rows"] = $this->Student->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['students'] = $this->Student->select($config["per_page"], $page);

		$data['title'] = "Manage Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_student');
		$this->load->view('admin/pages/student_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function add_student()
	{
		$this->check_session();
		$this->session->set_userdata('referred_from', current_url());
		$data['title_viewed'] = "Create Student";
		$this->load->model('Student');
		$this->load->model('Gradelevel');
		$data['gradelevel'] = $this->Gradelevel->select();
		$data['title'] = "Admin Add Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_student');
		$this->load->view('admin/pages/create_student');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function search_student()
	{
		$this->check_session();

		$search = ($this->input->post("search_student"))? $this->input->post("search_student"): '';
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        $this->load->model('Student');
		$data['title_viewed'] = "Manage Student";
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/search_student/$search";
		$config["total_rows"] = $this->Student->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['students'] = $this->Student->select($config["per_page"], $page, $search);
		
        $data['search'] = $search;
		$data['title'] = "Admin Manage Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_student');
		$this->load->view('admin/pages/student_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function view_student($id)
	{
		$this->check_session();
		$this->load->model('Student');
		$data['title_viewed'] = "View Student";
		$data['student'] = $this->Student->get_student($id);
		$data['title'] = "Admin Manage Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_student');
		$this->load->view('admin/pages/view_student_content');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_student($id)
	{
		$this->check_session();
		$this->load->model('Student');
		$this->load->model('Gradelevel');
		$data['title_viewed'] = "Edit Student";
		$data['student'] = $this->Student->get_student($id);
		$data['gradelevel'] = $this->Gradelevel->select_t($id);
		$data['title'] = "Admin Manage Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_student');
		$this->load->view('admin/pages/edit_student');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_student($id)
	{
		$this->check_session();
		$this->load->model('User');
		$this->form_validation->set_rules('fname', 'First name', 'required');
		$this->form_validation->set_rules('mname', 'Middle name', 'required');
		$this->form_validation->set_rules('lname', 'Last name', 'required');
		$this->form_validation->set_rules('grade_level', 'Grade Level', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('guardian_fname', 'First name', 'required');
		$this->form_validation->set_rules('guardian_mname', 'Middle name', 'required');
		$this->form_validation->set_rules('guardian_lname', 'Last name', 'required');
		$this->form_validation->set_rules('guardian_email', 'Email', 'required');
		$this->form_validation->set_rules('guardian_phone', 'Phone', 'required');
		$this->form_validation->set_rules('previous_school', 'Previous School', 'required');
		$this->form_validation->set_rules('previous_school_address', 'Previous School Address', 'required');
		$this->form_validation->set_rules('bday', 'Date of Birth', 'required');

		$data = array(
			'fname' => $this->input->post('fname'),
			'mname' => $this->input->post('mname'),
			'lname' => $this->input->post('lname'),
			'grade_level' => $this->input->post('grade_level'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'guardian_fname' => $this->input->post('guardian_fname'),
			'guardian_mname' => $this->input->post('guardian_mname'),
			'guardian_lname' => $this->input->post('guardian_lname'),
			'guardian_phone' => $this->input->post('guardian_phone'),
			'previous_school' => $this->input->post('previous_school'),
			'previous_school_address' => $this->input->post('previous_school_address'),
			'bday' => $this->input->post('bday'),
		);

		if(!$this->form_validation->run())
		{
			$this->check_session();
			$this->load->model('Student');
			$this->load->model('Gradelevel');
			$data['title_viewed'] = "Edit Student";
			$data['student'] = $this->Student->get_student($id);
			$data['gradelevel'] = $this->Gradelevel->select_t($id);
			$data['title'] = "Admin Manage Student";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/view_student');
			$this->load->view('admin/pages/edit_student');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
            $data_user = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'phone' => $this->input->post('phone'),
                'bday' => $this->input->post('bday'),
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
            );

            $this->User->update($data_user, $id);
            $data_student = array(
                'gradelevelID' => $this->input->post('grade_level'),
            );
            $this->load->model('Student');
            $this->Student->update_student($data_student, $id);
            $this->load->model('Previous_school', 'Prev');
            $data_prev_school = array(
                'school_name' => $this->input->post('previous_school'),
                'school_address' => $this->input->post('previous_school_address'),
            );
            $this->Prev->update($data_prev_school,$id);
            $this->load->model('Guardian');
            $data_guardian = array(
                'g_fname' => $this->input->post('guardian_fname'),
                'g_mname' => $this->input->post('guardian_mname'),
                'g_lname' => $this->input->post('guardian_lname'),
                'g_phone' => $this->input->post('guardian_phone'),
            );
            $this->Guardian->update($data_guardian, $id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_student($id);
		}
	}

	public function create_student()
	{
		$this->check_session();
		$flag = 0;
		$this->load->model('User');
		$this->form_validation->set_rules('fname', 'First name', 'required');
		$this->form_validation->set_rules('mname', 'Middle name', 'required');
		$this->form_validation->set_rules('lname', 'Last name', 'required');
		$this->form_validation->set_rules('grade_level', 'Grade Level', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('guardian_fname', 'First name', 'required');
		$this->form_validation->set_rules('guardian_mname', 'Middle name', 'required');
		$this->form_validation->set_rules('guardian_lname', 'Last name', 'required');
		$this->form_validation->set_rules('guardian_email', 'Email', 'required');
		$this->form_validation->set_rules('guardian_phone', 'Phone', 'required');
		$this->form_validation->set_rules('enrolleeType', 'Enrollee Type', 'required');
		if($this->input->post('enrolleeType') == 1)
		{
			$flag = 1;
		}
		else
		{
			$flag = 2;
			$this->form_validation->set_rules('previous_school', 'Previous School', 'required');
			$this->form_validation->set_rules('previous_school_address', 'Previous School Address', 'required');
		}
		$this->form_validation->set_rules('bday', 'Date of Birth', 'required');

		$data = array(
			'fname' => $this->input->post('fname'),
			'mname' => $this->input->post('mname'),
			'lname' => $this->input->post('lname'),
			'grade_level' => $this->input->post('grade_level'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'guardian_fname' => $this->input->post('guardian_fname'),
			'guardian_mname' => $this->input->post('guardian_mname'),
			'guardian_lname' => $this->input->post('guardian_lname'),
			'guardian_email' => $this->input->post('guardian_email'),
			'guardian_phone' => $this->input->post('guardian_phone'),
			'previous_school' => $this->input->post('previous_school'),
			'previous_school_address' => $this->input->post('previous_school_address'),
			'bday' => $this->input->post('bday'),
		);

		if($flag == 1)
		{
			$data['selected_old'] = true; 
		}
		if($flag == 2)
		{
			$data['selected_new'] = true; 
		}

		if(!$this->form_validation->run())
		{
			$this->check_session();
			$this->session->set_userdata('referred_from', current_url());
			$data['title_viewed'] = "Create Student";
			$this->load->model('Student');
			$this->load->model('Gradelevel');
			$data['gradelevel'] = $this->Gradelevel->select();
			$data['title'] = "Admin Add Student";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/manage_student');
			$this->load->view('admin/pages/create_student');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
			$access_code = random_string('alnum', 8);
            $data_user = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'bday' => $this->input->post('bday'),
                'access_code' => $access_code,
                'status' => 1,
                'roleID' => 2,
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
                'avatar' => 'profile_pic.jpg',
                'datecreated' => date('Y-m-d'),
                'password' => sha1($access_code),
            );

            $last_id = $this->User->insert($data_user);
            $data_student = array(
                'userID' => $last_id,
                'gradelevelID' => $this->input->post('grade_level'),
            );
            $this->load->model('Student');
            $this->Student->insert_student($data_student);

			if($flag == 2)
			{
				$this->load->model('Previous_school', 'Prev');
				$data_prev_school = array(
					'userID' => $last_id,
					'school_name' => $this->input->post('previous_school'),
					'school_address' => $this->input->post('previous_school_address'),
				);
				$this->Prev->insert($data_prev_school);
			}



            $this->load->model('Guardian');
            $data_guardian = array(
                'userID' => $last_id,
                'g_fname' => $this->input->post('guardian_fname'),
                'g_mname' => $this->input->post('guardian_mname'),
                'g_lname' => $this->input->post('guardian_lname'),
                'g_email' => $this->input->post('guardian_email'),
                'g_phone' => $this->input->post('guardian_phone'),
            );
            $this->Guardian->insert($data_guardian);

			$this->session->set_flashdata('Success', 'Creation Success');
			redirect('Admin/add_student');
			
		}

		
	}

	public function create_student1()
	{
		$this->check_session();
		$this->load->model('Studentsection');


		// GET INPUTS
		$user_data = array(
				'fname' => "Matthew",
				'mname' => "Macoco",
				'lname' => "Butalid",
				'role' => 'Student',
				'avatar' => 'profile_pic.jpg',
				'datecreated' => date('Y-m-d'),
		);

			
	

		$sid = $this->Studentsection->insert($user_data);

		$student_data = array(
				'studentID' => $sid,
				'sectionID' => 4,
		);			
		$this->Studentsection->insert_student($student_data);
		redirect('Admin/add_student');
			
		

		
	}

	public function delete_student($id)
	{
		$this->check_session();
		$this->load->model('User');
		$result = $this->User->get_this($id);
		foreach($result as $i)
		{
			$file = $i->avatar;
		}
		if($file != 'profile_pic.jpg')
		{
			unlink("./uploads/".$file);
		}
		$this->User->delete($id);
		redirect('Admin/student');
	}

	public function teacher()
	{
		$this->check_session();
		$this->session->set_userdata('referred_from', current_url());
		$data['title_viewed'] = "Manage Teacher";
		$config = array();
		$this->load->model('Teacher');
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/teacher";
		$config["total_rows"] = $this->Teacher->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['teachers'] = $this->Teacher->select($config["per_page"], $page);
		$data['title'] = "Admin Manage Teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_teacher');
		$this->load->view('admin/pages/teacher_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function search_teacher()
	{
		
		$this->check_session();
		$search = ($this->input->post("search_teacher"))? $this->input->post("search_teacher"): '';
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
		$data['title_viewed'] = "Manage Teacher";
        $this->load->model('Teacher');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/search_teacher/$search";
		$config["total_rows"] = $this->Teacher->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['teachers'] = $this->Teacher->select($config["per_page"], $page, $search);
        $data['search'] = $search;
		$data['title'] = "Admin Manage Teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_teacher');
		$this->load->view('admin/pages/teacher_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function view_teacher($id)
	{
		$this->check_session();
		$this->load->model('Teacher');
		$data['title_viewed'] = "View Teacher";
		$data['teacher'] = $this->Teacher->get_teacher($id);
		$data['title'] = "Admin Manage teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_teacher');
		$this->load->view('admin/pages/view_teach_content');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}
	
	public function edit_teacher($id)
	{
		$this->check_session();
		$this->load->model('Teacher');
		$data['title_viewed'] = "Edit Teacher";
		$data['teacher'] = $this->Teacher->get_teacher($id);
		$data['title'] = "Admin Manage teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_teacher');
		$this->load->view('admin/pages/edit_teacher');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_teacher($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
		$this->form_validation->set_rules('phone', 'Phone number', 'required|regex_match[/^(09|\+639)\d{9}$/]');
		$this->form_validation->set_rules('bday', 'Birth date', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|max_length[4]|numeric');

        $data = array(
            'fname' => $this->input->post('fname'),
            'mname' => $this->input->post('mname'),
            'lname' => $this->input->post('lname'),
            'phone' => $this->input->post('phone'),
            'bday' => $this->input->post('bday'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),
        );

		if(!$this->form_validation->run())
		{
			$this->check_session();
			$this->load->model('Teacher');
			$data['title_viewed'] = "Edit Teacher";
			$data['teacher'] = $this->Teacher->get_teacher($id);
			$data['title'] = "Admin Manage teacher";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/view_teacher');
			$this->load->view('admin/pages/edit_teacher');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
            $user_data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'phone' => $this->input->post('phone'),
                'bday' => $this->input->post('bday'),
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
            );

            $this->User->update($user_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_teacher($id);
			
		}
	}

	public function add_teacher()
	{
		$this->check_session();
		$this->session->set_userdata('referred_from', current_url());
		$data['title_viewed'] = "Create Teacher";
		$data['form_title'] = 'Teacher';
		$data['form_url'] = 'create_teacher';
		$data['title'] = "Admin Add Teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_teacher');
		$this->load->view('admin/pages/create_teacher');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function create_teacher()
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]');
		$this->form_validation->set_rules('phone', 'Phone number', 'required|regex_match[/^(09|\+639)\d{9}$/]');
		$this->form_validation->set_rules('bday', 'Birth date', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|max_length[4]|numeric');

        $data = array(
            'fname' => $this->input->post('fname'),
            'mname' => $this->input->post('mname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'bday' => $this->input->post('bday'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),
        );

		if(!$this->form_validation->run())
		{
			$this->check_session();
			$this->session->set_userdata('referred_from', current_url());
			$data['title_viewed'] = "Create Teacher";
			$data['title'] = "Admin Add Teacher";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/manage_teacher');
			$this->load->view('admin/pages/create_teacher');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
			$access_code = random_string('alnum', 8);
            $user_data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'bday' => $this->input->post('bday'),
                'access_code' => $access_code,
                'status' => 1,
                'roleID' => 3,
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
                'avatar' => 'profile_pic.jpg',
                'datecreated' => date('Y-m-d'),
                'password' => sha1($access_code),
            );

            $this->User->insert($user_data);

			$this->session->set_flashdata('Success', 'Creation Success');
			redirect('Admin/add_teacher');
			
		}

		
	}

	public function subject_teaching($id)
	{
		$this->check_session();
		$data['subject_teaching'] = true;
		$this->load->model('Teacher');
		$this->load->model('Teach');
		$data['title_viewed'] = "View Teacher";
		$data['teacher'] = $this->Teacher->get_teacher($id);
		$data['teach'] = $this->Teach->select_teach($id);
		$data['subject'] = $this->Teach->select_teach_subject($id);
		$data['title'] = "Admin Manage teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_teacher');
		$this->load->view('admin/pages/subject_to_teach');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function add_subject_teaching($id)
	{
		$this->check_session();
		$data['add_teaching'] = true;
		$this->load->model('Teacher');
		$this->load->model('Schedule');
		$data['title_viewed'] = "View Teacher";
		$data['teacher'] = $this->Teacher->get_teacher($id);
		$data['subject'] = $this->Schedule->get_all_subject($id);
		$data['schedules'] = $this->Schedule->get_all_sched($id);
		$data['title'] = "Admin Manage teacher";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_teacher');
		$this->load->view('admin/pages/add_teaching');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function insert_subject_teaching($id)
	{
		$this->check_session();
		$data['add_teaching'] = true;
		$this->load->model('Teach');
		$flag = 0;
		$teaching = $this->Teach->select($id);

		$count = count($this->input->post('schedule'));

		if($count > 1)
		{
			for($i=0; $i < $count; $i++)
			{
				$schedule = $this->input->post('schedule')[$i];
				$selected_subject = $this->Teach->select_subject($schedule);
	
				foreach($selected_subject as $o)
				{
					$time_create_start = date_create($o->schedule_start);
					$time_create_end = date_create($o->schedule_end);
					$time_start = date_format($time_create_start, "h:i");
					$time_end = date_format($time_create_end, "h:i");
					$weekday = $o->weekday;
				}
		
				foreach($teaching as $i)
				{
					$subject_start = date_create($i->schedule_start);
					$start = date_format($subject_start,"h:i");
					$subject_end = date_create($i->schedule_end);
					$end = date_format($subject_end,"h:i");
		
	
					if($weekday == $i->weekday)
					{
	
						if($time_start <= $start && $time_end >= $end)
						{
							$flag = 1;
						}
			
						if($time_start >= $start && $time_start < $end)
						{
							$flag = 1;
						}
			
						if($time_end > $start && $time_end <= $end)
						{
							$flag = 1;
						}
	
					}
	
					
				}
	
			}



			if($flag != 0)
			{
				$this->session->set_flashdata('time_error', 'Time conflict');
				redirect("Admin/add_subject_teaching/$id");
			}
			
	
			for($i=0; $i < $count; $i++)
			{
				$schedule = $this->input->post('schedule')[$i];
				$data = array(
					'userID' => $id,
					'scheduleID' => $schedule,
				);
	
				$this->Teach->insert($data);
			}
		}
		else
		{
			$schedule = $this->input->post('schedule')[0];
			$selected_subject = $this->Teach->select_subject($schedule);
	
			foreach($selected_subject as $o)
			{
				$time_create_start = date_create($o->schedule_start);
				$time_create_end = date_create($o->schedule_end);
				$time_start = date_format($time_create_start, "h:i");
				$time_end = date_format($time_create_end, "h:i");
				$weekday = $o->weekday;
			}
		
			foreach($teaching as $i)
			{
				$subject_start = date_create($i->schedule_start);
				$start = date_format($subject_start,"h:i");
				$subject_end = date_create($i->schedule_end);
				$end = date_format($subject_end,"h:i");
		
	
				if($weekday == $i->weekday)
				{
	
					if($time_start <= $start && $time_end >= $end)
					{
						$flag = 1;
					}
			
					if($time_start >= $start && $time_start < $end)
					{
						$flag = 1;
					}
			
					if($time_end > $start && $time_end <= $end)
					{
						$flag = 1;
					}
	
				}
	
					
			}

			if($flag != 0)
			{
				$this->session->set_flashdata('time_error', 'Time conflict');
				redirect("Admin/add_subject_teaching/$id");
			}
			

			$data = array(
				'userID' => $id,
				'scheduleID' => $schedule,
			);
			
			$this->Teach->insert($data);
		}








		$this->session->set_flashdata('Success', 'Subject Applied');
		redirect("Admin/add_subject_teaching/$id");
	}

	public function delete_subject_teaching($id)
	{
		$this->check_session();
		$teachID = $this->input->post('teach');
		$this->load->model('Teach');
		foreach($teachID as $i)
		{
			$this->Teach->delete($i);
		}

		$this->session->set_flashdata('Success', 'Deletion Success');
		$this->subject_teaching($id);
	}



	public function delete_teacher($id)
	{
		$this->check_session();
		$this->load->model('User');
		$result = $this->User->get_this($id);
		foreach($result as $i)
		{
			$file = $i->avatar;
		}
		if($file != 'profile_pic.jpg')
		{
			unlink("./uploads/".$file);
		}
		$this->User->delete($id);
		redirect('Admin/teacher');
	}

	public function staff()
	{
		$this->check_session();
		$this->session->set_userdata('referred_from', current_url());
		$data['title_viewed'] = "Manage Staff";
		$config = array();
		$this->load->model('Staff');
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/staff";
		$config["total_rows"] = $this->Staff->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['staffs'] = $this->Staff->select($config["per_page"], $page);
		$data['title'] = "Admin Manage Staff";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_staff');
		$this->load->view('admin/pages/staff_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function search_staff()
	{
		$this->check_session();
		$search = ($this->input->post("search_staff"))? $this->input->post("search_staff"): '';
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
		$data['title_viewed'] = "Manage Staff";
        $this->load->model('Staff');
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/search_staff/$search";
		$config["total_rows"] = $this->Staff->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['staffs'] = $this->Staff->select($config["per_page"], $page, $search);
        $data['search'] = $search;
		$data['title'] = "Admin Manage Staff";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_staff');
		$this->load->view('admin/pages/staff_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function view_staff($id)
	{
		$this->check_session();
		$this->load->model('Staff');
		$data['title_viewed'] = "View Staff";
		$data['staff'] = $this->Staff->get_staff($id);
		$data['title'] = "Admin Manage Staff";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_staff');
		$this->load->view('admin/pages/view_staff_content');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function edit_staff($id)
	{
		$this->check_session();
		$this->load->model('Staff');
		$this->load->model('Stafftype');
		$data['title_viewed'] = "Edit Staff";
		$data['staff'] = $this->Staff->get_staff($id);
		$data['title'] = "Admin Manage Staff";
		$data['stafftype'] = $this->Stafftype->select_t($id);
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_staff');
		$this->load->view('admin/pages/edit_staff');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_staff($id)
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
		$this->form_validation->set_rules('phone', 'Phone number', 'required|regex_match[/^(09|\+639)\d{9}$/]');
		$this->form_validation->set_rules('bday', 'Birth date', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('staff_type', 'Staff type', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|max_length[4]|numeric');

        $data = array(
            'fname' => $this->input->post('fname'),
            'mname' => $this->input->post('mname'),
            'lname' => $this->input->post('lname'),
            'phone' => $this->input->post('phone'),
            'bday' => $this->input->post('bday'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),
        );

		if(!$this->form_validation->run())
		{
			$this->check_session();
			$this->load->model('Staff');
			$this->load->model('Stafftype');
			$data['title_viewed'] = "Edit Staff";
			$data['staff'] = $this->Staff->get_staff($id);
			$data['title'] = "Admin Manage Staff";
			$data['stafftype'] = $this->Stafftype->select_t($id);
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/view_staff');
			$this->load->view('admin/pages/edit_staff');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
            $user_data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'phone' => $this->input->post('phone'),
                'bday' => $this->input->post('bday'),
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
            );


			
			$this->User->update($user_data, $id);
            $this->load->model('Staff');

            $staff_data = array(

                'stafftypeID' => $this->input->post('staff_type'),
            );

            $this->Staff->update_staff($staff_data, $id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->edit_staff($id);			
		}

		
	}

	public function add_staff()
	{
		$this->check_session();
		$this->session->set_userdata('referred_from', current_url());
		$data['title_viewed'] = "Create Staff";
		$data['title'] = "Admin Add Staff";
		$this->load->model('Stafftype');
		$data['stafftype'] = $this->Stafftype->select();
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_staff');
		$this->load->view('admin/pages/create_staff');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function create_staff()
	{
		$this->check_session();
		$this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]');
		$this->form_validation->set_rules('phone', 'Phone number', 'required|regex_match[/^(09|\+639)\d{9}$/]');
		$this->form_validation->set_rules('bday', 'Birth date', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('staff_type', 'Staff type', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|max_length[4]|numeric');

        $data = array(
            'fname' => $this->input->post('fname'),
            'mname' => $this->input->post('mname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'bday' => $this->input->post('bday'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),
        );

		if(!$this->form_validation->run())
		{
			$this->check_session();
			$this->session->set_userdata('referred_from', current_url());
			$data['title_viewed'] = "Create Staff";
			$data['title'] = "Admin Add Staff";
			$this->load->model('Stafftype');
			$data['stafftype'] = $this->Stafftype->select();
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/manage_staff');
			$this->load->view('admin/pages/create_staff');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
			$access_code = random_string('alnum', 8);
            $user_data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'bday' => $this->input->post('bday'),
                'access_code' => $access_code,
                'status' => 1,
                'roleID' => 4,
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
                'avatar' => 'profile_pic.jpg',
                'datecreated' => date('Y-m-d'),
                'password' => sha1($access_code),
            );

            $this->User->insert($user_data);

			
            $last_id = $this->User->insert($user_data);
            $this->load->model('Staff');

            $staff_data = array(
                'userID' => $last_id,
                'stafftypeID' => $this->input->post('staff_type'),
            );

            $this->Staff->insert_staff($staff_data);

			$this->session->set_flashdata('Success', 'Creation Success');
			redirect('Admin/add_staff');
			
		}

		
	}

	public function delete_staff($id)
	{
		$this->check_session();
		$this->load->model('User');
		$result = $this->User->get_this($id);
		foreach($result as $i)
		{
			$file = $i->avatar;
		}
		if($file != 'profile_pic.jpg')
		{
			unlink("./uploads/".$file);
		}
		$this->User->delete($id);
		redirect('Admin/staff');
	}

	public function delete_admin($id)
	{
		$this->check_session();
		$this->load->model('User');
		$result = $this->User->get_this($id);
		foreach($result as $i)
		{
			$file = $i->avatar;
		}
		if($file != 'profile_pic.jpg')
		{
			unlink("./uploads/".$file);
		}
		$this->User->delete($id);
		redirect('Admin/admin');
	}
	// ---[STAFF MANAGEMENT FUNCTION]---
	// 			---[END]---

	// ---[BOOTSTRAP CONFIGURATION/STYLE FOR PAGINATION]---
	// 					---[START]---
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
	// ---[BOOTSTRAP CONFIGURATION/STYLE FOR PAGINATION]---
	// 					---[END]---


	public function manage_section()
	{
		$this->check_session();
		$this->load->model('Section');
		$data['title_viewed'] = "Manage Section";
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/manage_section";
		$config["total_rows"] = $this->Section->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['sections'] = $this->Section->paginate($config["per_page"], $page);
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_section');
		$this->load->view('admin/pages/section_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function add_section()
	{
		$this->check_session();
		$data['title_viewed'] = "Create Section";
		$this->load->model('Gradelevel');
		$this->load->model('Teacher');
		$data['teacher'] = $this->Teacher->get_test();
		$data['gradelevel'] = $this->Gradelevel->select();
		$data['title'] = "Admin Add Student";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_section');
		$this->load->view('admin/pages/create_section');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function create_section()
	{
		$this->check_session();
		$this->load->model('Section');
        $this->form_validation->set_rules('name', 'Section name', 'required|is_unique[section.section_name]');
        $this->form_validation->set_rules('teacher', 'Class Adviser', 'required|is_unique[section.section_adviser]');
        $this->form_validation->set_rules('max', 'Max Capacity', 
		'required|numeric|greater_than_equal_to[10]|less_than_equal_to[30]');
        $this->form_validation->set_rules('year_level', 'Year Level', 'required');

        $data = array(
            'name' => $this->input->post('name'),
            'teacher' => $this->input->post('teacher'),
            'max' => $this->input->post('max'),
            'year_level' => $this->input->post('year_level'),
        );

		if(!$this->form_validation->run())
		{
			$this->check_session();
			$data['title_viewed'] = "Create Section";
			$this->load->model('Gradelevel');
			$this->load->model('Teacher');
			$data['teacher'] = $this->Teacher->get_active();
			$data['gradelevel'] = $this->Gradelevel->select();
			$data['title'] = "Admin Add Student";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/manage_section');
			$this->load->view('admin/pages/create_section');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{

			$section_data = array(
				'section_name' => $this->input->post('name'),
				'section_adviser' => $this->input->post('teacher'),
				'max_capacity' => $this->input->post('max'),
				'gradelevelID' => $this->input->post('year_level'),
				'section_datecreated' => date('Y-m-d'),
			);

			$this->Section->insert($section_data);

			$this->session->set_flashdata('Success', 'Creation Success');
			redirect('Admin/add_section');	
		}

		
	}

	public function student_section($sectionID)
	{
		$this->check_session();
		$this->load->model('Section');
		$this->form_validation->set_rules('student', 'Student', 'required');
		if(!$this->form_validation->run())
		{
			$this->view_section($sectionID);
			redirect("Admin/view_section/$sectionID");
		}
		else
		{
			$userID = $this->input->post('student');

			$update_data = array(
				'sectionID' => $sectionID,
			);

			$this->Section->put_student($update_data, $userID);
			redirect("Admin/view_section/$sectionID");
		}

	}

	public function search_section()
	{
		$this->check_session();
		$this->load->model('Section');
		$data['title_viewed'] = "Manage Section";
		$search = ($this->input->post("search_section"))? $this->input->post("search_section"): '';
		$search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
        $config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/manage_section/$search";
		$config["total_rows"] = $this->Section->count($search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['sections'] = $this->Section->paginate($config["per_page"], $page, $search);
		$data['search'] = $search;
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_section');
		$this->load->view('admin/pages/section_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function view_section($id)
	{
		$this->check_session();
		$this->load->model('Section');
		$data['title_viewed'] = "Manage Section";
		$data['stud_list'] = $this->Section->get_section_student_all($id);
		$aw = $this->Section->get($id);
		foreach($aw as $i)
		{
			$gradelevel = $i->gradelevelID;
		}
		$data['students'] = $this->Section->get_student($gradelevel);
		$data['section_data'] = $aw;
		$data['title'] = 'View section';
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_section');
		$this->load->view('admin/pages/section_view_content');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function view_section_search($id)
	{
		$this->check_session();
		$this->load->model('Section');
		$data['title_viewed'] = "Manage Section";
		$search = ($this->input->post("search_student"))? $this->input->post("search_student"): '';
		$search = ($this->uri->segment(4)) ? $this->uri->segment(4) : $search;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/view_section_search/$id/$search";
		$config["total_rows"] = $this->Section->count_student($id, $search);
		$config["per_page"] = 4;
		$config["uri_segment"] = 5;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5))? $this->uri->segment(5) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['stud_list'] = $this->Section->get_section_student($config["per_page"], $page, $id, $search);
		$aw = $this->Section->get($id);
		foreach($aw as $i)
		{
			$gradelevel = $i->gradelevelID;
		}
		$data['search'] = $search;
		$data['students'] = $this->Section->get_student($gradelevel);
		$data['section_data'] = $aw;
		$data['title'] = 'View section';
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_section');
		$this->load->view('admin/pages/section_view_content');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function manage_schedule($id)
	{
		$this->check_session();
		$this->load->model('Section');
		$this->load->model('Subject');
		$this->load->model('Schedule');

		$data['monday_scheds'] = $this->Schedule->get_monday($id);
		$data['tuesday_scheds'] = $this->Schedule->get_tuesday($id);
		$data['wednesday_scheds'] = $this->Schedule->get_wednesday($id);
		$data['thursday_scheds'] = $this->Schedule->get_thursday($id);
		$data['friday_scheds'] = $this->Schedule->get_friday($id);
		$data['saturday_scheds'] = $this->Schedule->get_saturday($id);


		$data['weekdays'] = array(
			"Monday",
			"Tuesday",
			"Wednesday",
			"Thursday",
			"Friday",
			"Saturday",
		);

		$data['title_viewed'] = "Manage Section Schedule";
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/manage_schedule/$id";
		$config["total_rows"] = $this->Schedule->count($id);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4))? $this->uri->segment(4) : 0;
		$data["pagination"] = $this->pagination->create_links();
		$data['schedule'] = $this->Schedule->select($config["per_page"], $page, $id);
		$aw = $this->Section->get($id);
		foreach($aw as $i)
		{
			$gradelevel = $i->gradelevelID;
		}
		$data['students'] = $this->Section->get_student($gradelevel);
		$data['section_data'] = $aw;
		$data['subjects'] = $this->Schedule->glsection($gradelevel, $id);
		// print_r($this->Schedule->glsection($gradelevel, $id));
		$data['title'] = 'View section';
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/view_section');
		$this->load->view('admin/pages/manage_schedule');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function create_schedule($sectionID)
	{
		$this->check_session();
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('weekday', 'Weekday', 'required');
		$this->form_validation->set_rules('time_start', 'Time Start', 'required');
		$this->form_validation->set_rules('time_end', 'Time End', 'required');

		$time_start = $this->input->post('time_start');
		$time_end = $this->input->post('time_end');
		$weekday = $this->input->post('weekday');
		$subject = $this->input->post('subject');

		if(!$this->form_validation->run())
		{
			$this->session->set_flashdata('time_error', 'Missing field inputs');
			redirect("Admin/manage_schedule/$sectionID");
		}
		else
		{
			$this->load->model('Schedule');
			switch (true) {
				case $time_start == $time_end:
					$this->session->set_flashdata('time_error', 'Time start should not be equal to Time End');
					redirect("Admin/manage_schedule/$sectionID");
					break;
	
				case $time_start >= $time_end:
					$this->session->set_flashdata('time_error', 'Time start should not be more than Time End');
					redirect("Admin/manage_schedule/$sectionID");
					break;
				
				default:
					# code...
					break;
			}

			$data_validate = $this->Schedule->get_schedule($sectionID);
			$flag = 0;
			foreach($data_validate as $i)
			{

				$create_start = date_create($i->schedule_start);
                $start = date_format($create_start,"h:i");
				$create_end = date_create($i->schedule_end);
            	$end = date_format($create_end,"h:i");
				if($weekday == $i->weekday)
				{

					if($time_start <= $start && $time_end >= $end)
					{
						$this->session->set_flashdata('time_error', 'Time conflict. Creation Cancelled');
						$flag = 1;
					}
	
					if($time_start >= $start && $time_start < $end)
					{
						$this->session->set_flashdata('time_error', 'Time conflict. Creation Cancelled');
						$flag = 1;
					}
	
					if($time_end > $start && $time_end <= $end)
					{
						$this->session->set_flashdata('time_error', 'Time conflict. Creation Cancelled');
						$flag = 1;
					}

					if($subject == $i->subjectID)
					{
						$this->session->set_flashdata('time_error',"Already Exist: $weekday - $i->subject_name");
						$flag = 1;
					}
					
				}


			}


			if($flag != 0)
			{
				redirect("Admin/manage_schedule/$sectionID");
			}


			$sched_data = array(
				'sectionID' => $sectionID,
				'subjectID' => $this->input->post('subject'),
				'weekday' => $this->input->post('weekday'),
				'schedule_start' => $this->input->post('time_start'),
				'schedule_end' => $this->input->post('time_end'),
			);
			

			$this->Schedule->insert($sched_data);
			$this->session->set_flashdata('Success', 'Creation Success');
			redirect("Admin/manage_schedule/$sectionID");
		}
	}

	public function update_schedule($sectionID,$schedID)
	{
		$this->check_session();
		$this->form_validation->set_rules('time_start', 'Time Start', 'required');
		$this->form_validation->set_rules('time_end', 'Time End', 'required');

		$time_start = $this->input->post('time_start');
		$time_end = $this->input->post('time_end');
		$weekday = $this->input->post('weekday');
		$subject = $this->input->post('subject');

		if(!$this->form_validation->run())
		{
			$this->session->set_flashdata('time_error', 'Missing field inputs');
			redirect("Admin/manage_schedule/$sectionID");
		}
		else
		{
			$this->load->model('Schedule');
			switch (true) {
				case $time_start == $time_end:
					$this->session->set_flashdata('time_error', 'Time start should not be equal to Time End');
					redirect("Admin/manage_schedule/$sectionID");
					break;
	
				case $time_start >= $time_end:
					$this->session->set_flashdata('time_error', 'Time start should not be more than Time End');
					redirect("Admin/manage_schedule/$sectionID");
					break;
				
				default:
					# code...
					break;
			}

			$data_validate = $this->Schedule->get_schedule($sectionID);
			$flag = 0;
			foreach($data_validate as $i)
			{

				if($i->scheduleID != $schedID)
				{
					if($weekday == $i->weekday)
					{
						$create_start = date_create($i->schedule_start);
						$start = date_format($create_start,"h:i");
						$create_end = date_create($i->schedule_end);
						$end = date_format($create_end,"h:i");
						if($time_start <= $start && $time_end >= $end)
						{
							$flag = 1;
							$this->session->set_flashdata('time_error', 'Time conflict. Update Cancelled');
						}
						if($time_start >= $start && $time_start < $end)
						{
							$flag = 1;
							$this->session->set_flashdata('time_error', 'Time conflict. Update Cancelled');
						}
						if($time_end > $start && $time_end <= $end)
						{
							$flag = 1;
							$this->session->set_flashdata('time_error', 'Time conflict. Update Cancelled');
						}
						if($subject == $i->subjectID)
						{
							$this->session->set_flashdata('time_error',"Already Exist: $weekday - $i->subject_name");
							$flag = 1;
						}
					}
				}

			}

			if($flag != 0)
			{
				redirect("Admin/manage_schedule/$sectionID");
			}


			$sched_data = array(
				'sectionID' => $sectionID,
				'subjectID' => $this->input->post('subject'),
				'weekday' => $this->input->post('weekday'),
				'schedule_start' => $this->input->post('time_start'),
				'schedule_end' => $this->input->post('time_end'),
			);
			

			$this->Schedule->update($sched_data,$schedID);
			$this->session->set_flashdata('Success', 'Update Success');
			redirect("Admin/manage_schedule/$sectionID");
		}
	}

	public function edit_section($id)
	{
		$this->check_session();
		$this->load->model('Section');
		$data['section_data'] = $this->Section->get($id);
		$data['title'] = 'Edit Section';
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/edit_section');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_section($id)
	{
		$this->check_session();
		$this->load->model('Section');
		$this->form_validation->set_rules('name', 'Section Name', 'required|is_unique[section.sectionName]');
		if(!$this->form_validation->run())
		{
			$this->edit_section($id);
		}
		else
		{
			$data = array(
				'sectionName' => $this->input->post('name')
			);
			$this->Section->update($data,$id);
			$this->edit_section($id);
		}
	}

	public function delete_section($id)
	{
		$this->check_session();
		$this->load->model('Section');
		$this->Section->delete($id);
		redirect('Admin/manage_section');
	}
	

	public function check_session()
	{
		if($this->session->userdata['admin_logged_in'] == FALSE)
		{
			redirect('Login');
		}
	}
	

	public function manage_dataset($uid)
	{
		$this->check_session();
		$this->load->model('User');
		$user = $this->User->get_where($uid);
		foreach($user as $i):
			$data = array(
				'fname' => $i->fname,
				'mname' => $i->mname,
				'lname' => $i->lname,
			);
		endforeach;
		$this->load->model('File_upload','file');

		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/manage_dataset/".$uid;
		$config["total_rows"] = $this->file->count($uid);
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['pagination'] = $this->pagination->create_links();
        $data['face_data'] = $this->file->get_data($config["per_page"], $page, $uid);
		
		$data['uid'] = $uid;
		$data['title'] = "Manage Dataset";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_data');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}



	public function delete_file($foldername,$id)
	{
		$this->check_session();
		$this->load->model('File_upload', 'file');

		$query = $this->file->get_where($id);
		foreach($query as $i):
			$path = $i->img_path;
			$uid = $i->uid;
		endforeach;
		$this->file->delete($id);
		unlink("./dataset/".$foldername.'/'.$path);

		$this->manage_dataset($uid);
	}

	public function gate_logs()
	{
		$this->check_session();

		$data['select_date'] = 'all_logs';
		$data['roleID'] = 0;

		$date_value = date('Y-m-d');
		$this->load->model("Gatelog");
		$data['date_value'] = $date_value;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/gate_logs/";
		$config["total_rows"] = $this->Gatelog->all_count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->all_get($config["per_page"], $page);
		$data['title_viewed'] = "Manage Gatelogs";
		$data['title'] = "Manage Gatelogs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/gate_logs');
		$this->load->view('admin/pages/view_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function all_logs()
	{
		$this->check_session();

		$data['select_date'] = 'all_logs';
		$data['roleID'] = 0;

		$data['title_viewed'] = "Manage Gatelogs";
		$this->load->model("Gatelog");
		$date = ($this->input->post("date_select"))? $this->input->post("date_select"): date('Y-m-d');
		$date = ($this->uri->segment(3)) ? $this->uri->segment(3) : $date;
		$data['date_value'] = $date;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/all_logs/$date";
		$config["total_rows"] = $this->Gatelog->all_count($date);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->all_get($config["per_page"], $page, $date);
		$data['title'] = "Manage Gatelogs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/gate_logs');
		$this->load->view('admin/pages/view_logs');
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
		$fields = array('USERID', 'NAME' ,'ROLE', 'DATE', 'ENTRY-TIME', 'EXIT-TIME');
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
					$i->role_title,
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

		$data['select_date'] = 'student_date';
		$data['roleID'] = 2;

		$date_value = date('Y-m-d');
		$data['title_viewed'] = "Student Gatelogs";
		$this->load->model("Gatelog");
		$data['date_value'] = $date_value;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/student_logs/";
		$config["total_rows"] = $this->Gatelog->student_count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->student_get($config["per_page"], $page);
		$data['title'] = "Manage Gatelogs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/gate_logs');
		$this->load->view('admin/pages/view_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function student_date()
	{
		$this->check_session();

		$data['select_date'] = 'student_date';
		$data['roleID'] = 2;

		$data['title_viewed'] = "Student Gatelogs";
		$this->load->model("Gatelog");
		$date = ($this->input->post("date_select"))? $this->input->post("date_select"): date('Y-m-d');
		$date = ($this->uri->segment(3)) ? $this->uri->segment(3) : $date;
		$data['date_value'] = $date;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/student_date/$date";
		$config["total_rows"] = $this->Gatelog->student_count($date);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->student_get($config["per_page"], $page, $date);
		$data['title'] = "Manage Gatelogs";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/gate_logs');
		$this->load->view('admin/pages/view_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function teacher_logs()
	{
		$this->check_session();

		$data['select_date'] = 'teacher_date';
		$data['roleID'] = 3;


		$date_value = date('Y-m-d');
		$data['title_viewed'] = "Teacher Gatelogs";
		$this->load->model("Gatelog");
		$data['date_value'] = $date_value;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/teacher_logs/";
		$config["total_rows"] = $this->Gatelog->teacher_count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->teacher_get($config["per_page"], $page);
		$data['title'] = "Manage Attendance";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/gate_logs');
		$this->load->view('admin/pages/view_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function teacher_date()
	{
		$this->check_session();
		
		$data['select_date'] = 'teacher_date';
		$data['roleID'] = 3;

		$this->load->model("Gatelog");
		$data['title_viewed'] = "Teacher Gatelogs";
		$date = ($this->input->post("date_select"))? $this->input->post("date_select"): date('Y-m-d');
		$date = ($this->uri->segment(3)) ? $this->uri->segment(3) : $date;
		$data['date_value'] = $date;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/teacher_date/$date";
		$config["total_rows"] = $this->Gatelog->teacher_count($date);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->teacher_get($config["per_page"], $page, $date);
		$data['title'] = "Manage Attendance";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/gate_logs');
		$this->load->view('admin/pages/view_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function staff_logs()
	{
		$this->check_session();

		$data['select_date'] = 'staff_date';
		$data['roleID'] = 4;


		$date_value = date('Y-m-d');
		$data['title_viewed'] = "Staff Gatelogs";
		$this->load->model("Gatelog");
		$data['date_value'] = $date_value;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/staff_logs/";
		$config["total_rows"] = $this->Gatelog->staff_count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->staff_get($config["per_page"], $page);
		$data['title'] = "Manage Attendance";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/gate_logs');
		$this->load->view('admin/pages/view_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function staff_date()
	{
		$this->check_session();
		
		$data['select_date'] = 'staff_date';
		$data['roleID'] = 4;

		$this->load->model("Gatelog");
		$data['title_viewed'] = "Staff Gatelogs";
		$date = ($this->input->post("date_select"))? $this->input->post("date_select"): date('Y-m-d');
		$date = ($this->uri->segment(3)) ? $this->uri->segment(3) : $date;
		$data['date_value'] = $date;
		$config = array();
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/staff_date/$date";
		$config["total_rows"] = $this->Gatelog->staff_count($date);
		$config["per_page"] = 4;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['gatelog'] = $this->Gatelog->staff_get($config["per_page"], $page, $date);
		$data['title'] = "Manage Attendance";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/gate_logs');
		$this->load->view('admin/pages/view_logs');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	// public function e_logs_search()
	// {
	// 	$this->check_session();
	// 	$this->load->model('Classroom');
	// 	$data['class'] = $this->Classroom->select();
	// 	$this->load->model('Logs');

	// 	$search = ($this->input->post("search_employee"))? $this->input->post("search_employee"): '';
	// 	$search = ($this->uri->segment(4)) ? $this->uri->segment(4) : $search;
	// 	$type = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';

	// 	if($type != '')
	// 	{
	// 		$this->employee_logs();
	// 	}
	// 	else 
	// 	{
	// 		$config = array();
	// 		$config = $this->bootstrap_pagination();
	// 		$config["base_url"] =  base_url() . "Admin/e_logs_search/$type/$search";
	// 		$config["total_rows"] = $this->Logs->emp_count($type, $search);
	// 		$config["per_page"] = 4;
	// 		$config["uri_segment"] = 5;
	// 		$this->pagination->initialize($config);
	// 		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
	// 		$data['pagination'] = $this->pagination->create_links();
	// 		$data['logs'] = $this->Logs->emp_get($config["per_page"], $page, $type, $search);
	// 		$data['search'] = $search;
	// 		$data['tests'] = $type;
	// 		$data['type'] = array('Teacher', 'Janitor', 'Cook', 'Security');

	// 		$data['title'] = "Manage Logs";
	// 		$this->load->view('dashboard/header',$data);
	// 		$this->load->view('admin/side_nav');
	// 		$this->load->view('admin/nav');
	// 		$this->load->view('admin/pages/employee_logs');
	// 		$this->load->view('dashboard/footer_nav');
	// 		$this->load->view('dashboard/footer');
	// 	}
	// }

	// public function e_logs_go()
	// {
	// 	$this->check_session();
	// 	$this->form_validation->set_rules('type','Type', 'required');
	// 	if(!$this->form_validation->run())
	// 	{
	// 		$this->employee_logs();
	// 	}
	// 	else
	// 	{
	// 		redirect('Admin/employee_logs/'.$this->input->post('type'));
	// 	}
	// }

	public function go_back()
	{
		if(!$this->session->userdata('referred_from'))
		{
			redirect('Admin');
		}
		else
		{
			$referred_from = $this->session->userdata('referred_from');
			redirect($referred_from, 'refresh');
		}
	}


	public function manage_subject()
	{
		$this->check_session();

		$data['title_viewed'] = "Manage Subject";
		$config = array();
		$this->load->model('Subject');
		$config = $this->bootstrap_pagination();
		$config["base_url"] =  base_url() . "Admin/manage_subject";
		$config["total_rows"] = $this->Subject->count();
		$config["per_page"] = 4;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['subjects'] = $this->Subject->paginate($config["per_page"], $page);
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_subject');
		$this->load->view('admin/pages/subject_list');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function add_subject()
	{
		$this->check_session();
		$data['title_viewed'] = "Manage Subject";
		$this->load->model('Gradelevel');
		$data['gradelevel'] = $this->Gradelevel->select();
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/manage_subject');
		$this->load->view('admin/pages/create_subject');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function create_subject()
	{
		$this->check_session();
		$this->load->model('Subject');
		$this->form_validation->set_rules('name','Subject Name', 'required|is_unique[subject.subject_name]');
		$this->form_validation->set_rules('year_level','Year/Grade level', 'required');
		if(!$this->form_validation->run())
		{
			$this->check_session();
			$data['title_viewed'] = "Manage Subject";
			$this->load->model('Gradelevel');
			$data['gradelevel'] = $this->Gradelevel->select();
			$data['title'] = "Admin Dashboard";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/manage_subject');
			$this->load->view('admin/pages/create_subject');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
			$subject_data = array(
				'subject_name' => $this->input->post('name'),
				'gradelevelID' => $this->input->post('year_level'),
				'subject_description' => $this->input->post('description'),
				'subject_datecreated' => date('Y-m-d'),
			);

			$this->Subject->insert($subject_data);

			$this->session->set_flashdata('Success', 'Creation Success');
			redirect('Admin/add_subject');
		}
	}

	public function subject_view($id)
	{
		$this->check_session();
		$data['title_viewed'] = "Manage Subject";
		$this->load->model('Subject');
		$data['subject_view'] =true;
		$data['subject'] = $this->Subject->get_this_subject($id);
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/subject_container');
		$this->load->view('admin/pages/subject_view');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}


	public function subject_edit($id)
	{
		$this->check_session();
		$data['title_viewed'] = "Manage Subject";
		$this->load->model('Subject');
		$this->load->model('Gradelevel');
		$data['subject_edit'] =true;
		$data['gradelevel'] = $this->Gradelevel->select();
		$data['subject'] = $this->Subject->get_this_subject($id);
		$data['title'] = "Admin Dashboard";
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/subject_container');
		$this->load->view('admin/pages/edit_subject');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_subject($id)
	{
		$this->check_session();
		$this->load->model('Subject');
		$this->form_validation->set_rules('name','Subject Name', 'required|is_unique[subject.subject_name]');
		$this->form_validation->set_rules('year_level','Year/Grade level', 'required');

		$data = array(
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description'),
		);
		if(!$this->form_validation->run())
		{
			$this->check_session();
			$data['title_viewed'] = "Manage Subject";
			$this->load->model('Subject');
			$this->load->model('Gradelevel');
			$data['subject_edit'] =true;
			$data['gradelevel'] = $this->Gradelevel->select();
			$data['subject'] = $this->Subject->get_this_subject($id);
			$data['title'] = "Admin Dashboard";
			$this->load->view('dashboard/header',$data);
			$this->load->view('admin/side_nav');
			$this->load->view('admin/nav');
			$this->load->view('admin/pages/subject_container');
			$this->load->view('admin/pages/edit_subject');
			$this->load->view('dashboard/footer_nav');
			$this->load->view('dashboard/footer');
		}
		else
		{
			$subject_data = array(
				'subject_name' => $this->input->post('name'),
				'gradelevelID' => $this->input->post('year_level'),
				'subject_description' => $this->input->post('description'),
			);

			$this->Subject->update($subject_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->subject_view($id);
		}
	}

	public function delete_subject($id)
	{
		$this->check_session();
		$this->load->model('Subject');
		$this->Subject->delete($id);
		$this->manage_subject();
	}

	public function settings()
	{
		$this->check_session();
		$this->load->model('School');
		$this->load->model('Schoolyear');
		$this->load->model(array('School','Schoolyear','Gate_settings'));
		$data['school'] = $this->School->select();
		$data['schoolyear'] = $this->Schoolyear->select();
		$data['gate_settings'] = $this->Gate_settings->select();

		$data['title_viewed'] = "School Settings";
		$data['title'] = "Manage School";
		$data['school_setting'] = true;
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/settings');
		$this->load->view('admin/pages/manage_settings');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}

	public function update_school($id)
	{
		$this->check_session();
		$this->load->model('School');

		$this->form_validation->set_rules('name','School name', 'required');
		$this->form_validation->set_rules('address','School address', 'required');
		if(!$this->form_validation->run())
		{
			$this->settings();
		}
		else
		{
			$subject_data = array(
				'school_name' => $this->input->post('name'),
				'school_address' => $this->input->post('address'),
				'school_description' => $this->input->post('description'),
			);

			$this->School->update($subject_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->settings();
		}



	}


	public function update_year($id)
	{
		$this->check_session();
		$this->load->model('Schoolyear');

		$this->form_validation->set_rules('start_year','Start year', 'required');
		$this->form_validation->set_rules('end_year','End year', 'required');
		if(!$this->form_validation->run())
		{
			$this->settings();
		}
		else
		{
			$subject_data = array(
				'start_year' => $this->input->post('start_year'),
				'end_year' => $this->input->post('end_year'),
			);

			$this->Schoolyear->update($subject_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->settings();
		}



	}


	public function update_gate($id)
	{
		$this->check_session();
		$this->load->model('Gate_settings');

		$this->form_validation->set_rules('gate_entry','Gate Settings', 'required');

		if(!$this->form_validation->run())
		{
			$this->settings();
		}
		else
		{
			$subject_data = array(
				'entry_settings' => $this->input->post('gate_entry'),
			);

			$this->Gate_settings->update($subject_data,$id);

			$this->session->set_flashdata('Success', 'Update Success');
			$this->settings();
		}

	}


	public function calendar($year = NULL , $month = NULL)
	{
		$this->check_session();
		$this->load->model('Mycal_model','mycal');


		$prefs = array(
			'show_next_prev' => TRUE,
			'next_prev_url'   => base_url('admin/calendar/')
		);
		$prefs['template'] = $this->mycal->calendar_template();
		$this->load->library('calendar', $prefs);
		$data['calendar'] = $this->calendar->generate($year , $month);

		$data['title_viewed'] = "School Settings";
		$data['title'] = "Manage School";
		$data['school_calendar'] = true;
		$this->load->view('dashboard/header',$data);
		$this->load->view('admin/side_nav');
		$this->load->view('admin/nav');
		$this->load->view('admin/pages/settings');
		$this->load->view('admin/pages/manage_calendar');
		$this->load->view('dashboard/footer_nav');
		$this->load->view('dashboard/footer');
	}



}
