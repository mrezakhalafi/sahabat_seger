<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang_model extends CI_model {
	function getDataCabang($id = NULL){
		$this->db->select("*");
		$this->db->from("tb_plant_cabang");
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