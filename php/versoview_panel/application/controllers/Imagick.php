<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Magick extends CI_Controller {
	function __construct() {
		parent::__construct();
    	// $this->load->library('session');
    	$this->load->model(array('Mod_request'));
	}
	public function index($value=""){
		$image = new Imagick();
		$image->pingImage('new.pdf');
		echo $image->getNumberImages();
	}
}