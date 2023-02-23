<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petani_model extends CI_Model{
	public function getMaxId(){
		$this->db->select("MAX(id)");
		$this->db->from("tb_petani");
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

	function getDataPetani($id = NULL){
			$this->db->select("*");
			$this->db->from("tb_petani");
		
		if($id !== NULL){
			$this->db->where("id", $id);
			$query = $this->db->get();
			$resultAll = $query->row();

			$this->db->select("*");
			$this->db->from("tb_kab");
			$this->db->where("id_provinsi", $resultAll->id_prov);
			$query = $this->db->get();
			$resultKab = $query->result();

			$this->db->select("*");
			$this->db->from("tb_kec");
			$this->db->where("id_kabupaten", $resultAll->id_kab);
			$query = $this->db->get();
			$resultKec = $query->result();

			$this->db->select("*");
			$this->db->from("tb_desa");
			$this->db->where("id_kecamatan", $resultAll->id_kec);
			$query = $this->db->get();
			$resultDesa = $query->result();

			$resultAll->kab = $resultKab;
			$resultAll->kec = $resultKec;
			$resultAll->desa = $resultDesa;
		}else{
			$query = $this->db->get();
			$resultAll = $query->result();
		}
		return $resultAll;
	}

	function getTampilFilterHasil($id_poktan=NULL,$id_staff=NULL,$id_plant=NULL){
		$this->db->select('tb_petani.*,tb_prov.nama_prov,tb_kab.nama_kab,tb_kec.nama_kec,tb_kab.nama_kab,tb_desa.nama_desa,tb_rek_bank.nama_bank,tb_poktan.nama_poktan,tb_user.fullname,tb_poktan.id_staff');
		$this->db->from('tb_petani');
		$this->db->join('tb_prov', 'tb_petani.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_petani.id_kab = tb_kab.id');
		$this->db->join('tb_kec', 'tb_petani.id_kec = tb_kec.id');
		$this->db->join('tb_desa', 'tb_petani.id_desa = tb_desa.id');
		$this->db->join('tb_rek_bank', 'tb_petani.rek_bank = tb_rek_bank.id');
		$this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_petani = tb_petani.id','left');	
		$this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id','left');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id','left');
		$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id','left');
		$this->db->group_by('tb_petani.id'); 
		$this->db->where_in("id_staff", $id_staff);
		$this->db->where_in("id_cabang", $id_plant);

		if($id_poktan !== NULL){
			
			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}
			$this->db->where_in('tb_user_akses_plant.id_cabang',$names);	
			$this->db->where_in("id_poktan", $id_poktan);
			
		}else{

			if($this->session->userdata('multiplant')==0){

				$this->db->where('tb_user.email',$this->session->userdata('email'));
				$this->db->or_where('tb_poktan.id_staff IS NULL');	
		
			}else{

				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}
				$this->db->where_in('tb_user_akses_plant.id_cabang',$names);
				$this->db->or_where('tb_poktan.id_staff IS NULL');	
			}
		}
		
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getDataPlant($id_petani=NULL){
		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang, tb_petani.id');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user','tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');
		$this->db->join('tb_poktan', 'tb_poktan.id_staff = tb_user.id');		
		$this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_poktan = tb_poktan.id');
		$this->db->join('tb_petani', 'tb_petani_lahan.id_petani = tb_petani.id');		
		$this->db->where_in("tb_poktan.id_staff", $id_petani);

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getDataPoktan($id_staff=NULL){
		$this->db->select('tb_poktan.nama_poktan,tb_petani.id');
		$this->db->from('tb_poktan');	
		$this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_poktan = tb_poktan.id');
		$this->db->join('tb_petani', 'tb_petani_lahan.id_petani = tb_petani.id');		
		$this->db->where_in("tb_poktan.id_staff", $id_staff);

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getTampilFilterHasilStaff($id_staff=NULL,$id_poktan=NULL,$id_plant=NULL){
		$this->db->select('tb_petani.*,tb_prov.nama_prov,tb_kab.nama_kab,tb_kec.nama_kec,tb_kab.nama_kab,tb_desa.nama_desa,tb_rek_bank.nama_bank,tb_poktan.nama_poktan,tb_user.fullname,tb_poktan.id_staff');
		$this->db->from('tb_petani');
		$this->db->join('tb_prov', 'tb_petani.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_petani.id_kab = tb_kab.id');
		$this->db->join('tb_kec', 'tb_petani.id_kec = tb_kec.id');
		$this->db->join('tb_desa', 'tb_petani.id_desa = tb_desa.id');
		$this->db->join('tb_rek_bank', 'tb_petani.rek_bank = tb_rek_bank.id');
		$this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_petani = tb_petani.id','left');	
		$this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id','left');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id','left');
		$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id','left');
		$this->db->where_in("tb_poktan.id", $id_poktan);
		$this->db->where_in("id_cabang", $id_plant);
		$this->db->group_by('tb_petani.id'); 


		if($id_staff !== NULL){
			$this->db->where_in("id_staff", $id_staff);
		}else{

			if($this->session->userdata('multiplant')==0){

				$this->db->where('tb_user.email',$this->session->userdata('email'));
				$this->db->or_where('tb_poktan.id_staff IS NULL');

			}else{

				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}
				$this->db->where_in('tb_user_akses_plant.id_cabang',$names);	
			}
		}

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getTampilFilterHasilPlant($id_plant=NULL,$id_poktan=NULL,$id_staff=NULL){
		$this->db->select('tb_petani.*,tb_prov.nama_prov,tb_kab.nama_kab,tb_kec.nama_kec,tb_kab.nama_kab,tb_desa.nama_desa,tb_rek_bank.nama_bank,tb_poktan.nama_poktan,tb_user.fullname,tb_poktan.id_staff,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_petani');
		$this->db->join('tb_prov', 'tb_petani.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_petani.id_kab = tb_kab.id');
		$this->db->join('tb_kec', 'tb_petani.id_kec = tb_kec.id');
		$this->db->join('tb_desa', 'tb_petani.id_desa = tb_desa.id');
		$this->db->join('tb_rek_bank', 'tb_petani.rek_bank = tb_rek_bank.id');
		$this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_petani = tb_petani.id','left');	
		$this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id','left');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id','left');
		$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang','tb_plant_cabang.id = tb_user_akses_plant.id_cabang');
		$this->db->where_in('tb_poktan.id',$id_poktan);
		$this->db->where_in('id_staff',$id_staff);
		$this->db->group_by('tb_petani.id'); 

		if($id_plant !== NULL){
			$this->db->where_in("id_cabang", $id_plant);
		}else{

			if($this->session->userdata('multiplant')==0){

				$this->db->where('tb_user.email',$this->session->userdata('email'));
				$this->db->or_where('tb_poktan.id_staff IS NULL');	
		
			}else{

				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}
				$this->db->where_in('tb_user_akses_plant.id_cabang',$names);	
				$this->db->or_where('tb_poktan.id_staff IS NULL');	
			}
		}

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

		function getTampilFilterHasilPlant2($id_plant=NULL){
		$this->db->select('tb_petani.*,tb_prov.nama_prov,tb_kab.nama_kab,tb_kec.nama_kec,tb_kab.nama_kab,tb_desa.nama_desa,tb_rek_bank.nama_bank,tb_poktan.nama_poktan,tb_user.fullname,tb_poktan.id_staff');
		$this->db->from('tb_petani');
		$this->db->join('tb_prov', 'tb_petani.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_petani.id_kab = tb_kab.id');
		$this->db->join('tb_kec', 'tb_petani.id_kec = tb_kec.id');
		$this->db->join('tb_desa', 'tb_petani.id_desa = tb_desa.id');
		$this->db->join('tb_rek_bank', 'tb_petani.rek_bank = tb_rek_bank.id');
		$this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_petani = tb_petani.id');	
		$this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
		$this->db->where('tb_petani.aktif',1);

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
				$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
				$this->db->where_in('tb_user_akses_plant.id_cabang',$names);	
			}
		}

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

}
?>