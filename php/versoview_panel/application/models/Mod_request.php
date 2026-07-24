<?php
	class Mod_request extends CI_Model {
    function register($name,$mail,$pass){
      #$sintak = "select 1 from magazine_users_hdr where ";
      $table = "magazine_users_hdr";
      #$this->db->where(array("user_name"=>$name,"user_email"=>$mail));
      $this->db->where("user_email='$mail'");
      $query = $this->db->get($table);
      #$this->db->update("member",array($modul=>$value));      
      #return $query->result_array();
      if($query->num_rows()==0){        
        $this->db->insert($table,array("user_name"=>$name,"user_email"=>$mail,"user_password"=>$pass,"user_updrec_date"=>tgl("full")));
        $this->db->insert_id();
        return "0";
      }else{
        return "1";
      }
    }
    function login($email,$pass){
      $table = "magazine_users_hdr";
      $this->db->where(array("user_email"=>$email,"user_password"=>$pass));
      $query = $this->db->get($table);
      return $query->num_rows();      
    }
    function api_each_query($sintak){
  		if(!empty($sintak)){
  			return result_query($this->db->query($sintak));		
  		}else{
  			return array();
  		}
    }	
	function api_single_query($sintak){
  		if(!empty($sintak)){			
  			return single_query($this->db->query($sintak));	
  		}else{
  			return array();
  		}
    }	
	}
?>