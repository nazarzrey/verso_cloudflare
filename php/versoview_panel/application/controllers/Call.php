<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Call extends CI_Controller {
	function __construct() {
		parent::__construct();
    	//$this->load->library('session');
    	//$this->load->model(array('Mod_request','User_activity','Mod_magazine'));
	}
	#index
	public function index($value=""){
	}

	public function other($value='')
	{
		require_once(APPPATH."controllers/Create_file.php");
		#$crt = new Create_file();
		#echo $ss= $crt->create_index;
		# code...
	}
}
?>