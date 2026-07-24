<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
	function __construct() {
		parent::__construct();
    	$this->load->library('session');
    	$this->load->model(array('Mod_login','Mod_data','User_activity','Mod_query'));
	}
	#index
	public function index($value=""){
		if($this->session->userdata()){		
			$data   = array();
			$form   = array();
			$status = array("status"=>"List Magazine","btn-txt"=>"Add Magazine","btn-class" => "add_magz");
      		$this->template("backend/backend_home",$data,$status,$form);
		}else{
          redirect('login');
		}
	}

	#content
	public function magz($value='',$value1=''){
		#h3($this->Mod_query->getDataMagazine($value)->magz_fk_issue);
      	if(!empty($value)){
      		$data['datamagazine'] = $this->Mod_query->getDataMagazine($value);
	      	$data['issuemagazine'] = $this->Mod_query->issueMagazine($this->Mod_query->getDataMagazine($value)->magz_fk_issue);
	      	$data['lastmagazine'] = $this->Mod_query->showDataMagazine($value);
	      	$data['submagazine']  = $this->Mod_query->subMagazine($value,$value1);

			$status = array("status"=>ucwords("$value")." Magazine","btn-txt"=>"x","btn-class" => "x");
			$form   = "";
	      	$this->template("backend/magazine/open_issue",$data,$status,$form);
	      }else{
          redirect(base_url('admin'));	      	
	      }
	}
	public function logout(){
  		$this->session->sess_destroy();
  		redirect(base_url('login'));
 	}

	#template	
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