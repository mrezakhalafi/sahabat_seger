<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petani extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model("petani_model");
		$this->_gotoPage();


	}

	public function index(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// show_404();
		// }
		//Buat Nyalain Menu
		$data['title'] = 'Data Petani';
		//Akhir Buat Nyalain Menu
		$data['title2'] = 'Tambah Data Petani';

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
		


		$this->db->select('tb_petani.*,tb_prov.nama_prov,tb_kab.nama_kab,tb_kec.nama_kec,tb_kab.nama_kab,tb_desa.nama_desa,tb_rek_bank.nama_bank,tb_poktan.nama_poktan,tb_user.fullname,tb_poktan.id_staff');
		$this->db->from('tb_petani');
		$this->db->join('tb_prov', 'tb_petani.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_petani.id_kab = tb_kab.id');
		$this->db->join('tb_kec', 'tb_petani.id_kec = tb_kec.id');
		$this->db->join('tb_desa', 'tb_petani.id_desa = tb_desa.id');
		$this->db->join('tb_rek_bank', 'tb_petani.rek_bank = tb_rek_bank.id');
		
		$this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_petani = tb_petani.id',"left");	
		$this->db->join('tb_poktan', 'tb_petani_lahan.id_poktan = tb_poktan.id',"left");
		$this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id',"left");
		$this->db->group_by('tb_petani.id'); 	

		if($this->session->userdata('multiplant')==0){
			$this->db->group_start();
			$this->db->where('tb_user.email',$this->session->userdata('email'));
			$this->db->or_where('tb_poktan.id_staff IS NULL');
			$this->db->group_end();	
		
		}else{

			$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}
			$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id', 'left');
			$this->db->group_start();
			$this->db->where_in('tb_user_akses_plant.id_cabang',$names);
			$this->db->or_where('tb_poktan.id_staff IS NULL');
			$this->db->group_end();	
		}

		$this->db->or_where('tb_poktan.id_staff',null);
		$data['tampil'] =  $this->db->get()->result_array();	

		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['bank'] =  $this->db->get('tb_rek_bank')->result_array();
		$data['prov'] = $this->db->get('tb_prov')->result_array();

		$this->db->select('tb_user_akses_plant.*,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user', 'tb_user_akses_plant.id_user = tb_user.id');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');		
		$data['tampil2'] =  $this->db->get()->result_array();

		$this->db->select('*');
		$this->db->from('tb_poktan');
		$this->db->join('tb_petani_lahan', 'tb_petani_lahan.id_poktan = tb_poktan.id');
		$this->db->join('tb_petani', 'tb_petani.id = tb_petani_lahan.id_petani');
		$this->db->join('tb_user','tb_user.id = tb_poktan.id_staff');
		$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');

		$plant = $this->session->userdata('plant[]');

			foreach($plant as $a){
			    $names[] = $a['id_cabang'];
			}

		$this->db->where_in('id_cabang',$names);		
		$data['tampil3'] =  $this->db->get()->result_array();


		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('petani/index',$data);
		$this->load->view('templates/footer');
	}

	public function tambah(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("petani") == false)){
		// 	show_404();
		// }
		//Buat Nyalain Menu
		$data['title'] = 'Data Petani';
		//Akhir Buat Nyalain Menu
		$data['title2'] = 'Tambah Data Petani';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['bank'] =  $this->db->get('tb_rek_bank')->result_array();
		$data['prov'] = $this->db->get('tb_prov')->result_array();
		
		$this->form_validation->set_rules('nama_petani','Nama','required');
		$this->form_validation->set_rules('no_ktp','No. KTP','required|numeric|min_length[15]|is_unique[tb_petani.no_ktp]');
		$this->form_validation->set_rules('no_kk','No. KK','required|numeric|min_length[15]|is_unique[tb_petani.no_kk]');
		$this->form_validation->set_rules('jns_kelamin','Jenis Kelamin','required');
		$this->form_validation->set_rules('tmpt_lahir','Tempat Lahir','required');
		$this->form_validation->set_rules('tgl_lahir','Tanggal Lahir','required');
		$this->form_validation->set_rules('tlp','Telepon','required|numeric');
		$this->form_validation->set_rules('id_prov','Provinsi','required');
		$this->form_validation->set_rules('id_kab','Kabupaten','required');
		$this->form_validation->set_rules('id_kec','Kecamatan','required');
		$this->form_validation->set_rules('id_desa','Desa','required');		
		$this->form_validation->set_rules('rek_cabang','Rekening Cabang','required');
		$this->form_validation->set_rules('rek_bank','Rekening Bank','required');
		$this->form_validation->set_rules('rek_nama','Nama Rekening','required');
		$this->form_validation->set_rules('rek_no','No Rekening','required|numeric|is_unique[tb_petani.rek_no]');

		if (empty($_FILES['file_kk']['name']))
		{
			$this->form_validation->set_rules('file_ktp','File KTP','required');	
		}

		if (empty($_FILES['file_ktp']['name']))
		{
		   	$this->form_validation->set_rules('file_kk','File KK','required');		
		}
	

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
			$this->load->view('petani/data',$data);
			$this->load->view('templates/footer');
			
			}else{
				$upload_ktp = $_FILES['file_ktp']['name'];
				$upload_kk = $_FILES['file_kk']['name'];
				$new_name = $this->input->post('no_ktp', true);

				//FOR KTP
				$config = array();
				$config['allowed_types'] = 'jpg|png|pdf|doc';
				$config['max_size'] = '2048';
				$config['upload_path'] = './assets/file/petani/file_ktp/'; 
				$config['file_name'] = $new_name;
				$this->load->library('upload', $config, 'coverupload');
				$this->coverupload->initialize($config);
				$upload_cover = $this->coverupload->do_upload('file_ktp');

				//FOR KK
				$new_name2 = $this->input->post('no_kk', true);
				$config = array();
				$config['allowed_types'] = 'jpg|png|pdf|doc';
				$config['max_size'] = '2048';
				$config['upload_path'] = './assets/file/petani/file_kk';
				$config['file_name'] = $new_name2;	
				$this->load->library('upload', $config, 'catalogupload');  
				$this->catalogupload->initialize($config);
				$upload_catalog = $this->catalogupload->do_upload('file_kk');	

				$foto_ktp = $this->coverupload->data('file_name');
				$foto_kk =  $this->catalogupload->data('file_name');	
				$tipe = 	$this->coverupload->data('file_ext');
				$tipe2 = 	$this->catalogupload->data('file_ext');	

				$tgl_lahir = $this->input->post('tgl_lahir', true);
				$tgl_lahir = str_replace('/', '-', $tgl_lahir);
				$tgl_lahir = date('Y-m-d', strtotime($tgl_lahir));

				$data = [
						"nama_petani" => $this->input->post('nama_petani', true),
						"no_ktp" => $this->input->post('no_ktp',true),
						"no_kk" => $this->input->post('no_kk',true),
						"jns_kelamin" => $this->input->post('jns_kelamin',true),
						"tmpt_lahir" => $this->input->post('tmpt_lahir',true),
						"tgl_lahir" => $tgl_lahir,
						"tlp" => '0'.$this->input->post('tlp',true),
						"id_prov" => $this->input->post('id_prov',true),
						"id_kec" => $this->input->post('id_kec',true),
						"id_kab" => $this->input->post('id_kab', true),
						"id_desa" => $this->input->post('id_desa',true),
						"nama_pasangan" => $this->input->post('nama_pasangan',true),
						"file_ktp" => $new_name.$tipe,
						"file_kk" => $new_name2.$tipe2,
						"rek_bank" => $this->input->post('rek_bank',true),
						"rek_cabang" => $this->input->post('rek_cabang',true),
						"rek_nama" => $this->input->post('rek_nama',true),
						"rek_no" => $this->input->post('rek_no', true),
						"in_date" => $this->input->post('in_date',true),
						"in_by" => $this->input->post('in_by',true),
						"edit_date" => $this->input->post('edit_date', true),
						"edit_by" => $this->input->post('edit_by',true),
						"aktif" => 1
					];

			$this->db->insert('tb_petani',$data);
			$this->session->set_flashdata('message','Data petani berhasil ditambahkan!');
			redirect('petani');	
		}
	}

	public function delete($id){
		$data = array(
			"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_petani', $data);
		$this->session->set_flashdata('message','Data petani berhasil dihapus!');
		redirect('petani');
	}

	public function aktif($id){
		$data = array(
			"aktif" => "1"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_petani', $data);
		$this->session->set_flashdata('message','Data petani berhasil diaktifkan!');
		redirect('petani');
	}

	public function getdataPetani(){
		$id = $this->input->post('id');
		$data = $this->petani_model->getDataPetani($id);
		echo json_encode($data);
	}

	public function ubahPetani(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("petani") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Ubah Data Petani';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['get_petani'] = $this->db->get('tb_petani')->row_array();

		$data['petani_img'] = $this->db->get_where('tb_petani',['id' => $this->input->post('id2',true) ])->row_array();

		$data['bank'] =  $this->db->get('tb_rek_bank')->result_array();
		$data['prov'] = $this->db->get('tb_prov')->result_array();
		$data['kab'] = $this->db->get('tb_kab')->result_array();
		$data['kec'] = $this->db->get('tb_kec')->result_array();
		$data['desa'] = $this->db->get('tb_desa')->result_array();

		$this->form_validation->set_rules('nama_petani','Nama','required');
		$this->form_validation->set_rules('no_ktp','No. KTP','numeric|min_length[15]');
		$this->form_validation->set_rules('no_kk','No. KK','numeric|min_length[15]');
		$this->form_validation->set_rules('jns_kelamin','Jenis Kelamin','required');
		$this->form_validation->set_rules('tmpt_lahir','Tempat Lahir','required');
		$this->form_validation->set_rules('tgl_lahir','Tanggal Lahir','required');
		$this->form_validation->set_rules('tlp','Telepon','required|numeric');
		$this->form_validation->set_rules('id_prov','Provinsi','required');
		$this->form_validation->set_rules('id_kab','Kabupaten','required');
		$this->form_validation->set_rules('id_kec','Kecamatan','required');
		$this->form_validation->set_rules('id_desa','Desa','required');		
		$this->form_validation->set_rules('rek_cabang','Rekening Cabang','required');
		$this->form_validation->set_rules('rek_bank','Rekening Bank','required');
		$this->form_validation->set_rules('rek_nama','Nama Rekening','required');
		$this->form_validation->set_rules('rek_no','No Rekening','required|numeric');

		// JIKA GAGAL ke VIEW FORM
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('petani/ubah',$data);
			$this->load->view('templates/footer');
		}else{
			$old_image = $data['petani_img']['file_ktp'];
			$old_image2 = $data['petani_img']['file_kk'];
			$upload_ktp = $_FILES['file_ktp']['name'];
			$upload_kk = $_FILES['file_kk']['name'];

		if (!$upload_ktp) {
			$new_name =  $old_image;
		}else{
			//FOR KTP
			unlink(FCPATH . 'assets/file/petani/file_ktp/' . $old_image);
			$new_name = $this->input->post('no_ktp', true);
			$config = array();
			$config['allowed_types'] = 'jpg|png|pdf|doc';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/file/petani/file_ktp/';
			$config['file_name'] = $new_name;
			$this->load->library('upload', $config, 'coverupload');
    		$this->coverupload->initialize($config);
    		$upload_cover = $this->coverupload->do_upload('file_ktp');

			$foto_ktp = $this->coverupload->data('file_name');
			$tipe = $this->coverupload->data('file_ext');
		}

		if (!$upload_kk) {
			$new_name2 = $old_image2;
		}else{
			//FOR KK
			unlink(FCPATH . 'assets/file/petani/file_kk/' . $old_image2);
			$new_name2 = $this->input->post('no_kk', true);
			$config = array();
			$config['allowed_types'] = 'jpg|png|pdf|doc';
			$config['max_size'] = '2048';
			$config['upload_path'] = './assets/file/petani/file_kk/';
			$config['file_name'] = $new_name2;	
			$this->load->library('upload', $config, 'catalogupload'); 
    		$this->catalogupload->initialize($config);
    		$upload_catalog = $this->catalogupload->do_upload('file_kk');
			$foto_kk =  $this->catalogupload->data('file_name');
			$tipe2 = 	$this->catalogupload->data('file_ext');	

		}
			$tgl_lahir = $this->input->post('tgl_lahir', true);
			$tgl_lahir = str_replace('/', '-', $tgl_lahir);
			$tgl_lahir = date('Y-m-d', strtotime($tgl_lahir));					
			$data = array(
				"nama_petani" => $this->input->post('nama_petani', true),
				"no_ktp" => $this->input->post('no_ktp',true),
				"no_kk" => $this->input->post('no_kk',true),
				"jns_kelamin" => $this->input->post('jns_kelamin',true),
				"tmpt_lahir" => $this->input->post('tmpt_lahir',true),
				"tgl_lahir" => $tgl_lahir,
				"tlp" => '0'.$this->input->post('tlp',true),
				"id_prov" => $this->input->post('id_prov',true),
				"id_kec" => $this->input->post('id_kec',true),
				"id_kab" => $this->input->post('id_kab', true),
				"id_desa" => $this->input->post('id_desa',true),
				"nama_pasangan" => $this->input->post('nama_pasangan',true),
				"file_ktp" => $new_name.$tipe,
				"file_kk" => $new_name2.$tipe2,
				"rek_bank" => $this->input->post('rek_bank',true),
				"rek_cabang" => $this->input->post('rek_cabang',true),
				"rek_nama" => $this->input->post('rek_nama',true),
				"rek_no" => $this->input->post('rek_no', true),
				"edit_date" => date("Y-m-d h:i:s"),
				"edit_by" => $this->session->userdata('id_role'),
				"aktif" => $this->input->post('aktif',true)
			);
			$this->db->where('id', $this->input->post('id2',true) );
			$this->db->update('tb_petani', $data);
			$this->session->set_flashdata('message','Data petani berhasil diubah!');
			redirect('petani');
		}
	}

	public function tampilFilter(){
		$id_poktan = $this->input->post('id_poktan');
		$id_staff = $this->input->post('id_staff');
		$id_plant = $this->input->post('id_plant');
		$data = $this->petani_model->getTampilFilterHasil($id_poktan,$id_staff,$id_plant);
		echo json_encode($data);		
	}

	public function tampilDataPlant(){
		$id_petani = $this->input->post('id_petani');
		$data = $this->petani_model->getDataPlant($id_petani);
		echo json_encode($data);		
	}

	public function tampilDataPoktan(){
		$id_staff = $this->input->post('id_staff');
		$data = $this->petani_model->getDataPoktan($id_staff);
		echo json_encode($data);		
	}	

	public function tampilFilterStaff(){
		$id_staff = $this->input->post('id_staff');
		$id_poktan = $this->input->post('id_poktan');
		$id_plant = $this->input->post('id_plant');
		$data = $this->petani_model->getTampilFilterHasilStaff($id_staff,$id_poktan,$id_plant);
		echo json_encode($data);		
	}

	public function tampilFilterPlant(){
		$id_plant = $this->input->post('id_plant');
		$id_staff = $this->input->post('id_staff');
		$id_poktan = $this->input->post('id_poktan');	
		$data = $this->petani_model->getTampilFilterHasilPlant($id_plant,$id_poktan,$id_staff);
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

?>