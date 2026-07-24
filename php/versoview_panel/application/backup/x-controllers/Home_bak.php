<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() {
		parent::__construct();
		// if ($this->session->userdata('username')) {
		//   redirect(base_url('site'));
		// }
		// $this->load->model(array('Mod_data',
		//                           'Mod_karyawan',
		//                           'Mod_siswa',
		//                           'Mod_proses'));
		$this->load->model(array('Mod_query'));
		#$this->load->helper('fungsi');
	}

	public function index(){
		#$this->load->view('welcome_message');
		#echo "this is home";

/*
$detail_agenda = $this->Mod_data->getDetailAgenda($id);
if($detail_agenda){
  if($detail_agenda->num_rows() > 0){
    foreach($detail_agenda->result_array() as $row){
      $items_detailagenda[] = $row;
    }
    $data['detail_agenda'] = $items_detailagenda;
  }
}

$data['sidebar'] = $this->load->view('template_web/sidebar',$data,true);

$this->load->view('template_web/header',$data);
$this->load->view('template_web/menu');
$this->load->view('template_web/notification');
$this->load->view('tdetail_agenda',$data);
$this->load->view('template_web/footer');
      #****/
        //$data['listcategory'] = $this->load->view();       
      	$data['datacategory'] = $this->Mod_query->getDataCategory();    
      	$data['datacover'] = $this->Mod_query->getDataCover();   
		#$this->load->view("templates/header",$data);
      	#var_dump($data);
		// $this->header();
		// $this->load->view('home',$data);
		// $this->footer();

		$this->template('home',$data);
	}

	#controller->router
	public function controller_magazine($value='',$value1=''){
		#h3($this->Mod_query->getDataMagazine($value)->magz_fk_issue);
      	$data['datamagazine'] = $this->Mod_query->getDataMagazine($value);
      	$data['issuemagazine'] = $this->Mod_query->issueMagazine($this->Mod_query->getDataMagazine($value)->magz_fk_issue);
      	$data['lastmagazine'] = $this->Mod_query->showDataMagazine($value);
      	$data['submagazine']  = $this->Mod_query->subMagazine($value,$value1);

     	#echo h3($this->Mod_query->getDataMagazine($value)["magz_fk_issue"]."xx");
		$this->template('file/open_magazine',$data);
      	#echo h3($this->Mod_query->getDataMagazine($value)->magz_fk_issue);
		
	}
	public function controller_category($value=''){
		if(!empty($value)){
			$data["listcategory"] = $this->Mod_query->listCategory($value);
			$this->template('file/page_category',$data);
		}else{
			$this->header();
			echo "gg";
			$this->footer();
		}
		//$this->template("<div style='margin:100px'>magazine detail page $datax</div>");
	}
	// public function controller_allmagazine($value=''){  
	// 	$this->template("<div style='margin:100px'>all magazine</div>","txt");
	// }
	// public function nama($value='',$value1='')
	// {
	// 	echo "nama ".$value." ".$value1;
	// }
	// public function controller_feature_magazine()
	// {
	// 	$this->template('file/open_magazine');
	// }

	#template
	public function header()
	{
      	$data['listcategory'] = $this->Mod_query->getCategory();   
		$this->load->view("templates/header",$data);
	}
	public function footer()
	{
		$this->load->view("templates/footer");
	}
	
	public function template($view,$data)
	{
		$this->header();
		if(is_array($data)){
			$this->load->view($view,$data);
		}else{
			echo $view;
		}
		$this->footer();
	}
	#error page
	// public function errorpage()
	// {
	// 	$this->template($this->load->view('errorpage'));
	// }

	#404

	// public function controller_mylibrary($value='')
	// {
	// 	echo "mylibrary page";
	// }
	// public function controller_qrcode($value='')
	// {
	// 	echo "qrcode page";
	// }
	// public function controller_googlerewards($value='')
	// {		
	// 	echo "google rewards page";
	// }
	// public function controller_batrewards($value='')
	// {
	// 	echo "bat rewards page";
	// }
}
