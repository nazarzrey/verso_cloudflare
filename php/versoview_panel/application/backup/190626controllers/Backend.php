<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
	function __construct() {
		parent::__construct();
    	$this->load->library('session');
    	$this->load->model(array('Mod_login','Mod_backend_magazine','User_activity','Mod_backend'));
	}
	#index
	public function index($value=""){
		if($this->session->userdata('uid')){		
			$data["data"] = $this->Mod_backend_magazine->userownmagazine($this->session->userdata('uid'));
			$form   = array();
			$status = array("status"=>"List Magazine","btn-txt"=>"Add Magazine","btn-href" => admin_url("magz/new"));
      		$this->template("backend/backend_home",$data,$status,$form);
		}else{
          redirect('login');
		}
	}


	#magazine list and config
	public function magz($value='',$value1='',$value2=''){
		$form   = "";
		#h3($value.$value1.$value2);
      	if(!empty($value)){
      		if(empty($value1)){
				if($value=="new"){
					$status = array("status"=>ucwords("$value")." Magazine","btn-txt"=>"","btn-href" => admin_url("magz/".$value."/setting"));
					$data 	= array();
		      		$this->template("backend/magazine/upload_new",$data,$status,$form);
		      	}else{
					$status = array("status"=>ucwords("$value")." Magazine","btn-txt"=>"Add Magazine Issue","btn-href" => admin_url("magz/".$value."/setting"));
					if(!$this->Mod_backend_magazine->adm_DataMagazine($value)){
						redirect('admin/magz');
						die();
					}
			  		$data['datamagazine'] = $this->Mod_backend_magazine->adm_DataMagazine($value);
			      	$data['issuemagazine']= $this->Mod_backend_magazine->adm_issueMagazine($this->Mod_backend_magazine->adm_DataMagazine($value)->magz_fk_issue);
			      	$data['lastmagazine'] = $this->Mod_backend_magazine->adm_showDataMagazine($value);
			      	$data['submagazine']  = $this->Mod_backend_magazine->adm_subMagazine($value,$value1);
		      		$this->template("backend/magazine/issue_listdata",$data,$status,$form);
		      	}
		    }else{
		    	if($value1=="setting"){
					redirect('admin/magz');
		      	}else{
			  		$data['datamagazine'] = $this->Mod_backend_magazine->adm_DataMagazine($value);
			      	$data['issuemagazine'] = $this->Mod_backend_magazine->adm_issueMagazine($this->Mod_backend_magazine->adm_DataMagazine($value)->magz_fk_issue);
			      	$data['lastmagazine'] = $this->Mod_backend_magazine->adm_showDataMagazine($value);
			      	$data['submagazine']  = $this->Mod_backend_magazine->adm_subMagazine($value,$value1);
	   				$edisi  = $this->Mod_backend_magazine->adm_subMagazine($value,$value1)->issue_title;
		      		if(empty($value2)){
	        			$link   = "<a class='ver-clr3' href='".admin_url("magz/".$value)."'>".ucwords("$value")." Magazine</a>";
						$status = array("status"=>$link." / ".ucwords($edisi),"btn-txt"=>"x","btn-class" => "x");
			      		$this->template("backend/magazine/issue_listdata",$data,$status,$form);
			      	}else{			      		
	        			$link   = "<a class='ver-clr3' href='".admin_url("magz/".$value)."'>".ucwords("$value")." Magazine</a>";
	        			$link2  = "<a class='ver-clr3' href='".admin_url("magz/".$value."/".$value1)."'>".ucwords($edisi)."</a>";
						$status = array("status"=>$link." / ".$link2." ( setting )","btn-txt"=>"x","btn-class" => "x");
						$form   = "";
			      		$this->template("backend/magazine/issue_setting",$data,$status,$form);
			      	}
		      	}
		    }
	    }else{
          redirect(base_url('admin'));	      	
	    }
	}

  	public function login() {
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
	public function logout(){
  		$this->session->sess_destroy();
  		redirect(base_url('login'));
 	}

	#account
	/*public function account($value='')
	 {
	 	die("kampret");
	 } */

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