<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verification extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form','string'));
		$this->load->library(array('form_validation', 'session',));
	}

	
	public function index()
	{
		$data['title'] = "User Activation";

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => $this->config->item('email'),
			'smtp_pass' => $this->config->item('password'),
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);
		
		// Send Email Verificaition
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from('no-reply@recogu.com', 'Verification');
		$this->email->to($this->session->flashdata('temp_email'));
		$this->email->subject('Send Email Codeigniter');
		$message = $this->send_verification($this->session->flashdata('temp_id'),$this->session->flashdata('temp_activation_code'));
		$this->email->message($message);
		$this->email->send();

		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('activation');
		$this->load->view('includes/footer');
	}

	public function activated()
	{
		$data['title'] = "User Activated";
		$this->load->view('includes/header',$data);
		$this->load->view('includes/nav');
		$this->load->view('activated');
		$this->load->view('includes/footer');
	}


	public function activation($id, $activation_code)
	{
		$this->load->model('User');
		$data = array(
			'status' => 1
		);
		$this->User->activate($data,$id,$activation_code);
		$this->activated();
	}


    public function send_verification($id,$activation_code)
    {
		$link = base_url('Verification/activation/'.$id.'/'.$activation_code);
        return $message = '
		<!doctype html>
		<html lang="en">
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
			<title><?=$title ?>
			</title>
			<link rel="stylesheet" href="css/bootstrap.min.css">
			<link rel="stylesheet" href="<?=base_url()?>assets/css/custom.css">
			<link rel="preconnect" href="https://fonts.googleapis.com">
			<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
			<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
			<link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
			<script src="https://kit.fontawesome.com/f91d0aa7c6.js" crossorigin="anonymous"></script>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
		</head>
		<body>
		<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: \'Lato\', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We\'re thrilled to have you here! Get ready to dive into your new account. </div>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<!-- LOGO -->
			<tr>
				<td bgcolor="#FFA73B" align="center">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
						<tr>
							<td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
						<tr>
							<td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
								<h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1> <h1 style="font-size: 50px;"><i class="fa-solid fa-circle-check"></i></h1>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
						<tr>
							<td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
								<p style="margin: 0;">We\'re excited to have you get started your User ID is <span class = "text-primary">'.$id.'</span>. First, you need to confirm your account. Just press the button below.</p>
							</td>
						</tr>
						<tr>
							<td bgcolor="#ffffff" align="left">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
											<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td align="center" style="border-radius: 3px;" bgcolor="#FFA73B"><a href="'.$link.'" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FFA73B; display: inline-block;">Confirm Account</a></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr> <!-- COPY -->
						<tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
						<tr>
							<td bgcolor="#FFECD1" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: \'Lato\', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
								<h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Thank you for registering</h2>
								<p style="margin: 0;"><a href="'.$link.'" target="_blank" style="color: #FFA73B;">Activate</a></p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
		</body>
		</html>

				';
    }





}