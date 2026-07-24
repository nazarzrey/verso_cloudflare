<?php
#ajaxrequest adalah yang systemnya post
defined('BASEPATH') or exit('No direct script access allowed');

class Ajaxpost extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// $this->load->library('session');
		#$this->load->model(array('Mod_ajax'));
		$this->load->model(array('Mod_request', 'User_activity', 'Mod_magazine'));
	}

	public function index()
	{
		echo  json_encode(array("result" => "this ajax.."));
	}

	public function newmagz($value = '', $value1 = '')
	{
		if ($this->session->userdata('uid')) {
			$uid = $this->session->userdata('uid');
			$kat = $this->input->post("cmagz");
			$jdl = $this->input->post("nmagz");
			$des = $this->input->post("dmagz");
			$auto = $this->input->post("aumagz");
			$data["result"] = $this->Mod_magazine->new_hdr_magz($jdl, $kat, $uid, $des, $auto);
			echo json_encode($data);
		}
	}

	public function user($value = '')
	{
		if ($value == "register") {
			if ($this->input->post("username")) {
				$this->form_validation->set_rules('username', 'username', 'required|trim');
				$this->form_validation->set_rules('email', 'email', 'required|trim');
				$this->form_validation->set_rules('password', 'password', 'required|trim');
				$name = $this->input->post("username");
				$mail = $this->input->post("email");
				$pass = $this->input->post("password");
				#$this->Mod_request->update($id,$value,$modul);
				$data["status"] = $this->Mod_request->register($name, $mail, $pass);
				echo json_encode($data);
			} else {
				echo "{}";
			}
		} elseif ($value == "login") {
			if ($this->input->post("useremail")) {
				$this->form_validation->set_rules('useremail', 'useremail', 'required|trim');
				$this->form_validation->set_rules('password', 'password', 'required|trim');
				$mail = $this->input->post("useremail");
				$pass = $this->input->post("password");
				#$this->Mod_request->update($id,$value,$modul);
				$data["status"] = $this->Mod_request->login($mail, $pass);
				echo json_encode($data);
			} else {
				echo "{}";
			}
		} else {
			die();
		}
	}

	public function crud($value = '', $value1 = '', $value2 = '')
	{
		$dir = "/var/www/html/";
		if ($value == "magz") {
			if ($value2 == "cek") {
			} elseif ($value2 == "hdr") {
				$sql  = "
						SELECT 
						b.magz_id AS data_hdr,a.magz_dtl_id AS data_dtl,c.gallery_fk_id AS data_img,
						IF(a.issue_publish=0,CONCAT('pdf_temp/',a.issue_pdf_file),CONCAT('pdf_publish/',a.issue_pdf_file)) AS pdf,
						CONCAT(c.gallery_path,c.gallery_image1) AS img,
						IF(a.issue_path IS NULL,'',CONCAT('pageturner/',a.issue_path)) AS path
						FROM magazine_data_dtl a
						LEFT JOIN magazine_data_hdr b ON a.magz_fk_id=b.magz_id
						LEFT JOIN magazine_gallery c ON a.magz_dtl_id=c.gallery_fk_id
						where b.magz_id='$value1'";
				$query = each_query($this->db->query($sql));
				if (count($query) > 0) {
					foreach ($query as $key => $data) {
						$pdf  = "./" . $data->pdf;
						$img  = "./" . $data->img;
						if (!empty($data->path)) {
							$flip = "./" . $data->path;
							if (is_dir($flip)) {
								$file = explode("/", $flip);
								$move = sys("dele") . " " . $flip;
								shell_exec($move);
							}
						}
						#echo "<br/><br/>";
						if (file_exists($pdf)) {
							$file = explode("/", $pdf);
							$move = sys("dele") . " " . $pdf;
							#echo "<br/>";
							shell_exec($move);
						}
						if (file_exists($img)) {
							$file = explode("/", $img);
							shell_exec(sys("dele") . " " . $img);
							#	echo "<br/>";
						}
					}
					$cvr   = $this->Mod_magazine->magazine_gallery("cover", $value1);
					if (file_exists($cvr)) {
						#echo $cvr;
					}
				}
				/*$flip = "./".$data->result_array()[0]["url"];
						$pdf  = "./".$data->result_array()[0]["pdf"];
						if(is_dir($flip)){
							shell_exec('rm -rf '.$flip);
							#echo $flip;
						}				
						if(file_exists($pdf)){
							shell_exec('rm '.$pdf);
							#echo $pdf;
						} */
				$delete = "call dele('$value1','hdr')";
				if ($this->db->query($delete)) {
					echo "1";
				} else {
					echo "0";
				}
			} elseif ($value2 == "dtl") {
				$sql  = "
						SELECT 
						b.magz_id AS data_hdr,a.magz_dtl_id AS data_dtl,c.gallery_fk_id AS data_img,
						IF(a.issue_publish=0,CONCAT('pdf_temp/',a.issue_pdf_file),CONCAT('pdf_publish/',a.issue_pdf_file)) AS pdf,
						CONCAT(c.gallery_path,c.gallery_image1) AS img,
						IF(a.issue_path IS NULL,'',CONCAT('pageturner/',a.issue_path)) AS path
						FROM magazine_data_dtl a
						LEFT JOIN magazine_data_hdr b ON a.magz_fk_id=b.magz_id
						LEFT JOIN magazine_gallery c ON a.magz_dtl_id=c.gallery_fk_id
						where a.issue_id='$value1'";
				$query = each_query($this->db->query($sql));
				#var_dump($query);
				foreach ($query as $key => $data) {
					$pdf  = "./" . $data->pdf;
					$img  = "./" . $data->img;
					if (!empty($data->path)) {
						$flip = "./" . $data->path;
						if (is_dir($flip)) {
							$file = explode("/", $flip);
							$move = sys("rmdir") . " " . $flip;
							shell_exec($move);
						}
					}
					#echo "<br/><br/>";
					if (file_exists($pdf)) {
						$file = explode("/", $pdf);
						$move = sys("dele") . " " . $pdf;
						#echo "<br/>";
						shell_exec($move);
					}
					#kalo detil yg di pilih ketika autocover jangan di hapus, kalo ga baru di hapus
					/*
							if(file_exists($img)){
								$file = explode("/",$img);
								shell_exec(sys("dele")." ".$img);
							#	echo "<br/>";
							}
							*/
				}
				$cvr   = $this->Mod_magazine->magazine_gallery("cover", $value1);
				if (file_exists($cvr)) {
					#echo $cvr;
				}
				/*$flip = "./".$data->result_array()[0]["url"];
						$pdf  = "./".$data->result_array()[0]["pdf"];
						if(is_dir($flip)){
							shell_exec('rm -rf '.$flip);
							#echo $flip;
						}				
						if(file_exists($pdf)){
							shell_exec('rm '.$pdf);
							#echo $pdf;
						}
						*/
				$delete = "call dele('$value1','dtl')";
				if ($this->db->query($delete)) {
					echo "1";
				} else {
					echo "0";
				}
			} else {
				echo "x";
			}
		} else {
			die("");
		}
	}

	public function upload($value = '')
	{
		/*ini_set('display_errors', true);
		ini_set('max_execution_time', 0);
		ini_set('upload_max_filesize', '100M');
		ini_set('post_max_size', '100M');
		ini_set('client_max_body_size', '100M');
		*/
		ini_set('display_errors', true);
		ini_set('max_execution_time', 0);
		ini_set('upload_max_filesize', '100M');
		ini_set('post_max_size', '100M');
		ini_set('client_max_body_size', '100M');
		$tgl							= date("ymd");
		$path 							= './pdf_temp/' . $tgl . "/";
		$path2 							= "./magazine/cover-issue/" . $tgl . "/";
		$config['upload_path']          = $path;
		$config['allowed_types']        = 'gif|jpg|png|pdf';
		$config['max_size']             = 1536000; #6.3Mb
		$config['max_filesize']			= 1536000; #6.3Mb
		$this->load->library('upload', $config);

		if (!is_dir($path)) {
			mkdir($path);
		}
		if (!is_dir($path2)) {
			mkdir($path2);
		}
		$str = array(" ", "&", "'", '"', "/", "\\", "*", "@", "!", "#", "$", "%", "^", "(", ")");
		$uid = $this->input->post("uid");
		$hdr = $this->input->post("magz_id");
		$cat = $this->input->post("pdf_category");
		$jdl = $this->input->post("pdf_title");
		$des = $this->input->post("pdf_desc");
		$magz = strtolower(str_replace($str, "", $jdl));
		$ran  = rand(0, 100);
		#$temp = $magz.tgl("sort");
		if (!$this->upload->do_upload('new_pdf', $config)) {
			$error = array('error' => str_replace(array("<p>", "</p>"), "", $this->upload->display_errors()));
			$data  = array('upload_data' => $this->upload->data()); #explode pdf data to array
			$fsz   = round($data["upload_data"]["file_size"] / 1024, 2) . " Mb";
			echo json_encode(array($error["error"] . " your file size is : " . $fsz . " try with other file"));
		} else {
			$data   = array('upload_data' => $this->upload->data()); #explode pdf data to array
			//die(var_dump($data));
			$oname  = $data["upload_data"]["file_name"];
			$nname  = tgl("sort2") . $uid . $cat . $ran . ".pdf";
			$icon   = "";
			if (rename($path . $oname, $path . $nname)) {
				$pdfname = $nname;
			} else {
				$pdfname = $oname;
			}
			$numpdf   = numPdf($path . $pdfname);
			$iconname = tgl("sort") . $uid . $cat . $ran . ".jpg";
			$thumb    = $path2 . $iconname;
			$imagick    = cover($path . $pdfname, $thumb);
			// $imagick  = sys('conv').' -colorspace sRGB -density  40 '.$path.$pdfname.'[0] -set units PixelsPerInch -alpha remove  -quality 50 '.$thumb;
			#sample convert -colorspace sRGB -density  40 210723144518147561.pdf[0] -set units PixelsPerInch -alpha remove  -quality 50 filejpg.jpg
			#die($imagick);
			// shell_exec($imagick);
			if (file_exists($thumb)) {
				$icon = $iconname;
			}
			$status   = $this->Mod_magazine->new_dtl_magz($cat, $hdr, $jdl, $des, $tgl . "/" . $pdfname, $numpdf, $tgl . "/" . $icon);
			echo json_encode(array($status));
		}
	}
	public function record($value = '', $value1 = '')
	{
		if ($this->input->post("media") && !empty($value1)) {
			$ip    = $this->input->ip_address();
			$media = $this->input->post("media");
			$url   = $this->input->post("url");
			$magz  = $value1;
			$page  = explode("/", $url);
			$lastp = str_replace("index.html#", "", end($page));
			$sql   = "call view_record($magz,'$ip','$lastp',null,'$media')";
			$data["result"] = $this->db->query($sql);
			echo json_encode($data);
		}
	}
	public function conv($value = '', $value1 = '')
	{

		$filepdf	= "./pdf_temp/jed.pdf";

		$num_pages = shell_exec('identify -format %n ' . $filepdf);
		for ($x = 0; $x <= $num_pages - 1; $x++) {
			$xx = $x + 1;
			$move  = $saveAsPath . "page/" . $xx . '.jpg';
			$thumb = $saveAsPath . "thumb/" . $xx . '.jpg';
			shell_exec('convert -density 200x200 -geometry 1841, 2481 -trim ' . $filepdf . '[' . $x . '] -quality 65 ' . $move);
			shell_exec('convert -density 200x200 -geometry 356, 480 -trim ' . $filepdf . '[' . $x . '] -quality 65 ' . $thumb);
		}
	}
}
