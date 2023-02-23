<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Auth_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$this->_gotoPage();   
		$this->form_validation->set_rules('username','Username','trim|required');
		$this->form_validation->set_rules('password','Password','trim|required');
		if($this->form_validation->run() == false){
			$data['title'] = 'Sahabat Seger';
			$this->load->view('templates/auth_header',$data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		}else{
			$this->_login();
		}
	}

	private function _gotoPage(){
		if ($this->session->userdata('id_role') == 1) {
			redirect('admin');
		}

		if ($this->session->userdata('id_role') == 2 || $this->session->userdata('id_role') == 3 || $this->session->userdata('id_role') == 4) {
			redirect('user');
		}
	}


	private function _login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->db->select("tb_user.*,tb_role.id,tb_role.multiplant");
		$this->db->select("tb_user.*,tb_role.multiplant");
		$this->db->from('tb_user');
		$this->db->join('tb_role','tb_user.id_role = tb_role.id');
		$this->db->where('username',$username);
		$user = $this->db->get()->row_array();


		$this->db->select('id_cabang');
		$this->db->from('tb_user_akses_plant');
		$this->db->join('tb_user','tb_user.id = tb_user_akses_plant.id_user');
		$this->db->where('tb_user.username', $username);
		$plant = $this->db->get()->result_array();

		//JIKA USER ADA
		if($user){
			//JIKA USERNYA AKTIF
			if($user['aktif'] == 1){
				if(password_verify($password, $user['pass'])){
					$data = [
						'id' => $user['id'],
						'email' => $user['email'],
						'id_role' => $user['id_role'],
						'multiplant' => $user['multiplant'],
						'plant[]' => $plant
					];

					$this->session->set_userdata($data);
					if($user['id_role'] == 1){
						redirect('admin');
					}
					if($user['id_role'] == 2 || $user['id_role'] == 3 || $user['id_role'] == 4){
						redirect('user');
					}
				}else{
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Wrong password!</div>');
					redirect('auth');
				}
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Akun di nonaktifkan!</div>');
				redirect('auth');
			}
		}else{
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Username tidak terdaftar!</div>');
			redirect('auth');
		}
	}

	public function logout(){
		$this->session->unset_userdata('id');		
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('id_role');
		$this->session->unset_userdata('multiplant');
		$this->session->unset_userdata('plant');
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Anda berhasil logout!</div>');
		redirect('auth');
	}

	public function blocked(){
		$this->load->view('auth/blocked');
	}

	public function forgotPassword(){
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		if ($this->form_validation->run() == false) {
			$data['title'] = 'Forgot Password';
			$this->load->view('templates/auth_header',$data);
			$this->load->view('auth/forgot-password');
			$this->load->view('templates/auth_footer');
		}else{
			$this->Auth_model->resetPasswordModel();
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Email sudah terkirim! cek email untuk reset password.</div>');
			redirect('auth');
		}
	}

	public function resetPassword(){
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('tb_user' ,['email' => $email])->row_array();

		if($user){
			$user_token = $this->db->get_where('user_token' ,['token' => $token])->row_array();
			if($user_token){
				//jika benar set session
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Reset password gagal!</div>');
				redirect('auth');
			}
		}else{
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Reset password gagal! Email salah.</div>');
			redirect('auth');
		}
	}

	public function changePassword(){
		//Cek agar method ini ga bisa di akses tanpa ada session
		if(!$this->session->userdata('reset_email')){
			redirect('auth');
		}
		$this->form_validation->set_rules('password1','Password','trim|required|min_length[3]|matches[password2]');
		$this->form_validation->set_rules('password2','Password','trim|required|min_length[3]|matches[password1]');
		if($this->form_validation->run() == false){
			$data['title'] = 'Ubah Password';
			$this->load->view('templates/auth_header',$data);
			$this->load->view('auth/change-password');
			$this->load->view('templates/auth_footer');
		}else{
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');
			$this->db->set('pass', $password);
			$this->db->where('email', $email);
			$this->db->update('tb_user');

			//hapus session sebelum balik kehalaman login
			$this->session->unset_userdata('reset_email');
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Password telah diubah, silahkan login!</div>');
			redirect('auth');
		}
	}
}