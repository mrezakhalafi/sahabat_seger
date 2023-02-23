<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poktan_model extends CI_Model{
	function getDataPoktan($id = NULL){
			$this->db->select("*");
			$this->db->from("tb_poktan");

		if($id !== NULL){
			$this->db->where("id", $id);
			$query = $this->db->get();
			$resultAll = $query->row();

			$this->db->select("*");
			$this->db->from("tb_kab");
			$this->db->where("id_provinsi", $resultAll->id_provinsi);
			$query = $this->db->get();
			$resultKab = $query->result();

			$this->db->select("*");
			$this->db->from("tb_kec");
			$this->db->where("id_kabupaten", $resultAll->id_kabupaten);
			$query = $this->db->get();
			$resultKec = $query->result();

			$this->db->select("*");
			$this->db->from("tb_desa");
			$this->db->where("id_kecamatan", $resultAll->id_kecamatan);
			$query = $this->db->get();
			$resultDesa = $query->result();

			$resultAll->kabupaten = $resultKab;
			$resultAll->kecamatan = $resultKec;
			$resultAll->desa = $resultDesa;
		}else{
			$query = $this->db->get();
			$resultAll = $query->result();
		}
		return $resultAll;
	}

	function getDataPlant($id_poktan=NULL){
		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang, tb_poktan.id');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user','tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');
		$this->db->join('tb_poktan', 'tb_poktan.id_staff = tb_user.id');
		$this->db->where_in("tb_poktan.id", $id_poktan);

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;

	}

	function getTampilFilterHasilStaff($id_staff=NULL,$id_plant=NULL){
		$this->db->select('tb_poktan.*,tb_user.fullname,tb_jns_mitra.jenis_mitra,tb_komuditi.nama_komuditi,tb_desa.nama_desa,tb_kec.nama_kec,tb_kab.nama_kab,tb_prov.nama_prov,tb_rek_bank.nama_bank');
		$this->db->from('tb_poktan');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
		$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_jns_mitra', 'tb_poktan.id_jenis_mitra = tb_jns_mitra.id');
		$this->db->join('tb_komuditi', 'tb_poktan.id_komuditi = tb_komuditi.id');
		$this->db->join('tb_rek_bank', 'tb_poktan.rek_bank = tb_rek_bank.id');
		$this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.id');
		$this->db->join('tb_kec', 'tb_poktan.id_kecamatan = tb_kec.id');
		$this->db->join('tb_kab', 'tb_poktan.id_kabupaten = tb_kab.id');
		$this->db->join('tb_prov', 'tb_poktan.id_provinsi = tb_prov.id');
		$this->db->where_in('id_cabang', $id_plant);
		
		if($id_staff !== NULL){
			$this->db->where_in("id_staff", $id_staff);

		}else{

		if($this->session->userdata('multiplant')==0){

			$this->db->where('tb_user.email',$this->session->userdata('email'));
		
		}else{

			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}
			// $this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
			// $this->db->where_in('tb_user_akses_plant.id_cabang',$names);	
			}
		}

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getTampilFilterHasilPlant($id_plant=NULL,$id_staff=NULL){
		$this->db->select('tb_poktan.*,tb_user.fullname,tb_jns_mitra.jenis_mitra,tb_komuditi.nama_komuditi,tb_desa.nama_desa,tb_kec.nama_kec,tb_kab.nama_kab,tb_prov.nama_prov,tb_rek_bank.nama_bank');
		$this->db->from('tb_poktan');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
		$this->db->join('tb_jns_mitra', 'tb_poktan.id_jenis_mitra = tb_jns_mitra.id');
		$this->db->join('tb_komuditi', 'tb_poktan.id_komuditi = tb_komuditi.id');
		$this->db->join('tb_rek_bank', 'tb_poktan.rek_bank = tb_rek_bank.id');
		$this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.id');
		$this->db->join('tb_kec', 'tb_poktan.id_kecamatan = tb_kec.id');
		$this->db->join('tb_kab', 'tb_poktan.id_kabupaten = tb_kab.id');
		$this->db->join('tb_prov', 'tb_poktan.id_provinsi = tb_prov.id');
		$this->db->where_in('id_staff', $id_staff);

		if($id_plant !== NULL){
			$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
			$this->db->where_in("id_cabang", $id_plant);
		}else{

			if($this->session->userdata('multiplant')==0){

				$this->db->where('tb_user.email',$this->session->userdata('email'));
			
			}else{
				
				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}
				// $this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
				// $this->db->where_in('tb_user_akses_plant.id_cabang',$names);
				$this->db->where('tb_poktan.aktif',1);
			}
		}

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getTampilFilterHasilPlant2($id_plant=NULL){
		$this->db->select('tb_poktan.*,tb_user.fullname,tb_jns_mitra.jenis_mitra,tb_komuditi.nama_komuditi,tb_desa.nama_desa,tb_kec.nama_kec,tb_kab.nama_kab,tb_prov.nama_prov,tb_rek_bank.nama_bank');
		$this->db->from('tb_poktan');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
		$this->db->join('tb_jns_mitra', 'tb_poktan.id_jenis_mitra = tb_jns_mitra.id');
		$this->db->join('tb_komuditi', 'tb_poktan.id_komuditi = tb_komuditi.id');
		$this->db->join('tb_rek_bank', 'tb_poktan.rek_bank = tb_rek_bank.id');
		$this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.id');
		$this->db->join('tb_kec', 'tb_poktan.id_kecamatan = tb_kec.id');
		$this->db->join('tb_kab', 'tb_poktan.id_kabupaten = tb_kab.id');
		$this->db->join('tb_prov', 'tb_poktan.id_provinsi = tb_prov.id');
		$this->db->where('tb_poktan.aktif',1);

		if($id_plant !== NULL){
			$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
			$this->db->where_in("id_cabang", $id_plant);
		}else{

			if($this->session->userdata('multiplant')==0){

				$this->db->where('tb_user.email',$this->session->userdata('email'));
			
			}else{
				
				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}
				$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_poktan.id_staff');
				$this->db->where_in('id_cabang',$names);
			}
		}

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

