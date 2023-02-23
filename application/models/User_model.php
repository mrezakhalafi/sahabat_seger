<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_model {
	function getDataUser($id = NULL){
		$this->db->select("id");
		$this->db->from("tb_user");
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

	function getAllDataUser($id = NULL){
		$this->db->select("tb_user.*,tb_user_akses_plant.id_cabang,tb_role.multiplant");
		$this->db->from("tb_user");
		$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id', 'left');
		$this->db->join('tb_role','tb_user.id_role = tb_role.id');
		if($id !== NULL){
			$this->db->where("tb_user.id", $id);

			$query = $this->db->get();
			$result = $query->row();
		}else{
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}

	function getAllPlant($id = NULL){
		$this->db->select("id_cabang");
		$this->db->from("tb_user_akses_plant");
		if($id !== NULL){
			$this->db->where("id_user", $id);

			$query = $this->db->get();
			$result = $query->result();
		}else{
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}
}
?>