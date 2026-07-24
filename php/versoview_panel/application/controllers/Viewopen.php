<?php

#ajaxrequest adalah yang systemnya get
defined('BASEPATH') or exit('No direct script access allowed');

class Viewopen extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model(array('User_activity', 'Mod_openview'));
		Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
		Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
		Header('Access-Control-Allow-Methods: GET, POST');
	}
	#index
	public function index($id = '', $page = '', $open = '')
	{
		if (empty($id)) {
			echo  json_encode(array("result" => "this ajax openview " . $id));
		} else {
			#$return = $this->Mod_openview->openview_hdr($id,$page);
			#echo $return;
			$data_page  = min_space($page, "-");
			#echo "xx".$id.$data_page.current_url();
			$v_hdr = $this->Mod_openview->openview_hdr($id, $data_page);
			$v_dtl = $this->Mod_openview->openview_dtl($id, $data_page);

			#if(Host()=="localhost"){ 
			#}
			#var_dump($v_hdr[0]->magz_name);
			if ($v_dtl == "0") {
				$data["hdr_openview"] = $v_hdr;
			} else {
				$data["dtl_openview"] = $v_dtl;
			}
			$data["hdr_id"]   = $id;
			$data["hdr_page"] = $data_page;
			if (!empty($open)) {
				$this->load->view("backend/openview_template_single", $data);
			} else {
				$this->load->view("templates/openview_header", $data);
				$this->load->view("backend/openview_template", $data);
				$this->load->view("templates/openview_footer");
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
	public function kebakar($id = "", $page = "")
	{
		#headers.append('Access-Control-Allow-Origin', 'file:///D:/xampp/htdocs/agencyfish/weblist/versoview/pageturner/200122/api-yzjs0gucd25/api.html#');
		#headers.append('Access-Control-Allow-Credentials', 'true');

		$uid   = $this->input->post("uid");
		$utipe = $this->input->post("tipe");
		$data_page  = min_space($page, "-");
		if ($page == "") {
			$v_hdr = $this->Mod_openview->openview_hdr($id, $data_page);
			foreach ($v_hdr as $key => $value) {
				$imgpage = ganjil_genap($value->magz_page);
				$path    = $value->issue_path;
				$url1    = $id . "/" . $value->content . "#";
				$gg = gg($key);
				echo "<div class='content-page fisrt-content-page $gg' data-url='" . $url1 . "'>";
				echo "<div class='container'>";
				echo "<div class='img row img-deliver' id='ov-" . $value->magz_page . "' data-href='" . $id . "/" . min_space($value->content, "-") . "#ptop" . "'>";
				echo "<div class='img-data'>";
				foreach ($imgpage as $key => $xpage) {
					$img = api_ov_img($xpage, $path, "med");
					echo "<img src='" . $img . "' id='p" . $xpage . "' class='ov-image'/>";
				}
				echo "</div>";
				echo "</div>";
				echo "
	          <div style='padding:0'>
	          <h2 style='padding:0 !important;margin:10px 0 10px 0 !important'>" . $value->title . "</h2>
	          <h3 style='padding: 0 0 20px 0 !important;'>" . $value->lead . "</h3>
	          </div>
	          ";
				echo "</div>
	        </div>";
			}
		} else {
			$v_dtl = $this->Mod_openview->openview_dtl($id, $data_page);
			echo "<div style='margin-bottom:70px'><div class='view-page'></div>";
			$body = "";
			$capt = "";
			foreach ($v_dtl as $key => $value) {
				$body = $value->body_text;
				$p = "<section>" . $value->body_text . "</section>";
				$l = "<section style='white-space: normal;'>" . $value->caption . "</section>";
				$imgpage = ganjil_genap($value->magz_page);
				$path    = $value->issue_path;
				$url1    = base_url("ovj/" . $id . "/" . $value->magz_page);
				echo "<div class='content-page fisrt-content-page' data-url='" . $url1 . "'>";
				if ($value->magz_page % 2 == 0) {
					echo "<div class='img-dtl'>";
					echo "<div class='img-data'>";
					foreach ($imgpage as $key => $xpage) {
						// $url = base_url("ovj/".$id."/".$page);
						$img = api_ov_img($xpage, $path, "med");
						echo "<img src='" . $img . "' id='p" . $xpage . "' class='ov-image'/>";
					}
					echo "</div>";
					echo "</div>";
				}
				if (!empty(trim($value->title))) {
					echo "
	                <h2 style='padding:40px 0;margin:0'>" . $value->title . "</h2>
	                <h3>" . $value->lead . "</h3>
	                ";
				}
				echo $p . " " . $l;
				echo "</div>";
				#echo "</a>";
			}
			echo '
	      <div class="ov-footer" style="background: #fff;position: fixed;bottom: 0;left:0;z-index: 999;width:100%;box-shadow:1px 1px 5px #ccc">
	       
	          <img src="assets/images/ovi.png" style="height: 25px;margin-top:0px" />
	        </a>
	      </div>
	    </div>';
		}
		##$path  = $this->Mod_openview->konten($id);
		#var_dump($path);
		#var_dump($path);
		##$arr[] = array("path_flipbook"=>$path->ov_flipbook,"path_openview"=>$path->ov_openview);
		#header('Content-type: application/json');
		##echo json_encode($arr);
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