function getTampilFilterHasilPlant3($id_plant=NULL){
		$this->db->select('tb_poktan.*,tb_user.fullname,tb_jns_mitra.jenis_mitra,tb_komuditi.nama_komuditi,tb_desa.nama_desa,tb_kec.nama_kec,tb_kab.nama_kab,tb_prov.nama_prov,tb_rek_bank.nama_bank');
		$this->db->from('tb_poktan');
		$this->db->join('tb_petani_lahan','tb_petani_lahan.id_poktan = tb_poktan.id');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
		$this->db->join('tb_jns_mitra', 'tb_poktan.id_jenis_mitra = tb_jns_mitra.id');
		$this->db->join('tb_komuditi', 'tb_poktan.id_komuditi = tb_komuditi.id');
		$this->db->join('tb_rek_bank', 'tb_poktan.rek_bank = tb_rek_bank.id');
		$this->db->join('tb_desa', 'tb_poktan.id_desa = tb_desa.id');
		$this->db->join('tb_kec', 'tb_poktan.id_kecamatan = tb_kec.id');
		$this->db->join('tb_kab', 'tb_poktan.id_kabupaten = tb_kab.id');
		$this->db->join('tb_prov', 'tb_poktan.id_provinsi = tb_prov.id');
		$this->db->where('tb_poktan.aktif',1);

		if($id_plant !== NULL){
			$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
			$this->db->where_in("id_cabang", $id_plant);
		}else{

			if($this->session->userdata('multiplant')==0){

				$this->db->where('tb_user.email',$this->session->userdata('email'));
			
			}else{
				
				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}
				// $this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
				// $this->db->where_in('tb_user_akses_plant.id_cabang',$names);
				$this->db->where('tb_poktan.aktif',1);
			}
		}

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}


}
?>