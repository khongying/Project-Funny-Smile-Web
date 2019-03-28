<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dentist extends CI_Controller {

  
	public function __construct() { 
        parent::__construct();
        $this->load->model('dentist_m');
	}	

	public function index(){
		$session_data = $this->session->userdata('sessed_in');
	 	if ($session_data == '') {
	 		redirect('/auth');
		}
		$data['dentis']  = $this->dentist_m->dentis();
		$this->load->view('base/head');
		$this->load->view('dentist/index', $data);
		$this->load->view('base/footer');
	}

	public function add_dentist(){
		$session_data = $this->session->userdata('sessed_in');
	 	if ($session_data == '') {
	 		redirect('/auth');
	 	}
        $data['dentis_type']  = $this->dentist_m->dentis_type();
        $this->load->view('base/head');
		$this->load->view('dentist/add_dentist', $data);
		$this->load->view('base/footer');
	}

	public function insert_dentist(){
		$data = $this->input->post();

		$data_insert = array(
			'dentist_number' => $data['dentist_number'],
			'dentist_gender' => $data['dentist_gender'],
			'fname' => $data['fname'],
			'lname' => $data['lname'],
			'dentist_type'   => $data['dentist_type']
		);
		$query = $this->db->insert('dentist', $data_insert);
		$return = array();
		if ($query) {
			$return['status'] 	= true;
			$return['message'] 	= 'เพิ่มทันตแพทย์ร้อยแล้ว'; 
		}else{
			$return['status'] 	= false;
			$return['message'] 	= 'เพิ่มทันตแพทย์ไม่สำเร็จ';
		}

		echo json_encode($return);
	}

	public function getdata(){
		$id = $this->uri->segment(3); 
		$data = $this->dentist_m->get_dentis($id); 
		echo json_encode($data);
	}

	public function from_edit_dentist(){
		$session_data = $this->session->userdata('sessed_in');
	 	if ($session_data == '') {
	 		redirect('/auth');
	 	}
	 	$id = $this->uri->segment(3); 
        $data['dentis']  = $this->dentist_m->get_dentis($id);
        $data['dentis_type']  = $this->dentist_m->dentis_type();
        $this->load->view('base/head');
		$this->load->view('dentist/from_edit_dentist', $data);
		$this->load->view('base/footer');
	}

	public function edit_dentist(){
		$data = $this->input->post();
		$data_update = array(
			'dentist_number' => $data['dentist_number'],
			'dentist_gender' => $data['dentist_gender'],
			'fname' => $data['fname'],
			'lname' => $data['lname'],
			'dentist_type'   => $data['dentist_type']
		);
		$this->db->where("id", $data['id']);
        $query = $this->db->update("dentist",$data_update);
		$return = array();
		if ($query) {
			$return['status'] 	= true;
			$return['message'] 	= 'แก้ไขข้อมูลทันตแพทย์ร้อยแล้ว'; 
		}else{
			$return['status'] 	= false;
			$return['message'] 	= 'แก้ไขข้อมูลทันตแพทย์ไม่สำเร็จ';
		}

		echo json_encode($return);
	}

	public function trash(){
		$id = $this->uri->segment(3);
		$this->db->where('id', $id);
		$query = $this->db->delete('dentist');

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
