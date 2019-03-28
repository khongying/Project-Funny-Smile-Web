<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts extends CI_Controller {


	public function __construct() { 
        parent::__construct();
        $this->load->model('shifts_m');
	}	

	public function add_shifts(){

		$data = $this->input->post();

		$check_shifts = $this->shifts_m->check_shifts($data['date'],$data['time']);

		$return = array();
		
		if(count($check_shifts) == 1){
			$return['status'] 	= false;
			$return['message'] 	= 'วันที่ '.$data['date'].' เวลา '.$data['time'].'น. มีผู้จองแล้ว'; 
		}else{
			
			$data_insert = array(
				'ref_dentist' => $data['ref_dentist_id'],
				'ref_patient' => $data['ref_patient_id'],
				'date' => $data['date'],
				'time'   => $data['time'],
				'reason'   => $data['reason']
			);


			$data_notification = array(
				'text' => "คุณมีนัดทำฟัน ".$data['date']." เวลา".$data['time']."น.",
				'date' => date("Y-m-d"),
				'status' => "true",
				'ref_patient' => $data['ref_patient_id'],
			);
			
			$query_notification = $this->db->insert('notification', $data_notification);
			$query = $this->db->insert('shifts', $data_insert);
			if ($query) {
				$return['status'] 	= true;
				$return['message'] 	= 'เพิ่มข้อมูลร้อยแล้ว'; 
			}else{
				$return['status'] 	= false;
				$return['message'] 	= 'เพิ่มัข้อมูลไม่สำเร็จ';
			}
			
		}
		

		echo json_encode($return);
	}

	public function shift_change(){
		$data = $this->input->post();
		if ($data['state'] != "Wait") {
			$data_update = array(
				'state' => $data['state']
			);
			$this->db->where("id_shifts", $data['id']);
			$query = $this->db->update("shifts",$data_update);
			if ($query) {
				$return['status'] 	= true;
				$return['message'] 	= 'อัพเดทสถานะเรียบร้อยแล้ว'; 
			}else{
				$return['status'] 	= false;
				$return['message'] 	= 'อัพเดทสถานะไม่สำเร็จ';
			}
		} else {
			$check_shifts = $this->shifts_m->check_shifts($data['date'],$data['time']);
			$return = array();
			if(count($check_shifts) == 1){
				$return['status'] 	= false;
				$return['message'] 	= 'วันที่ '.$data['date'].' เวลา '.$data['time'].'น. มีผู้จองแล้ว';
			}else{
				$data_update = array(
					'date' => $data['date'],
					'time' => $data['time']
				);
				$this->db->where("id_shifts", $data['id']);
				$query = $this->db->update("shifts",$data_update);
				if ($query) {
					$return['status'] 	= true;
					$return['message'] 	= 'เลื่อนนัดร้อยแล้ว'; 
				}else{
					$return['status'] 	= false;
					$return['message'] 	= 'เลื่อนนัดไม่สำเร็จ';
				}
			}
		}
	
		

		echo json_encode($return);
	}

	public function trash(){
		$id = $this->uri->segment(3);
		$id_patient = $this->uri->segment(4);
		$this->db->where('id_shifts', $id);
		$query = $this->db->delete('shifts');

		$data_notification = array(
			'text' => "เราได้ทำการยกเลิกนัดให้คุณเรียบร้อยแล้ว",
			'date' => date("Y-m-d"),
			'status' => "true",
			'ref_patient' => $id_patient,
		);
		$query_notification = $this->db->insert('notification', $data_notification);

		$return = array();
		if ($query) {
			$return['status'] 	= true;
			$return['message'] 	= 'ยกเลิกร้อยแล้ว'; 
		}else{
			$return['status'] 	= false;
			$return['message'] 	= 'ยกเลิกไม่สำเร็จ';
		}

		echo json_encode($return);
	}

	public function claim_shift(){
		$inputJSON = file_get_contents('php://input');
		$input = json_decode($inputJSON, TRUE);

		$check_shifts = $this->shifts_m->check_shifts($input['date'],$input['time']);

		$return = array();
		
		if(count($check_shifts) == 1){
			$return['status'] 	= false;
			$return['message'] 	= 'วันที่ '.$input['date'].' เวลา '.$input['time'].'น. มีผู้จองแล้ว'; 
		}else{
			$data_insert = array(
				'ref_dentist' => $input['ref_dentist_id'],
				'ref_patient' => $input['ref_patient_id'],
				'date' => $input['date'],
				'time'   => $input['time'],
				'reason'   => $input['reason'],
				'ref_id_shift'   => $input['ref_id_shift']
			);
			$query = $this->db->insert('claim_shifts', $data_insert);
			if ($query) {

				$shifts_update = array(
					'state' => "Postpone"
				);
				$this->db->where("id_shifts", $input['ref_id_shift']);
				$query_shifts = $this->db->update("shifts",$shifts_update);
				if ($query_shifts) {
					$return['status'] 	= true;
					$return['message'] 	= 'ยื่นคำร้องเลื่อนนัดสำเร็จ'; 
				}
			}else{
				$return['status'] 	= false;
				$return['message'] 	= 'ยื่นคำร้องเลื่อนนัดไม่สำเร็จ';
			}
			
		}
		echo json_encode($return);
	}

	public function history_patient(){
		$id_patient = $this->uri->segment(3);
		$data = $this->shifts_m->history_patient($id_patient);
		echo json_encode($data);
	}

	public function appointment(){
		$id_patient = $this->uri->segment(3);
		$data = $this->shifts_m->appointment($id_patient);
		echo json_encode($data);
	}

	public function check(){
		$id_patient = $this->uri->segment(3);
		$date = $this->uri->segment(4);
		$data = $this->shifts_m->check($id_patient,$date);
		echo json_encode($data);
	}

	public function notification(){
		$id_patient = $this->uri->segment(3);
		$date = $this->uri->segment(4);
		$data = $this->shifts_m->notification($id_patient,$date);
		echo json_encode($data);
	}


	public function notificationread(){
		$id = $this->uri->segment(3);
		$notification_update = array(
			'status' => "false"
		);
		$this->db->where("id", $id);
		$query_notification = $this->db->update("notification",$notification_update);
	}
	
}
