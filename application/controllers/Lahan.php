<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lahan extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->_gotoPage();
		$this->load->model("lahan_model");
		$this->load->model("poktan_model");
		$this->load->model("petani_model");
	}

	public function index($id="",$id2="",$id3=""){	
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// 	show_404();
		// }	
		$data['title'] = 'Data Lahan';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		// $data['petani'] = $this->petani_model->getTampilFilterHasilPlant();
		$data['poktan'] = $this->poktan_model->getTampilFilterHasilPlant2();
		$data['prov'] = $this->db->get('tb_prov')->result_array();
		$data['kab'] = $this->db->get_where('tb_kab',['id_provinsi' => $id])->result_array();
		$data['kec'] = $this->db->get_where('tb_kec',['id_kabupaten' => $id2])->result_array();
		$data['desa'] = $this->db->get_where('tb_desa',['id_kecamatan' => $id3])->result_array();

		if($this->session->userdata('multiplant')==0){
			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

			$this->db->select("*");
			$this->db->from('tb_plant_cabang');

			$this->db->where_in('id',$names);
			$data['cabang'] =  $this->db->get()->result_array();	
		}else{

			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

			$this->db->select("*");
			$this->db->from('tb_plant_cabang');

			$this->db->where_in('id',$names);
			$data['cabang'] =  $this->db->get()->result_array();	
		}

		$this->db->select('tb_petani_lahan.*,tb_poktan.nama_poktan,tb_poktan.id_staff,tb_petani.nama_petani,tb_prov.nama_prov,tb_kab.nama_kab,tb_kec.nama_kec,tb_desa.nama_desa');
		$this->db->from('tb_petani_lahan');
		$this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id');
		$this->db->join('tb_petani', 'tb_petani_lahan.id_petani = tb_petani.id AND tb_petani.aktif = 1');
		$this->db->join('tb_prov', 'tb_petani_lahan.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_petani_lahan.id_kab = tb_kab.id');
		$this->db->join('tb_kec', 'tb_petani_lahan.id_kec = tb_kec.id');
		$this->db->join('tb_desa', 'tb_petani_lahan.id_desa = tb_desa.id');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
		$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->where_in('tb_user_akses_plant.id_cabang', $names);
		$this->db->where('tb_poktan.aktif',1);

		$data['tampil'] =  $this->db->get()->result_array();
		
		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');		
		$data['tampil2'] =  $this->db->get()->result_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('lahan/index',$data);
		$this->load->view('templates/footer');
	}


	public function tambah(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("lahan") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Tambah Data Lahan';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		
		$data['petani'] = $this->petani_model->getTampilFilterHasilPlant2();
		$data['poktan'] = $this->poktan_model->getTampilFilterHasilPlant2();
		$data['prov'] = $this->db->get('tb_prov')->result_array();
		$data['kab'] = $this->db->get('tb_kab')->result_array();
		$data['kec'] = $this->db->get('tb_kec')->result_array();
		$data['desa'] = $this->db->get('tb_desa')->result_array();

			if($this->session->userdata('multiplant')==0){
			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

			$this->db->select("*");
			$this->db->from('tb_plant_cabang');

			$this->db->where_in('id',$names);
			$data['cabang'] =  $this->db->get()->result_array();	
		}else{

			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

			$this->db->select("*");
			$this->db->from('tb_plant_cabang');

			$this->db->where_in('id',$names);
			$data['cabang'] =  $this->db->get()->result_array();	
		}

		$this->db->select('tb_petani_lahan.*,tb_poktan.nama_poktan,tb_poktan.id_staff,tb_petani.nama_petani,tb_prov.nama_prov,tb_kab.nama_kab,tb_kec.nama_kec,tb_desa.nama_desa');
		$this->db->from('tb_petani_lahan');
		$this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id');
		$this->db->join('tb_petani', 'tb_petani_lahan.id_petani = tb_petani.id');
		$this->db->join('tb_prov', 'tb_petani_lahan.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_petani_lahan.id_kab = tb_kab.id');
		$this->db->join('tb_kec', 'tb_petani_lahan.id_kec = tb_kec.id');
		$this->db->join('tb_desa', 'tb_petani_lahan.id_desa = tb_desa.id');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
		$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->where_in('tb_user_akses_plant.id_cabang', $names);
		$this->db->where('tb_poktan.aktif',1);
		
		$data['tampil'] =  $this->db->get()->result_array();

		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');		
		$data['tampil2'] =  $this->db->get()->result_array();

		$this->form_validation->set_rules('id_poktan','Poktan','required|callback_check_petani_poktan');
		$this->form_validation->set_rules('id_petani','Petani','required|callback_check_petani_poktan');
		$this->form_validation->set_rules('id_prov','Provinsi','required');
		$this->form_validation->set_rules('id_kab','Kabupaten','required');
		$this->form_validation->set_rules('id_kec','Kecamatan','required');
		$this->form_validation->set_rules('id_desa','Desa','required');
		$this->form_validation->set_rules('nama_lahan','Nama Lahan','required');
		$this->form_validation->set_rules('luas','Luas','required|numeric');
		$this->form_validation->set_rules('kepemilikan','Kepemilikan','required');


		// JIKA GAGAL ke VIEW FORM
		if ($this->form_validation->run() == FALSE) {
			$provid = $this->input->post('id_prov',true);
			$kabid = $this->input->post('id_kab',true);
			$kacid = $this->input->post('id_kec',true);

			$data['kab'] = $this->db->get_where('tb_kab', ['id_provinsi' => $provid])->result_array();
			$data['kec'] = $this->db->get_where('tb_kec', ['id_kabupaten' => $kabid])->result_array();
			$data['desa'] = $this->db->get_where('tb_desa', ['id_kecamatan' => $kacid])->result_array();
		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('lahan/index',$data);
		$this->load->view('templates/footer');
		}else{
					
		$data = [
			"id_poktan" => $this->input->post('id_poktan', true),
			"id_petani" => $this->input->post('id_petani',true),
			"id_prov" => $this->input->post('id_prov', true),
			"id_kab" => $this->input->post('id_kab',true),
			"id_kec" => $this->input->post('id_kec', true),
			"id_desa" => $this->input->post('id_desa',true),
			"nama_lahan" => $this->input->post('nama_lahan',true),
			"luas" => $this->input->post('luas',true),
			"kepemilikan" => $this->input->post('kepemilikan', true),
			"in_by" => $this->input->post('in_by',true),
			"in_date" => $this->input->post('in_date',true),
			"edit_by" => $this->input->post('edit_by', true),
			"edit_date" => $this->input->post('edit_date',true),
			"aktif" => 1
		];

			$this->db->insert('tb_petani_lahan',$data);
			$this->session->set_flashdata('message','Data lahan berhasil ditambahkan!');
			redirect('lahan');
	
				}
			}
		function check_petani_poktan() {
		   	$petani = $this->input->post('id_petani');// get fiest name
		    $poktan = $this->input->post('id_poktan');// get last name
		    $this->db->select('*');
		    $this->db->from('tb_petani_lahan');
		    $this->db->where('id_petani', $petani);
		    $this->db->where('id_poktan', $poktan);
		    $query = $this->db->get();
		    $num = $query->num_rows();
		    if ($num > 0) {
		        return FALSE;
		    } else {
		        return TRUE;
		    }
		}

	public function delete($id){
			$data = array(
			"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_petani_lahan', $data);
					$this->session->set_flashdata('message','Data lahan berhasil dihapus!');
					redirect('lahan');
	}

	public function aktif($id){
			$data = array(
			"aktif" => "1"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_petani_lahan', $data);
					$this->session->set_flashdata('message','Data lahan berhasil diaktifkan!');
					redirect('lahan');
	}

	public function fetch(){

			$output = '';
				 if($this->input->post('postaction') == "id_prov"){

				 $data['coba1'] = $this->db->get_where('tb_kab',['id_provinsi' => $this->input->post('query')])->result_array();
				  $output .= '<option value="">Pilih Kabupaten</option>';

				  foreach($data['coba1'] as $row){
 
				  					  	 $output .= '<option value="'.$row["id"].'">'.$row["nama_kab"].'</option>';
				  }
				 }

				 if($this->input->post('postaction') == "id_kab"){

				 $data['coba2'] = $this->db->get_where('tb_kec',['id_kabupaten' => $this->input->post('query')])->result_array();
				  $output .= '<option value="">Pilih Kecamatan</option>';

				  foreach($data['coba2'] as $row2){
				  	 $output .= '<option value="'.$row2["id"].'">'.$row2["nama_kec"].'</option>';
				  }
				 }

				 if($this->input->post('postaction') == "id_kec"){

				 $data['coba3'] = $this->db->get_where('tb_desa',['id_kecamatan' => $this->input->post('query')])->result_array();
				  $output .= '<option value="">Pilih Desa</option>';

				  foreach($data['coba3'] as $row3){
				  	 $output .= '<option value="'.$row3["id"].'">'.$row3["nama_desa"].'</option>';
				  }
				 }
				 
				 echo $output;

			}

		public function petaniFetch(){

			$output = '';
			if($this->input->post('postaction') == "id_poktan_lahan"){


			 $this->db->select("tb_petani.*");
			 $this->db->from('tb_petani');
			 $this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_petani = tb_petani.id',"left");
			 $this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id',"left");
			 $this->db->where('tb_petani.aktif',1);
			 $this->db->where('id_poktan', $this->input->post('query'));
			 $this->db->or_where('tb_poktan.id_staff IS NULL');
			 $data['coba1'] = $this->db->get()->result_array();
			 $output .= '<option value="">Pilih Petani</option>';

			  foreach($data['coba1'] as $row){
				$output .= '<option value="'.$row["id"].'">'.$row["nama_petani"].'</option>';
			  }
			 }
			 
			 echo $output;

		}

	public function tampilFilterPlant(){
		$id_plant = $this->input->post('id_plant');
		$data = $this->lahan_model->getFilterPlant($id_plant);
		echo json_encode($data);		
	}

	public function tampilDataPlant(){
		$id_plant = $this->input->post('id_plant');
		$data = $this->lahan_model->getDataPlant($id_plant);
		echo json_encode($data);		
	}

	public function getdataLahan(){
		$id = $this->input->post('id');

			$this->db->select("*");
			$this->db->from("tb_petani_lahan");
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

			$this->db->select("tb_petani.*");
			$this->db->from("tb_petani");
			$this->db->join('tb_petani_lahan','tb_petani_lahan.id_petani = tb_petani.id');
			$this->db->join('tb_poktan','tb_poktan.id = tb_petani_lahan.id_poktan');
			$this->db->where("id_poktan", $resultAll->id_poktan);
			$this->db->where('tb_poktan.aktif',1);
			$query = $this->db->get();
			$resultPetani = $query->result();

			$resultAll->kab = $resultKab;
			$resultAll->kec = $resultKec;
			$resultAll->desa = $resultDesa;
			$resultAll->petani = $resultPetani;

			echo json_encode($resultAll);
	}

	public function ubahLahan(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("lahan") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Tambah Data Lahan';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['petani'] = $this->petani_model->getTampilFilterHasilPlant2();
		$data['poktan'] = $this->poktan_model->getTampilFilterHasilPlant2();
		$data['prov'] = $this->db->get('tb_prov')->result_array();
		$data['kab'] = $this->db->get('tb_kab')->result_array();
		$data['kec'] = $this->db->get('tb_kec')->result_array();
		$data['desa'] = $this->db->get('tb_desa')->result_array();

			if($this->session->userdata('multiplant')==0){
			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

			$this->db->select("*");
			$this->db->from('tb_plant_cabang');

			$this->db->where_in('id',$names);
			$data['cabang'] =  $this->db->get()->result_array();	
		}else{

			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

			$this->db->select("*");
			$this->db->from('tb_plant_cabang');

			$this->db->where_in('id',$names);
			$data['cabang'] =  $this->db->get()->result_array();	
		}

		$this->db->select('tb_petani_lahan.*,tb_poktan.nama_poktan,tb_poktan.id_staff,tb_petani.nama_petani,tb_prov.nama_prov,tb_kab.nama_kab,tb_kec.nama_kec,tb_desa.nama_desa');
		$this->db->from('tb_petani_lahan');
		$this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id');
		$this->db->join('tb_petani', 'tb_petani_lahan.id_petani = tb_petani.id');
		$this->db->join('tb_prov', 'tb_petani_lahan.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_petani_lahan.id_kab = tb_kab.id');
		$this->db->join('tb_kec', 'tb_petani_lahan.id_kec = tb_kec.id');
		$this->db->join('tb_desa', 'tb_petani_lahan.id_desa = tb_desa.id');
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
		$this->db->join('tb_user_akses_plant', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->where_in('tb_user_akses_plant.id_cabang', $names);

		$data['tampil'] =  $this->db->get()->result_array();

		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');		
		$data['tampil2'] =  $this->db->get()->result_array();



		
			$provid = $this->input->post('id_prov',true);
			$kabid = $this->input->post('id_kab',true);
			$kacid = $this->input->post('id_kec',true);

			$data['kab'] = $this->db->get_where('tb_kab', ['id_provinsi' => $provid])->result_array();
			$data['kec'] = $this->db->get_where('tb_kec', ['id_kabupaten' => $kabid])->result_array();
			$data['desa'] = $this->db->get_where('tb_desa', ['id_kecamatan' => $kacid])->result_array();
			
	
			$data = array(
		    "id_poktan" => $this->input->post('id_poktan', true),
			"id_petani" => $this->input->post('id_petani',true),
			"id_prov" => $this->input->post('id_prov',true),
			"id_kab" => $this->input->post('id_kab',true),
			"id_kec" => $this->input->post('id_kec',true),
			"id_desa" => $this->input->post('id_desa',true),
			"nama_lahan" => $this->input->post('nama_lahan',true),
			"luas" => $this->input->post('luas',true),
			"kepemilikan" => $this->input->post('kepemilikan',true),
			"edit_date" => date("Y-m-d h:i:s"),
			"edit_by" => $this->session->userdata('id_role'),
			"aktif" => $this->input->post('aktif',true)

		);

		$this->db->where('id', $this->input->post('id2',true) );
		$this->db->update('tb_petani_lahan', $data);
		$this->session->set_flashdata('message','Data lahan berhasil diubah!');
		redirect('lahan');
		

	}
	//=======================================================//
	//					PRIVATE FUNCTION 					 //
	//=======================================================//

	private function _gotoPage(){
		$role = $this->session->userdata('id_role');
		if($role == null){
				redirect('auth');
		}
	}
}
?>
