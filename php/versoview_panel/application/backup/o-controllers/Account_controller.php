<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account_controller extends CI_Controller {
	function __construct() {
		parent::__construct();
    	$this->load->library('session');
    	// $this->load->library('../controllers/backend_template');
    	$this->load->model(array('Account_module','User_activity'));
	}
	#index
	public function index($value=""){
		if($this->session->userdata()){		
			$data   = array();
			$form   = array();
			$status = array("status"=>"Profile Manager","btn-class" => "x","btn-txt"=>"x");
      		$this->template("backend/account/account_view_profile",$data,$status,$form);
		}else{
          redirect('login');
		}
	}

	public function profile($value='')
	{
		die("s");
	}

	public function header($status){
		$data['session'] = $this->User_activity->activity();
		$this->load->view("templates/backend_header",$data);
		$this->load->view("templates/backend_menu_sidebar",$data);
		$this->load->view("templates/backend_menu_top",$data);		
		if(!empty($status)){
			$xdata["status"]=$status;
			$this->load->view("templates/backend_status",$xdata);
		}
	}
	public function footer(){
      	$data 	= "footer";
		$this->load->view("templates/backend_footer",$data);
	}	
	public function template($view,$data,$status,$form){
		$this->header($status);
		//die($form)
		if(!empty($form)){
			$this->load->view("form/modal_form",$form);
		}
		if(is_array($data)){
			$this->load->view($view,$data);
		}else{
			if($data=="view"){
				$this->load->view($view);
			}else{
				echo $view;
			}
		}
		$this->footer();
	}
}