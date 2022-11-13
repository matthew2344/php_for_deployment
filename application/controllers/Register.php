<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form','string'));
		$this->load->library(array('form_validation', 'session',));
	}

    public function index()
	{
		$data['title'] = "Register";
		$data['navlink'] = base_url('Welcome/auth');
        $this->load->model('Gradelevel');
        $data['gradelevel'] = $this->Gradelevel->select();
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('register');
		$this->load->view('regstudent');
		$this->load->view('includes/footer');
	}

    public function teacher()
	{
		$data['title'] = "Register";
		$data['navlink'] = base_url('Welcome/auth');

		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('register');
		$this->load->view('regteach');
		$this->load->view('includes/footer');
	}

    public function staff()
	{
		$data['title'] = "Register";
		$data['navlink'] = base_url('Welcome/auth');
        $this->load->model('Stafftype');
        $data['stafftype'] = $this->Stafftype->select();
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('register');
		$this->load->view('regstaff');
		$this->load->view('includes/footer');
	}

    public function admin()
	{
		$data['title'] = "Register";
		$data['navlink'] = base_url('Welcome/auth');

		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('register');
		$this->load->view('regadmin');
		$this->load->view('includes/footer');
	}


    public function new_user()
    {
        $this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');

        if(!$this->form_validation->run())
        {
            $this->index();
        }
        else
        {
            $data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'role' => 'Admin',
                'avatar' => 'profile_pic.jpg',
                'datecreated' => date('Y-m-d'),
                'activation_code' => random_string('alnum', 16),
                'password' => sha1($this->input->post('password')),
            );

            $last_id = $this->User->insert($data);

			$flash_data = array(
				'temp_email' => $data['email'],
				'temp_activation_code' => $data['activation_code'],
				'temp_id' => $last_id,
			);
			$this->session->set_flashdata($flash_data);
			redirect('Verification');
        }
    }

	public function new_student()
    {
        $this->load->model('User');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('mname', 'Middle name', 'required');
        $this->form_validation->set_rules('lname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]');
		$this->form_validation->set_rules('phone', 'Phone number', 'required|regex_match[/^(09|\+639)\d{9}$/]');
		$this->form_validation->set_rules('bday', 'Birth date', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|max_length[4]');
		$this->form_validation->set_rules('grade_level', 'Grade level', 'required');
		$this->form_validation->set_rules('previous_school', 'Previous School', 'required');
		$this->form_validation->set_rules('previous_school_address', 'Previous School Address', 'required');
		$this->form_validation->set_rules('guardian_fname', 'Guardian First name', 'required');
		$this->form_validation->set_rules('guardian_mname', 'Guardian Middle name', 'required');
		$this->form_validation->set_rules('guardian_lname', 'Guardian Last name', 'required');
		$this->form_validation->set_rules('guardian_email', 'Guardian Email', 'required');
		$this->form_validation->set_rules('guardian_phone', 'Guardian Phone number', 'required|regex_match[/^(09|\+639)\d{9}$/]');

        $data = array(
            'fname' => $this->input->post('fname'),
            'mname' => $this->input->post('mname'),
            'lname' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'bday' => $this->input->post('bday'),
            'address' => $this->input->post('address'),
            'zipcode' => $this->input->post('zipcode'),
            'grade_level' => $this->input->post('grade_level'),
            'previous_school' => $this->input->post('previous_school'),
            'previous_school_address' => $this->input->post('previous_school_address'),
            'guardian_fname' => $this->input->post('guardian_fname'),
            'guardian_mname' => $this->input->post('guardian_mname'),
            'guardian_lname' => $this->input->post('guardian_lname'),
            'guardian_email' => $this->input->post('guardian_email'),
            'guardian_phone' => $this->input->post('guardian_phone'),
        );

        if(!$this->form_validation->run())
        {
            // $this->index();
            $data['title'] = "Register";
            $data['navlink'] = base_url('Welcome/auth');
            $this->load->model('Gradelevel');
            $data['gradelevel'] = $this->Gradelevel->select();
            $this->load->view('includes/header',$data);
            $this->load->view('includes/nav');
            $this->load->view('register');
            $this->load->view('regstudent');
            $this->load->view('includes/footer');
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
                'status' => 0,
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
            $this->load->model('Previous_school', 'Prev');
            $data_prev_school = array(
                'userID' => $last_id,
                'school_name' => $this->input->post('previous_school'),
                'school_address' => $this->input->post('previous_school_address'),
            );
            $this->Prev->insert($data_prev_school);
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

			redirect('Register');
        }
    }


	public function new_admin()
	{
		$this->load->model('User');
		$this->load->model('Address');
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
            $data['title'] = "Register";
            $data['navlink'] = base_url('Welcome/auth');
    
            $this->load->view('includes/header',$data);
            $this->load->view('includes/nav');
            $this->load->view('register');
            $this->load->view('regadmin');
            $this->load->view('includes/footer');
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


			redirect('Register/new_admin');
        }
	}

	public function new_teacher()
	{
		$this->load->model('User');
		$this->load->model('Address');
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
            $data['title'] = "Register";
            $data['navlink'] = base_url('Welcome/auth');
    
            $this->load->view('includes/header',$data);
            $this->load->view('includes/nav');
            $this->load->view('register');
            $this->load->view('regteach');
            $this->load->view('includes/footer');
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
                'status' => 0,
                'roleID' => 3,
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
                'avatar' => 'profile_pic.jpg',
                'datecreated' => date('Y-m-d'),
                'password' => sha1($access_code),
            );

            $this->User->insert($user_data);


			redirect('Register/new_teacher');
        }
	}

	public function new_staff()
	{
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
            $data['title'] = "Register";
            $data['navlink'] = base_url('Welcome/auth');
            $this->load->model('Stafftype');
            $data['stafftype'] = $this->Stafftype->select();
            $this->load->view('includes/header',$data);
            $this->load->view('includes/nav');
            $this->load->view('register');
            $this->load->view('regstaff');
            $this->load->view('includes/footer');
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
                'status' => 0,
                'roleID' => 4,
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
                'avatar' => 'profile_pic.jpg',
                'datecreated' => date('Y-m-d'),
                'password' => sha1($access_code),
            );

            $last_id = $this->User->insert($user_data);
            $this->load->model('Staff');

            $staff_data = array(
                'userID' => $last_id,
                'stafftypeID' => $this->input->post('staff_type'),
            );

            $this->Staff->insert_staff($staff_data);

			redirect('Register/new_staff');
        }
	}
}