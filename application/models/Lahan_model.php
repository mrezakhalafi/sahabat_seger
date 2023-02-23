<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lahan_model extends CI_model {
	function getFilterPlant($id_plant = NULL){
		
		$this->db->select('tb_petani_lahan.*,tb_prov.nama_prov,tb_kab.nama_kab,tb_kec.nama_kec,tb_desa.nama_desa,tb_poktan.nama_poktan,tb_petani.nama_petani');	
		$this->db->from('tb_petani_lahan');
		$this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id AND tb_poktan.aktif = 1');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
		$this->db->join('tb_prov', 'tb_petani_lahan.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_petani_lahan.id_kab = tb_kab.id');
		$this->db->join('tb_kec', 'tb_petani_lahan.id_kec = tb_kec.id');
		$this->db->join('tb_desa', 'tb_petani_lahan.id_desa = tb_desa.id');	
		$this->db->join('tb_petani', 'tb_petani_lahan.id_petani = tb_petani.id');	
		
		if($id_plant !== NULL){
			$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
			$this->db->where_in("id_cabang", $id_plant);
		}else{
			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

			$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
			$this->db->where_in('tb_user_akses_plant.id_cabang', $names);
		}
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}


	function getDataPlant($id_plant=NULL){
		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang, tb_petani_lahan.id');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user','tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');
		$this->db->join('tb_poktan', 'tb_poktan.id_staff = tb_user.id AND tb_poktan.aktif = 1');
		$this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_poktan = tb_poktan.id');
		$this->db->where_in("tb_petani_lahan.id", $id_plant);

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;

	}

}
?>