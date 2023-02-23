<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plant extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("plant_model");
		$this->_gotoPage();
	}

	public function index(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Plant';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		$this->db->select('tb_plant.*,tb_region.nama_region');
		$this->db->from('tb_plant');
		$this->db->join('tb_region', 'tb_plant.id_region = tb_region.id');
		$data['tampil'] =  $this->db->get()->result_array();
		$data['region'] = $this->db->get('tb_region')->result_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('plant/index',$data);
		$this->load->view('templates/footer');
	}

	public function getData(){
		$id = $this->input->post('id');
		$data = $this->plant_model->getDataPlant($id);
		echo json_encode($data);
	}

	public function ubahData(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("plant") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Ubah Data Plant';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		$this->db->select('tb_plant.*,tb_region.nama_region');
		$this->db->from('tb_plant');
		$this->db->join('tb_region', 'tb_plant.id_region = tb_region.id');
		$data['tampil'] =  $this->db->get()->result_array();
		$data['region'] = $this->db->get('tb_region')->result_array();

		$this->form_validation->set_rules('kode_plant','Kode Plant','required|trim|numeric');
		$this->form_validation->set_rules('nama_plant','Nama Plant','required');
		$this->form_validation->set_rules('id_region','Region','required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('plant/index',$data);
			$this->load->view('templates/footer');
		}else{
			$data = array(
		      	"kode_plant" => $this->input->post('kode_plant', true),
				"nama_plant" => $this->input->post('nama_plant',true),
				"id_region" => $this->input->post('id_region',true),
				"aktif" => $this->input->post('aktif',true)
				);

			$this->db->where('id', $this->input->post('id2',true) );
			$this->db->update('tb_plant', $data);
			$this->session->set_flashdata('message','Data plant berhasil diubah!');
			redirect('plant');
			}
		}

	public function tambahPlant(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("plant") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Plant';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		$this->db->select('tb_plant.*,tb_region.nama_region');
		$this->db->from('tb_plant');
		$this->db->join('tb_region', 'tb_plant.id_region = tb_region.id');
		$data['tampil'] =  $this->db->get()->result_array();
		$data['region'] = $this->db->get('tb_region')->result_array();

		$this->form_validation->set_rules('kode_plant','Kode Plant','required|trim|numeric|is_unique[tb_plant.kode_plant]');
		$this->form_validation->set_rules('nama_plant','Nama Plant','required|is_unique[tb_plant.nama_plant]');
		$this->form_validation->set_rules('id_region','Region','required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('plant/index',$data);
			$this->load->view('templates/footer');
		}else{
		
			$provid = $this->input->post('id_prov',true);
			$data['kab'] = $this->db->get_where('tb_kab', ['id_provinsi' => $provid])->result_array();
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('plant/index',$data);
			$this->load->view('templates/footer');

			$data = array(
		      	"kode_plant" => $this->input->post('kode_plant', true),
				"nama_plant" => $this->input->post('nama_plant',true),
				"id_region" => $this->input->post('id_region',true),
				"aktif" => 1
				);

			$this->db->insert('tb_plant',$data);
			$this->session->set_flashdata('message','Data plant berhasil ditambahkan!');
			redirect('plant');
			
		}
}

	public function delete($id){
		$data = array(
			"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_plant', $data);
		$this->session->set_flashdata('message','Data plant berhasil dihapus!');
		redirect('plant');
	}

	public function aktif($id){
		$data = array(
			"aktif" => "1"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_plant', $data);
		$this->session->set_flashdata('message','Data plant berhasil diaktifkan!');
		redirect('plant');
	}

	public function fetch(){

		 $output = '';
		 
		 if($this->input->post('postaction') == "id_plant"){
			 $data['coba1'] = $this->db->get_where('tb_plant_cabang',['id_plant' => $this->input->post('query')])->result_array();
			 $output .= '<option value="">Pilih Cabang</option>';

			 foreach($data['coba1'] as $row){
			  	 $output .= '<option value="'.$row["id"].'">'.$row["nama_cabang"].'</option>';
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