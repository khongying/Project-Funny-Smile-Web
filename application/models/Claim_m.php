<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Claim_m extends CI_Model {

	function __construct() {
		parent::__construct();

	}
    
    public function claim_shifts($id){
        $this->db->select('*');
        $this->db->where('id_claim =',$id);
        $this->db->from('claim_shifts');
        $query = $this->db->get();
        $result =  $query->result_array();
        return $result;
    }

}
