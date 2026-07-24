<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Backend extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array('Mod_magazine', 'User_activity', 'Mod_backend', 'Mod_magazine_user', 'Mod_magick'));
	}
	#index
	public function index($value = "")
	{
		if ($this->session->userdata('uid')) {
			$data["data"] = $this->Mod_magazine->userownmagazine($this->session->userdata('uid'));
			$form   	  = "show";
			$status 	  = array("status" => "List Magazine", "btn-txt" => "Add Magazine", "btn-class" => "new-magz");
			$magzname 	  = $this->Mod_magazine->HdrMagz("", "magz_url");
			$data['dtlcat']	= $this->Mod_magazine->CatDtl("", "");
			$this->template("backend/backend_home", $data, $status, $form);
		} else {
			redirect('login');
		}
	}


	#magazine list and config
	#public function panel($value='',$value1='',$value2=''){
	#	echo $value,$value1,$value2;
	#}
	public function magz($value = '', $value1 = '', $value2 = '')
	{
		#die("1 ".$value." 2 ".$value1." 3 ".$value1);

		$form   = "";
		if (!empty($value)) {
			if (!empty($value1)) {
				if ($value1 == "setting") {
					redirect('backend');
				} else {
					if ($this->Mod_magazine->adm_subMagazine($value, $value1)) {
						$edisi  = $this->Mod_magazine->adm_subMagazine($value, $value1)->issue_title;
					} else {
						$edisi  = $value;
					};
					if ($this->session->userdata('uid') == "1") {
						if (strpos($value1, "page") !== false) {
							$arr = explode(":", $value);
							if (count((array)$arr) > 1) {
								echo "x";
							}
						} else {
						}
					};
					$data['datamagazine']  = $this->Mod_magazine->adm_DataMagazine($value);
					$data['issuemagazine'] = $this->Mod_magazine->adm_issueMagazine($this->Mod_magazine->adm_DataMagazine($value)->magz_fk_issue);
					$data['lastmagazine']  = $this->Mod_magazine->adm_showDataMagazine($value);
					$data['submagazine']   = $this->Mod_magazine->adm_subMagazine($value, $value1);
					#$edisi  = $this->Mod_magazine->adm_subMagazine($value,$value1)->issue_title;
					if (empty($value2)) {
						$link   = "<a class='ver-clr3' href='" . admin_url("magz/" . $value) . "'>" . ucwords("$value") . " Magazine</a>";
						$status = array("status" => $link . " / " . ucwords($edisi), "btn-txt" => "x", "btn-class" => "x");
						$this->template("backend/magazine/issue_listdata", $data, $status, $form);
					} else {
						$link   = "<a class='ver-clr3' href='" . admin_url("magz/" . $value) . "'>" . ucwords("$value") . " Magazine</a>";
						$link2  = "<a class='ver-clr3' href='" . admin_url("magz/" . $value . "/" . $value1) . "'>" . ucwords($edisi) . "</a>";
						$status = array("status" => $link . " / " . $link2 . " ( setting )", "btn-txt" => "x", "btn-class" => "x");
						$form   = "";
						$this->template("backend/magazine/issue_setting", $data, $status, $form);
					}
				}
			} else {
				if ($value == "new") {
					$status = array("status" => ucwords("$value") . " Magazine", "btn-txt" => "", "btn-href" => admin_url($value . "/setting"));
					$data 	= array();
					$this->template("backend/magazine/upload_new", $data, $status, $form);
				} else {
					$magzname = $this->Mod_magazine->HdrMagz($value, "magz_url");
					#var_dump($magzname);
					#die("1 ".$value." 2 ".$value1." 3 ".$value1);
					if (!$magzname) {
						redirect('backend');
						die();
					}
					$M_name   = $magzname[0]->magz_name;
					if (strpos(strtolower($M_name), "magazine") === false) {
						$M_name = $M_name . " Magazine";
					}
					$status   = array("status" => ucwords(strtolower($M_name)), "btn-txt" => "Add Magazine Issue", "btn-class" => admin_url($value . "/new"));
					$uid      = $this->User_activity->activity()["uid"];
					$uid = $this->User_activity->activity()["uid"];
					$data['issue_view']	   = $this->Mod_magazine_user->issue_view($uid, "");
					$data['hdrmagz'] 	   = $magzname;
					$data['issuemagazine'] = $this->Mod_magazine->adm_issueMagazine($magzname[0]->magz_id);
					$data['dtlcat']	       = $this->Mod_magazine->CatDtl($magzname[0]->magz_cat, "");
					$this->template("backend/magazine/issue_listdata", $data, $status, $form);
				}
			}
		} else {
			redirect(base_url('admin'));
		}
	}
	public function ov_magz($value = '', $value1 = '', $value2 = '')
	{
		#die("1 ".$value." 2 ".$value1." 3 ".$value1);
		$form   = "";
		if (!empty($value)) {
			if (!empty($value1)) {
				if ($value1 == "setting") {
					redirect('ov');
				} else {
					if ($this->Mod_magazine->adm_subMagazine($value, $value1)) {
						$edisi  = $this->Mod_magazine->adm_subMagazine($value, $value1)->issue_title;
					} else {
						$edisi  = $value;
					};
					if ($this->session->userdata('uid') == "1") {
						if (strpos($value1, "page") !== false) {
							$arr = explode(":", $value);
							if (count((array)$arr) > 1) {
								echo "x";
							}
						} else {
						}
					};
					$data['datamagazine']  = $this->Mod_magazine->adm_DataMagazine($value);
					$data['issuemagazine'] = $this->Mod_magazine->adm_issueOpenview($this->Mod_magazine->adm_DataMagazine($value)->magz_fk_issue);
					$data['lastmagazine']  = $this->Mod_magazine->adm_showDataMagazine($value);
					$data['submagazine']   = $this->Mod_magazine->adm_subMagazine($value, $value1);
					#$edisi  = $this->Mod_magazine->adm_subMagazine($value,$value1)->issue_title;
					if (empty($value2)) {
						$link   = "<a class='ver-clr3' href='" . admin_url("magz/" . $value) . "'>" . ucwords("$value") . " Magazine</a>";
						$status = array("status" => $link . " / " . ucwords($edisi), "btn-txt" => "x", "btn-class" => "x");
						$this->template("backend/openview/issue_listdata", $data, $status, $form);
					} else {
						$link   = "<a class='ver-clr3' href='" . admin_url("magz/" . $value) . "'>" . ucwords("$value") . " Magazine</a>";
						$link2  = "<a class='ver-clr3' href='" . admin_url("magz/" . $value . "/" . $value1) . "'>" . ucwords($edisi) . "</a>";
						$status = array("status" => $link . " / " . $link2 . " ( setting )", "btn-txt" => "x", "btn-class" => "x");
						$form   = "";
						$this->template("backend/openview/issue_setting", $data, $status, $form);
					}
				}
			} else {
				if ($value == "new") {
					$status = array("status" => ucwords("$value") . " Magazine", "btn-txt" => "", "btn-href" => admin_url($value . "/setting"));
					$data 	= array();
					$this->template("backend/openview/upload_new", $data, $status, $form);
				} else {
					#echo h3("XXXX");
					$magzname = $this->Mod_magazine->HdrMagz($value, "magz_url");
					#var_dump($magzname);
					#die("1 ".$value." 2 ".$value1." 3 ".$value1);
					if (!$magzname) {
						redirect('ov');
						die();
					}
					$M_name   = $magzname[0]->magz_name;
					if (strpos(strtolower($M_name), "magazine") === false) {
						$M_name = $M_name . " Magazine";
					}
					$status   = array("status" => "Openview for " . ucwords(strtolower($M_name)), "btn-txt" => "Add Magazine Issue", "btn-class" => admin_url($value . "/new"));
					$uid      = $this->User_activity->activity()["uid"];
					#if(!$this->Mod_magazine->adm_DataMagazine($value)){						
					#	redirect('backend');
					#	die();
					#}					
					#die("1 ".$value." 2 ".$value1." 3 ".$value1);
					$uid = $this->User_activity->activity()["uid"];
					$data['issue_view']	   = $this->Mod_magazine_user->issue_view($uid, "");
					$data['hdrmagz'] 	   = $magzname;
					$data['issuemagazine'] = $this->Mod_magazine->adm_issueOpenview($magzname[0]->magz_id);
					$data['dtlcat']	       = $this->Mod_magazine->CatDtl($magzname[0]->magz_cat, "");
					#$data['lastmagazine'] = $this->Mod_magazine->adm_showDataMagazine($value);
					#$data['submagazine']  = $this->Mod_magazine->adm_subMagazine($value,$value1);
					#h3("s");
					$this->template("backend/openview/issue_listdata", $data, $status, $form);
				}
			}
		} else {
			redirect(base_url('admin'));
		}
	}

	public function openView($id = '')
	{

		// $data["data"] = $this->Mod_magazine->userownopenview($this->session->userdata('uid'));
		$form   	  = "show";
		$status 	  = array("status" => "Openview Ready", "btn-txt" => "Add Openview", "btn-class" => "x");
		$magzname 	  = $this->Mod_magazine->HdrMagz("", "magz_url");
		$data['dtlcat']	= $this->Mod_magazine->CatDtl("", "");
		$this->template("backend/backend_openview", $data, $status, $form);
	}
	public function login()
	{
		$data = "X";
		$this->load->view("templates/backend_header", $data);
		$this->load->view("backend/v_login", $data);
		$this->load->view("templates/backend_footer", $data);
	}
	public function signup($value = '')
	{
		$data = "x";
		$this->load->view("templates/backend_header", $data);
		$this->load->view("backend/v_signup", $data);
		$this->load->view("templates/backend_footer", $data);
	}
	public function logout()
	{
		$this->session->sess_destroy();
		// fb
		if (isset($_SESSION['fb_access_token'])) {
			#   include "config.fb.php";
			unset($_SESSION['fb_access_token']);
		}
		// tw
		$session_data = array('sess_logged_in' => 0);
		$this->session->set_userdata($session_data);
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);
		#die('<META http-equiv="refresh" content="0;URL=home.html">');
		/*refresh("https://colours-indonesia.com/cotw/home.html");
        die();

require 'facebook.php';
$facebook->destroySession();
header( "location:index.php" */
		redirect(base_url('login'));
	}

	#account
	/*public function account((array)$value='')
	 {
	 	die("kampret");
	 } */

	#template	
	public function header($status)
	{
		$data['session'] = $this->User_activity->activity();
		$this->load->view("templates/backend_header", $data);
		$this->load->view("templates/backend_menu_sidebar", $data);
		$this->load->view("templates/backend_menu_top", $data);
		if (!empty($status)) {
			$xdata["status"] = $status;
			$this->load->view("templates/backend_status", $xdata);
		}
	}
	public function footer()
	{
		$data 	= "footer";
		$this->load->view("templates/backend_footer", $data);
	}
	public function template($view, $data, $status, $form)
	{
		$this->header($status);
		#die($form);
		if (!empty($form)) {
			$this->load->view("form/modal_form", $form);
		}
		if (is_array($data)) {
			$this->load->view($view, $data);
		} else {
			if ($data == "view") {
				$this->load->view($view);
			} else {
				echo $view;
			}
		}
		$this->footer();
	}
}
