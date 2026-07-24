<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errorpage404 extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('Mod_query'));
	}
	public function index()
	{
      	$data['listcategory'] = $this->Mod_query->getCategory();   
		$this->load->view("templates/header",$data);
		$this->load->view("errorpage");		
		$this->load->view("templates/footer");
	}

}

/* End of file Errorpage404.php */
/* Location: ./application/controllers/Errorpage404.php */