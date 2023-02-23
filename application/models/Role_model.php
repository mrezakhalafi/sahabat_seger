<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_model {
	function getDataRole($id = NULL){
		$this->db->select("*");
		$this->db->from("tb_role");
		if($id !== NULL){
			$this->db->where("id", $id);

			$query = $this->db->get();
			$result = $query->row();
		}else{
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}
}
?>