<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Patient_m extends CI_Model {

	function __construct() {
		parent::__construct();

	}
    
    public function dentist() {
        $this->db->select('*');
        $this->db->join('dentist_type','dentist.dentist_type = dentist_type.id_type');
        $this->db->from('dentist');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function patient(){
        $this->db->select('*');
        $this->db->join('dentist','dentist.id = patient.ref_dentist_id');
        $this->db->from('patient');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function check_patient($no_card,$no_card_patient){
        $this->db->select('*');        
        $this->db->or_where('patient.no_card =',$no_card);
        $this->db->or_where('patient.no_card_patient =',$no_card_patient);
        $this->db->from('patient');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_patient($id){
        $this->db->select('*');
        $this->db->join('dentist','dentist.id = patient.ref_dentist_id');
        $this->db->where('patient.id_patient =',$id);
        $this->db->from('patient');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function patient_find($id){
        $this->db->select('*');
        $this->db->where('patient.ref_dentist_id =',$id);
        $this->db->from('patient');
        $query = $this->db->get();
        $result =  $query->result_array();
        return $result;
    }

}
