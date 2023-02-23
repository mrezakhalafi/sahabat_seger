<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poktantanam extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("poktantanam_model");
		$this->load->model("poktan_model");
		$this->_gotoPage();
		$this->load->helper('url');
	}

	public function index(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Poktan Tanam';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$poktan = $this->input->get('poktan');
		$staff = $this->input->get('staff');

		if($this->session->userdata('multiplant')==0){
			$this->db->where('email',$this->session->userdata('email'));
			$this->db->where('id_role',3);
			$data['staff'] =  $this->db->get('tb_user')->result_array();
		}else{

			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

			$this->db->select('tb_user.fullname,tb_user.id');
			$this->db->from('tb_user');
			$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
			$this->db->where('id_role',3);
			$this->db->where_in('tb_user_akses_plant.id_cabang',$names);
			$data['staff'] =  $this->db->get()->result_array();	
		}

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


		if($this->session->userdata('multiplant')==0){
			$this->db->select("tb_poktan.nama_poktan,tb_poktan.id");
			$this->db->from('tb_poktan');
			$this->db->join('tb_user','tb_user.id = tb_poktan.id_staff');
			$this->db->where('tb_user.email',$this->session->userdata('email'));
			$data['poktan'] = $this->db->get()->result_array();
		}else{
			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}
			$this->db->select("tb_poktan.nama_poktan,tb_poktan.id");
			$this->db->from('tb_poktan');
			$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_poktan.id_staff');

			$this->db->where_in('id_cabang',$names);
			$data['poktan'] =  $this->db->get()->result_array();	
		}
		
		$this->db->select('tb_poktan_tanam.*,tb_poktan.nama_poktan,tb_user.fullname');
		$this->db->from('tb_poktan_tanam');
		$this->db->join('tb_poktan', 'tb_poktan_tanam.id_poktan = tb_poktan.id');
		$this->db->join('tb_user', 'tb_poktan_tanam.staff = tb_user.id');
		// $this->db->join('tb_petani_lahan_hsl','tb_petani_lahan_hsl.id_tanam = tb_poktan_tanam.id','left');

		if($this->session->userdata('multiplant')==0){

			$this->db->where('tb_user.email',$this->session->userdata('email'));
			$data['tampil'] =  $this->db->get()->result_array();	
		
		}else{

			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}
			$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
			$this->db->where_in('tb_user_akses_plant.id_cabang',$names);
			$data['tampil'] =  $this->db->get()->result_array();	
		}

		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');		
		$data['tampil2'] =  $this->db->get()->result_array();


		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('poktantanam/index',$data);
		$this->load->view('templates/footer');
	}

	public function direct(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("poktantanam") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Poktan Tanam';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$poktan = $this->input->get('poktan');
		$staff = $this->input->get('staff');

		$data['staff'] =  $this->db->get('tb_user')->result_array();
		$data['cabang'] = $this->db->get('tb_plant_cabang')->result_array();
		$data['plant'] = $this->db->get('tb_plant')->result_array();

		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');		
		$data['tampil2'] =  $this->db->get()->result_array();

		$this->db->select('tb_poktan_tanam.*,tb_poktan.nama_poktan,tb_user.fullname');
		$this->db->from('tb_poktan_tanam');
		$this->db->join('tb_poktan', 'tb_poktan_tanam.id_poktan = tb_poktan.id');
		$this->db->join('tb_user', 'tb_poktan_tanam.staff = tb_user.id');

		$id = $this->input->get('id');

		if ($poktan) {
			$this->db->where('id_poktan', $poktan);
		}if($staff){
			$this->db->where('staff', $staff);
		}
		$this->db->where('tb_poktan_tanam.id', $id);
		$data['tampil'] =  $this->db->get()->result_array();

		$data['poktan'] = $this->db->get('tb_poktan')->result_array();
		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('poktantanam/index',$data);
		$this->load->view('templates/footer');
	}

	public function tambah(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("poktantanam") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Poktan Tanam';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['poktan'] =  $this->poktan_model->getTampilFilterHasilPlant2();
	

		if($this->session->userdata('multiplant')==0){
			$this->db->where('email',$this->session->userdata('email'));
			$this->db->where('id_role',3);
			$data['staff'] =  $this->db->get('tb_user')->result_array();
		}else{

			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

			$this->db->select('tb_user.fullname,tb_user.id');
			$this->db->from('tb_user');
			$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
			$this->db->where('id_role',3);
			$this->db->where_in('tb_user_akses_plant.id_cabang',$names);
			$data['staff'] =  $this->db->get()->result_array();	
		}


		$this->form_validation->set_rules('id_poktan','Poktan','required');
		$this->form_validation->set_rules('tgl_tanam','Tanggal Tanam','required');
		$this->form_validation->set_rules('luas_tanam','Luas Tanam','required|less_than['.$this->input->post('value123').']');

		$this->form_validation->set_rules('pengairan1','Pengairan 1','required');
		$this->form_validation->set_rules('pemupukan1','Pemupukan 1','required|numeric');
		$this->form_validation->set_rules('pemupukan2','Pemupukan 2','numeric');
		$this->form_validation->set_rules('prediksi_tonase','Prediksi Tonase','numeric');
		$this->form_validation->set_rules('staff','Staff','required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('poktantanam/tambah',$data);
			$this->load->view('templates/footer');
		}else {
			$tgl_tanam = $this->input->post('tgl_tanam', true);
			$tgl_tanam = str_replace('/', '-', $tgl_tanam);
			$tgl_tanam = date('Y-m-d', strtotime($tgl_tanam));
			$tgl_panen = $this->input->post('tgl_panen', true);
			$tgl_panen = str_replace('/', '-', $tgl_panen);
			$tgl_panen = date('Y-m-d', strtotime($tgl_panen));

			$data = [
				"id_poktan" => $this->input->post('id_poktan', true),
				"tgl_tanam" => $tgl_tanam,
				"tgl_panen" => $tgl_panen,
				"luas_tanam" => $this->input->post('luas_tanam',true),
				"pengairan1" => $this->input->post('pengairan1', true),
				"pemupukan1" => $this->input->post('pemupukan1',true),
				"penjarangan" => $this->input->post('penjarangan',true),
				"penyiangan" => $this->input->post('penyiangan', true),
				"penyakit" => $this->input->post('penyakit',true),
				"penyakit_desc" => $this->input->post('penyakit_desc',true),
				"pemupukan2" => $this->input->post('pemupukan2', true),
				"pengairan2" => $this->input->post('pengairan2',true),
				"pengairan3" => $this->input->post('pengairan3',true),
				"prediksi_tonase" => $this->input->post('prediksi_tonase',true),
				"in_date" => $this->input->post('in_date',true),
				"in_by" => $this->input->post('in_by',true),
				"edit_date" => $this->input->post('edit_date', true),
				"edit_by" => $this->input->post('edit_by',true),
				"staff" => $this->input->post('staff',true),
				"aktif" => 1
			];
			
			$this->db->insert('tb_poktan_tanam',$data);
			$this->session->set_flashdata('message','Data poktan tanam berhasil ditambahkan!');
			redirect('poktantanam');
		}
	}

	public function fetchpoktantanam(){
		$id = $this->input->post('id');
		$data = $this->poktantanam_model->getDataPoktanLahan($id);
		echo json_encode($data);
	}

	public function tampilKunjungan(){
		$tanggal = $this->input->post('tgl');
		$staff = $this->input->post('staff');
		$data = $this->poktantanam_model->getTampilKunjunganHasil($tanggal, $staff);
		$data2 = $this->poktantanam_model->getTampilKunjunganHasilLibur($tanggal, $staff);
		$data3 = array_merge($data,$data2);
		echo json_encode($data3);		
	}

	public function tampilStatus(){
		$tanam = $this->input->post('tanam');
		$data = $this->poktantanam_model->getStatusTanam($tanam);
		echo json_encode($data);		
	}

	public function tampilKunjunganLibur(){
		$tanggal = $this->input->post('tgl');
		$staff = $this->input->post('staff');
		$data2 = $this->poktantanam_model->getTampilKunjunganHasilLibur($tanggal, $staff);
		echo json_encode($data2);		
	}

	public function tampilFilter(){
		$id_poktan = $this->input->post('id_poktan');
		$id_staff = $this->input->post('id_staff');
		$id_plant = $this->input->post('id_plant');
		$data = $this->poktantanam_model->getTampilFilterHasil($id_poktan,$id_staff,$id_plant);
		echo json_encode($data);		
	}

	public function tampilFilterStaff(){
		$id_staff = $this->input->post('id_staff');
		$id_plant = $this->input->post('id_plant');
		$id_poktan = $this->input->post('id_poktan');		
		$data = $this->poktantanam_model->getTampilFilterHasilStaff($id_staff,$id_plant,$id_poktan);
		echo json_encode($data);		
	}

	public function tampilFilterPlant(){
		$id_plant = $this->input->post('id_plant');
		$id_poktan = $this->input->post('id_poktan');
		$id_staff = $this->input->post('id_staff');
		$data = $this->poktantanam_model->getTampilFilterHasilPlant($id_plant,$id_poktan,$id_staff);
		echo json_encode($data);		
	}

	public function tampilDataPlant(){
		$id_tanam = $this->input->post('id_tanam');
		$data = $this->poktantanam_model->getDataPlant($id_tanam);
		echo json_encode($data);		
	}

	public function getdatahasilPanen(){
		$id_hasil = $this->input->post('id');
		$data = $this->poktantanam_model->getdatahasil($id_hasil);
		echo json_encode($data);	
	}

	public function ubahHasil(){
		$data['title'] = 'Data Poktan Tanam';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();

		$data = [
				"id_lahan" => $this->input->post('id_lahan', true),
				"id_tanam" => $this->input->post('id_tanam', true),
				"luas_tanam" => $this->input->post('luas_tanam2', true),
				"hasil_panen" => $this->input->post('hasil_panen', true),
				"kadar_air" => $this->input->post('kadar_air', true)
		];
		$this->db->where('id_tanam', $this->input->post('id_tanam', true));
		$this->db->update('tb_petani_lahan_hsl', $data);
		$this->session->set_flashdata('message','Data hasil panen berhasil diubah!');
			redirect('poktantanam');
	}

	public function delete($id){
		$data = array(
		"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_poktan_tanam', $data);
		$this->session->set_flashdata('message','Data poktan berhasil dihapus!');
			redirect('poktantanam');	
	}

	public function aktif($id){
		$data = array(
		"aktif" => "1"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_poktan_tanam', $data);
		$this->session->set_flashdata('message','Data poktan berhasil diaktifkan!');
			redirect('poktantanam');	
	}

	public function ubahpoktanTanam(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("poktantanam") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Poktan Tanam';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
        $data['poktan'] =  $this->poktan_model->getTampilFilterHasilPlant2();

			if($this->session->userdata('multiplant')==0){
				$this->db->where('email',$this->session->userdata('email'));
				$this->db->where('id_role',3);
				$data['staff'] =  $this->db->get('tb_user')->result_array();
			}else{

				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
				    $names[] = $a['id_cabang'];
				}

				$this->db->select('tb_user.fullname,tb_user.id');
				$this->db->from('tb_user');
				$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
				$this->db->where('id_role',3);
				$this->db->where_in('tb_user_akses_plant.id_cabang',$names);
				$data['staff'] =  $this->db->get()->result_array();	
			}


		$this->form_validation->set_rules('id_poktan','Poktan','required');
		$this->form_validation->set_rules('tgl_tanam','Tanggal Tanam','required');
		$this->form_validation->set_rules('luas_tanam','Luas Tanam','required');
		$this->form_validation->set_rules('pengairan1','Pengairan1','required');
		$this->form_validation->set_rules('pemupukan1','Pemupukan1','required');
		$this->form_validation->set_rules('prediksi_tonase','Prediksi Tonase','numeric');


		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('poktantanam/ubah',$data);
			$this->load->view('templates/footer');
		}else {
			$tgl_tanam = $this->input->post('tgl_tanam', true);
			$tgl_tanam = str_replace('/', '-', $tgl_tanam);
			$tgl_tanam = date('Y-m-d', strtotime($tgl_tanam));
			$tgl_panen = $this->input->post('tgl_panen', true);
			$tgl_panen = str_replace('/', '-', $tgl_panen);
			$tgl_panen = date('Y-m-d', strtotime($tgl_panen));

			$data = [
				"id_poktan" => $this->input->post('id_poktan', true),
				"tgl_tanam" => $tgl_tanam,
				"tgl_panen" => $tgl_panen,
				"luas_tanam" => $this->input->post('luas_tanam',true),
				"pengairan1" => $this->input->post('pengairan1', true),
				"pemupukan1" => $this->input->post('pemupukan1',true),
				"penjarangan" => $this->input->post('penjarangan',true),
				"pemupukan2" => $this->input->post('pemupukan2', true),
				"pengairan2" => $this->input->post('pengairan2',true),
				"pengairan3" => $this->input->post('pengairan3',true),
				"prediksi_tonase" => $this->input->post('prediksi_tonase',true),
				"edit_date" => date("Y-m-d h:i:s"),
				"edit_by" => $this->session->userdata('id_role'),
				"staff" => $this->input->post('staff', true),
				"aktif" => $this->input->post('aktif',true)
			];

			$this->db->where('id', $this->input->post('id2', true));
			$this->db->update('tb_poktan_tanam', $data);
			$this->session->set_flashdata('message','Data poktan berhasil diubah!');
			redirect('poktantanam');
		}
	}

	public function getdatapoktanTanam(){
		$id = $this->input->post('id');
		$data = $this->poktantanam_model->getDataPoktanTanam($id);
		echo json_encode($data);
	}


	public function getdatapoktanTanam120(){
		$id = $this->input->post('id');
		$data = $this->poktantanam_model->getDataPoktanTanam120($id);
		echo json_encode($data);
	}

	public function fetch(){

		$output = '';
		$meong = $this->input->post('query');

		$this->db->select('tb_user_akses_plant.id_user,tb_user_akses_plant.id_cabang,tb_user.*');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user','tb_user_akses_plant.id_user = tb_user.id');
		$this->db->where_in('id_cabang' , $meong);
		$data['coba1'] = $this->db->get()->result_array();

		  foreach($data['coba1'] as $row){
			$output .= '<option value="'.$row["id"].'">'.$row["fullname"].'</option>';
		 	 }	  
		 echo $output;
	}

	public function tambahHasil(){
		$data['title'] = 'Data Poktan Tanam';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();

		$data = [
				"id_lahan" => $this->input->post('id_lahan', true),
				"id_tanam" => $this->input->post('id_tanam', true),
				"luas_tanam" => $this->input->post('luas_tanam2', true),
				"hasil_panen" => $this->input->post('hasil_panen', true),
				"kadar_air" => $this->input->post('kadar_air', true)
		];

			
		$this->db->insert('tb_petani_lahan_hsl',$data);
		$this->session->set_flashdata('message','Data hasil tanam berhasil ditambahkan!');
		redirect('poktantanam');

	}	

	public function cekhasil(){
		$this->db->select('id_tanam');
		$this->db->from('tb_petani_lahan_hsl');
		$data =  $this->db->get()->row_array();
		echo json_encode($data);
	}

	public function staffFetch(){

			$output = '';
			if($this->input->post('postaction') == "id_poktan_tanam"){
			 $this->db->select("tb_user.*,tb_poktan.id_staff");
			 $this->db->from('tb_user');
			 $this->db->join('tb_poktan', 'tb_user.id = tb_poktan.id_staff');
			 $this->db->where('tb_poktan.aktif',1);
			 $this->db->where('tb_poktan.id', $this->input->post('query'));
			 $data['coba1'] = $this->db->get()->result_array();
			 $output .= '<option value="">Pilih Staff</option>';
			  foreach($data['coba1'] as $row){
				$output .= '<option value="'.$row["id_staff"].'">'.$row["fullname"].'</option>';
			  }
			 }
			 
			 echo $output;

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
