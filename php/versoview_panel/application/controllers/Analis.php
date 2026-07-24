<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Analis extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('Mod_analis');    
	}
	public function index(){	
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		$arr = array();
		$arr["app"] = $this->input->post('app');
		$arr["edition"] = $this->input->post('edition');
		$arr["page"] = $this->input->post('page');
		$arr["position"] = $this->input->post('position');
		$arr["period"] = $this->input->post('period');
		$arr["ip"] = $this->input->post('ip');
		$arr["country"] = $this->input->post('country');
		$arr["browser"] = $this->input->post('browser');
		$arr["device"] = $this->input->post('device');
		$arr["size"] = $this->input->post('size');
		$arr["custom"] = $this->input->post('custom');
		$arr["years"] = $this->input->post('years');
		if($this->input->post("guid")){
			$guid = $this->input->post('guid');
			if(strlen($guid)==0){
				if(isset($_COOKIE['MAGS_ID'])){
					$arr["guid"] = $_COOKIE['MAGS_ID'];
				};
			}else{
				$arr["guid"] = $guid;
			}
		}			
		$data = $this->Mod_analis->click($arr);
  		echo json_encode($this->input->post());
	}	
}