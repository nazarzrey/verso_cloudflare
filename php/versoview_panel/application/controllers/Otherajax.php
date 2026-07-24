<?php
#ajaxrequest adalah yang systemnya get
defined('BASEPATH') OR exit('No direct script access allowed');

class Otherajax extends CI_Controller {
	function __construct() {
		parent::__construct();
    	$this->load->library('session');
    	$this->load->model(array('Mod_magazine'));
	}
	public function count_img($path='',$num=''){
		if(is_numeric($num)){
			$persen = $filecount/$num*100;
			if($persen<5){
				$percent = 1;
			}else{
				$percent = $persen;
			}
			if($filecount==$num){
				$this->Mod_magazine->ProConv($path,array("issue_convert"=>"2",));
				$DtlMgz  = $this->Mod_magazine->DtlMagz($path,"issue_path");
				echo json_encode(array($percent,$DtlMgz->dynamic_url));
			}else{
				echo json_encode(array($percent,"0"));
			}
		}else{
			echo $filecount;
		}
	}
}