<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('facebook');
    }
	
	public function index()
	{
		
		if($this->facebook->is_authenticated()){
			$userProfile = $this->facebook->request('get', '/me?fields=id,name,first_name,last_name,email,gender,locale,picture');

			$data = array('name'=>$userProfile['name'],
							  'email'=>$userProfile['email'],
							  'gambar'=>$userProfile['picture']['data']['url']);
			$this->load->view('home',$data);

		}
		else
		{
			$data['authUrl'] =  $this->facebook->login_url();
			$this->load->view('login',$data);
        }
	    
    }

	public function logout() {
		$this->facebook->destroy_session();
		redirect('/login');
    }
}
