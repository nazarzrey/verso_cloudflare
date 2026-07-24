<?php
date_default_timezone_set('Asia/Jakarta');
#ajaxrequest adalah yang systemnya get
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxrequest extends CI_Controller {
	function __construct() {
		parent::__construct();
    	$this->load->library('session');
    	$this->load->model(array('Mod_request','User_activity','Mod_magazine','Mod_magick','Analitics'));
	}
	#index
	public function index(){
		echo  json_encode(array("result"=>"this ajax request"));
	}

	public function pageturner($value='')
	{
		$Url = $this->Mod_magazine->UrlDyn($value);
		redirect($Url);
	}

	public function issue_data($value='',$value1='')
	{
		if(!empty($value)){
			#show detail data magazine when showup modal
			$sintak["result"] = $this->Mod_magazine->DtlMagz($value,"issue_id");
			echo json_encode($sintak);
		}
	}
	public function issue_openview($value='',$value1='')
	{
		if(!empty($value)){
			#show detail data magazine when showup modal
			$ov_header = $this->Mod_magazine->HdrOV($value);
			#$detail["detail"] = $this->Mod_magazine->DtlOV($value,"issue_id");
			#echo json_encode(array($header,$detail));
			$ov_id     = $value;
            return require(APPPATH.'views/backend/openview/openview_edit.php');
		}
	}
	public function api_magz(){
		$data = $this->Mod_magazine->userownmagazine_app("");
		if(count($data)>0){
			foreach ($data as $key => $value) {
				$bigname = strtoupper($value->magz_name);
				$lowname = strtolower($value->magz_name);
				$url     = $value->magz_url;
				$imgdata = explode(",",$value->gallery);
	#			h3($imgdata[0].$imgdata[1].$value->gallery);
				$img     = $this->Mod_magazine->magazine_gallery($imgdata[0],$imgdata[1]);
				#die($img);
				$d_issue = $value->ttl_issue;
				if($d_issue!=0){
					$arr[] = array("title"=>Uw($bigname),"path"=>"","description"=>$value->magz_desc,"href"=>$url,"image"=>magz_img($img),"total"=>$d_issue);
				}
			}
			echo json_encode($arr);
		}
		/*$sintak = "select lower(title) as title,path,description,href,image from api_magazine";
		if(count($this->Mod_request->api_each_query($sintak))<=1){			
			$data[] = $this->Mod_request->api_each_query($sintak);
		}else{
			$data = $this->Mod_request->api_each_query($sintak);
		}
		echo json_encode($data);*/
	}
	/* 

	public function api_magz_dtl($issue){
		$data = $this->Mod_magazine->adm_issueMagazine($issue);
		#var_dump($data);
		if($data){
			if(count($data)>0){
				foreach ($data as $key => $d) {
					if($d->pdf_pub=="1"){
						$arr[] = array("title"=>Uw($d->issue_title),"description"=>$d->issue_desc,"href"=>$d->dyn,"image"=>magz_img($d->gambar));
						#$arr[] = array("title"=>Uw($d->issue_title),"description"=>$d->issue_desc,"href"=>$d->issue_path,"image"=>magz_img($d->gambar));
					}else{
						$arr = array("");
					}
				}
			}else{
				$arr = array("");
			}
		}else{
			$arr = array("");
		}
		echo json_encode($arr);
	}
	 */
	public function api_magz_dtl($issue = '0', $last_magazine = 0){
		$data = $this->Mod_magazine->adm_issueMagazine_app($issue);
		#var_dump($data);
		if($data){
			if(count($data)>0){
				foreach ($data as $key => $d) {
					$arr[] = array("header"=>Uw($d->magz_id),"id"=>Uw($d->magz_dtl_id),"title"=>Uw($d->issue_title),"description"=>$d->issue_desc,"href"=>$d->issue_path,"image"=>magz_img($d->gambar),"page"=>Uw($d->page),"issue_id"=>$d->issue_id);
					if ($key == 0 && $last_magazine == 1) break;
				}
			}else{
				$arr = array("");
			}
		}else{
			$arr = array("");
		}
		echo json_encode($arr);
	}

	public function api_magz_cat($cat = '0'){
		$data = $this->Mod_magazine->adm_issueMagazine_cat($cat);
		#var_dump($data);
		if($data){
			if(count($data)>0){
				foreach ($data as $key => $d) {
					$arr[] = array("title"=>Uw($d->issue_title),"description"=>$d->issue_desc,"href"=>$d->issue_path,"image"=>magz_img($d->gambar));					
				}
			}else{
				$arr = array();
			}
		}else{
			$arr = array();
		}
		echo json_encode($arr);
	}
	
	public function magz_not_used($val = ''){
		if(!empty($val)){
			  $total_size = 0;
			  $path  = sys("path")."pageturner/";

			  $files = scandir($path);

			  foreach($files as $t) {
			    if (is_dir(rtrim($path, '/') . '/' . $t)) {
			      if ($t<>"." && $t<>"..") {
			      	  #echo $t;
			      	  $path2   = $path.$t."/";
			      	  $subfile = scandir($path2);
			      	  foreach ($subfile as $z) {			      	  	
			    	   if (is_dir($path2.$z)) {
		      			if ($z<>"." && $z<>"..") {
								$data = $this->Mod_magazine->notMagzUsed($z);
								if($data){
			      					echo $z." - ok";
			      				}else{
			      					echo sys("rmdir").$path2.$z;
			      				}
		      					echo "<br/>";
			      			}
				      	  }
				      	}
				      }
				  }
			}
		}
	}
	
	public function api_about(){
		$sintak = "select * from about";
		$data = $this->Mod_request->api_each_query($sintak);
		echo json_encode($data);
	}
	public function api_popular(){
		$sintak = "select lower(title) as title,path,description,href,image from api_magazine LIMIT 3";	
		if(count($this->Mod_request->api_each_query($sintak))<=1){			
			$data["data"][] = $this->Mod_request->api_each_query($sintak);
		}else{
			$data["data"] = $this->Mod_request->api_each_query($sintak);
		}			
		echo json_encode($data);
	}
	public function api_sample(){
		$data = $this->Mod_magazine->adm_issueMagazine_sample();
		if(count($data)<=1)	$arr["data"][] = $data;			
		else $arr["data"] = $data;
		echo json_encode($arr);
	}
	public function api_sample2(){
		$data = $this->Mod_magazine->adm_issueMagazine_sample();
		if(count($data)<=1)	$arr[] = $data;			
		else $arr = $data;
		echo json_encode($arr);
	}
	public function api_featured($tab = 0){
		if ($tab == 0) $data = $this->Mod_magazine->adm_issueMagazine_featured();
		if ($tab == 1) $data = $this->Mod_magazine->adm_issueMagazine_arrival();
		if ($tab == 2) $data = $this->Mod_magazine->adm_issueMagazine_popular();
		if(count($data)<=1)	$arr["data"][] = $data;			
		else $arr["data"] = $data;
		echo json_encode($arr);
	}
	public function api_last_magazine(){
		$sintak = "select UPPER(title) as title,description,href from api_magazine LIMIT 1";
		$data = $this->Mod_request->api_each_query($sintak);
		echo json_encode($data);
	}
	public function api_ads(){
		$sintak = "select * from api_ads";
		$data   = $this->Mod_request->api_each_query($sintak);
		echo json_encode($data);
	}
	public function title($jdl='',$kat='')	#26-06-19 "cek title first be4 upload
	{
		$data["result"] = $this->Mod_magazine->title_cat($jdl,$kat);
		echo json_encode($data);
	}
	public function other($value='')
	{
		require_once(APPPATH."controllers/Create_file.php");
		$crt = new Create_file();
		echo $ss= $crt->create_index;
		# code...
	}
	public function convert_pdf($value='',$value1='')
	{
/*
		if(!$value){
			die("{}");
		}
		if(!$this->Mod_magazine->magz_name($value)){			
			die("{}");
		}
		ini_set('display_errors', true);
		ini_set('max_execution_time', 0);
		ini_set('upload_max_filesize', '100M');
		ini_set('post_max_size', '100M');
		ini_set('client_max_body_size', '100M');
	    $file 	  	= 'book.zip';    
	    $imagename  = $this->Mod_magazine->magz_name($value);
	    $pdfname  	= $this->Mod_magazine->magz_pdf($value);
		$directory 	= sys("path");
	    $foldername = "pageturner/".str_replace(" ","",$imagename);
		
	    $path       = $directory.$foldername."/";
	    $path2      = $directory."magazine/cover/";
	    $saveAsPath = $directory.$foldername."/files/";
	    $filepdf 	= $directory."pdf_temp/".$pdfname;
		$title      = ucwords(strtolower($imagename))." Magazine";
		$iconfile  	= "ico_".strtolower(str_replace(" ","-",$imagename)).tgl("sort").".jpg";
		if(empty($pdfname) || !file_exists($filepdf)){
			die("temporary pdf is nolonger exists, please reupload");
		}else{
			$zip = new ZipArchive;			
			$res = $zip->open($file);
			if ($res === TRUE) {
				$zip->extractTo($path);
				$zip->close();
			}
			if(!empty($value1)){
				if(is_numeric($value1)){
					$num_pages = $value1;
				}else{
					$num_pages = 1;
				}
			}else{
				$num_pages = numPdf($filepdf);
			}
			for ($x = 0; $x <= $num_pages - 1; $x++) {
				$xx = $x + 1;
				$move  = $saveAsPath . "page/" . $xx.'.jpg';
				$thumb = $saveAsPath . "thumb/" . $xx.'.jpg';
				shell_exec(sys('conv').' -colorspace sRGB -density 290 '.$filepdf.'['.$x.'] -set units PixelsPerInch -alpha remove  -quality 40 '.$move);
				shell_exec(sys('conv').' -colorspace sRGB -density  50 '.$filepdf.'['.$x.'] -set units PixelsPerInch -alpha remove  -quality 50 '.$thumb);
			} 
			#convert rose1.png -set units PixelsPerInch -density 300 rose2c.jpg
			// $thumb = $path."/files/thumb/1.jpg";
			// $icon  = $path2.$iconfile;
			// if(file_exists($thumb)){
				// copy($thumb,$icon);
			// }
			// $num_pages = "3";
			require_once(APPPATH."controllers/Create_file.php");
			$ga  = $this->Mod_magazine->analytics($value);
			create_index($path,$value,$ga);
			create_config($path,$num_pages);
			#$pdfname  	= $this->Mod_magazine->magz_update($value,$iconfile);
			echo "ok";
		}*/
	}	
	public function publish_issue($value)
	{
		if($this->session->userdata('uid')){
			$DtlMgz = $this->Mod_magazine->DtlMagz($value,"issue_id");
			$target = $DtlMgz->ipath;
			$iss_id = $DtlMgz->dtl_id;
			$DynUrl = $this->Mod_magazine->DynUrl($iss_id,$target);

			require_once(APPPATH."controllers/Create_file.php");
			$ga  	= $this->Mod_magazine->analytics($value);			
			$path 	= "./pageturner/".$DtlMgz->ipath;
			create_index($path,$DtlMgz->dtl_id,$ga);
			create_config($path,$DtlMgz->ipage);
			$this->Mod_magazine->ProConv($value,array("issue_publish"=>"1"));
			echo json_encode(array("ok",$DynUrl));
		}
	}

	public function convert_progress($path='',$num='')
	{
		#$DtlMgz  = $this->Mod_magazine->DtlMagz($value,"issue_id");
		if(strlen($path)>10){
			$path = str_replace("_","/",$path);
			$dir  = "./pageturner/".$path."/files/page/";
			if(!is_dir($dir)){			
				echo "x directory not found, please try to convert";
			}else{
              	echo $this->Mod_magick->count_img($path,$num,$dir);
			}
		}else{
			echo "x error resutl ajax, please re convert";
		}
	}

	public function convert_issue($value='',$value1=''){		
		if(!$value){
			die("{}");
		}
		$DtlMgz = $this->Mod_magazine->DtlMagz($value,"issue_id");
		#var_dump($DtlMgz);
		if(!$DtlMgz){
			die("{}");
		}else{
			$this->Mod_magick->convert_iss($DtlMgz,$value,"convert","");
		}
	}

	public function setting($value='',$value1=''){
		if($value=="view-issue"){
   			$uid = $this->session->userdata('uid');
   			if($value1=="i-small"){
   				$v = "1";
   			}else{
   				$v = "2";
   			}
   			$syx = "call setting('$uid','$v','issue_view')";
   			$this->db->query($syx);
		}
	}
	public function issue_cover($value='')
	{
		$data["result"] = $this->Mod_magazine->issue_cover($value);
		echo json_encode($data);
	}

	function buka($error){
		print "<pre>";
		print_r($error);
		print "</pre>";
	}

	public function addlibrary(){
		if($this->input->post('Magazine')){
			$magazine	= $this->input->post('Magazine');
			$user	= $this->input->post('User');			
			$data = $this->Mod_magazine->addtoLibrary($user, $magazine);
			// $this->buka($data);
		}
	}

	public function addsuscribe(){
		if($this->input->post('Magazine')){
			$magazine	= $this->input->post('Magazine');
			$user	= $this->input->post('User');			
			$data = $this->Mod_magazine->addtoSuscribe($user, $magazine);
			// $this->buka($data);
		}
	}

	public function getlibrary(){
		if($this->input->post('email')){						
			echo $data = $this->Mod_magazine->getlibrary($this->input->post('email'));	      	
		}else{
			$data = [];
			echo json_encode($data);			
		}
	}

	public function getsuscribe(){
		if($this->input->post('email')){						
			echo $data = $this->Mod_magazine->getsuscribe($this->input->post('email'));	      	
		}else{
			$data = [];
			echo json_encode($data);				
		}	
		// $this->buka($query);
	}

	public function getsearch(){
		if($this->input->get('search')){						
			echo $data = $this->Mod_magazine->getsearch($this->input->get('search'));	      	
		}else{
			$data = [];
			echo json_encode($data);			
		}	
	}

	public function setview(){
		if($this->input->post('email')){						
			echo $data = $this->Mod_magazine->setview($this->input->post('email'));	      	
		}else{
			$data = [];
			echo json_encode($data);			
		}
	}

	public function api_magzin($cat){
		$str = "";
		if ($cat == 'a0a0a0a0a0a0a0a0a0a0a0a0') {
			for ($x = 1; $x <= 12; $x++) {
			    $str = $str . $x . ",";
			}
			$cat = substr($str, 0, -1);
		}

		$exp = explode('a', $cat);
		$str = "";
		foreach ($exp as $key => $value) {
			if ($value != "" && $value != "0")
				$str = $str . $value . ",";
		}
		
		$cat = substr($str, 0, -1);		


		$data = $this->Mod_magazine->userownmagazine_in($cat);
		if(count($data)>0){
			foreach ($data as $key => $value) {
				$bigname = strtoupper($value->magz_name);
				$lowname = strtolower($value->magz_name);
				$url     = $value->magz_url;
				$imgdata = explode(",",$value->gallery);
				$img     = $this->Mod_magazine->magazine_gallery($imgdata[0],$imgdata[1]);
				$d_issue = $value->ttl_issue;
				if($d_issue!=0){
					$arr[] = array("title"=>Uw($bigname),"path"=>"","description"=>$value->magz_desc,"href"=>$url,"image"=>magz_img($img),"total"=>$d_issue);
				}
			}
			echo json_encode($arr);
		}
	}

	public function api_magz_detil($issue = '0'){
		$data = $this->Mod_magazine->issueMagazinedetil($issue);
		$dataOpenView = $this->Mod_magazine->openView();		
		// $ada = 0;
		// echo "<pre>";
		// print_r($dataOpenView);
		// echo "</pre>";
		// var_dump($dataOpenView);
		if($data){
			if(count($data)>0){
				foreach ($data as $key => $d) {
					$a = array();
					$b = array();
					for ($x = 1; $x <= $d->issue_pdf_page; $x++) {	
						$ada = 0;	
						$content = '';				
						foreach ($dataOpenView as $f => $g) {
							if ($ada == 0){
								$ada = $g->magz_page == $x ? 1 : 0;
								$content = $ada == 1 ? $g->content : '';	
							}							
						}
						$md_array["id"] = $x;
						$md_array["openview"] = $content;
						$md_array["img"] = "https://panel.versoview.com/pageturner/".$d->issue_path."/files/medium/".$x.".jpg";
				    	array_push($a, $md_array);
					}

					for ($x = 1; $x <= $d->issue_pdf_page; $x++) {
						$ada = 0;	
						$content = '';				
						foreach ($dataOpenView as $f => $g) {
							if ($ada == 0){
								$ada = $g->magz_page == $x ? 1 : 0;
								$content = $ada == 1 ? $g->content : '';	
							}							
						}
						$md_array["id"] = $x;
						$md_array["openview"] = $content;
						$md_array["img"] = "https://panel.versoview.com/pageturner/".$d->issue_path."/files/thumb/".$x.".jpg";
				    	array_push($b, $md_array);
					}

					$arr[] = array(
						"title"=>Uw($d->issue_title),
						"description"=>$d->issue_desc,
						"page"=>Uw($d->issue_pdf_page),
						"data"=>$a,
						"thumb"=>$b
					);					
				}
			}else{
				$arr = array("");
			}
		}else{
			$arr = array("");
		}
		echo json_encode($arr);
	}

	public function baca(){
		$data = $this->Mod_magazine->baca();
		if($data){
			if(count($data)>0){
				$str = "";
				$tinggi = 0;
				foreach ($data as $key => $d) {
					if ($tinggi != $d->tinggi) {
			        	if (abs($tinggi - $d->tinggi) == 1){
			        		$str .= $d->isi;
			        	}
		        		else{
		        			$tinggi = $d->tinggi;
		        			$arr[] = array(
								"hal"=>$d->hal,
								"atas"=>$d->atas,
								"kiri"=>$d->kiri,
								"besar"=>$d->tinggi,
								"isi"=>$str,
								"typetext"=>$d->typetext,
							);
							$str = "";
		        		}
			        }else{
		        		$str .= $d->isi;
			        }
											
				}
			}else{
				$arr = array("");
			}
		}else{
			$arr = array("");
		}
		echo json_encode($arr);
	}

	public function api_magz_anantara(){
		$data = $this->Mod_magazine->adm_issueMagazine_anantara();
		#var_dump($data);
		if($data){
			if(count($data)>0){
				foreach ($data as $key => $d) {
					$arr[] = array("header"=>Uw($d->magz_id),"id"=>Uw($d->magz_dtl_id),"title"=>Uw($d->issue_title),"description"=>$d->issue_desc,"href"=>$d->issue_path,"image"=>magz_img($d->gambar),"page"=>Uw($d->page),"issue_id"=>$d->issue_id,"issue"=>$d->issue);
				}
			}else{
				$arr = array("");
			}
		}else{
			$arr = array("");
		}
		echo json_encode($arr);
	}	

	public function api_magz_detl($id){
		$data = $this->Mod_magazine->api_magz_detl($id);

		if($data){
			if(count($data)>0){
				foreach ($data as $key => $d) {
					$arr[] = array(
						"id"=>Uw($d->issue_id),
						"title"=>Uw($d->issue_title),
						"description"=>$d->issue_desc,
						"page"=>$d->page,
						"content"=>$d->content,
						"title"=>$d->title,
						"body_text"=>$d->body_text,
						"caption"=>$d->caption,
						"detail"=>$d->detail,
						"written"=>$d->written,
						"issue_id"=>$d->issue_id,
						"m"=>$d->m,
						"l"=>$d->l,
						"t"=>$d->t,
					);
				}
			}else{
				$arr = array("");
			}
		}else{
			$arr = array("");
		}
		echo json_encode($arr);
	}	
//api.versoview
	public function getip($ip = NULL, $purpose = "location", $deep_detect = TRUE)
	{
		$output = NULL;
	    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
	        $ip = $_SERVER["REMOTE_ADDR"];
	        if ($deep_detect) {
	            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
	                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
	                $ip = $_SERVER['HTTP_CLIENT_IP'];
	        }
	    }
	    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), "", strtolower(trim($purpose)));
	    $support    = array("country", "countrycode", "regional", "region", "city", "location", "address");
		$cek_ip = $this->db->get_where("ip", array("ip" => $ip));
			$has_ip = single_query($cek_ip);	
		if($has_ip){
			$output = array(
				"city"           => $has_ip->city,
				"regional"          => $has_ip->regional,
				"country"        => $has_ip->country,
				"continent"        => $has_ip->continent
			);
			$server = "local";
		}else{
			if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
				$token = "a121fa2ab33e93";
				$url   = "https://ipinfo.io/{$ip}?token={$token}";
				$url2  = "https://api.ipinfo.io/lite/{$ip}?token={$token}";
				$ipdat = @json_decode(file_get_contents($url));
				if (!empty($ipdat->country) && strlen($ipdat->country) == 2) {

					switch ($purpose) {

						case "location":
							$output = $nzr = array(
								"city"       => @$ipdat->city,
								"regional"   => @$ipdat->region,
								"country"    => $this->countryCodeToName(@$ipdat->country),
								"continent"  => $this->countryToContinent(@$ipdat->country),								
								"isp" => @$ipdat->org
							);
							break;

						case "address":
							$address = array();

							if (!empty($ipdat->country))
								$address[] = $ipdat->country;

							if (!empty($ipdat->region))
								$address[] = $ipdat->region;

							if (!empty($ipdat->city))
								$address[] = $ipdat->city;

							$output = $nzr = implode(", ", array_reverse($address));
							break;

						case "city":
							$output = $nzr = @$ipdat->city;
							break;

						case "regional":
						case "region":
							$output = $nzr = @$ipdat->region;
							break;

						case "country":
							$output = $nzr = @$ipdat->country;
							break;

						case "countrycode":
							$output = $nzr = @$ipdat->country;
							break;
							
						case "isp":
							$output = $nzr = @$ipdat->org;
							break;
					}
				}
			}

			$server = "ipinfo";
			if (isset($nzr)) {
				$zre = array_merge(array("ip" => $ip), $nzr);
			} else {
				$zre = array("ip" => $ip);
			}
			$cekip  = $this->Analitics->cekip($zre);	
			if (isset($output['isp'])) {
				unset($output['isp']);
			}
		}
	    return $output;
	}

	public function country($uid=null)
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
		header('Content-Type: application/json');

		$ip = $this->getClientIP();

		$exists = $this->db->where([
			'ip' => $ip,
			'uid' => $uid
		])->where('updrec_date >=', date('Y-m-d H:i:s', strtotime('-1 day')))
		  ->get('ip_filter')->row();

		if (!$exists) {
			$this->db->insert('ip_filter', ['ip'   => $ip,'uid'  => $uid]);
		}

		$res = new stdClass();
		$res->ip = $ip;
		$location = $this->getip($ip, 'location');

		if (is_array($location)) {
			$res->country = isset($location['country']) && $location['country'] ? $location['country'] : 'unknown';
			$res->regional = isset($location['regional']) ? $location['regional'] : null;
			$res->city = isset($location['city']) ? $location['city'] : null;
			$res->continent = isset($location['continent']) ? $location['continent'] : null;
		} else {
			$res->country = $location ? $location : 'unknown';
		}

		echo json_encode($res, JSON_UNESCAPED_UNICODE);
		exit;
	}
	private function getClientIP()
	{
		// Cloudflare
		if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']) &&
			filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		}

		// Proxy / Load balancer
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ($ips as $ip) {
				$ip = trim($ip);
				if (filter_var($ip, FILTER_VALIDATE_IP)) {
					return $ip;
				}
			}
		}

		// Client IP langsung
		if (!empty($_SERVER['HTTP_CLIENT_IP']) &&
			filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}

		return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
	}
	
	//debuger
	public function country_debug($uid=null)
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
		header('Content-Type: application/json');

		$ip = $this->getClient_debug();
		$exists = $this->db->where([
			'ip' => $ip,
			'uid' => $uid
		])->where('updrec_date >=', date('Y-m-d H:i:s', strtotime('-1 day')))
		  ->get('ip_filter')->row();

		if (!$exists) {
			$this->db->insert('ip_filter', ['ip'   => $ip,'uid'  => $uid]);
		}


		$res = new stdClass();
		$res->ip = $ip;
		$res->country = $this->getip_debug($ip, 'location');

		echo json_encode($res, JSON_UNESCAPED_UNICODE);
		exit;
	}
	private function getClient_debug()
	{
		// Cloudflare
		if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']) &&
			filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		}

		// Proxy / Load balancer
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ($ips as $ip) {
				$ip = trim($ip);
				if (filter_var($ip, FILTER_VALIDATE_IP)) {
					return $ip;
				}
			}
		}

		// Client IP langsung
		if (!empty($_SERVER['HTTP_CLIENT_IP']) &&
			filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}

		return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
	}
	
	public function getip_debug($ip = NULL, $purpose = "location", $deep_detect = TRUE)
	{
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support    = array("country", "countrycode", "regional", "region", "city", "location", "address");
		$cek_ip = $this->db->get_where("ip", array("ip" => $ip));
			$has_ip = single_query($cek_ip);	
		if($has_ip){
			$output = array(
				"city"           => $has_ip->city,
				"regional"          => $has_ip->regional,
				"country"        => $has_ip->country,
				"continent"        => $has_ip->continent
			);
			$server = "local";
		}else{			
			if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
				$token = "a121fa2ab33e93";
				$url   = "https://ipinfo.io/{$ip}?token={$token}";
				$ipdat = @json_decode(file_get_contents($url));
				if (!empty($ipdat->country) && strlen($ipdat->country) == 2) {

					switch ($purpose) {

						case "location":
							$output = $nzr = array(
								"city"       => @$ipdat->city,
								"regional"   => @$ipdat->region,
								"country"    => $this->countryCodeToName(@$ipdat->country),
								"continent"  => $this->countryToContinent(@$ipdat->country),
								"isp" => @$ipdat->org,
							);
							break;

						case "address":
							$address = array();

							if (!empty($ipdat->country))
								$address[] = $ipdat->country;

							if (!empty($ipdat->region))
								$address[] = $ipdat->region;

							if (!empty($ipdat->city))
								$address[] = $ipdat->city;

							$output = $nzr = implode(", ", array_reverse($address));
							break;

						case "city":
							$output = $nzr = @$ipdat->city;
							break;

						case "regional":
						case "region":
							$output = $nzr = @$ipdat->region;
							break;

						case "country":
							$output = $nzr = @$ipdat->country;
							break;

						case "countrycode":
							$output = $nzr = @$ipdat->country;
							break;
					}
				}
			}

			$server = "ipinfo";

			if (isset($nzr)) {
				$zre = array_merge(array("ip" => $ip), $nzr);
			} else {
				$zre = array("ip" => $ip);
			}
			//dbg($zre);
			$cekip  = $this->Analitics->cekip($zre);	
			if (isset($output['isp'])) {
				unset($output['isp']);
			}
		}
		return $output;
	}

	private function countryToContinent($code)
	{
		$map = array(
			// ===== ASIA =====
			"AF"=>"Asia","AM"=>"Asia","AZ"=>"Asia","BH"=>"Asia","BD"=>"Asia","BT"=>"Asia",
			"BN"=>"Asia","KH"=>"Asia","CN"=>"Asia","CY"=>"Asia","GE"=>"Asia","HK"=>"Asia",
			"IN"=>"Asia","ID"=>"Asia","IR"=>"Asia","IQ"=>"Asia","IL"=>"Asia","JP"=>"Asia",
			"JO"=>"Asia","KZ"=>"Asia","KW"=>"Asia","KG"=>"Asia","LA"=>"Asia","LB"=>"Asia",
			"MO"=>"Asia","MY"=>"Asia","MV"=>"Asia","MN"=>"Asia","MM"=>"Asia","NP"=>"Asia",
			"KP"=>"Asia","OM"=>"Asia","PK"=>"Asia","PS"=>"Asia","PH"=>"Asia","QA"=>"Asia",
			"SA"=>"Asia","SG"=>"Asia","KR"=>"Asia","LK"=>"Asia","SY"=>"Asia","TW"=>"Asia",
			"TJ"=>"Asia","TH"=>"Asia","TL"=>"Asia","TR"=>"Asia","TM"=>"Asia","AE"=>"Asia",
			"UZ"=>"Asia","VN"=>"Asia","YE"=>"Asia",

			// ===== EUROPE =====
			"AL"=>"Europe","AD"=>"Europe","AT"=>"Europe","BY"=>"Europe","BE"=>"Europe",
			"BA"=>"Europe","BG"=>"Europe","HR"=>"Europe","CZ"=>"Europe","DK"=>"Europe",
			"EE"=>"Europe","FI"=>"Europe","FR"=>"Europe","DE"=>"Europe","GR"=>"Europe",
			"HU"=>"Europe","IS"=>"Europe","IE"=>"Europe","IT"=>"Europe","LV"=>"Europe",
			"LI"=>"Europe","LT"=>"Europe","LU"=>"Europe","MT"=>"Europe","MD"=>"Europe",
			"MC"=>"Europe","ME"=>"Europe","NL"=>"Europe","MK"=>"Europe","NO"=>"Europe",
			"PL"=>"Europe","PT"=>"Europe","RO"=>"Europe","RU"=>"Europe","SM"=>"Europe",
			"RS"=>"Europe","SK"=>"Europe","SI"=>"Europe","ES"=>"Europe","SE"=>"Europe",
			"CH"=>"Europe","UA"=>"Europe","GB"=>"Europe","VA"=>"Europe",

			// ===== AFRICA =====
			"DZ"=>"Africa","AO"=>"Africa","BJ"=>"Africa","BW"=>"Africa","BF"=>"Africa",
			"BI"=>"Africa","CV"=>"Africa","CM"=>"Africa","CF"=>"Africa","TD"=>"Africa",
			"KM"=>"Africa","CG"=>"Africa","CD"=>"Africa","CI"=>"Africa","DJ"=>"Africa",
			"EG"=>"Africa","GQ"=>"Africa","ER"=>"Africa","SZ"=>"Africa","ET"=>"Africa",
			"GA"=>"Africa","GM"=>"Africa","GH"=>"Africa","GN"=>"Africa","GW"=>"Africa",
			"KE"=>"Africa","LS"=>"Africa","LR"=>"Africa","LY"=>"Africa","MG"=>"Africa",
			"MW"=>"Africa","ML"=>"Africa","MR"=>"Africa","MU"=>"Africa","MA"=>"Africa",
			"MZ"=>"Africa","NA"=>"Africa","NE"=>"Africa","NG"=>"Africa","RW"=>"Africa",
			"ST"=>"Africa","SN"=>"Africa","SC"=>"Africa","SL"=>"Africa","SO"=>"Africa",
			"ZA"=>"Africa","SS"=>"Africa","SD"=>"Africa","TZ"=>"Africa","TG"=>"Africa",
			"TN"=>"Africa","UG"=>"Africa","ZM"=>"Africa","ZW"=>"Africa",

			// ===== NORTH AMERICA =====
			"AG"=>"North America","BS"=>"North America","BB"=>"North America","BZ"=>"North America",
			"CA"=>"North America","CR"=>"North America","CU"=>"North America","DM"=>"North America",
			"DO"=>"North America","SV"=>"North America","GD"=>"North America","GT"=>"North America",
			"HT"=>"North America","HN"=>"North America","JM"=>"North America","MX"=>"North America",
			"NI"=>"North America","PA"=>"North America","KN"=>"North America","LC"=>"North America",
			"VC"=>"North America","TT"=>"North America","US"=>"North America",

			// ===== SOUTH AMERICA =====
			"AR"=>"South America","BO"=>"South America","BR"=>"South America","CL"=>"South America",
			"CO"=>"South America","EC"=>"South America","GY"=>"South America","PY"=>"South America",
			"PE"=>"South America","SR"=>"South America","UY"=>"South America","VE"=>"South America",

			// ===== OCEANIA =====
			"AU"=>"Oceania","FJ"=>"Oceania","KI"=>"Oceania","MH"=>"Oceania","FM"=>"Oceania",
			"NR"=>"Oceania","NZ"=>"Oceania","PW"=>"Oceania","PG"=>"Oceania","WS"=>"Oceania",
			"SB"=>"Oceania","TO"=>"Oceania","TV"=>"Oceania","VU"=>"Oceania",

			// ===== ANTARCTICA / OTHER =====
			"AQ"=>"Antarctica"
		);

		return $map[strtoupper($code)] ?? "Unknown";
	}	
	private function countryCodeToName($code)
	{
		$map = array(
			"AF"=>"Afghanistan","AX"=>"Åland Islands","AL"=>"Albania","DZ"=>"Algeria",
			"AS"=>"American Samoa","AD"=>"Andorra","AO"=>"Angola","AI"=>"Anguilla",
			"AQ"=>"Antarctica","AG"=>"Antigua and Barbuda","AR"=>"Argentina","AM"=>"Armenia",
			"AW"=>"Aruba","AU"=>"Australia","AT"=>"Austria","AZ"=>"Azerbaijan",
			"BS"=>"Bahamas","BH"=>"Bahrain","BD"=>"Bangladesh","BB"=>"Barbados",
			"BY"=>"Belarus","BE"=>"Belgium","BZ"=>"Belize","BJ"=>"Benin",
			"BM"=>"Bermuda","BT"=>"Bhutan","BO"=>"Bolivia","BA"=>"Bosnia and Herzegovina",
			"BW"=>"Botswana","BR"=>"Brazil","BN"=>"Brunei","BG"=>"Bulgaria",
			"BF"=>"Burkina Faso","BI"=>"Burundi","KH"=>"Cambodia","CM"=>"Cameroon",
			"CA"=>"Canada","CV"=>"Cape Verde","CF"=>"Central African Republic",
			"TD"=>"Chad","CL"=>"Chile","CN"=>"China","CO"=>"Colombia",
			"KM"=>"Comoros","CG"=>"Congo","CD"=>"Congo (DRC)","CR"=>"Costa Rica",
			"CI"=>"Côte d’Ivoire","HR"=>"Croatia","CU"=>"Cuba","CY"=>"Cyprus",
			"CZ"=>"Czech Republic","DK"=>"Denmark","DJ"=>"Djibouti","DM"=>"Dominica",
			"DO"=>"Dominican Republic","EC"=>"Ecuador","EG"=>"Egypt","SV"=>"El Salvador",
			"GQ"=>"Equatorial Guinea","ER"=>"Eritrea","EE"=>"Estonia","ET"=>"Ethiopia",
			"FJ"=>"Fiji","FI"=>"Finland","FR"=>"France","GA"=>"Gabon",
			"GM"=>"Gambia","GE"=>"Georgia","DE"=>"Germany","GH"=>"Ghana",
			"GR"=>"Greece","GL"=>"Greenland","GD"=>"Grenada","GT"=>"Guatemala",
			"GN"=>"Guinea","GW"=>"Guinea-Bissau","GY"=>"Guyana","HT"=>"Haiti",
			"HN"=>"Honduras","HK"=>"Hong Kong","HU"=>"Hungary","IS"=>"Iceland",
			"IN"=>"India","ID"=>"Indonesia","IR"=>"Iran","IQ"=>"Iraq",
			"IE"=>"Ireland","IL"=>"Israel","IT"=>"Italy","JM"=>"Jamaica",
			"JP"=>"Japan","JO"=>"Jordan","KZ"=>"Kazakhstan","KE"=>"Kenya",
			"KI"=>"Kiribati","KW"=>"Kuwait","KG"=>"Kyrgyzstan","LA"=>"Laos",
			"LV"=>"Latvia","LB"=>"Lebanon","LS"=>"Lesotho","LR"=>"Liberia",
			"LY"=>"Libya","LI"=>"Liechtenstein","LT"=>"Lithuania","LU"=>"Luxembourg",
			"MO"=>"Macau","MG"=>"Madagascar","MW"=>"Malawi","MY"=>"Malaysia",
			"MV"=>"Maldives","ML"=>"Mali","MT"=>"Malta","MH"=>"Marshall Islands",
			"MR"=>"Mauritania","MU"=>"Mauritius","MX"=>"Mexico","FM"=>"Micronesia",
			"MD"=>"Moldova","MC"=>"Monaco","MN"=>"Mongolia","ME"=>"Montenegro",
			"MA"=>"Morocco","MZ"=>"Mozambique","MM"=>"Myanmar","NA"=>"Namibia",
			"NR"=>"Nauru","NP"=>"Nepal","NL"=>"Netherlands","NZ"=>"New Zealand",
			"NI"=>"Nicaragua","NE"=>"Niger","NG"=>"Nigeria","KP"=>"North Korea",
			"MK"=>"North Macedonia","NO"=>"Norway","OM"=>"Oman","PK"=>"Pakistan",
			"PW"=>"Palau","PA"=>"Panama","PG"=>"Papua New Guinea","PY"=>"Paraguay",
			"PE"=>"Peru","PH"=>"Philippines","PL"=>"Poland","PT"=>"Portugal",
			"QA"=>"Qatar","RO"=>"Romania","RU"=>"Russia","RW"=>"Rwanda",
			"SA"=>"Saudi Arabia","SN"=>"Senegal","RS"=>"Serbia","SC"=>"Seychelles",
			"SL"=>"Sierra Leone","SG"=>"Singapore","SK"=>"Slovakia","SI"=>"Slovenia",
			"SB"=>"Solomon Islands","SO"=>"Somalia","ZA"=>"South Africa","KR"=>"South Korea",
			"SS"=>"South Sudan","ES"=>"Spain","LK"=>"Sri Lanka","SD"=>"Sudan",
			"SR"=>"Suriname","SE"=>"Sweden","CH"=>"Switzerland","SY"=>"Syria",
			"TW"=>"Taiwan","TJ"=>"Tajikistan","TZ"=>"Tanzania","TH"=>"Thailand",
			"TL"=>"Timor-Leste","TG"=>"Togo","TO"=>"Tonga","TT"=>"Trinidad and Tobago",
			"TN"=>"Tunisia","TR"=>"Turkey","TM"=>"Turkmenistan","TV"=>"Tuvalu",
			"UG"=>"Uganda","UA"=>"Ukraine","AE"=>"United Arab Emirates","GB"=>"United Kingdom",
			"US"=>"United States","UY"=>"Uruguay","UZ"=>"Uzbekistan","VU"=>"Vanuatu",
			"VE"=>"Venezuela","VN"=>"Vietnam","YE"=>"Yemen","ZM"=>"Zambia","ZW"=>"Zimbabwe"
		);

		return $map[strtoupper($code)] ?? "Unknown";
	}

}
