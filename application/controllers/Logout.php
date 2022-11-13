<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form', 'string'));
		$this->load->library(array('form_validation', 'session',));
	}

    public function index()
    {
		// DESTROYS USERDATA SESSIONS AND REDIRECTED TO LOGIN PAGE
        $this->session->sess_destroy();
        redirect('Login');
    }


}