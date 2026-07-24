<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kondangan extends CI_Controller {
	#pake autolod di config set library databse auto 
	// public function __construct()
	// {
	// 	parent::__construct();
	// 	$this->load->database();
	// }

	public function index()
	{
		$this->load->datbase();
		$data["judul"] = "Daftar mahasisawa";
		$this->load->view('templates/header',$data);
		$this->load->view('kondangan/index');
		$this->load->view('templates/footer');
	}

}

/* End of file Mahasiswa.php */
/* Location: ./application/controllers/Mahasiswa.php */