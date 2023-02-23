<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokpoktan_model extends CI_model {
	function getDokPok($id = NULL){
		$this->db->select("*");
		$this->db->from("tb_poktan_dok");
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