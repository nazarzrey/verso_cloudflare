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
		if (DIRECTORY_SEPARATOR == '\\') {
    		$dir   = "D:\\xampp\\htdocs\\agencyfish\\weblist\\versoview";
    		$conv  = "magick";
		    // unix, linux, mac
		}else{
    		$dir   = "/var/www/html/";
    		$conv  = "convert";
		}
		$file 	   = numPdf($dir.'/pdf_temp/new.pdf');
		echo $file;
		/*$numpage   = shell_exec("identify -format %n, ".$file);
		$num       = explode(",",$numpage);
		if(is_array($num)){
			echo $page      = $num[0];
		}else{
			echo "0";
		}*/

		echo sys("conv")."ss";
		/*
		echo $cek_file =  Path()."./adeliafirdaus.txt";
		if(file_exists($cek_file)){
			echo "ok";
		}*/
		#echo shell_exec($conv."  -colorspace sRGB -set units PixelsPerInch -density 350 '.$filepdf.'['.$x.'] -quality 40 '.$move");
		//$image->pingImage($dir.'/pdf_temp/new.pdf');
		//echo $image->getNumberImages();
	}
}