<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poktantanam_model extends CI_model {
	function getDataPoktanTanam($id = NULL){
			$this->db->select("tb_petani_lahan.id as `lahan` ,tb_poktan_tanam.*");
			$this->db->from("tb_poktan_tanam");
			$this->db->join('tb_poktan', 'tb_poktan.id = tb_poktan_tanam.id_poktan');
			$this->db->join('tb_petani_lahan','tb_petani_lahan.id_poktan = tb_poktan.id');
			// $this->db->join('tb_petani_lahan_hsl','tb_petani_lahan_hsl.id_tanam = tb_poktan_tanam.id');
			if($id !== NULL){
				$this->db->where("tb_poktan_tanam.id", $id);
				$query = $this->db->get();
				$result = $query->row();

				$this->db->select("tb_user.*,tb_poktan.id_staff");
				$this->db->from("tb_user");
				$this->db->join('tb_poktan', 'tb_poktan.id_staff = tb_user.id');
				$this->db->where("tb_poktan.id", $result->id_poktan);
				$query = $this->db->get();
				$resultStaff = $query->result();

				$result->staff = $resultStaff;

			}else{
				$query = $this->db->get();
				$result = $query->result();
			}
			return $result;
	}

	// function getDataPoktanTanamLahan($id = NULL){
	// 		$this->db->select("tb_petani_lahan.id as `lahan` ,tb_poktan_tanam.*");
	// 		$this->db->from("tb_poktan_tanam");
	// 		$this->db->join('tb_poktan', 'tb_poktan.id = tb_poktan_tanam.id_poktan');
	// 		$this->db->join('tb_petani_lahan','tb_petani_lahan.id_poktan = tb_poktan.id');
	// 		$this->db->join('tb_petani_lahan_hsl','tb_petani_lahan_hsl.id_tanam = tb_poktan_tanam.id');
	// 		if($id !== NULL){
	// 			$this->db->where("tb_poktan_tanam.id", $id);

	// 			$query = $this->db->get();
	// 			$result = $query->row();
	// 		}else{
	// 			$query = $this->db->get();
	// 			$result = $query->result();
	// 		}
	// 		return $result;
	// }

	function getDataPoktanTanam120($id = NULL){
			$this->db->select("tb_poktan_tanam.*,tb_petani_lahan.id,tb_petani_lahan_hsl.hasil_panen,tb_petani_lahan_hsl.kadar_air");
			$this->db->from("tb_poktan_tanam");
			$this->db->join('tb_poktan', 'tb_poktan.id = tb_poktan_tanam.id_poktan');
			$this->db->join('tb_petani_lahan','tb_petani_lahan.id_poktan = tb_poktan.id');
			$this->db->join('tb_petani_lahan_hsl','tb_petani_lahan_hsl.id_tanam = tb_poktan_tanam.id',"left");
			if($id !== NULL){
				$this->db->where("tb_poktan_tanam.id", $id);

				$query = $this->db->get();
				$result = $query->row();
			}else{
				$query = $this->db->get();
				$result = $query->result();
			}
			return $result;
	}

	 function getdatahasil($id){
	 	return $this->db->get_where('tb_petani_lahan_hsl',['id_tanam' => $id])->row_array();

	}

	function getDataPoktanLahan($id = NULL){
			$this->db->select("luas");
			$this->db->from("tb_petani_lahan");
			$this->db->join('tb_poktan','tb_poktan.id = tb_petani_lahan.id_poktan');
			$this->db->where('tb_poktan.aktif',1);
			if($id !== NULL){
				$this->db->where("id_poktan", $id);

				$query = $this->db->get();
				$result = $query->result();
			}else{
				$query = $this->db->get();
				$result = $query->result();
			}
			return $result;
	}

	function getTampilKunjungan($tgl=NULL, $staff=NULL){
		$this->db->select('tb_kunjungan.*,tb_user.fullname, tb_poktan.nama_poktan, tb_poktan.alamat, tb_tipe_kunjungan.tipe_kunjungan');	
		$this->db->from('tb_kunjungan');
		$this->db->join('tb_user', 'tb_kunjungan.id_staff = tb_user.id');
		$this->db->join('tb_poktan', 'tb_kunjungan.id_poktan = tb_poktan.id');
		$this->db->join('tb_tipe_kunjungan', 'tb_kunjungan.id_tipe_kunjungan = tb_tipe_kunjungan.id');
		if($tgl !== NULL){
			$this->db->where("tb_kunjungan.tgl_kunjungan", $tgl);
		}
		if($staff !== NULL){
			$this->db->where("tb_kunjungan.id_staff", $staff);
		}
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getTampilKunjunganHasil($tgl=NULL, $staff=NULL){
		$this->db->select('tb_kunjungan.*,tb_user.fullname, tb_poktan.nama_poktan, tb_poktan.alamat, tb_tipe_kunjungan.tipe_kunjungan');	
		$this->db->from('tb_kunjungan');
		$this->db->join('tb_user', 'tb_kunjungan.id_staff = tb_user.id');
		$this->db->join('tb_poktan', 'tb_kunjungan.id_poktan = tb_poktan.id');
		$this->db->join('tb_tipe_kunjungan', 'tb_kunjungan.id_tipe_kunjungan = tb_tipe_kunjungan.id');

		if($tgl !== NULL){
			$this->db->where("tb_kunjungan.tgl_kunjungan", $tgl);
		}
		if($staff !== NULL){
			$this->db->where("tb_kunjungan.id_staff", $staff);
		}
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getTampilKunjunganHasilLibur($tgl=NULL, $staff=NULL){
		$this->db->select('tb_kunjungan.*,tb_tipe_kunjungan.tipe_kunjungan');	
		$this->db->from('tb_kunjungan');
		$this->db->join('tb_tipe_kunjungan', 'tb_kunjungan.id_tipe_kunjungan = tb_tipe_kunjungan.id');

		if($tgl !== NULL){
			$this->db->where("tb_kunjungan.tgl_kunjungan", $tgl);
		}
		if($staff !== NULL){
			$this->db->where("tb_kunjungan.id_staff", $staff);
		}
		$this->db->where("tipe_kunjungan", 'Hari Libur Nasional');
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getTampilFilterHasil($id_poktan=NULL,$id_staff=NULL,$id_plant=NULL){
		$this->db->select('tb_poktan_tanam.*,tb_poktan.nama_poktan,tb_user.fullname');	
		$this->db->from('tb_poktan_tanam');
		$this->db->join('tb_poktan', 'tb_poktan_tanam.id_poktan = tb_poktan.id');
		$this->db->join('tb_user', 'tb_poktan_tanam.staff = tb_user.id');
		$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->where_in("id_cabang", $id_plant);
		$this->db->where_in("staff", $id_staff);

		if($id_poktan !== NULL){
			$this->db->where_in("id_poktan", $id_poktan);
			if($this->session->userdata('multiplant')==0){
			$this->db->where('tb_user.email',$this->session->userdata('email'));
			}else{
				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}
				$this->db->where_in('tb_user_akses_plant.id_cabang',$names);	
			}
		}else{

			if($this->session->userdata('multiplant')==0){

				$this->db->where('tb_user.email',$this->session->userdata('email'));	
		
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

	function getTampilFilterHasilStaff($id_staff=NULL,$id_plant=NULL,$id_poktan=NULL){
		$this->db->select('tb_poktan_tanam.*,tb_poktan.nama_poktan,tb_user.fullname');	
		$this->db->from('tb_poktan_tanam');
		$this->db->join('tb_user', 'tb_poktan_tanam.staff = tb_user.id');
		$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_poktan', 'tb_poktan_tanam.id_poktan = tb_poktan.id');
		$this->db->where_in('id_cabang', $id_plant);
		$this->db->where_in('id_poktan', $id_poktan);
		if($id_staff !== NULL){
			$this->db->where_in("staff", $id_staff);
		}else{

			if($this->session->userdata('multiplant')==0){

				$this->db->where('tb_user.email',$this->session->userdata('email'));	
		
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

	function getDataPlant($id_tanam=NULL){
		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang, tb_poktan_tanam.id');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user','tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');
		$this->db->join('tb_poktan_tanam', 'tb_poktan_tanam.staff = tb_user.id');
		$this->db->where_in("tb_poktan_tanam.id", $id_tanam);

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getStatusTanam($tanam=NULL){
		$this->db->select('*');
		$this->db->from('tb_poktan_tanam');
		$this->db->where_in("id", $tanam);

		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}


	function getTampilFilterHasilPlant($id_plant=NULL,$id_poktan=NULL,$id_staff=NULL){
		$this->db->select('tb_poktan_tanam.*,tb_poktan.nama_poktan,tb_user.fullname');	
		$this->db->from('tb_poktan_tanam');
		$this->db->join('tb_poktan', 'tb_poktan_tanam.id_poktan = tb_poktan.id');
		$this->db->join('tb_user', 'tb_poktan_tanam.staff = tb_user.id');
		$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->where_in('tb_poktan_tanam.staff', $id_staff);
		$this->db->where_in('id_poktan', $id_poktan);

		if($id_plant !== NULL){
			$this->db->where_in("id_cabang", $id_plant);

			if($this->session->userdata('multiplant')==0){
			$this->db->where('tb_user.email',$this->session->userdata('email'));
			}else{
				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}
				$this->db->where_in('tb_user_akses_plant.id_cabang',$names);	
			}
		}else{

			if($this->session->userdata('multiplant')==0){

				$this->db->where('tb_user.email',$this->session->userdata('email'));	
		
			}else{

				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}
				$this->db->where_in('tb_user_akses_plant.id_cabang',$names);	
				// $this->db->where('tb_poktan.aktif',1);
			}
		}
		
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}

	function getTampilFilterHasilPlant2($id_plant=NULL){
		$this->db->select('tb_poktan_tanam.*,tb_poktan.nama_poktan,tb_user.fullname');	
		$this->db->from('tb_poktan_tanam');
		$this->db->join('tb_poktan', 'tb_poktan_tanam.id_poktan = tb_poktan.id');
		$this->db->join('tb_user', 'tb_poktan_tanam.staff = tb_user.id');

		if($id_plant !== NULL){
			$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
			$this->db->where_in("id_cabang", $id_plant);
			if($this->session->userdata('multiplant')==0){
			$this->db->where('tb_user.email',$this->session->userdata('email'));
			}else{
				//Nothing
			}
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
				// $this->db->where('tb_poktan.aktif',1);
			}
		}
		
		$query = $this->db->get();
		$result = $query->result();
		
		return $result;
	}


	function getDataPoktanTanamModal($id = NULL){
		$this->db->select("*");
		$this->db->from("tb_poktan_tanam");
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