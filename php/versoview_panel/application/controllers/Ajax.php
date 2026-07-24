<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	function __construct() {
		parent::__construct();
    	// $this->load->library('session');
    	#$this->load->model(array('Mod_ajax'));
	}
	public function index($value=""){
		echo  json_encode(array("result"=>"this ajax"));
	}
	public function crud($value='',$value1='',$value2='')
	{
		$dir = "/var/www/html/";
		if($value=="magz"){
			if($value2=="cek"){
			}elseif($value2=="del"){
				$sql  = "SELECT 
						CONCAT((SELECT setting_value FROM magazine_settings WHERE setting_data='path-flipbook'),'/',magz_url) AS url,
						CONCAT((SELECT setting_value FROM magazine_settings WHERE setting_data='path-pdf'),'/',magz_pdf_file) AS pdf
						FROM magazine_data_hdr WHERE
						magz_id='$value1'";
				$data = $this->db->query($sql);
				#echo $query->num_rows();
				if($data->num_rows()==1){
					$flip = "./".$data->result_array()[0]["url"];
					$pdf  = "./".$data->result_array()[0]["pdf"];
					if(is_dir($flip)){
						shell_exec('rm -rf '.$flip);
						#echo $flip;
					}				
					if(file_exists($pdf)){
						shell_exec('rm '.$pdf);
						#echo $pdf;
					}
					$delete = "call dele('$value1')";
					if($this->db->query($delete)){
						echo "1";
					}else{
						echo "0";
					}
				}else{
					echo "x";
				}
			}else{
				die("");
			}
		}
		#echo $value,$value1,$value2,$dir;
	}
	public function record($value='',$value1='')
	{
		if($this->input->post("media") && !empty($value1) ){
			$ip    = $_SERVER['REMOTE_ADDR'];
			$media = $this->input->post("media");
			$url   = $this->input->post("url");
			$magz  = $value1;
			$page  = explode("/", $url);
			$lastp = str_replace("index.html#","",end($page));
			$sql   = "call view_record($magz,'$ip','$lastp',null,'$media')";
			$data["result"] = $this->db->query($sql);
			echo json_encode($data);
		}
	}
	public function conv($value='',$value1=''){
		
		$filepdf	= "./pdf_temp/jed.pdf";
		
		$num_pages = shell_exec('identify -format %n '.$filepdf);
		for ($x = 0; $x <= $num_pages - 1; $x++) {
			$xx = $x + 1;
			$move  = $saveAsPath . "page/" . $xx.'.jpg';
			$thumb = $saveAsPath . "thumb/" . $xx.'.jpg';
			shell_exec('convert -density 200x200 -geometry 1841, 2481 -trim '.$filepdf.'['.$x.'] -quality 65 '.$move);
			shell_exec('convert -density 200x200 -geometry 356, 480 -trim '.$filepdf.'['.$x.'] -quality 65 '.$thumb);				    
		} 
		/*
		$im = new imagick();
		$im->setResolution(200, 200);  
		$im->readImage($filepdf);
		#die(tgl("full"));
		$im->setImageFormat('jpeg');			
		$im->setImageAlphaChannel(imagick::ALPHACHANNEL_REMOVE);
		$im->mergeImageLayers(imagick::LAYERMETHOD_FLATTEN);
		$im->setImageBackgroundColor('white');
		$num_pages = $im->getNumberImages();
		//for ($i = 0; $i < $num_pages; $i++) {
		for ($i = 0; $i < $num_pages; $i++) {
			$a = $i + 1;
			$temp  = $saveAsPath . "temp/" . $a.'.jpg';
			$move  = $saveAsPath . "page/" . $a.'.jpg';
			$thumb = $saveAsPath . "thumb/" . $a.'.jpg';
			$im->setIteratorIndex($i);					
			
			// $im->resizeImage( 1240, 1654, Imagick::FILTER_SINC, 0.1, false );  				
			$im->setImageCompression(imagick::COMPRESSION_JPEG); 
			$im->setImageCompressionQuality(300);					
			$im->writeImage($temp);	
			#echo $temp;				
			if(file_exists($temp)){
				if(filesize($temp)<=1024000){
					copy($temp,$move);
					ak_img_resize($temp,$thumb, 356, 480, "jpg");
				}else{						
					ak_img_resize($temp,$move, 1841, 2481, "jpg");
					ak_img_resize($temp,$thumb, 356, 480, "jpg");
				}
				unlink($temp);
			}
		}
		$im->clear(); 
		$im->destroy();
		*/
		/*
		$num_pages = shell_exec('identify -format %n '.$filepdf);
		for ($x = 0; $x <= $num_pages - 1; $x++) {
			$xx = $x + 1;
			$move  = $saveAsPath . "page/" . $xx.'.jpg';
			$thumb = $saveAsPath . "thumb/" . $xx.'.jpg';
			shell_exec('convert -density 200x200 -geometry 1841, 2481 -trim '.$filepdf.'['.$x.'] -quality 65 '.$move);
			shell_exec('convert -density 200x200 -geometry 356, 480 -trim '.$filepdf.'['.$x.'] -quality 65 '.$thumb);				    
		} 
		*/

	}		
}