<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller {
	public function editProfile(){
		// $this->_gotoPage();
		$data['title'] = 'Edit Profile';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

	    $this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar',$data);
		$this->load->view('templates/topbar',$data);
		$this->load->view('user/edit',$data);
		$this->load->view('templates/footer');
	}

	public function ubahData(){
		$data['title'] = 'Edit Profile';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
			$this->form_validation->set_rules('name','Full Name','required|trim');
		if ($this->form_validation->run() == false){
		    $this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('user/edit',$data);
			$this->load->view('templates/footer');
		}else{
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$upload_image = $_FILES['image']['name'];
			if($upload_image){
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['upload_path'] = './assets/img/profile/';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) {
					$old_image = $data['user']['image'];
					if($old_image != 'default.jpg'){
						unlink(FCPATH . 'assets/img/profile/' . $old_image);
					}
					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>'); 
					redirect('edit');
				}
			}
			$this->db->set('fullname', $name);
			$this->db->where('email',$email);
			$this->db->update('tb_user');
			$this->session->set_flashdata('message_ava','<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
			redirect('edit/editprofile');
		}
	}

	public function changePassword(){
		$data['title'] = 'Change Password';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$this->form_validation->set_rules('current_password', 'Password lama','required|trim');
		$this->form_validation->set_rules('new_password1', 'Password baru','required|trim|min_length[3]|matches[new_password2]');
		$this->form_validation->set_rules('new_password2', 'Password baru','required|trim|min_length[3]|matches[new_password1]');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('user/edit',$data);
			$this->load->view('templates/footer');
			
		}else{
			//CEK PASSWORD YG USER INPUT SAMA GA SAMA PASSWORD YG LAMA
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password1');

			if(!password_verify($current_password, $data['user']['pass'])){
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Password lama salah!</div>');
				redirect('edit/editprofile');
			}else{
				if($current_password == $new_password){
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password lama</div>');
					redirect('edit/editprofile');
				}else{
					//PASWORD SUDAH OK
					$password_hash = password_hash($new_password, PASSWORD_DEFAULT);
					$this->db->set('pass', $password_hash);
					$this->db->where('email', $data['user']['email']);
					$this->db->update('tb_user');
					$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Password berhasil diubah!</div>');
					redirect('edit/editprofile');
				}
			}
		}
	}
}