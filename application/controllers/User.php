<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->_gotoPage();
		$data['title'] = 'Dashboard';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		$this->db->select('*');
		$this->db->from('tb_petani');
		$this->db->limit(5);
		$data['tampil_petani'] = $this->db->get()->result_array();

		$data['jumlah_user'] = $this->db->get('tb_user')->num_rows();
		$data['jumlah_user'] = $this->db->get('tb_user')->num_rows();
		$data['jumlah_petani'] = $this->db->get('tb_petani')->num_rows();
		$data['jumlah_lahan'] = $this->db->get('tb_petani_lahan')->num_rows();
		$data['jumlah_poktan'] = $this->db->get('tb_poktan')->num_rows();	
		
		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('admin/index',$data);
		$this->load->view('templates/footer');
	}

	//=======================================================//
	//					PRIVATE FUNCTION 					 //
	//=======================================================//

	private function _gotoPage(){
		$role = $this->session->userdata('id_role');
		if($role == null){
			redirect('auth');
		}
		else if ($this->session->userdata('id_role') != 2 && $this->session->userdata('id_role') != 3  && $this->session->userdata('id_role') != 4 ) {
			redirect('auth');
		}
	}
}