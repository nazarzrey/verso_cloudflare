<?php

/*
header('Access-Control-Allow-Origin:https://jagowebdev.com');
$data = file_get_contents('https://medium.com/@steve.yegge/latest?format=json');
echo str_replace('])}while(1);</x>', '', $data);
*/
// header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
header('Access-Control-Allow-Origin:*'); //for allow any domain, insecure
// header('Access-Control-Allow-Origin:https://panel.versoview.com'); //for allow any domain, insecure

// header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed

  //  $test = getallheaders();
/*

$uid     = get_header("X-Auth");
$session = get_header("X-Keys");*/
#ajaxrequest adalah yang systemnya get
// get_header("origin");
defined('BASEPATH') OR exit('No direct script access allowed');

class OpenVi extends CI_Controller {

	function __construct() {
		parent::__construct();
    	$this->load->library('session');
    	$this->load->model(array('User_activity','Mod_openvi'));
	}

	public function index() {
		echo "x";
	}
	public function query($table = "") {
		echo $table."XX";
		if($table!=""){
			$sintak = "select * from $table";       
	        $query  = all_query($this->db->query($sintak));
	        debug($query);
	    }else{
	    	echo "nama table blom ada";
	    }
	}

	public function unic($salt = "") {
	    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	        $temp = sys_get_temp_dir().DIRECTORY_SEPARATOR."diskpartscript.txt";
	        if(!file_exists($temp) && !is_file($temp)) file_put_contents($temp, "select disk 0\ndetail disk");
	        $output = shell_exec("diskpart /s ".$temp);
	        $lines = explode("\n",$output);
	        $result = array_filter($lines,function($line) {
	            return stripos($line,"ID:")!==false;
	        });
	        if(count($result)>0) {
	            $result = array_shift($result);
	            $result = explode(":",$result);
	            $result = trim(end($result));       
	        } else $result = $output;       
	    } else {
	        $result = shell_exec("blkid -o value -s UUID");  
	        if(stripos($result,"blkid")!==false) {
	            $result = $_SERVER['HTTP_HOST'];
	        }
	    }   
	    echo md5($salt.md5($result));
	}

	public function like($id, $content, $unic_device, $action = 0){
		$content = str_replace("%20", " ", $content);
		if ($action == 1){
			$result = $this->Mod_openvi->like($id, $content, $unic_device, 1);
		}else{
			$result = $this->Mod_openvi->like($id, $content, $unic_device);
		}
	}

	public function getlike($id = 0){
		if ($id == 0){
			$result = $this->Mod_openvi->getlike();
			$json   = json_encode($result);
			echo $json;			
		}else{
			$result = $this->Mod_openvi->getlike($id);
			$json   = json_encode($result);
			echo $json;			
		}
	}

	public function getbookmark($id = 0){
		if ($id == 0){
			$result = $this->Mod_openvi->getbookmark();
			$json   = json_encode($result);
			echo $json;			
		}else{
			$result = $this->Mod_openvi->getbookmark($id);
			$json   = json_encode($result);
			echo $json;			
		}
	}

	public function bookmark($id, $content, $unic_device, $action = 0){
		$content = str_replace("%20", " ", $content);
		if ($action == 1){
			$result = $this->Mod_openvi->bookmark($id, $content, $unic_device, 1);
		}else{
			$result = $this->Mod_openvi->bookmark($id, $content, $unic_device);
		}
	}
	
	public function collect($tipe="",$edisi="",$uid="",$data=""){
		if($tipe=="hdr"){
			// get_hdr_openvi($edisi,$uid);
			$result = $this->Mod_openvi->get_hdr_openvi($edisi,$uid);
			echo json_encode($result);
		}else{
			$result ="";
		}
		if($tipe=="comment_like_body"){
		}
		if($tipe=="comment_get"){
			$lmt    	= 5;
			// die($data);
			// $start 		= round(microtime(true)*1000);
			$magz_edisi = "bca-88";
			$magz_sect  = $edisi;
			$limit  	= "limit ".$lmt;
			#echo $data;
			if($uid=="more-child"){
				$child_data = explode("-",str_replace("com-","",$data));
				if(is_array($child_data)){
					$child_id  = $child_data[0];
					$child_ttl = $child_data[1];
					$result = $this->comment_get_child($child_id,$child_ttl,$lmt,"child");
				}
				return;
			};
			$xdata      = 0;
			if($data=="" || $data==0){
				$data	= $xdata;
			}
			if($uid!="default"){
				if($data!="0"){
					$limit = "limit ".$data.",".$lmt;
				}
			}
			$result = $this->Mod_openvi->get_comment($magz_edisi,$magz_sect,$limit);
			$total  = $this->Mod_openvi->get_comment_ttl($magz_edisi,$magz_sect,"");
			$ttl_parent = $data;
			$load_more = "";
			if($total){
				if($total[0]->ttl>$lmt){
					$ttl_parent = $total[0]->ttl-$data;
					if($ttl_parent>=$lmt){
						$load_more = "<div class='load-parent'></div>";
					}
				}
			}
			//$json   = json_encode($result);
			if($result){
				if(count($result)>0){
					echo "<ul>";
					foreach ($result as $key => $parent) {
						echo "<li class='prnt' id='com-".$parent->cmnt_id."'>";
						echo '
						  <div class="rpdtl">
			                <div class="cmnt-txt">
			                  <b>'.Uw($parent->cmnt_name).'</b>'.$parent->cmnt_text.'
			                </div>                            
			                <div class="cmnt-reply">
			                  '.$parent->tanggal.'
			                  <a class="reply-cmnt" comment-id="'.$parent->cmnt_id.'" comment-name="'.$parent->cmnt_name.'">Reply</a>
			                </div>
			              </div>';					
						echo $this->comment_get_child($parent->cmnt_id,$parent->reply,$lmt,"default");
						echo "</li>";
					}
					echo $load_more;
					echo "</ul>";
				}
			}
			#$end  = round(microtime(true)*1000);
			#echo $end." - ".$start." = ".($end-$start);
			#$exec = ($end-$start)/500;
			#echo "execute in  ".($exec)." detik";
			#debug(microtime());
		}
		if($tipe=="likebook"){
			if($this->input->post()){
				$cm_tp  = $this->input->post("tipe");
				$cm_uid = $this->input->post("uid");
				$cm_nem = $this->input->post("value");
				$cm_eds = $this->input->post("edisi");
				$cm_sec = $this->input->post("section");
				#debug($cm_tp,$cm_uid,$cm_nem,$cm_eds,$cm_sec);
				$save   = $this->Mod_openvi->post_likebook($cm_tp,$cm_uid,$cm_nem,$cm_eds,$cm_sec,"");
				if($save){
					echo  json_encode(array($cm_tp,"1"));
				}else{
					echo  json_encode(array($cm_tp,"0"));
				}
			}else{
				echo  json_encode(array($cm_tp,"0"));
			}
		}
		if($tipe=="comment_post"){
			//echo json_encode("ok");
			if($this->input->post()){
				$cm_id  = $this->input->post("cid");
				$cm_uid = $this->input->post("cuid");
				$cm_nem = $this->input->post("cnam");
				$cm_eds = $this->input->post("cedisi");
				$cm_sec = $this->input->post("csection");
				$cm_isi = $this->input->post("comment");
				$save   = $this->Mod_openvi->post_comment($cm_id,$cm_uid,$cm_nem,$cm_eds,$cm_sec,$cm_isi);
				if($save){
					$this->comment_get_child($save,"1","1","post");
					//echo json_encode($save);
				}
			}else{
				echo  json_encode(array("this post ajax"));
			}
		}
	}

	public function comment_get_child($cmnt_id='',$reply='',$lmt,$load){
		$limi 			 = 1;
		$limit 			 = "limit ".$limi;
		$load_child_more = "";
		$sisa 			 = $reply - $limi;
		$ul1 			 = "<ul class='ch-".$cmnt_id."'>";
		$ul2 			 = "</ul>";
		$style           = "rpdtl2";
		if($load=="child"){
			$total  = $this->Mod_openvi->get_comment_ttl("","",$cmnt_id);
			// echo $total[0]->ttl." -".$reply;
			if($total[0]->ttl>$sisa){	
				$limit = "limit ".$reply.",".$lmt;
			}
			$ul1 = $ul2 = "";
		}else{
			if($reply>$limi){
				$load_child_more = "<div class='cmnt-reply2 load-child' id='rep-".$cmnt_id."' data-child='$reply'>View more replies <span>($sisa)</span></div>";
				if($load!="default"){				
					$limit = "limit ".$reply.",".$limi;
				}
			}
			if($load=="post"){
				$limit = "post";
				$style = "rpdtl";
			}
		}
		// echo $limit;
		$result = $this->Mod_openvi->get_comment_child($cmnt_id,$limit);
		if($result){
			if(count($result)>0){
				echo $load_child_more;
				echo $ul1;				
				foreach ($result as $key => $child) {
					// echo br(array($child->cmnt_reply,$cmnt_id,$child->cmnt_id));
					// if($child->cmnt_reply==$cmnt_id && $load=="child"){
					// 	return;
					// }
					if($load=="child"){
						$id = $child->cmnt_id;
					}else{
						$id = $result[0]->cmnt_id;
					}
					echo "<li id='com-".$id."' class='pr-".$cmnt_id."'>";
					#echo br($child->cmnt_name." :".$child->cmnt_text." ".$child->reply);
					echo '
					  <div class="'.$style.'">                        
		                <div class="cmnt-txt">
		                  <b>'.Uw($child->cmnt_name).'</b>'.$child->cmnt_text.'
		                </div>                            
		                <div class="cmnt-reply">
		                  '.$child->tanggal.'
		                  <a class="reply-cmnt" comment-id="'.$child->cmnt_id.'"  comment-name="'.$child->cmnt_name.'">Reply</a>
		                </div>
		              </div>';
					#echo $reply." ".$limi;
					if($child->cmnt_reply!="0"){
						echo $this->comment_get_child($child->cmnt_id,$child->reply,$limi,"default");
					}
					echo "</li>";
				}			
				echo $ul2;
			}
		}
	}

	#****
}
