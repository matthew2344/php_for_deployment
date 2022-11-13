<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile_handler extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'string'));
		$this->load->library(array('form_validation', 'session',));
	}

    public function login()
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
                $role = $result->role_title;
                $status = $result->status;
            }

            if($role != "Teacher")
            {
                echo "Not Teacher";
            }
            elseif($status == 0)
            {
                echo "Not Activated";
            }
            else
            {
                echo "Success";
            }

        }
        else
        {
            echo "Invalid Credentials";
        }

    }

    public function getSubject($uid="202200020")
    {
        $this->load->model('Teach');
        $data = $this->Teach->select_teach($uid);
        
        header('Content-Type: application/json');
        // echo json_encode($data);
        echo json_encode($data);
    }


}