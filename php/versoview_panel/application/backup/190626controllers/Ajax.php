<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	function __construct() {
		parent::__construct();
    	// $this->load->library('session');
    	//$this->load->model(array('Mod_request'));
	}
	#index
	public function index($value=""){
	}
	public function upload($value='')
	{
		$config['upload_path']          = './pdf_temp/';
		$config['allowed_types']        = 'gif|jpg|png|pdf';
		$config['max_size']             = 1024000;
 		$str = array(" ","&","'",'"',"/","\\","*","@","!","#","$","%","^","(",")");
		$uid = $this->input->post("uid");
		$cat = $this->input->post("pdf_category");
		$jdl = $this->input->post("pdf_title");
		$des = $this->input->post("pdf_desc");
		$magz = strtolower(str_replace($str,"",$jdl));
		$url  = $magz.tgl("sort");
		$uri  = "admin/magz/".$magz;
		$this->load->library('upload', $config); 
		if ( ! $this->upload->do_upload('new-pdf')){
			$error = array('error' => $this->upload->display_errors());
			echo json_encode(array($error));
			//$this->load->view('v_upload', $error);
		}else{
			$data   = array('upload_data' => $this->upload->data(),$url);
			$status = $this->Mod_request->magz_created($cat,$magz,$url,$jdl,$des,$uid,$data["upload_data"]["file_name"]);
			echo json_encode(array($status,$data["upload_data"]["file_name"],$data["upload_data"]["file_size"],$uri));
		}
	}
	public function convert($value)
	{		
		ini_set('display_errors', true);
		ini_set('max_execution_time', 0);
		ini_set('upload_max_filesize', '100M');
		ini_set('post_max_size', '100M');
		ini_set('client_max_body_size', '100M');
		error_reporting(E_ALL);
		/**/
		    //$file 	  	= 'book.zip';    
		    $imagename  = "dng";
		    $pdfname  	= "jeddah.pdf";
			$directory 	= "/var/www/html/";
		    $foldername = "pageturner/".str_replace(" ","",$imagename);
		    #    if (!is_dir($foldername)) { mkdir($foldername); }
			
		    $path       = $directory.$foldername."/";
		    $path2      = $directory."magazine/cover/";
		    $saveAsPath = $directory.$foldername."/files/";
		    $filepdf 	= $directory."/pdf_temp/".$pdfname;
			$title      = ucwords(strtolower($imagename))." Magazine";
			$iconfile  	= "ico_".strtolower(str_replace(" ","-",$imagename)).tgl("sort").".jpg";
			
		    /* $zip = new ZipArchive;			
		    $res = $zip->open($file);
		    if ($res === TRUE) {
		        $zip->extractTo($path);
		        $zip->close();		        
		        // echo "WOOT! $file extracted to $path";
		    } */
			echo tgl("full")."<br/>";
			$im = new imagick();
			$im->setResolution(200, 200);  
			if(!$im->readImage($filepdf)){
				echo "cekfile";
			}			
			echo tgl("full")."<br/>";
			$im->setImageFormat('jpeg');			
			$im->setImageAlphaChannel(imagick::ALPHACHANNEL_REMOVE);
			$im->mergeImageLayers(imagick::LAYERMETHOD_FLATTEN);
			$im->setImageBackgroundColor('white');
			$num_pages = $im->getNumberImages();
			//for ($i = 0; $i < $num_pages; $i++) {
			for ($i = 0; $i < 2; $i++) {
				$a = $i + 1;
				$temp  = $saveAsPath . "temp/" . $a.'.jpg';
				$move  = $saveAsPath . "page/" . $a.'.jpg';
				$thumb = $saveAsPath . "thumb/" . $a.'.jpg';
				$im->setIteratorIndex($i);			
				// $im->resizeImage( 1240, 1654, Imagick::FILTER_SINC, 0.1, false );  			
//				$im->resizeImage( 1240, 1654, Imagick::FILTER_SINC, 0.1, false );  					
				$im->setImageCompression(imagick::COMPRESSION_JPEG); 
				$im->setImageCompressionQuality(300);					
		        $im->writeImage($temp);	
				#echo $temp;				
				if(file_exists($temp)){
					#if(filesize($temp)<=1024000){
					#	copy($temp,$move);
					#	ak_img_resize($temp,$thumb, 270, 360, "jpg");
					#}else{						
						ak_img_resize_test($temp,$move, 1240, 1654, "jpg");
						ak_img_resize_test($temp,$thumb, 270, 360, "jpg");
					#}
					#unlink($temp);
				}
			}
		    $im->clear(); 
		    $im->destroy();			
			echo tgl("full");
			echo "<br/>";
			echo "<a href='http://34.87.117.247/pageturner/dng/index.php' target='_blank'>go here</a>";
		/**/
	}	
	function json(){
		$data = array("1","2","3");
		echo json_encode($data);
	}
	function resize(){	
		$directory 	= "/var/www/html/";	
		echo $saveAsPath = $directory."pageturner/dng/files/";
		$temp  = $saveAsPath . "temp/1.jpg";
		$move  = $saveAsPath . "1.jpg";
		echo ak_img_resize_test($temp,$move, 1240, 1654, "jpg");
		//ak_img_resize($temp,$thumb, 270, 360, "jpg");
	}
}