<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller {


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
	 	$data['patient']  = $this->patient_m->patient();
		$this->load->view('base/head');
		$this->load->view('patient/index', $data);
		$this->load->view('base/footer');
	}

	public function add_patient(){
		$session_data = $this->session->userdata('sessed_in');
	 	if ($session_data == '') {
	 		redirect('/auth');
	 	}
	 	$data['dentist']  = $this->patient_m->dentist();
		$this->load->view('base/head');
		$this->load->view('patient/add_patient', $data);
		$this->load->view('base/footer');
	} 

	public function insert_patient(){
		$data = $this->input->post();
		
		$check_patient = $this->patient_m->check_patient($data['no_card'],$data['no_card_patient']);

		if(count($check_patient) > 0){
			$return['status'] 	= false;
			$return['message'] 	= 'เลขประจำตัวประชาชน หรือ เลขที่บัตร มีในระบบแล้ว'; 
		}else{
			$data_insert = array(
				'no_card' => $data['no_card'],
				'no_card_patient' => $data['no_card_patient'],
				'full_name' => $data['full_name'],
				'phone'   => $data['phone'],
				'be_allergic' => $data['be_allergic'],
				'ref_dentist_id' => $data['ref_dentist_id']
			);
			$query = $this->db->insert('patient', $data_insert);
			$return = array();
			if ($query) {
				$return['status'] 	= true;
				$return['message'] 	= 'เพิ่มคนไข้ร้อยแล้ว'; 
			}else{
				$return['status'] 	= false;
				$return['message'] 	= 'เพิ่มคนไข้ไม่สำเร็จ';
			}
		}	
		
		echo json_encode($return);
	}

	public function getdata(){
		$id = $this->uri->segment(3); 
		$data = $this->patient_m->get_patient($id); 
		echo json_encode($data);
	}

	public function from_edit_patient(){
		$session_data = $this->session->userdata('sessed_in');
	 	if ($session_data == '') {
	 		redirect('/auth');
	 	}
	 	$id = $this->uri->segment(3); 
        $data['patient']  = $this->patient_m->get_patient($id);
        $data['dentist']  = $this->patient_m->dentist();
        $this->load->view('base/head');
		$this->load->view('patient/from_edit_patient', $data);
		$this->load->view('base/footer');
	}

	public function edit_patient(){ 
		$data = $this->input->post();

	
		$data_update = array(
			'no_card' => $data['no_card'],
			'no_card_patient' => $data['no_card_patient'],
			'full_name' => $data['full_name'],
			'phone'   => $data['phone'],
			'be_allergic' => $data['be_allergic'],
			'ref_dentist_id' => $data['ref_dentist_id']
		);

		$this->db->where("id_patient", $data['id']);
		$query = $this->db->update("patient",$data_update);
		$return = array();
		if ($query) {
			$return['status'] 	= true;
			$return['message'] 	= 'แก้ข้อมูลคนไข้ร้อยแล้ว'; 
		}else{
			$return['status'] 	= false;
			$return['message'] 	= 'แก้ข้อมูลคนไข้ไม่สำเร็จ';
		}

		echo json_encode($return);
	}

	public function avatar(){
		$data = $this->input->post();

		$date = date("Ymdhis");
		$temp_user = "imges/avatar/";
		$file_name = "";
		
		if($_FILES["avatar"]["size"]>0){
			if(move_uploaded_file($_FILES["avatar"]["tmp_name"],$temp_user.$date."_".$_FILES["avatar"]["name"])){
				$file_name = $date."_".$_FILES["avatar"]["name"];
			}
		}

		$data_update = array(
			'avatar' => $file_name
		);
		$this->db->where("id_patient", $data['id_patient']);
        $query = $this->db->update("patient",$data_update);
		echo base_url().$temp_user.$file_name;


	}

	public function updatemobile(){
		$inputJSON = file_get_contents('php://input');
		$input = json_decode($inputJSON, TRUE);

		
		$data_update = array(
			'full_name' => $input['full_name'],
			'phone'   => $input['phone'],
			'be_allergic' => $input['be_allergic']
		);

		$this->db->where("id_patient", $input['id_patient']);
        $query = $this->db->update("patient",$data_update);
		$return = array();
		if ($query) {
			$return['status'] 	= true;
			$return['message'] 	= 'แก้ข้อมูลคนไข้ร้อยแล้ว'; 
		}else{
			$return['status'] 	= false;
			$return['message'] 	= 'แก้ข้อมูลคนไข้ไม่สำเร็จ';
		}

		echo json_encode($return);


	}


	public function history(){
		$session_data = $this->session->userdata('sessed_in');
	 	if ($session_data == '') {
	 		redirect('/auth');
	 	}
		$id_patient = $this->uri->segment(3); 
		$data['patient']  = $this->patient_m->get_patient($id_patient);
		$data['history'] = $this->shifts_m->history_patient($id_patient);
        $this->load->view('base/head');
		$this->load->view('patient/history', $data);
		$this->load->view('base/footer');
	}

	public function trash(){
		$id = $this->uri->segment(3);
		$this->db->where('id_patient', $id);
		$query = $this->db->delete('patient');

		$return = array();
		if ($query) {
			$return['status'] 	= true;
			$return['message'] 	= 'ลบข้อมูลร้อยแล้ว'; 
		}else{
			$return['status'] 	= false;
			$return['message'] 	= 'ลบข้อมูลไม่สำเร็จ';
		}

		echo json_encode($return);
	}
}
