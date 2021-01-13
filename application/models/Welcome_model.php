<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_model extends CI_Model{

	//--------------------------------------------------------------------
	public function add($data){
    $query = $this->db->insert('users', $data);
    if($query){
      return $this->db->insert_id();
    }
		return false;
	}

}

?>