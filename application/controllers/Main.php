<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


	public function __construct() { 
		parent::__construct();
		$this->load->model('dentist_m');
		$this->load->model('patient_m');
		$this->load->model('shifts_m');
	}	

	public function index(){
		$session_data = $this->session->userdata('sessed_in');
	 	if ($session_data == '') {
	 		redirect('/auth');
		 }

		$data['dentis']  = count($this->dentist_m->dentis());
		$data['patient']  = count($this->patient_m->patient());
		$data['claim'] = count($this->shifts_m->request());
		$this->load->view('base/head');
		$this->load->view('base/index', $data);
		$this->load->view('base/footer');
	}
}
