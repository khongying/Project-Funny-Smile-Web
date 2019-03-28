<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {


	public function __construct() { 
        parent::__construct();
        $this->load->model('patient_m');
        $this->load->model('shifts_m');
	}	

	public function index(){
		$session_data = $this->session->userdata('sessed_in');
	 	if ($session_data == '') {
	 		redirect('/auth');
		}
		$data['dentist']  = $this->patient_m->dentist();
		$data['time'] = array(
			array("10.00","10.30"),
			array("10.30","11.00"),
			array("11.00","11.30"),
			array("11.30","12.00"),
			array("12.00","12.30"),
			array("12.30","13.00"), 
			array("13.00","13.30"),
			array("13.30","14.00"),
			array("14.00","14.30"),
			array("14.30","15.00"),
			array("15.00","15.30"),
			array("15.30","16.00"),
			array("16.00","16.30"),
			array("16.30","17.00"),
			array("17.00","17.30"),
			array("17.30","18.00"),
			array("18.00","18.30"),
			array("18.30","19.00"),
			array("19.00","19.30"),
			array("19.30","20.00")
		);
		$this->load->view('base/head');
		$this->load->view('appointment/index',$data);
		$this->load->view('base/footer');
	}

	public function dentisrt(){
		$id = $this->uri->segment(3);
		$patient = $this->patient_m->patient_find($id);
		echo json_encode($patient);
	}

	public function dentisrt_date(){
		$date = $this->uri->segment(3);
		$id_dentisrt = $this->uri->segment(4);
		$due_date = $this->shifts_m->due_date($date,$id_dentisrt);
		echo json_encode($due_date);
	}


	
}
