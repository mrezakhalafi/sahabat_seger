<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kunjungan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("Kunjungan_model");
		$this->load->model("Poktan_model");
		$this->_gotoPage();
	}

	public function index(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url() == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Rencana Kunjungan';
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
		$this->load->view('kunjungan/index',$data);
		$this->load->view('templates/footer');
	}

	public function ubah(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("kunjungan") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Kunjungan';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$this->form_validation->set_rules('tgl_kunjungan','Tanggal Kunjungan','required');	
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('kunjungan/index',$data);
			$this->load->view('templates/footer');
		}else{
			$tgl_format = date_create($this->input->post('tgl_kunjungan',true));
			$data = array(
		      	"id_poktan" => $this->input->post('id_poktan', true),
				"alamat" => $this->input->post('alamat',true),
				"id_tipe_kunjungan" => $this->input->post('tipe_kunjungan',true),
				"tgl_kunjungan" => date_format($tgl_format,"Y-m-d")
				);

			$this->db->where('id', $this->input->post('id2',true));
			$this->db->update('tb_kunjungan', $data);
			$this->session->set_flashdata('message','Data kunjungan berhasil diubah!');
			redirect('kunjungan');
			}
		}

	public function tambahhasiltancana(){
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("kunjungan") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Kunjungan';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$this->form_validation->set_rules('tgl_kunjungan','Tanggal Kunjungan','required|callback_check_kunjungan');	
		$this->form_validation->set_rules('id_poktan','Id poktan','required|callback_check_kunjungan');	
		$this->form_validation->set_rules('id_staff','Staff','required|callback_check_kunjungan');
		$this->form_validation->set_rules('tipe_kunjungan','Tipe Kunjungan','required|callback_check_kunjungan');		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('hasilkunjungan/index',$data);
			$this->load->view('templates/footer');
		}else{
			$tgl_format = date_create($this->input->post('tgl_kunjungan_modal',true));

			if($this->input->post('aktual_kunjungan_modal',true)!=null){
			$aktual_format = date_create($this->input->post('aktual_kunjungan_modal',true));
			$gajah = date_format($aktual_format,"Y-m-d");
			}
			else{
			$gajah = "";
			}
			if($this->input->post('id_poktan',true)==""){
				$jerapah = null;
				$singa = null;
				$koala = null;
				$zebra = null;
			}
			else{
				$jerapah = $this->input->post('id_poktan',true);
				$singa = $this->input->post('id_poktan_tanam',true);
				$koala = $this->input->post('alamat',true);
				$zebra = $this->input->post('periode',true);
			}
			$data = array(
				"tgl_kunjungan" => date_format($tgl_format,"Y-m-d"),
				"id_poktan" => $jerapah,
				"alamat" => $koala,
				"id_tipe_kunjungan" => $this->input->post('tipe_kunjungan',true),
				"id_staff" => $this->input->post('id_staff',true),
				"hasil_kunjungan" => $this->input->post('hasil_kunjungan',true),
				"aktual_kunjungan" => $gajah,
				"id_poktan_tanam" => $singa,
				"periode" => $zebra,
				"tgl_mulai" => date_format($tgl_format,"Y-m-d"),
				"tgl_akhir" => date_format($tgl_format,"Y-m-d")
				);
			
			$this->db->insert('tb_kunjungan', $data);
			$this->session->set_flashdata('message','Data hasil kunjungan berhasil ditambah!');
			redirect('hasilkunjungan');
			}
		}

	function check_kunjungan() {
		   	$staff = $this->input->post('id_staff');// get fiest name
		    $poktan = $this->input->post('id_poktan');// get last name
		    $tgl_kunjungan = $this->input->post('tgl_kunjungan');// get last name
		    $tipe_kunjungan = $this->input->post('tipe_kunjungan');// get last name
		    $this->db->select('*');
		    $this->db->from('tb_kunjungan');
		    $this->db->where('id_staff', $staff);
		    $this->db->where('id_poktan', $poktan);
		    $this->db->where('tgl_kunjungan', $tgl_kunjungan);
		    $this->db->where('id_tipe_kunjungan', $tipe_kunjungan);
		    $query = $this->db->get();
		    $num = $query->num_rows();
		    if ($num > 0) {
		        return FALSE;
		    } else {
		        return TRUE;
		    }
		}

	
	public function tambahhasil(){ //SEKALIGUS UBAH HASIL
		// if($this->session->userdata('id_role') == NULL || ($this->session->userdata('id_role') !== NULL && $this->mylib->check_url("kunjungan") == false)){
		// 	show_404();
		// }
		$data['title'] = 'Data Kunjungan';
		$data['user'] = $this->db->get_where('tb_user',['email' => $this->session->userdata('email')])->row_array();
		$data['trole'] = $this->db->get_where('tb_role',['id' => $this->session->userdata('id_role')])->row_array();
		$this->form_validation->set_rules('tgl_kunjungan','Tanggal Kunjungan','required');	
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header',$data);
			$this->load->view('templates/sidebar',$data);
			$this->load->view('templates/topbar',$data);
			$this->load->view('hasilkunjungan/index',$data);
			$this->load->view('templates/footer');
		}else{

			$aktual_format = date_create($this->input->post('aktual_kunjungan_modal',true));			
			$data = array(
				"hasil_kunjungan" => $this->input->post('hasil_kunjungan',true),
				"aktual_kunjungan" => date_format($aktual_format,"Y-m-d")
				);

			$this->db->where('id', $this->input->post('id2',true));
			$this->db->update('tb_kunjungan', $data);
			$this->session->set_flashdata('message','Data hasil kunjungan berhasil diperbaharui!');
			redirect('hasilkunjungan');
			}
		}

	public function deletehasil($id){
		// $data = array(
		// 	"hasil_kunjungan" => "",
		// 	"aktual_kunjungan" => ""
		// );
		$this->db->where('id', $id);
		// $this->db->update('tb_kunjungan', $data);
		$this->db->delete('tb_kunjungan');
		$this->session->set_flashdata('message','Data hasil kunjungan berhasil dihapus!');
		redirect('hasilkunjungan');
	}

	public function deletekunjungan($id){
		$this->db->where('id', $id);
		$this->db->delete('tb_kunjungan');
		$this->session->set_flashdata('message','Data kunjungan berhasil dihapus!');
		redirect('kunjungan');
	}

	public function getPoktan(){
		$id = $this->input->post('id');
		$this->db->select('*');
		$this->db->from('tb_poktan');
		$this->db->where('id_staff',$id);
		$query = $this->db->get();
		$data = $query->result();
		echo json_encode($data);
	}

	public function tambah(){
		$id_poktan = $this->input->post('id_poktan',true);
		$alamat = $this->input->post('alamat',true);
		$tipe_kunjungan = $this->input->post('tipe_kunjungan',true);
		$tgl = $this->input->post('tgl',true);
		$tanam = $this->input->post('id_poktan_tanam',true);
		$periode = $this->input->post('periode',true);
		$tgl_mulai = $this->input->post('tgl_mulai',true);
		$tgl_akhir = $this->input->post('tgl_akhir',true);

		$i=0;
		if($id_poktan){
			foreach ($id_poktan as $dt) {

				if($dt==""){
				$tgl_format = date_create($tgl[$i]);
				$data = array(
					"id_poktan" => null,
					"alamat" => null,
					"id_staff" => $this->input->post('id_staff',true),
					"id_tipe_kunjungan" => $tipe_kunjungan[$i],
					"tgl_kunjungan" => date_format($tgl_format,"Y-m-d"),
					"id_poktan_tanam" => null,
					"periode" => $periode[$i],
					"tgl_mulai" => $tgl_mulai[$i],
					"tgl_akhir" => $tgl_akhir[$i]
				);
				}else{
				$tgl_format = date_create($tgl[$i]);
				$data = array(
					"id_poktan" => $dt,
					"alamat" => $alamat[$i],
					"id_staff" => $this->input->post('id_staff',true),
					"id_tipe_kunjungan" => $tipe_kunjungan[$i],
					"tgl_kunjungan" => date_format($tgl_format,"Y-m-d"),
					"id_poktan_tanam" => $tanam[$i],
					"periode" => null,
					"tgl_mulai" => $tgl_mulai[$i],
					"tgl_akhir" => $tgl_akhir[$i]
				);
			}
				$this->db->insert('tb_kunjungan',$data);	
				$i++;		
			}
		}

		$this->session->set_flashdata('message','Data kunjungan ditambahkan!');
		redirect('kunjungan');
	}

	public function getData(){
		$id = $this->input->post('id');
		$data = $this->Kunjungan_model->getDataKunjungan($id);
		echo json_encode($data);	
	}

	public function getdataKunjungan(){
		$id = $this->input->post('id');
		$data = $this->Kunjungan_model->getDataKunjungan2($id);
		echo json_encode($data);
	}

	public function getdataKunjunganLibur(){
		$id = $this->input->post('id');
		$data = $this->Kunjungan_model->getDataKunjunganLibur($id);
		echo json_encode($data);
	}

	public function getstatusTanam(){
		$id = $this->input->post('id');
		$data = $this->Kunjungan_model->getstatusTanam($id);
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
