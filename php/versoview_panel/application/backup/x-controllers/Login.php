<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller {
    function __construct() {
    parent::__construct();
    $this->load->model(array('Mod_login','Mod_data'));
  }
  function index() {
  	$data = "X";
  	$this->load->view("templates/backend_header",$data);
  	$this->load->view("backend/v_login",$data);
  	$this->load->view("templates/backend_footer",$data);
    /*$sekolah = $this->Mod_data->getSekolah();
    if($sekolah){
      if($sekolah->num_rows() > 0){
        foreach($sekolah->result_array() as $row){
          $items_sekolah[] = $row;
        }
        $data['sekolah'] = $items_sekolah;
      }
    }
      $this->load->view('template_web/header',$data);
      $this->load->view('template_web/menu');
      $this->load->view('template_web/notification');
      $this->load->view('twebsite');
      $this->load->view('template_web/footer');*/
  }
  public function signup($value=''){
    $data = "x";
    $this->load->view("templates/backend_header",$data);
    $this->load->view("backend/v_signup",$data);
    $this->load->view("templates/backend_footer",$data);
  }

  function validate(){
    $this->form_validation->set_rules('username', 'username', 'required|trim');
    $this->form_validation->set_rules('password', 'password', 'required|trim');
    if ($this->form_validation->run() == FALSE){
        redirect('login');
    } else {
      $usr = $this->input->post('username');
      $psw = $this->input->post('password');
      $cek = $this->Mod_login->cek($usr, $psw);
      if ($cek->num_rows() > 0) {
        //login berhasil, buat session
        foreach ($cek->result() as $qad) {
          $sess_data['uid'] 	= $qad->user_id;
          $sess_data['uname'] 	= $qad->user_name;
          $sess_data['utype'] 	= $qad->user_type;
          $sess_data['uacc']	= $qad->user_account;
          $sess_data['uem']		= $qad->user_email;
          $this->session->set_userdata($sess_data);
        }
        //die("ossk");
        	$this->session->set_flashdata('success', 'Login Berhasil !');
          // redirect(base_url('admin'));
        	redirect(admin_url(""));
        /*
        if ($sess_data['user_type'] == 1) {
            $this->session->set_flashdata('success', 'Login Berhasil !');
            redirect(base_url('index.php/cms'));
        }else{
            $this->session->set_flashdata('success', 'Login Berhasil !');
            redirect(base_url('index.php/member'));
        }*/
        
      }else{
        $this->session->set_flashdata('result_login', 'Username atau Password yang anda masukkan salah.');
        redirect(base_url('login'));
      }
    }
  }
}