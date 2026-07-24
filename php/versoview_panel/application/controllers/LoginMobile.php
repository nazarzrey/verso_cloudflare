<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class LoginMobile extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model(array('Mod_login_mobile'));    
  }
  function index() {
      $data = $this->Mod_login_mobile->cek();
      // foreach ($data->result() as $row) {
      //   echo $row->user_name;
      // }
      echo json_encode($data->result_array());
  }
  function SignUp() {
      $email = $this->input->post('email');
      $name = $this->input->post('name');
      $nohp = $this->input->post('nohp');
      $password = hash('sha512', $this->input->post('password'));
      // echo json_encode("Wuoke");
      $data = $this->Mod_login_mobile->signup($email, $name, $nohp, $password); 
      if (count($data) > 0) echo json_encode($data);
      else echo json_encode("Invalid Username or Password Please Try Again");
  }
  function SignIn() {
      $username = $this->input->post('email');
      $password = hash('sha512', $this->input->post('password'));
      $data = $this->Mod_login_mobile->signin($username, $password); 
      // echo json_encode($password);

      if (count($data) > 0) echo json_encode($data);
      else echo json_encode("Invalid Username or Password Please Try Again");
  }
  function getEmail() {
      $json = file_get_contents('php://input');
      $obj = json_decode($json,true);   
      $username = $obj['email'];
      // $username = 'danangroesmanto@gmail.com';

      $data = $this->Mod_login_mobile->getId($username);
      $id = $data[0]['user_id'];
      
      $note = '<a href="'.base_url().'loginMobile/changePass/'.$id.'">Mohon klik link ini untuk mengganti password</a>';
      $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.office365.com',
            'smtp_port' => 587,
            'smtp_crypto' => 'tls',
            'smtp_timeout' => 60,
            'smtp_user' => 'danang.rusmanto@agencyfish.com',
            'smtp_pass' => 'Dup55729',
            'mailtype'  => 'html', 
            'charset'   => 'iso-8859-1'
        );

      	$this->load->library('email', $config);        
        $this->email->set_newline("\r\n");

        $this->email->from('danang.rusmanto@agencyfish.com', 'Ocop Bro');
        $this->email->to($username); 
        
        $this->email->subject('Reset Password');
        $this->email->message($note);
        $this->email->set_mailtype("html");         
        if ($this->email->send()) {
            echo json_encode('Your Email has successfully been sent.');
        } else {
            echo json_encode('Email not registered');            
            // show_error($this->email->print_debugger());
        }      
  }
  function changePass($id) {
  		$data = array('id' => $id);
        $this->load->view('loginMobile', $data);  		
  }
  function changePassw($id) {
  		$pass1 = $_POST["pass1"];
  		$pass2 = $_POST["pass2"];
  		$pass3 = $_POST["pass3"];

  		if ($pass2 == $pass3){
  			$password = hash('sha512', hash('sha256', $pass2));
  			$this->Mod_login_mobile->changePassw($id, $password); 
  		}
  		// echo $id;
  }
}