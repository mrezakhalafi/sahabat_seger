<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kunjungan_model extends CI_model {
	function getDataKunjungan($id = NULL){
		$this->db->select("*");
		$this->db->from("tb_poktan");
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

	function getDataKunjungan2($id = NULL){
		$this->db->select("tb_kunjungan.*,tb_poktan.nama_poktan,tb_tipe_kunjungan.tipe_kunjungan");
		$this->db->from("tb_kunjungan");
		$this->db->join('tb_poktan', 'tb_kunjungan.id_poktan = tb_poktan.id');
		$this->db->join('tb_tipe_kunjungan','tb_kunjungan.id_tipe_kunjungan = tb_tipe_kunjungan.id');
		if($id !== NULL){
			$this->db->where("tb_kunjungan.id", $id);
			$query = $this->db->get();
			$result = $query->row();
		}else{
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}

	function getDataKunjunganLibur($id = NULL){
		$this->db->select("tb_kunjungan.*,tb_tipe_kunjungan.tipe_kunjungan");
		$this->db->from("tb_kunjungan");
		$this->db->join('tb_tipe_kunjungan','tb_kunjungan.id_tipe_kunjungan = tb_tipe_kunjungan.id');
		if($id !== NULL){
			$this->db->where("tb_tipe_kunjungan.tipe_kunjungan", "Hari Libur Nasional");
			$query = $this->db->get();
			$result = $query->row();
		}else{
			$query = $this->db->get();
			$result = $query->result();
		}
		return $result;
	}

	function getstatusTanam($id = NULL){
		$this->db->select("*");
		$this->db->from("tb_poktan_tanam");
		if($id !== NULL){
			$this->db->where("id_poktan", $id);
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