<?php

#ajaxrequest adalah yang systemnya get
defined('BASEPATH') or exit('No direct script access allowed');

class Viewopenstat extends CI_Controller
{
	function __construct()
	{

		Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
		Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
		Header('Access-Control-Allow-Methods: GET, POST');
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array('User_activity', 'Mod_openview'));
	}
	#index
	public function index($id = '', $page = '', $open = '', $img = '')
	{
		$link = $this->Mod_openview->link($id);
		$mstpath 		  = base_url() . $this->config->item('mstpath') . "/";
		if (strpos($link->issue_path, 'http') !== false) {
			$data["msturi"]   = $link->issue_path;
		} else {
			$data["msturi"]   = $mstpath . $link->issue_path;
		}
		if (!empty($img)) {
			echo  $data["msturi"] . "files/extfile/" . $img;
		} else {
			if (empty($id)) {
				echo  json_encode(array("result" => "this ajax openview " . $id));
			} else {
				#$return = $this->Mod_openview->openview_hdr($id,$page);
				#echo $return;
				$data_page  = min_space($page, "-");
				#echo "xx".$id.$data_page.current_url();
				$v_hdr = $this->Mod_openview->openview_hdr($id, $data_page);
				$v_dtl = $this->Mod_openview->openview_dtl($id, "all");
				$v_jdl = $this->Mod_openview->openview_edisi($id);
				#if(Host()=="localhost"){ 
				#}
				#var_dump($v_hdr[0]->magz_name);
				###if($v_dtl=="0"){
				$data["hdr_openview"] = $v_hdr;
				// dbg($data);
				###}else{
				$data["dtl_openview"] = $v_dtl;
				###}
				$data["hdr_id"]   = $id;
				$data["hdr_page"] = $data_page;
				$data["halaman"]  = $page;

				$xcurl = str_replace("http://", "", current_url());
				$curl = explode("/", $xcurl);
				if (strpos($xcurl, "versoview.com") !== false) {
					$curl2 = "ov_std";
				} else {
					$curl2 = $curl[2];
				}
				if (strpos($curl2, 'ov') !== false) {
					if (!empty($page)) {
						if (strpos($xcurl, "versoview.com") !== false) {
							if ($curl[5] == "view") {
								$this->load->view("api/openview_dtl_new", $data);
							} else if ($curl[5] == "edisi") {
								echo json_encode($v_jdl);
								// echo strtoupper($v_jdl[0]->judul); # . " - " . $v_jdl[0]->content_title;
								// $this->load->view("api/openview_dtl_new", $data);
							} else {
								// #dbg($curl2);
								$data["ov"] = $curl2;
								$this->load->view("templates/" . $curl2 . "/openview_header", $data);
								$this->load->view("backend/" . $curl2 . "/openview_template_stat", $data);
								$this->load->view("templates/" . $curl2 . "/openview_footer");
							}
						} else {
							if ($curl[4] == "view") {
								$this->load->view("api/openview_dtl_new", $data);
							} else if ($curl[4] == "edisi") {
								echo json_encode($v_jdl);
								// echo strtoupper($v_jdl[0]->judul); # . " - " . $v_jdl[0]->content_title;
								// $this->load->view("api/openview_dtl_new", $data);
							} else {
								#dbg($curl2);
								#ov_std disini skripnya
								$data["ov"] = $curl2;
								$this->load->view("templates/" . $curl2 . "/openview_header", $data);
								$this->load->view("backend/" . $curl2 . "/openview_template_stat", $data);
								$this->load->view("templates/" . $curl2 . "/openview_footer");
							}
						}
					} else {
						$this->load->view("backend/" . $curl2 . "/openview_template_stat", $data);
					}
				} else {
					if (!empty($page)) {
						$this->load->view("templates/openview_header", $data);
						$this->load->view("backend/openview_template_stat", $data);
						$this->load->view("templates/openview_footer");
					} else {
						$this->load->view("backend/openview_template_stat", $data);
					}
				}
			}
		}
	}
	public function api($id = '')
	{
		$path  = $this->Mod_openview->api($id);
		#var_dump($path);
		#var_dump($path);
		$arr[] = array("path_flipbook" => $path->ov_flipbook, "path_openview" => $path->ov_openview);
		#header('Content-type: application/json');
		echo json_encode($arr);
	}
	public function ovi_gambar($id_gambar = "")
	{
	}
	public function yang_isi_anantara()
	{
		$data = $this->Mod_openview->yang_isi_anantara();
		#var_dump($data);
		if ($data) {
			if (count($data) > 0) {
				foreach ($data as $key => $d) {
					$arr[] = array(
						"title" => $d->title,
						"content" => $d->content,
						"lead" => $d->lead,
						"magz_page" => $d->magz_page,
					);
				}
			} else {
				$arr = array("");
			}
		} else {
			$arr = array("");
		}
		echo json_encode($arr);
	}

	public function detil_isi_anantara($id)
	{
		$data = $this->Mod_openview->detil_isi_anantara($id);
		#var_dump($data);
		if ($data) {
			if (count($data) > 0) {
				foreach ($data as $key => $d) {
					$arr[] = array(
						"title" => $d->title,
						"content" => $d->content,
						"body_text" => $d->body_text,
						"caption" => $d->caption,
						"lead" => $d->lead,
						"magz_page" => $d->magz_page,
					);
				}
			} else {
				$arr = array("");
			}
		} else {
			$arr = array("");
		}
		echo json_encode($arr);
	}

	public function detail_isi_anantara($id)
	{
		$data = $this->Mod_openview->detail_isi_anantara($id);
		#var_dump($data);
		if ($data) {
			if (count($data) > 0) {
				foreach ($data as $key => $d) {
					$arr[] = array(
						"title" => $d->title,
						"content" => $d->content,
						"body_text" => $d->body_text,
						"caption" => $d->caption,
						"lead" => $d->lead,
						"magz_page" => $d->magz_page,
					);
				}
			} else {
				$arr = array("");
			}
		} else {
			$arr = array("");
		}
		echo json_encode($arr);
	}
	/*
	public function openview(){
		echo $return;
	}
*/
}
