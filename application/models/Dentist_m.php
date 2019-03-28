<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Dentist_m extends CI_Model {

	function __construct() {
		parent::__construct();

	}
    
    public function dentis_type(){
        $this->db->select('*');
        $this->db->from('dentist_type');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function dentis(){
        $this->db->select('*');
        $this->db->from('dentist');
        $this->db->join('dentist_type','dentist.dentist_type = dentist_type.id_type');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function get_dentis($id){
        $this->db->select('*');
        $this->db->from('dentist');
        $this->db->join('dentist_type','dentist_type.id_type = dentist.dentist_type');
        $this->db->where('dentist.id =',$id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

}
