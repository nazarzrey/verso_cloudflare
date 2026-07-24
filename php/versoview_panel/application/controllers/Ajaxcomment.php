<?php
#ajaxrequest adalah yang systemnya get
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxcomment extends CI_Controller {
	function __construct() {
		parent::__construct();
    	$this->load->library('session');
    	$this->load->model(array('User_activity','Mod_comment'));
	}
	#index
	public function index(){
		echo  json_encode(array("result"=>"this ajax request"));
	}
	public function comment_push($value=''){
		echo  json_encode($value);
	}


	public function comment_get($value=''){
		$data="";
		$magz_edisi="bca-87";
		$magz_section="";
		$result = $this->Mod_comment->get_comment($magz_edisi,$magz_section,$value);
		$json   = json_encode($result);
		#echo count($result);
		#debug($result,"r");
		if(count($result)>0){
			echo "<ul>";
			foreach ($result as $key => $parent) {
				echo "<li>";
				echo '
				  <div>                        
	                <div class="cmnt-txt">
	                  <b>'.Uw($parent->cmnt_name).'</b>'.$parent->cmnt_text.'
	                </div>                            
	                <div class="cmnt-reply">
	                  '.$parent->tanggal.'
	                  <a class="reply-cmnt" data-comment="'.$parent->cmnt_id.'" data-name="'.$parent->cmnt_name.'">Reply</a>
	                </div>
	              </div>';
				#$parent->cmnt_id." -> ".$parent->cmnt_reply." -> ".
				#echo "<div>$parent->cmnt_name." :".$parent->cmnt_text);# $this->comment_get_child($value->cmnt_id,$value->cmnt_key);								
				echo $this->comment_get_child($parent->cmnt_id,$parent->cmnt_key);
				echo "</li>";
			}			
		}
		#debug($result);
	}
	public function comment_get_child($cmnt_id='',$cmnt_key=''){
		$result = $this->Mod_comment->get_comment_child($cmnt_id,$cmnt_key);
		$json   = json_encode($result);
		#echo count($result);
		#debug($result,"");
		if(count($result)>0){
			echo "<ul>";
			foreach ($result as $key => $child) {
				echo "<li>";
				#echo br($child->cmnt_name." :".$child->cmnt_text." ".$child->reply);
				echo '
				  <div>                        
	                <div class="cmnt-txt">
	                  <b>'.Uw($child->cmnt_name).'</b>'.$child->cmnt_text.'
	                </div>                            
	                <div class="cmnt-reply">
	                  '.$child->tanggal.'
	                  <a class="reply-cmnt" data-comment="'.$child->cmnt_id.'" data-name="'.$child->cmnt_name.'">Reply</a>
	                </div>
	              </div>';
				if($child->reply!="0"){
					echo $this->comment_get_child($child->cmnt_id,$child->cmnt_key);
				}
				echo "</li>";
			}			
			echo "</ul>";
		}
	}

	public function header($status){
		$data['session'] = $this->User_activity->activity();
		$this->load->view("templates/backend_header",$data);
		$this->load->view("templates/backend_menu_sidebar",$data);
		$this->load->view("templates/backend_menu_top",$data);		
		if(!empty($status)){
			$xdata["status"]=$status;
			$this->load->view("templates/backend_status",$xdata);
		}
	}
	public function footer(){
      	$data 	= "footer";
		$this->load->view("templates/backend_footer",$data);
	}	
	public function template($view,$data,$status,$form){
		$this->header($status);
		#die($form);
		if(!empty($form)){
			$this->load->view("form/modal_form",$form);
		}
		if(is_array($data)){
			$this->load->view($view,$data);
		}else{
			if($data=="view"){
				$this->load->view($view);
			}else{
				echo $view;
			}
		}
		$this->footer();
	}
}