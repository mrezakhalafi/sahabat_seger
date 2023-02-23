<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Cabang_model");
		$this->_gotoPage();
	}

	public function index(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// 	show_404();
		// }

		$data['title'] = 'Data Cabang';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		$this->db->select('tb_plant_cabang.*,tb_prov.nama_prov,tb_kab.nama_kab,tb_plant.nama_plant');
		$this->db->from('tb_plant_cabang');
		$this->db->join('tb_prov', 'tb_plant_cabang.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_plant_cabang.id_kab = tb_kab.id');
		$this->db->join('tb_plant', 'tb_plant_cabang.id_plant = tb_plant.id');
		$data['tampil'] =  $this->db->get()->result_array();

		$this->db->where('aktif',1);
		$data['plant'] = $this->db->get('tb_plant')->result_array();
		$data['prov'] = $this->db->get('tb_prov')->result_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('cabang/index',$data);
		$this->load->view('templates/footer');
	}

	public function tambahCabang(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url('cabang') == false)){
		// 	show_404();
		// }

		$data['title'] = 'Data Cabang';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		$this->db->select('tb_plant_cabang.*,tb_prov.nama_prov,tb_kab.nama_kab,tb_plant.nama_plant');
		$this->db->from('tb_plant_cabang');
		$this->db->join('tb_prov', 'tb_plant_cabang.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_plant_cabang.id_kab = tb_kab.id');
		$this->db->join('tb_plant', 'tb_plant_cabang.id_plant = tb_plant.id');
		$data['tampil'] =  $this->db->get()->result_array();

		$data['plant'] = $this->db->get('tb_plant')->result_array();
		$data['prov'] = $this->db->get('tb_prov')->result_array();

		$this->form_validation->set_rules('id_plant','Nama Plant','required');
		$this->form_validation->set_rules('kode_cabang','Kode Cabang','required|is_unique[tb_plant_cabang.kode_cabang]');
		$this->form_validation->set_rules('nama_cabang','Nama Cabang','required|is_unique[tb_plant_cabang.nama_cabang]');
		$this->form_validation->set_rules('id_prov','Provinsi','required');
		$this->form_validation->set_rules('id_kab','Kabupaten','required');

		if ($this->form_validation->run() == FALSE) {
			$provid = $this->input->post('id_prov',true);
			$data['kab'] = $this->db->get_where('tb_kab', ['id_provinsi' => $provid])->result_array();
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('cabang/index',$data);
			$this->load->view('templates/footer');
		}else{

			$data = array(
		      	"id_plant" => $this->input->post('id_plant', true),
				"kode_cabang" => $this->input->post('kode_cabang',true),
				"nama_cabang" => $this->input->post('nama_cabang',true),
				"id_prov" => $this->input->post('id_prov',true),
				"id_kab" => $this->input->post('id_kab',true),
				"aktif" => 1
			);

			$this->db->insert('tb_plant_cabang',$data);
			$this->session->set_flashdata('message','Data cabang berhasil ditambahkan!');
			redirect('cabang');
			
		}
	}

	public function delete($id){
		$data = array(
			"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_plant_cabang', $data);
		$this->session->set_flashdata('message','Data cabang berhasil dihapus!');
		redirect('cabang');
	}

	public function aktif($id){
		$data = array(
			"aktif" => "1"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_plant_cabang', $data);
		$this->session->set_flashdata('message','Data cabang berhasil diaktifkan!');
		redirect('cabang');
	}
	
	public function getData(){
		$id = $this->input->post('id');
		$this->db->select("*");
		$this->db->from("tb_plant_cabang");
		$this->db->where("id", $id);
		$query = $this->db->get();
		$result = $query->row();

		$this->db->select("*");
		$this->db->from("tb_kab");
		$this->db->where("id_provinsi", $result->id_prov);
		$query = $this->db->get();
		$resultKab = $query->result();
		$result->kab = $resultKab;
		echo json_encode($result);
	}

	public function ubahData(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("cabang") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Cabang';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		$this->db->select('tb_plant_cabang.*,tb_prov.nama_prov,tb_kab.nama_kab,tb_plant.nama_plant');
		$this->db->from('tb_plant_cabang');
		$this->db->join('tb_prov', 'tb_plant_cabang.id_prov = tb_prov.id');
		$this->db->join('tb_kab', 'tb_plant_cabang.id_kab = tb_kab.id');
		$this->db->join('tb_plant', 'tb_plant_cabang.id_plant = tb_plant.id');
		$data['tampil'] =  $this->db->get()->result_array();

		$this->db->where('aktif',1);
		$data['plant'] = $this->db->get('tb_plant')->result_array();
		$data['prov'] = $this->db->get('tb_prov')->result_array();

		$this->form_validation->set_rules('id_plant','Nama Plant');
		$this->form_validation->set_rules('kode_cabang','Kode Cabang');
		$this->form_validation->set_rules('nama_cabang','Nama Cabang');
		$this->form_validation->set_rules('id_prov','Provinsi','required');
		$this->form_validation->set_rules('id_kab','Kabupaten','required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('cabang/index',$data);
			$this->load->view('templates/footer');
		}else{
			$data = array(
		      	"id_plant" => $this->input->post('id_plant', true),
				"kode_cabang" => $this->input->post('kode_cabang',true),
				"nama_cabang" => $this->input->post('nama_cabang',true),
				"id_prov" => $this->input->post('id_prov',true),
				"id_kab" => $this->input->post('id_kab',true),
				"aktif" => $this->input->post('aktif',true)
			);

			$this->db->where('id', $this->input->post('id2',true) );
			$this->db->update('tb_plant_cabang', $data);
			$this->session->set_flashdata('message','Data cabang berhasil diubah!');
			redirect('cabang');
		}
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