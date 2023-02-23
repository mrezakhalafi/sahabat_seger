<?php

class Auth_model extends CI_model {

	public function resetPasswordModel(){
		$email = $this->input->post('email');
		$user = $this->db->get_where('tb_user',['email' => $email, 'aktif' => 1])->row_array();

		if($user){
			$token = md5(uniqid(rand(), true));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];

			$this->db->insert('user_token', $user_token);
			$this->_sendEmail($token, 'forgot');
		}else{
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email is note registered or activated</div>');
			redirect('auth/forgotpassword');
		}
	}

  function check_access($url = NULL, $role = NULL){
    $this->db->select("*");
    $this->db->from("tb_menu");
    $this->db->join("user_access_menu","tb_menu.id = user_access_menu.id_menu","inner");
    if($url){
      $this->db->where("tb_menu.url", $url);
    }
    if($role){
      $this->db->where("user_access_menu.id_role", $role);      
    }
    $query = $this->db->get();
    $result = $query->result();
    return $result;
  }

	private function _sendEmail($token, $type){
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'henrycuber@gmail.com',
			'smtp_pass' => 'modernw4r3',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		];

		//load library email di codeigniter
		$this->load->library('email', $config);
		$this->email->initialize($config);
		$this->email->from('henrycuber@gmail.com','Sahabat Seger');
		$this->email->to($this->input->post('email'));

		if($type == 'forgot'){
			$this->email->subject('Reset Password Request : Sahabat Seger');
			$this->email->message('<!DOCTYPE html>
 <html>
 <head>
     <title></title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 

    <style>
  .header-mail {
  min-height:50px; 

background: rgb(12,156,72);
background: linear-gradient(90deg, rgba(12,156,72,1) 0%, rgba(31,168,61,1) 35%, rgba(23,186,92,1) 100%);
}

.message-body {
  
  background: white;
  color: black;
  min-height: auto;
  border-bottom:  5px solid rgb(17,122,61);
}

.btn-primary {

    color: #fff;
    background-color: #007bff;
    border-color: #007bff;

}

.btn {

    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;

}

.header-mail h1{
    padding-bottom: 10px;
    padding-top: 10px;
  text-align:   center;
  color: white;
}

.message-body h1{
    text-align:   center;
  margin-top: 20px;
}

.message-body p{
  text-align:   center;
  margin-top:   20px;
  padding-left:   20px;
  padding-right:  20px;
  font-size:  13px;
}

.text-center {
    text-align: center;
}
.btn-kirana {
    color: #fff;
    background-color: #28b463;
    border-color: #28b463;
}

.btn-kirana:hover {
	color: #fff;
	box-shadow: 0 16px 38px -12px rgba(0,0,0,0.2),0 4px 25px 0 rgba(0,0,0,.12),0 8px 10px -5px rgba(0,0,0,.2);
}
</style>

</head>
 <body>
<div class="col-lg-12"> 
  <div class="row">
    <div class="col-sm-12 header-mail">
      <h1>PT. SEP (Sumber Energi Pangan)</h1>
    </div>
    <div class="col-sm-10 mx-auto message-body">
    <h2 class="text-center">Reset Password</h2>
      <p>Klik link dibawah ini untuk melakukan reset password :</p>
      <div class="col text-center mt-4 mb-4">
      	<a href="'.base_url(). 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) .'"><button class="btn btn-sm btn-kirana">Reset Password</button></a>
       </div> 
       <p class="text-center mt-2" style="color: #8b8b8b"><small class="text-center">* Jika bukan anda yang melakukan reset password, hiraukan email ini</small></p>
    </div>
  </div>
</div>
 
 </body>
 </html>');
			
		} 

		if($this->email->send()){
			return true;
		}else{
			echo $this->email->print_debugger();
			die;
		}

	}
}
?>