<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("user_model");
		$this->load->model("role_model");
	}

	public function index(){
		$this->_gotoPage();
		$data['title'] = 'Dashboard';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();

		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		$this->db->select('*');
		$this->db->from('tb_petani');
		$this->db->limit(5);
		$data['tampil_petani'] = $this->db->get('tb_petani_lahan',5)->result_array();
		
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

	public function role($idrole = ""){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// 	show_404();
		// }
		$data['title'] = 'Role Access';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['tampilrole'] = $this->db->get('tb_role')->result_array();

		$data['role'] = $this->db->get_where('tb_role', ['id' => $idrole])->row_array();
		$data['menu_kategori'] = $this->db->get('tb_kategori_menu')->result_array();
		$data['menu'] = $this->db->get('tb_menu')->result_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('admin/role',$data);
		$this->load->view('templates/footer');
	}


	public function direct($idrole = ""){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url('admin/role') == false)){
		// 	show_404();
		// }
		$data['title'] = 'Role Access';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['tampilrole'] = $this->db->get('tb_role')->result_array();

		$data['role'] = $this->db->get_where('tb_role', ['id' => $idrole])->row_array();
		$data['menu_kategori'] = $this->db->get('tb_kategori_menu')->result_array();
		$data['menu'] = $this->db->get('tb_menu')->result_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('admin/role',$data);
		$this->load->view('templates/footer');
	}


	public function tambahRole(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("admin/role") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Tambah Data Role';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['tampilrole'] = $this->db->get('tb_role')->result_array();
		$data['role'] = $this->db->get('tb_role')->result_array();

		$this->form_validation->set_rules('nama_role','Nama Role','required');

		// JIKA GAGAL ke VIEW FORM
		if ($this->form_validation->run() == FALSE) {
		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('admin/role',$data);
		$this->load->view('templates/footer');
		}else{

		$data = [
			"nama_role" => $this->input->post('nama_role', true),
			"multiplant" => $this->input->post('multiplant', true),
			"aktif" => 1
		];

			$this->db->insert('tb_role',$data);
			$this->session->set_flashdata('message','Data role berhasil ditambahkan!');
			redirect('admin/role');
		}
	}				

	public function hapusRole($id){		
		$data = array(
			"aktif" => "0"

		);
		$this->db->where('id', $id);
		$this->db->update('tb_role', $data);
		$this->session->set_flashdata('message','Data role berhasil dihapus!');
		redirect('admin/role');
	}

	public function aktifRole($id){		
		$data = array(
			"aktif" => "1"

		);
		$this->db->where('id', $id);
		$this->db->update('tb_role', $data);
		$this->session->set_flashdata('message','Data role berhasil diaktifkan!');
		redirect('admin/role');
	}

	public function changeAccess(){
		$id_menu = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');
		$parent_id = $this->input->post('parentId');
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

		$data = [
			'id_role' => $role_id,
			'id_menu' => $id_menu,
			'id_kategori' => $parent_id
		];

		$result = $this->db->get_where('user_access_menu', $data);

		if ($result->num_rows() < 1) {
			$this->db->insert('user_access_menu', $data);
		}else{
			$this->db->delete('user_access_menu', $data);
		}

		$this->session->set_flashdata('message','Berhasil merubah akses!');
					
	}

	public function tampildataUser($id_user =""){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("admin/tampildatauser") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data User';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['role'] = $this->db->get('tb_role')->result_array();
		$data['getrole'] = $this->db->get('tb_role')->result_array();
		$data['cabang'] = $this->db->get('tb_plant_cabang')->result_array();
		$data['plant'] = $this->db->get('tb_plant')->result_array();

		$this->db->select('tb_user.*,tb_role.nama_role,tb_role.multiplant');
		$this->db->from('tb_user');
		$this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
		$data['get_user'] = $this->db->get()->result_array();

		$this->db->select('tb_user_akses_plant.*,tb_user.id,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');
		$this->db->join('tb_user', 'tb_user_akses_plant.id_user = tb_user.id');
		$data['akses_semua'] = $this->db->get()->result_array();
	
		$this->db->select('tb_user.*,tb_role.multiplant,tb_role.nama_role');
		$this->db->from('tb_user');
		$this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
		$this->db->where('tb_user.id',$id_user);
		$data['get_user_byid'] = $this->db->get()->row_array();

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('admin/tampiluser',$data);
		$this->load->view('templates/footer');
	}

	public function tambahUser($id_user =""){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("admin/tampildatauser") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Tambah Data User';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['getrole'] = $this->db->get('tb_role')->result_array();

		$id_user = $this->input->post('userId');

		$data['cabang'] = $this->db->get('tb_plant_cabang')->result_array();
		$data['plant'] = $this->db->get('tb_plant')->result_array();

		$this->db->select('tb_user.*,tb_role.nama_role');
		$this->db->from('tb_user');
		$this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
		$data['get_user'] = $this->db->get()->result_array();

		$this->db->select('tb_user.*,tb_role.multiplant,tb_role.nama_role');
		$this->db->from('tb_user');
		$this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
		$this->db->where('tb_user.id',$id_user);
		$data['get_user_byid'] = $this->db->get()->row_array();

		$this->db->select('tb_user_akses_plant.*,tb_user.id,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');
		$this->db->join('tb_user', 'tb_user_akses_plant.id_user = tb_user.id');
		$data['akses_semua'] = $this->db->get()->result_array();

		$this->db->select('tb_user.*,tb_role.nama_role');
		$this->db->from('tb_user');
		$this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
		$data['get_user'] = $this->db->get()->result_array();
		$this->db->from('tb_user');
		$this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
		$data['role'] = $this->db->get()->row_array();	

		$this->form_validation->set_rules('id_role','Role','required');

		if (empty($this->input->post('id_plant_cabang')))
		{
		   $this->form_validation->set_rules('id_plant_cabang','ID Plant','required');		
		}

		$this->form_validation->set_rules('username','Username','required|is_unique[tb_user.username]');		
		$this->form_validation->set_rules('fullname','Fullname','required');		
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[tb_user.email]');		
		$this->form_validation->set_rules('pass','Password','required|trim|min_length[3]|matches[pass2]');
		$this->form_validation->set_rules('pass2','Password','required|trim|matches[pass]');
		// JIKA GAGAL ke VIEW FORM
		
		if ($this->form_validation->run() == FALSE) {
		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('admin/tampiluser',$data);
		$this->load->view('templates/footer');
		}else{		

		$data = [
			"id_role" => $this->input->post('id_role', true),	
			"username" => $this->input->post('username',true),
			"fullname" => $this->input->post('fullname',true),
			"pass" => password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
			"email" => $this->input->post('email',true),
			"in_date" => $this->input->post('in_date',true),
			"in_by" => $this->input->post('in_by',true),
			"edit_date" => $this->input->post('edit_date', true),
			"edit_by" => $this->input->post('edit_by',true),
			"image" => 'default.jpg',
			"aktif" => 1
		];

		$this->db->insert('tb_user',$data);
		$last_id = $this->db->insert_id();
		$id_cabang = $this->input->post('id_plant_cabang[]');
		$i=0;
	
		foreach ($id_cabang as $dt){
			$data2 = array(
				"id_cabang" => $dt,
				"id_user" => $last_id
			);

		$this->db->insert('tb_user_akses_plant',$data2);	
		$i++;	
		}

		$this->session->set_flashdata('message','Data user berhasil ditambahkan!');
		redirect('admin/tampildatauser');	
		}
	}

	

	public function hapususer($id){
		$data = array(
			"aktif" => "0"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_user', $data);
		$this->session->set_flashdata('message','Data user berhasil dihapus!');
		redirect('admin/tampildatauser');
	}

	public function aktifuser($id){
		$data = array(
			"aktif" => "1"
		);
		$this->db->where('id', $id);
		$this->db->update('tb_user', $data);
		$this->session->set_flashdata('message','Data user berhasil diaktifkan!');
		redirect('admin/tampildatauser');
	}
			
	public function getData(){
		$id = $this->input->post('id');
		$data = $this->user_model->getAllDataUser($id);
		$data->plant = $this->user_model->getAllPlant($id);
		echo json_encode($data);
	}

	public function getPlant(){
		$id = $this->input->post('id');
		$data = $this->user_model->getAllPlant($id);
		echo json_encode($data);
	}

	public function ubahData($id_user =""){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("admin/tampildatauser") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Ubah Data User';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$data['role'] = $this->db->get('tb_role')->result_array();
		$data['getrole'] = $this->db->get('tb_role')->result_array();

		$data['plant'] = $this->db->get('tb_plant')->result_array();
		$data['cabang'] = $this->db->get('tb_plant_cabang')->result_array();
		$id_user = $this->input->post('userId');

		$this->db->select('tb_user.*,tb_role.nama_role,tb_role.multiplant');
		$this->db->from('tb_user');
		$this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
		$data['get_user'] = $this->db->get()->result_array();

		$this->db->select('tb_user_akses_plant.*,tb_user.id,tb_plant_cabang.nama_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_plant_cabang', 'tb_user_akses_plant.id_cabang = tb_plant_cabang.id');
		$this->db->join('tb_user', 'tb_user_akses_plant.id_user = tb_user.id');
		$data['akses_semua'] = $this->db->get()->result_array();
	
		$data['get_plant'] = $this->db->get('tb_plant')->result_array();

		$this->db->select('tb_user.*,tb_role.multiplant,tb_role.nama_role');
		$this->db->from('tb_user');
		$this->db->join('tb_role', 'tb_user.id_role = tb_role.id');
		$this->db->where('tb_user.id',$id_user);
		$data['get_user_byid'] = $this->db->get()->row_array();

		$this->form_validation->set_rules('id_role','Role','required');		
		$this->form_validation->set_rules('username','Username','required');		
		$this->form_validation->set_rules('fullname','Fullname','required');		
		$this->form_validation->set_rules('email','Email','required');		
		$this->form_validation->set_rules('pass','Password','trim|min_length[3]|matches[pass2]',['matches' => 'Password dont match!',
			'min_length' => 'Password too short!']);
		$this->form_validation->set_rules('pass2','Password','trim|matches[pass]');

			if(!$this->input->post('pass')){
				$password = $this->input->post('pass_bp');
			}else{
				$password = password_hash($this->input->post('pass'), PASSWORD_DEFAULT);
			}

		// JIKA GAGAL ke VIEW FORM
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('admin/tampiluser',$data);
			$this->load->view('templates/footer');
		}else{
		
		$data = [
			"id_role" => $this->input->post('id_role', true),	
			"username" => $this->input->post('username',true),
			"fullname" => $this->input->post('fullname',true),
			"pass" => $password,
			"email" => $this->input->post('email',true),
			"in_date" => $this->input->post('in_date',true),
			"in_by" => $this->input->post('in_by',true),
			"edit_date" => $this->input->post('edit_date', true),
			"edit_by" => $this->input->post('edit_by',true),
			"aktif" => $this->input->post('aktif',true)
		];

			$this->db->where('id', $this->input->post('id_user',true) );
			$this->db->update('tb_user', $data);

			$last_id = $this->input->post('id_user', true);
			$id_cabang = $this->input->post('id_plant_cabang[]');
			$i=0;

			$this->db->where('id_user', $this->input->post('id_user',true) );
			$this->db->delete('tb_user_akses_plant');		

			foreach ($id_cabang as $dt) {
				$data2 = array(
					"id_cabang" => $dt,
					"id_user" => $last_id
				);

			$this->db->insert('tb_user_akses_plant', $data2);
			$i++;	
		}
		$this->session->set_flashdata('message','Data user berhasil diubah!');
		redirect('admin/tampildatauser');
		}
	}

	public function getdataRole(){
		$id = $this->input->post('id');
		$data = $this->role_model->getDataRole($id);
		echo json_encode($data);
	}

	public function ubahRole(){
		$data = array(
		      		"nama_role" => $this->input->post('nama_role', true),
		      		"multiplant" => $this->input->post('multiplant', true),		      		
					"aktif" => $this->input->post('aktif',true)
			);

		$this->db->where('id', $this->input->post('id_role',true) );
		$this->db->update('tb_role', $data);
		$this->session->set_flashdata('message','Data role berhasil diubah!');
		redirect('admin/role');
	}

	//=======================================================//
	//					PRIVATE FUNCTION 					 //
	//=======================================================//

	private function _gotoPage(){
		$role = $this->session->userdata('id_role');
		if($role == null){
			redirect('auth');
		}
		else if ($this->session->userdata('id_role') != 1) {
			redirect('auth');
		}
	}
}