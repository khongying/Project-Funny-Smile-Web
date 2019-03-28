<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


	public function __construct() { 
		parent::__construct();
		$this->load->model('auth_m');
	}	

	public function index(){
		$this->load->view('auth/head');
		$this->load->view('auth/login');
		$this->load->view('auth/footer');
	}

	public function chk_login(){
		$email = $this->input->post('email');
		$pass = $this->input->post('password');
		$res  = $this->auth_m->check_login($email, $pass);
		$respone = array();
		if ($res['status'] == true) {
			$this->session->set_userdata('sessed_in',$res['session']);
			$reponse['status'] = $res['status'];
			$reponse['message'] = $res['message'];
			$reponse['email'] = $res["session"][0]['email'];
			$reponse['user_name'] = $res["session"][0]['user_name'];
		}else{
			$reponse['status']  = $res['status'];
			$reponse['message'] = $res['message'];
		}
		
		echo json_encode($res);
	}

	public function logout(){
		$this->session->unset_userdata('sessed_in');
		redirect('/');
	}


	public function patient_login(){
		$inputJSON = file_get_contents('php://input');
		$input = json_decode($inputJSON, TRUE);
		$res  = $this->auth_m->patient_login($input['no_card'], $input['no_card_patient']);
		$respone = array();
		if ($res['status'] == true) {
			$reponse['status'] = $res['status'];
			$reponse['message'] = $res['message'];
			$reponse['data'] = $res['data'];
		}else{
			$reponse['status']  = $res['status'];
			$reponse['message'] = $res['message'];
		}
		
		echo json_encode($res);
	}

}
