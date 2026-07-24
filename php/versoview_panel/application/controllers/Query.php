<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Query extends CI_Controller {

	function __construct() {
		parent::__construct();
    	$this->load->library('session');
    	$this->load->model(array('User_activity'));
	}


	public function index($table = "") {
	    	echo "nama table blom ada";
	}
	public function sintak($table=""){
		$data["table"]=$table;
  		$this->load->view("vquery",$data);
	}
	public function query($table=""){
	}
}