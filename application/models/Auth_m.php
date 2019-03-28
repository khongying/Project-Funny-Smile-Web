<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Auth_m extends CI_Model {

	function __construct() {
		parent::__construct();

	}
	public function check_login($email, $pass)
	{
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('email', $email);
		$this->db->where('password', $pass);
		$this->db->limit('1');
		$query = $this->db->get();
		$res = array();
		if ($query) {
			if ($query->num_rows() == 1) {
				$res['status']  = true;
				$res['message'] = 'เข้าสู่ระบบสำเร็จ';
				$res['session'] = $query->result_array();

			}else{
				$res['status']  = false;
				$res['message'] = 'กรุณาตรวจสอบ Email และ Password';
			}
		}else{
			$res['status']  = false;
			$res['message'] = 'ไม่สามารถเข้าสู่ระบบได้';
		}

		return $res;
	}

	public function patient_login($no_card, $no_card_patient)
	{
		$this->db->select('*');
		$this->db->from('patient');
        $this->db->join('dentist','dentist.id = patient.ref_dentist_id');
		$this->db->where('no_card', $no_card);
		$this->db->where('no_card_patient', $no_card_patient);
		$this->db->limit('1');
		$query = $this->db->get();
		$res = array();
		if ($query) {
			if ($query->num_rows() == 1) {
				$res['status']  = true;
				$res['message'] = 'เข้าสู่ระบบสำเร็จ';
				$res['data'] =  ( count($query->result_array()>0) ) ? $query->result_array()[0] : []; 

			}else{
				$res['status']  = false;
				$res['message'] = 'กรุณาตรวจสอบความถูกต้อง';
			}
		}else{
			$res['status']  = false;
			$res['message'] = 'ไม่สามารถเข้าสู่ระบบได้';
		}

		return $res;
	}

}
