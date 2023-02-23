<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Menu_model');
		$this->_gotoPage();
	}

	public function index(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// 	show_404();
		// }
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['title'] = 'Menu Management';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['menu'] = $this->Menu_model->getMenu();
		$data['kategori_menu'] = $this->db->get('tb_kategori_menu')->result_array();



		// $this->db->select("*");
		// $this->db->from('tb_menu');

		// $this->db->where('aktif',1);
		// $data['cek'] = $this->db->get()->result_array();

		// var_dump($data['cek']);


		$this->form_validation->set_rules('kategori_menu','Menu','required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('menu/index',$data);
			$this->load->view('templates/footer');
		}else{
			$data = [ 
				'kategori_menu' => $this->input->post('kategori_menu'),
				'aktif' => 1
			];

			$this->db->insert('tb_kategori_menu', $data);
			$this->session->set_flashdata('message','Kategori menu telah berhasil ditambahkan!');
			redirect('menu');
		}
	}

	public function ubahkategori(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("menu") == false)){
		// 	show_404();
		// }
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['title'] = 'Menu Management';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['menu'] = $this->Menu_model->getMenu();
		$data['kategori_menu'] = $this->db->get('tb_kategori_menu')->result_array();

		$this->db->where('parent',$this->input->post('id2',true));
		$data['get_menu'] = $this->db->get('tb_menu')->result_array();

		$this->form_validation->set_rules('kategori_menu','Menu','required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('menu/index',$data);
			$this->load->view('templates/footer');
		}else{
			$data = [
				'kategori_menu' => $this->input->post('kategori_menu',true),
				'aktif' => $this->input->post('aktif',true)
			];
			$this->db->where('id', $this->input->post('id2',true) );
			$this->db->update('tb_kategori_menu', $data);


			$data2 = [
				'aktif' => $this->input->post('aktif',true)
			];
			$this->db->where('parent', $this->input->post('id2',true) );
			$this->db->update('tb_menu', $data2);

			$this->session->set_flashdata('message','Data kategori menu berhasil diubah!');
			redirect('menu');
		}
	}

	public function getData(){
		$id = $this->input->post('id');
		$data = $this->Menu_model->getDataMenu($id);
		echo json_encode($data);
	}

	public function getDataKategori(){
		$id = $this->input->post('id');
		$data = $this->Menu_model->getDataMenuKategori($id);
		echo json_encode($data);
	}

	public function tambahmenu(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("menu") == false)){
		// 	show_404();
		// }
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['title'] = 'Menu Management';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['menu'] = $this->Menu_model->getMenu();
		$data['kategori_menu'] = $this->db->get('tb_kategori_menu')->result_array();
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('parent','Menu','required');
		$this->form_validation->set_rules('url','URL','required');
		$this->form_validation->set_rules('icon','Icon','required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('menu/index',$data);
			$this->load->view('templates/footer');
		}else{
			$data = [
				'title' => $this->input->post('title',true),
				'parent' => $this->input->post('parent',true),
				'url' => $this->input->post('url',true),
				'icon' => $this->input->post('icon',true),
				"in_date" => $this->input->post('in_date',true),
				"in_by" => $this->input->post('in_by',true),
				"edit_date" => $this->input->post('edit_date', true),
				"edit_by" => $this->input->post('edit_by',true),
				"no_urut" => $this->input->post('no_urut',true),
				'aktif' => 1
			];

			$this->db->insert('tb_menu', $data);
			$this->session->set_flashdata('message','Data menu berhasil ditambahkan');
			redirect('menu');
		}
	}
	public function ubahmenu(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("menu") == false)){
		// 	show_404();
		// }
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['title'] = 'Menu Management';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['menu'] = $this->Menu_model->getMenu();
		$data['kategori_menu'] = $this->db->get('tb_kategori_menu')->result_array();
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('parent','Menu','required');
		$this->form_validation->set_rules('url','URL','required');
		$this->form_validation->set_rules('icon','Icon','required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('menu/index',$data);
			$this->load->view('templates/footer');
		}else{
			$data = [
				'title' => $this->input->post('title',true),
				'parent' => $this->input->post('parent',true),
				'url' => $this->input->post('url',true),
				'icon' => $this->input->post('icon',true),
				"edit_date" => $this->input->post('edit_date', true),
				"edit_by" => $this->input->post('edit_by',true),
				"no_urut" => $this->input->post('no_urut',true),
				'aktif' => $this->input->post('aktif',true)
			];

			$this->db->where('id', $this->input->post('id2',true) );
			$this->db->update('tb_menu', $data);



		if($this->input->post('aktif',true) == 0){
			$this->db->select("*");
			$this->db->where('id_menu', $this->input->post('id2',true) );
			$this->db->delete('user_access_menu');

			$parent = $this->input->post('parent',true);

			$data['coba'] = $this->db->get_where('tb_menu',['parent' => $parent, 'aktif' => 1])->num_rows();
			if($data['coba'] > 1){
				$data = array(
					"aktif" => "0"
				);
				$this->db->where('id', $id);
				$this->db->update('tb_menu', $data);
			}else{
				$data = array(
					"aktif" => "0"
				);
				$this->db->where('id', $id);
				$this->db->update('tb_menu', $data);

				$data2 = array(
					"aktif" => "0"
				);
				$this->db->where('id',$parent);
				$this->db->update('tb_kategori_menu', $data2);
			}
			
		}else{

			$data2 = [
			'aktif' => 1
			];


			$this->db->where('id', $this->input->post('parent',true) );
			$this->db->update('tb_kategori_menu', $data2);

			}

			$this->session->set_flashdata('message','Data menu berhasil diubah!');
			redirect('menu');
		}
	}

	public function deletekategori($id){

		$this->db->where('parent',$id);
		$data['get_menu'] = $this->db->get('tb_menu')->result_array();

		$data = array(
			"aktif" => "0"
		);

		$this->db->where('id', $id);
		$this->db->update('tb_kategori_menu', $data);
		
		$data2 = [
			'aktif' => "0"
		];

		$this->db->where('parent', $id);
		$this->db->update('tb_menu', $data2);

		$this->db->select("*");
		$this->db->where('id_kategori', $id);
		$this->db->delete('user_access_menu');

		$this->session->set_flashdata('message','Data menu berhasil dihapus!');
		redirect('menu');
	}

	public function aktifkategori($id){

		$this->db->where('parent',$id);
		$data['get_menu'] = $this->db->get('tb_menu')->result_array();

		$data = array(
			"aktif" => "1"
		);

		$this->db->where('id', $id);
		$this->db->update('tb_kategori_menu', $data);
		
		$data2 = [
			'aktif' => "1"
		];
		$this->db->where('parent', $id);
		$this->db->update('tb_menu', $data2);

		$this->session->set_flashdata('message','Data menu berhasil diaktifkan!');
		redirect('menu');
	}

	public function deletemenu($id, $parent){

$data['coba'] = $this->db->get_where('tb_menu',['parent' => $parent, 'aktif' => 1])->num_rows();
if($data['coba'] > 1){
	// echo "delete anak saja";
	
		$data = array(
			"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_menu', $data);

		$this->db->where('id_menu', $id);
		$this->db->delete('user_access_menu');
}else{
	// echo "delete bapak juga";

	$data = array(
			"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_menu', $data);

	$data2 = array(
			"aktif" => "0"
		);
		$this->db->where('id',$parent);
		$this->db->update('tb_kategori_menu', $data2);
	
}




		$this->session->set_flashdata('message','Data menu berhasil dihapus!');
		redirect('menu');

	}

	public function aktifmenu($id, $parent){

		$data = array(
			"aktif" => "1"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_menu', $data);

		$data2 = [
		'aktif' => 1
		];

		$this->db->where('id', $parent);
		$this->db->update('tb_kategori_menu', $data2);

		$this->session->set_flashdata('message','Data menu berhasil diaktifkan!');
		redirect('menu');
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