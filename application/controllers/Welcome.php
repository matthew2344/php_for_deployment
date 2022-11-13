<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('form_validation', 'session',));
	}

	public function index()
	{
		$data['title'] = "Home";
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('home');
		$this->load->view('includes/footer_nav');
		$this->load->view('includes/footer');
	}

	public function test()
	{
		$data['title'] = "Home";
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('test');
		$this->load->view('includes/footer_nav');
		$this->load->view('includes/footer');
	}
	public function test2($year = NULL , $month = NULL)
	{
		$data['title'] = "Home";

		$this->load->model('Mycal_model');
		$data['calender'] = $this->Mycal_model->getcalender($year , $month);
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('test2');
		$this->load->view('includes/footer_nav');
		$this->load->view('includes/footer');
	}
	
	public function capture()
	{
		if(isset($_FILES["webcam"]["tmp_name"]))
		{
			$tmpName = $_FILES["webcam"]["tmp_name"];
			$imageName = date('Ymdhis').'.jpeg';
			move_uploaded_file($tmpName, 'uploads/'. $imageName);

		}
	}

	public function test_post()
	{
		$array_start = array();
		$count_input = count($this->input->post('start'));
		for($i = 0; $i < $count_input; $i++)
		{
			array_push($array_start, array(
				'subject' => $this->input->post('sample')[$i],
				'start' => $this->input->post('start')[$i],
				'end' => $this->input->post('end')[$i],
			));
		}


		// $this->session->set_flashdata('Success', "");
		// $this->test2();
		print_r($array_start);
	}







}
