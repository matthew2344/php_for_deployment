<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'string'));
		$this->load->library(array('form_validation', 'session',));
	}

	public function index()
	{
		$data['title'] = "Login";
		$data['navlink'] = base_url('Welcome/auth');
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('login');
		$this->load->view('includes/footer_nav');
		$this->load->view('includes/footer');
	}



    public function auth()
    {
        $this->form_validation->set_rules('userID', 'User ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if(!$this->form_validation->run())
		{
			$this->auth();
		}
        else
        {
            $data = array(
				'userID' => $this->input->post('userID'),
				'password' => sha1($this->input->post('password')),
			);


            $this->load->model('User');
            if($results = $this->User->login1($data))
            {
                // VALID LOGIN
                foreach($results as $result)
                {
                    $newdata = array(
                        'uid' => $result->userID,
                        'fname' => $result->fname,
                        'mname' => $result->mname,
                        'lname' => $result->lname,
                        'email' => $result->email,
                        'role' => $result->role_title,
                        'avatar' => $result->avatar,
                        'status' => $result->status,
                    );
                }
                $this->session->set_userdata($newdata);
                $this->redirect_user($this->session->userdata['role'],$this->session->userdata['status']);
            }
            else
            {
                // INVALID LOGIN
                $this->session->set_flashdata('error', 'Invalid Login Credentials');
                $this->index();
            }
        }
    }

    public function redirect_user($usertype,$status)
    {
        switch($usertype)
        {
            case "Admin":
                if($status == 0){
                    $this->session->set_flashdata('error', 'User not activated');
                    $this->index();
                } else {
                    $this->session->set_userdata('admin_logged_in', TRUE);
                    redirect('Admin');
                }
                break;
            case "Teacher":
                if($status == 0)
                {
                    $this->session->set_flashdata('error', 'User not activated');
                    $this->index();
                }
                else
                {
                    $this->session->set_userdata('teacher_logged_in', TRUE);
                    redirect('Teacher');
                }
                break;
            case "Staff":
                $this->load->model('Staff');
                if($status == 0)
                {
                    $this->session->set_flashdata('error', 'User not activated');
                    $this->index();
                }
                else
                {

                    if($result = $this->Staff->get_title($this->session->userdata['uid']))
                    {
                        foreach($result as $i)
                        {
                            if($i->staff_title == 'Security')
                            {
                                $this->session->set_userdata('security_logged_in', TRUE);
                                redirect('Security');
                            }
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'User not Security');
                        $this->index();
                    }
                }
                break;
            case "Student":
                if($status == 0)
                {
                    $this->session->set_flashdata('error', 'User not activated');
                    $this->index();
                }
                else
                {
                    $this->session->set_userdata('student_logged_in', TRUE);
                    redirect('Student');
                }
                break;
            default:
                $this->index();
            
        }

    }
}