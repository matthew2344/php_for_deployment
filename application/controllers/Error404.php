<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// 
// CONTORLLER OF ERROR404
// ---[USE CASE SCENARIO]---
// DISPLAY WHEN SPECIFIC LINK OR PAGE REQUEST IS NON-EXISTENT
// 
// ---[FUNCTIONS]---
// construct() -> LINE 16
// index() -> LINE 23
// link_configure() -> LINE 35
// ------[END]------
// 
class Error404 extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->library(array('session',));
	}

    public function index()
    {
		$data = $this->link_configure();
        $data['title'] = "Error 404";
		
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('errors/error404');
		$this->load->view('includes/footer_nav');
		$this->load->view('includes/footer');
    }

	public function link_configure()
	{
		if(isset($this->session->userdata['admin_logged_in']))
		{
			return array(
				'back_link' => base_url('Admin'),
				'navtitle' => 'Go Back',
			);
		}
		elseif(isset($this->session->userdata['student_logged_in']))
		{
			return array(
				'back_link' => base_url('Student'),
				'navtitle' => 'Go Back',
			);
		}
		elseif(isset($this->session->userdata['teacher_logged_in']))
		{
			return array(
				'back_link' => base_url('Teacher'),
				'navtitle' => 'Go Back',
			);
		}
		else
		{
			return array(
				'back_link' => base_url('Login'),
				'navtitle' => 'Go Back',
			);
		}
	}
}
