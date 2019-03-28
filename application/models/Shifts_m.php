<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Shifts_m extends CI_Model {

	function __construct() {
		parent::__construct();

	}
    
    public function due_date($date,$id_dentisrt){
        $this->db->select('*');
        $this->db->join('patient','patient.id_patient = shifts.ref_patient');
        $this->db->where('shifts.ref_dentist =',$id_dentisrt);
        $this->db->where('shifts.date =',$date);
        $this->db->order_by('shifts.time', 'asc');
        $this->db->from('shifts');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function check_shifts($date,$time){
        $this->db->select('*');        
        $this->db->where('shifts.time =',$time);
        $this->db->where('shifts.date =',$date);
        $this->db->from('shifts');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function shifts($id){
        $this->db->select('*');
        $this->db->join('patient','patient.id_patient = shifts.ref_patient');
        $this->db->join('dentist','dentist.id = shifts.ref_dentist');
        $this->db->where('id_shifts =',$id);
        $this->db->from('shifts');
        $query = $this->db->get();
        $result =  $query->result_array();
        return $result;
    }

    public function history_patient($id_patient){
        $this->db->select('*');
        $this->db->join('patient','patient.id_patient = shifts.ref_patient');
        $this->db->join('dentist','dentist.id = shifts.ref_dentist');
        $this->db->where('shifts.ref_patient =',$id_patient);
        $this->db->order_by('shifts.date', 'asc');
        $this->db->from('shifts');
        $query = $this->db->get();
        $result = $query->result();
        return $result;    
    } 

    public function appointment($id_patient){
        $this->db->select('*');
        $this->db->join('patient','patient.id_patient = shifts.ref_patient');
        $this->db->join('dentist','dentist.id = shifts.ref_dentist');
        $this->db->where('shifts.ref_patient =',$id_patient);
        $this->db->where('shifts.state !=',"Success");
        $this->db->from('shifts');
        $query = $this->db->get();
        $result = $query->result();
        return $result;    
    }    

    public function request(){
        $this->db->select('*');
        $this->db->join('patient','patient.id_patient = claim_shifts.ref_patient');
        $this->db->where('claim_shifts.state =',"Wait");
        $this->db->from('claim_shifts');
        $query = $this->db->get();
        $result = $query->result();
        return $result;    
    } 

    public function check($id_patient,$date){
        $this->db->select('*');
        $this->db->where('shifts.ref_patient =',$id_patient);
        $this->db->where('shifts.date =',$date);
        $this->db->from('shifts');
        $query = $this->db->get();
        $result = $query->result();
        return $result;    
    }  

    public function notification($id_patient,$date){
        $this->db->select('*');
        $this->db->where('ref_patient =',$id_patient);
        $this->db->where('date =',$date);
        $this->db->from('notification');
        $query = $this->db->get();
        $result = $query->result();
        return $result;    
    } 
       

}
