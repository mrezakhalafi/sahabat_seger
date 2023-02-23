<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokpoktan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("dokpoktan_model");
		$this->load->model("Poktan_model");
		$this->_gotoPage();
	}


	public function index(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Dokumen Poktan';

        $plant = $this->session->userdata('plant[]');
        foreach($plant as $a){
            $names[] = $a['id_cabang'];
        }

		$this->db->select('tb_poktan_dok.*,tb_poktan.nama_poktan,tb_jns_dok.jns_dokumen');
		$this->db->from('tb_poktan_dok');
		$this->db->join('tb_poktan', 'tb_poktan_dok.id_poktan = tb_poktan.id');
		$this->db->join('tb_jns_dok', 'tb_poktan_dok.id_jns_dok = tb_jns_dok.id');
        $this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
        $this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
        $this->db->where_in('tb_user_akses_plant.id_cabang',$names);
        $this->db->where('tb_poktan.aktif',1);
		$data['dokpoktan'] = $this->db->get()->result_array();
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();

		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['poktan'] =  $this->Poktan_model->getTampilFilterHasilPlant2();
		$data['jns_dok'] = $this->db->get('tb_jns_dok')->result_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('dokpoktan/index',$data);
		$this->load->view('templates/footer');
	}

	public function tambah(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("dokpoktan") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Tambah Data Dokumen Poktan';

        $plant = $this->session->userdata('plant[]');
        foreach($plant as $a){
            $names[] = $a['id_cabang'];
        }

		$this->db->select('tb_poktan_dok.*,tb_poktan.nama_poktan,tb_jns_dok.jns_dokumen');
		$this->db->from('tb_poktan_dok');
		$this->db->join('tb_poktan', 'tb_poktan_dok.id_poktan = tb_poktan.id');
		$this->db->join('tb_jns_dok', 'tb_poktan_dok.id_jns_dok = tb_jns_dok.id');
        $this->db->join('tb_user', 'tb_poktan.id_staff = tb_user.id');
        $this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
        $this->db->where_in('tb_user_akses_plant.id_cabang',$names);
       	$this->db->where('tb_poktan.aktif',1);
		$data['dokpoktan'] = $this->db->get()->result_array();

		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['jns_dok'] = $this->db->get('tb_jns_dok')->result_array();
		$data['poktan'] =  $this->Poktan_model->getTampilFilterHasilPlant2();
		$data['dokpok'] = $this->db->get('tb_jns_dok')->result_array();

		$this->form_validation->set_rules('id_poktan','Poktan','required');
		$this->form_validation->set_rules('id_jns_dok','Jenis Dokumen','required');

		if (empty($_FILES['file_dokpoktan']['name']))
		{
		    $this->form_validation->set_rules('file_dokpoktan','File Dokumen','required');
		}

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('dokpoktan/index',$data);
			$this->load->view('templates/footer');
		}else{
			$upload_ktp = $_FILES['file_dokpoktan']['name'];
			//FOR KTP
			$config = array();
			$config['allowed_types'] = 'jpg|png|pdf|doc';
			$config['max_size'] = '2048';

			$folder = $this->db->get_where('tb_jns_dok',['id' => $this->input->post('id_jns_dok',true)])->row_array();

			$config['upload_path'] = './assets/file/poktan/'.$this->input->post('id_poktan', true).'/'.$folder['jns_dokumen'];
			mkdir($config['upload_path'],0755,TRUE);
			$this->load->library('upload', $config, 'coverupload'); // Create custom object for cover upload
			$this->coverupload->initialize($config);
			$this->coverupload->do_upload('file_dokpoktan');
			$file_poktan = $this->coverupload->data('file_name');

			$data = [
				"id_poktan" => $this->input->post('id_poktan', true),
				"id_jns_dok" => $this->input->post('id_jns_dok',true),
				"location" => $config['upload_path'].'/'.$file_poktan,
				"file_poktan" => $file_poktan,
				"in_date" => $this->input->post('in_date',true),
				"in_by" => $this->input->post('in_by',true),
				"edit_date" => $this->input->post('edit_date', true),
				"edit_by" => $this->input->post('edit_by',true),
				"aktif" => 1
			];
				$this->db->insert('tb_poktan_dok',$data);
				$this->session->set_flashdata('message','Data dokumen poktan berhasil ditambahkan!');
				redirect('dokpoktan');
		}
	}


	public function delete($id){
		$data = array(
			"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_poktan_dok', $data);
		$this->session->set_flashdata('message','Data dokumen poktan berhasil dihapus!');
		redirect('dokpoktan');
	}

	public function aktif($id){
		$data = array(
			"aktif" => "1"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_poktan_dok', $data);
		$this->session->set_flashdata('message','Data dokumen poktan berhasil diaktifkan!');
		redirect('dokpoktan');
	}

	public function getdataDokpok(){
		$id = $this->input->post('id');
		$data = $this->dokpoktan_model->getDokPok($id);
		echo json_encode($data);
	}

	public function ubahData(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("dokpoktan") == false)){
		// 	show_404();
		// }
		$data['dok_poktan'] = $this->db->get_where('tb_poktan_dok',['id' => $this->input->post('id2',true) ])->row_array();
		$old_image = $data['dok_poktan']['file_poktan'];
		$folder = $this->db->get_where('tb_jns_dok',['id' => $this->input->post('id_jns_dok',true)])->row_array();

		$config['upload_path'] = './assets/file/poktan/'.$this->input->post('id_poktan', true).'/'.$folder['jns_dokumen'];

		$path = './assets/file/poktan/'.$this->input->post('id_poktan', true).'/'.$folder['jns_dokumen'];
		mkdir($config['upload_path'],0755,TRUE);
		$dok_poktan = $_FILES['file_dokpoktan']['name'];

		if(!$dok_poktan){
			$file_poktan =  $old_image;
		}else{
			//FOR KTP
			$config = array();
			$config['allowed_types'] = 'jpg|png|pdf|doc';
			$config['max_size'] = '2048';
			$config['upload_path'] = $path;
			$this->load->library('upload', $config, 'coverupload');
			$this->coverupload->initialize($config);
			$upload_cover = $this->coverupload->do_upload('file_dokpoktan');

			if ($upload_cover) {
				unlink(FCPATH . './assets/file/poktan/'.$this->input->post('id_poktan', true).'/'.$folder['jns_dokumen'].'/'.$old_image);
			}

			$file_poktan = $this->coverupload->data('file_name');
		}

		$data = array(
			"id_poktan" => $this->input->post('id_poktan', true),
			"id_jns_dok" => $this->input->post('id_jns_dok',true),
			"location" => $path.'/'.$file_poktan,
			"file_poktan" => $file_poktan,
			"edit_date" => date("Y-m-d h:i:s"),
			"edit_by" => $this->session->userdata('id_role'),
			"aktif" => $this->input->post('aktif',true)
		);
		$this->db->where('id', $this->input->post('id2',true) );
		$this->db->update('tb_poktan_dok', $data);
		$this->session->set_flashdata('message','Data dokumen poktan berhasil diubah!');
		redirect('dokpoktan');
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
