<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Controller {


	public function __construct() { 
        parent::__construct();
        $this->load->model('shifts_m');
        $this->load->model('claim_m');
	}	

	public function index(){
		$data['claim'] = $this->shifts_m->request();
		$this->load->view('base/head');
		$this->load->view('request/index',$data);
		$this->load->view('base/footer');
	}

	
	public function claim(){
		$session_data = $this->session->userdata('sessed_in');
	 	if ($session_data == '') {
	 		redirect('/auth');
	 	}
	 	$id = $this->uri->segment(3); 
	 	$data['claim'] = $this->claim_m->claim_shifts($id);


	 	$shifts_id = $data['claim'][0]['ref_id_shift'];
	 	$data['shifts'] = $this->shifts_m->shifts($shifts_id);
	 
	 
		$this->load->view('base/head');
		$this->load->view('request/claim',$data);
		$this->load->view('base/footer');
	}

	public function update_shifts(){
		$data = $this->input->post();
		$data_update = array(
				'date' => $data['update']['claim_date'],
				'time' => $data['update']['claim_time'],
				'state' => 'Wait'
			);
		$this->db->where("id_shifts", $data['update']['shifts_id']);
		$query = $this->db->update("shifts",$data_update);
		
		if ($query) {
			$claim_update = array(
				'state' => "Approved"
			);
			$this->db->where("id_claim", $data['update']['claim_id']);
			$query_claim = $this->db->update("claim_shifts",$claim_update);
			
			$data_notification = array(
				'text' => "เราได้ทำการเลื่อนนัดให้คุณเรียบร้อยแล้ว",
				'date' => date("Y-m-d"),
				'status' => "true",
				'ref_patient' => $data['update']['ref_patient'],
			);

			$notification_info = array(
				'text' => "คุณมีนัดทำฟัน ".$data['update']['claim_date']." เวลา".$data['update']['claim_time']."น.",
				'date' => $data['update']['claim_date'],
				'status' => "true",
				'ref_patient' => $data['update']['ref_patient'],
			);

			$this->db->insert('notification', $notification_info);
			$this->db->insert('notification', $data_notification);


			
			if ($query_claim) {
				$return['status'] 	= true;
				$return['message'] 	= 'เลื่อนนัดร้อยแล้ว'; 
			}else{
				$return['status'] 	= false;
				$return['message'] 	= 'เลื่อนนัดไม่สำเร็จ';
			}
		}else{
			$return['status'] 	= false;
			$return['message'] 	= 'เลื่อนนัดไม่สำเร็จ';
		}

		echo json_encode($return);
	}

	public function canceled(){
		$data = $this->input->post();
		$data_update = array(
				'state' => 'Wait'
			);
		$this->db->where("id_shifts", $data['update']['shifts_id']);
        $query = $this->db->update("shifts",$data_update);
		if ($query) {
			$claim_update = array(
				'state' => "Canceled"
			);
			$this->db->where("id_claim", $data['update']['claim_id']);

			$data_notification = array(
				'text' => "การขอเลื่อนนัดไม่สำเร็จ",
				'date' => date("Y-m-d"),
				'status' => "true",
				'ref_patient' => $data['update']['ref_patient'],
			);
			$query_notification = $this->db->insert('notification', $data_notification);

			$query_claim = $this->db->update("claim_shifts",$claim_update);
			if ($query_claim) {
				$return['status'] 	= true;
				$return['message'] 	= 'ยกเลิกเลื่อนนัดร้อยแล้ว'; 
			}else{
				$return['status'] 	= false;
				$return['message'] 	= 'ยกเลิกเลื่อนนัดไม่สำเร็จ';
			}
		}else{
			$return['status'] 	= false;
			$return['message'] 	= 'ยกเลิกเลื่อนนัดไม่สำเร็จ';
		}

		echo json_encode($return);
	}
}
