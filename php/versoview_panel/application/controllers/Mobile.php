<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Mobile extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model('MobileX');    
  }
  // function index() {
  //     $data = $this->Mod_login_mobile->cek();
  //     echo json_encode($data->result_array());
  // }
  function search() {
      $find = $this->input->get('find');
      $data = $this->MobileX->getMagazine($find);
      if (count($data) > 0) echo json_encode($data);
      else echo json_encode("0");
  }

  function login() {
      $email = $this->input->post('email'); 
      $data = $this->MobileX->login($email);
      echo $data;
  }

  function login_email() {
      $name = $this->input->post('name'); 
      $email = $this->input->post('email'); 
      $password = $this->input->post('password'); 
      $data = $this->MobileX->login_email($name, $email, $password);
      echo json_encode($data);
  }

  function signin_email() {
      $email = $this->input->post('email'); 
      $password = $this->input->post('password'); 
      $data = $this->MobileX->signin_email($email, $password);
      echo json_encode($data);
  }

  function bookmark() {
      $login = $this->input->post('login'); 
      $page = $this->input->post('page'); 
      $issue = $this->input->post('issue'); 
      $pagedetail = $this->input->post('pagedetail'); 
      $status = $this->input->post('status'); 
      $data = $this->MobileX->bookmark($login, $page, $status, $pagedetail, $issue);
      echo json_encode($data);
  }

  function favorite() {
      $login = $this->input->post('login'); 
      $page = $this->input->post('page'); 
      $issue = $this->input->post('issue'); 
      $pagedetail = $this->input->post('pagedetail'); 
      $status = $this->input->post('status'); 
      $data = $this->MobileX->favorite($login, $page, $status, $pagedetail, $issue);
      echo json_encode($data);
  }

  function demo($value="") {
  	/*
	$data = $this->MobileX->getDemo($value,"demo");  	
  	echo json_encode($data);
	*/
	$this->dev("eColours");
  }
  function dev($value="") {
	if(empty($value)){
		$data = "Api APP Magazine";
	}else{		
		$data = $this->MobileX->getDemo($value,"dev");
		/* $result = array("");
		$result = new stdClass();		
		foreach($data as $key => $hasil){
			$result[] = $hasil->id;
		} */
	}
  	echo json_encode($data);
  }

  function magazine($value="eColours") {
  	$data = $this->MobileX->getMagz($value,"live");  	
  	echo json_encode($data);
  }
  function nazarapp($value="eColours") {
  	$data = $this->MobileX->getNzr($value,"live");  	
  	echo json_encode($data);
  }
}