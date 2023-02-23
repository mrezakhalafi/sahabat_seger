<?php

Class Mylib {
	protected $CI;

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('session');
		$this->CI->load->model('Auth_model');
	}	

	public function check_url($url_link = NULL){
		$url = str_replace(DOMAIN_URL, "", ($url_link == NULL ? $_SERVER['REQUEST_URI'] : $url_link));
		$url = preg_replace('{/$}', '', $url);
		$check = $this->CI->Auth_model->check_access($url, $this->CI->session->userdata('id_role') );
		if(empty($check))
			redirect('error');
		else return true;
	}
}

?>