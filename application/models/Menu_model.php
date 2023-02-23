<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model{
	public function getMenu(){
		$query = "SELECT `tb_menu`.*, `tb_kategori_menu`.`kategori_menu` FROM `tb_menu` JOIN `tb_kategori_menu` ON `tb_menu`.`parent` = `tb_kategori_menu`.`id`
		";
	return $this->db->query($query)->result_array();
	}

	function getDataMenu($id = NULL){
		$this->db->select("*");
		$this->db->from("tb_menu");
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
	function getDataMenuKategori($id = NULL){
		$this->db->select("*");
		$this->db->from("tb_kategori_menu");
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