<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poktan extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("poktan_model");
		$this->_gotoPage();
	}

	public function index(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Poktan';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		
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
		$this->load->view('poktan/index',$data);
		$this->load->view('templates/footer');
	}

	public function tambah(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("poktan") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Tambah Data Poktan';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['bank'] =  $this->db->get('tb_rek_bank')->result_array();


		if($this->session->userdata('multiplant')==0){
			$this->db->where('id_role',3);
			$this->db->where('email',$this->session->userdata('email'));
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

		$data['mitra'] = $this->db->get('tb_jns_mitra')->result_array();
		$data['komuditi'] = $this->db->get('tb_komuditi')->result_array();
		$data['prov'] = $this->db->get('tb_prov')->result_array();		

		$this->form_validation->set_rules('id_staff','Staff','required');
		$this->form_validation->set_rules('id_jenis_mitra','Jenis Mitra','required');
		$this->form_validation->set_rules('id_komuditi','Komuditi','required');
		$this->form_validation->set_rules('id_desa','Desa','required');
		$this->form_validation->set_rules('id_kecamatan','Kecamatan','required');
		$this->form_validation->set_rules('id_kabupaten','Kabupaten','required');
		$this->form_validation->set_rules('id_provinsi','Provinsi','required');
		$this->form_validation->set_rules('nama_poktan','Nama Poktan','required|is_unique[tb_poktan.nama_poktan]');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('ketua','Ketua','required');
		$this->form_validation->set_rules('sekretaris','Sekretaris','required');
		$this->form_validation->set_rules('bendahara','Bandahara','required');
		$this->form_validation->set_rules('rek_bank','Rekening Bank','required');
		$this->form_validation->set_rules('rek_cabang','Rekening Cabang','required');
		$this->form_validation->set_rules('rek_nama','Nama Rekening','required');
		$this->form_validation->set_rules('rek_no','No. Rekening','required|numeric|is_unique[tb_poktan.rek_no]');
		$this->form_validation->set_rules('tlp','No. Telepon','required|numeric');		
		// JIKA GAGAL ke VIEW FORM
		if ($this->form_validation->run() == FALSE) {
			$provid= $this->input->post('id_provinsi',true);
			$kabid = $this->input->post('id_kabupaten',true);
			$kecid = $this->input->post('id_kecamatan',true);

			$data['kab'] = $this->db->get_where('tb_kab', ['id_provinsi' => $provid])->result_array();
			$data['kec'] = $this->db->get_where('tb_kec', ['id_kabupaten' => $kabid])->result_array();
			$data['desa'] = $this->db->get_where('tb_desa', ['id_kecamatan' => $kecid])->result_array();
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('poktan/tambah',$data);
			$this->load->view('templates/footer');
		}else{

		$provid= $this->input->post('id_provinsi',true);
		$kabid = $this->input->post('id_kabupaten',true);
		$kecid = $this->input->post('id_kecamatan',true);
			
		$data['kab'] = $this->db->get_where('tb_kab', ['id_provinsi' => $provid])->result_array();
		$data['kec'] = $this->db->get_where('tb_kec', ['id_kabupaten' => $kabid])->result_array();
		$data['desa'] = $this->db->get_where('tb_desa', ['id_kecamatan' => $kecid])->result_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('poktan/tambah',$data);
		$this->load->view('templates/footer');

			$data = [
				"id_staff" => $this->input->post('id_staff', true),
				"id_jenis_mitra" => $this->input->post('id_jenis_mitra',true),
				"id_komuditi" => $this->input->post('id_komuditi',true),
				"id_desa" => $this->input->post('id_desa', true),
				"id_kecamatan" => $this->input->post('id_kecamatan',true),
				"id_kabupaten" => $this->input->post('id_kabupaten',true),
				"id_provinsi" => $this->input->post('id_provinsi',true),
				"id_kabupaten" => $this->input->post('id_kabupaten',true),
				"nama_poktan" => $this->input->post('nama_poktan',true),			
				"alamat" => $this->input->post('alamat', true),
				"email" => $this->input->post('email',true),
				"ketua" => $this->input->post('ketua',true),
				"sekretaris" => $this->input->post('sekretaris',true),
				"bendahara" => $this->input->post('bendahara', true),
				"rek_bank" => $this->input->post('rek_bank',true),
				"rek_cabang" => $this->input->post('rek_cabang',true),
				"rek_nama" => $this->input->post('rek_nama',true),
				"rek_no" => $this->input->post('rek_no', true),
				"in_date" => $this->input->post('in_date',true),
				"in_by" => $this->input->post('in_by',true),
				"edit_date" => $this->input->post('edit_date', true),
				"edit_by" => $this->input->post('edit_by',true),
				"tlp" => '0'.$this->input->post('tlp',true),
				"aktif" => 1
			];

			$this->db->insert('tb_poktan',$data);
			$this->session->set_flashdata('message','Data poktan berhasil ditambahkan!');
			redirect('poktan');
	
	}
}

	public function delete($id){
		$data = array(
			"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_poktan', $data);
		$this->session->set_flashdata('message','Data poktan berhasil dihapus!');
		redirect('poktan');	
	}

	public function aktif($id){
		$data = array(
			"aktif" => "1"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_poktan', $data);
		$this->session->set_flashdata('message','Data poktan berhasil diaktifkan!');
		redirect('poktan');	
	}

	public function getdataPoktan(){
		$id = $this->input->post('id');
		$data = $this->poktan_model->getDataPoktan($id);
		echo json_encode($data);
	}

	public function ubah(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("poktan") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Ubah Data Poktan';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['get_poktan'] = $this->db->get('tb_poktan')->row_array();

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

		$data['mitra'] = $this->db->get('tb_jns_mitra')->result_array();
		$data['komuditi'] = $this->db->get('tb_komuditi')->result_array();
		$data['prov'] = $this->db->get('tb_prov')->result_array();
		$data['kab'] = $this->db->get('tb_kab')->result_array();
		$data['kec'] = $this->db->get('tb_kec')->result_array();
		$data['desa'] = $this->db->get('tb_desa')->result_array();	
		$data['bank'] =  $this->db->get('tb_rek_bank')->result_array();

		$this->form_validation->set_rules('id_staff','Staff','required');
		$this->form_validation->set_rules('id_jenis_mitra','Jenis Mitra','required');
		$this->form_validation->set_rules('id_komuditi','Komuditi','required');
		$this->form_validation->set_rules('id_desa','Desa','required');
		$this->form_validation->set_rules('id_kec','Kecamatan','required');
		$this->form_validation->set_rules('id_kab','Kabupaten','required');
		$this->form_validation->set_rules('id_prov','Provinsi','required');
		$this->form_validation->set_rules('nama_poktan','Nama Poktan','required');
		$this->form_validation->set_rules('alamat','Alamat','required');
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('ketua','Ketua','required');
		$this->form_validation->set_rules('sekretaris','Sekretaris','required');
		$this->form_validation->set_rules('bendahara','Bandahara','required');
		$this->form_validation->set_rules('rek_bank','Rekening Bank','required');
		$this->form_validation->set_rules('rek_cabang','Rekening Cabang','required');
		$this->form_validation->set_rules('rek_nama','Nama Rekening','required');
		$this->form_validation->set_rules('rek_no','No. Rekening','required|numeric');
		$this->form_validation->set_rules('tlp','Nama Telepon','required|numeric');	

		// JIKA GAGAL ke VIEW FORM
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('poktan/ubah',$data);
			$this->load->view('templates/footer');
		}else{
			$data = array(
				"id_staff" => $this->input->post('id_staff', true),
				"id_jenis_mitra" => $this->input->post('id_jenis_mitra',true),
				"id_komuditi" => $this->input->post('id_komuditi',true),
				"id_desa" => $this->input->post('id_desa', true),
				"id_kecamatan" => $this->input->post('id_kec',true),
				"id_provinsi" => $this->input->post('id_prov',true),
				"id_kabupaten" => $this->input->post('id_kab',true),
				"nama_poktan" => $this->input->post('nama_poktan',true),			
				"alamat" => $this->input->post('alamat', true),
				"email" => $this->input->post('email',true),
				"ketua" => $this->input->post('ketua',true),
				"sekretaris" => $this->input->post('sekretaris',true),
				"bendahara" => $this->input->post('bendahara', true),
				"rek_bank" => $this->input->post('rek_bank',true),
				"rek_cabang" => $this->input->post('rek_cabang',true),
				"rek_nama" => $this->input->post('rek_nama',true),
				"rek_no" => $this->input->post('rek_no', true),
				"edit_date" => date("Y-m-d h:i:s"),
				"edit_by" => $this->session->userdata('id_role'),
				"tlp" => '0'.$this->input->post('tlp',true),
				"aktif" => $this->input->post('aktif',true)
			);

			$this->db->where('id', $this->input->post('id2',true) );
			$this->db->update('tb_poktan', $data);
			$this->session->set_flashdata('message','Data poktan berhasil diubah!');
			redirect('poktan');
		}
	}

	public function tampilFilterStaff(){
		$id_staff = $this->input->post('id_staff');
		$id_plant = $this->input->post('id_plant');
		$data = $this->poktan_model->getTampilFilterHasilStaff($id_staff,$id_plant);
		echo json_encode($data);		
	}

	public function tampilDataPlant(){
		$id_poktan = $this->input->post('id_poktan');
		$data = $this->poktan_model->getDataPlant($id_poktan);
		echo json_encode($data);		
	}

	public function tampilFilterPlant(){
		$id_plant = $this->input->post('id_plant');
		$id_staff = $this->input->post('id_staff');
		$data = $this->poktan_model->getTampilFilterHasilPlant($id_plant,$id_staff);
		echo json_encode($data);		
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