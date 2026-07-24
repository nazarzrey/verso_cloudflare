<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	function __construct() {
		parent::__construct();
		// if ($this->session->userdata('username')) {
		//   redirect(base_url('site'));
		// }
		// $this->load->model(array('Mod_data',
		//                           'Mod_karyawan',
		//                           'Mod_siswa',
		//                           'Mod_proses'));
		//$this->load->model(array('Mod_query','Mod_magazine'));
		#$this->load->helper('fungsi');
	}
	public function index(){     
		$this->load->view("home/test_page");
	}
	public function tes2(){     
		$this->load->view("home/test");
	}
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
