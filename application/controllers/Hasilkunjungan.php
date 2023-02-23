<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Hasilkunjungan extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model("Poktan_model");
		}

		public function index(){
			// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
			// 	show_404();
			// }
			$data['title'] = 'Data Hasil Kunjungan';
			$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
			$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();

			// $data['poktan'] = $this->Poktan_model->getTampilFilterHasilPlant2();
			$data['tipekun'] = $this->db->get('tb_tipe_kunjungan')->result_array();
			$data['tampilpoktan'] = $this->db->get('tb_poktan')->result_array();

			if($this->session->userdata('multiplant')==0){
				$this->db->where('email',$this->session->userdata('email'));
				$data['tampilstaff'] = $this->db->get('tb_user')->result_array();
			}else{
				$plant = $this->session->userdata('plant[]');

				foreach($plant as $a){
					$names[] = $a['id_cabang'];
				}

				$this->db->select('tb_user.fullname,tb_user.id');
				$this->db->from('tb_user');
				$this->db->join('tb_user_akses_plant','tb_user_akses_plant.id_user = tb_user.id');
				$this->db->where_in('tb_user_akses_plant.id_cabang',$names);
                $this->db->where('id_role',3);
				$data['tampilstaff'] =  $this->db->get()->result_array();
			}

			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('hasilkunjungan/index',$data);
			$this->load->view('templates/footer');
		}
	}
