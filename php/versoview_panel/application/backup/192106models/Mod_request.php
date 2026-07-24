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
    function magz_pdf($id){
      $this->db->where(array("magz_id"=>$id));
      $query = $this->db->get("magazine_data_hdr");
      return $query->result_array()[0]["magz_pdf_file"];
    }
    function magz_update($id,$cover){		
        $this->db->query("update magazine_data_hdr set magz_process_c2flip=2 where magz_id=$id");
		$this->db->query("update magazine_gallery set gallery_image1='$cover' where gallery_fk_id=$id and gallery_description='cover'");
    }
    function api_each_query($sintak){
		//$sintak = "select lower(title) as title,description,image_name,href from api_magazine";
        #$this->db->query($sintak);
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
    function magz_name($id){
      $this->db->where(array("magz_id"=>$id));
      $query = $this->db->get("magazine_data_hdr");
      return strtolower($query->result_array()[0]["magz_name"]);
    }
    function magz_created($category,$url,$urldtl,$title,$desc,$uid,$pdf){
      #$sintak = "select 1 from magazine_users_hdr where ";
      $table = "magazine_data_hdr";
      $this->db->where("magz_name='$title'");
      $query = $this->db->get($table);
      if($query->num_rows()==0){        
        $this->db->insert($table,
          array(
          "magz_cat"=>$category,
          "magz_url"=>$url,
          "magz_name"=>strtoupper($title),
          "magz_desc"=>$desc,
          "magz_user_id"=>$uid,
          "magz_pdf_file"=>$pdf,
          "magz_updrec_date"=>tgl("full"),
		  "magz_href"=>base_url("magazine/".strtolower($title))
          )
        );
        if($this->db->insert_id()){    
          $this->db->query("update $table set magz_cover=magz_id where magz_cover is null");
          $this->db->where(array("magz_url"=>$url,"magz_user_id"=>$uid,"magz_name"=>strtoupper($title)));
          $subquery = $this->db->get($table);
          if($subquery->num_rows()==1){ 
            $result_array = $subquery->result_array();
            $hdr_id       = $result_array[0]["magz_id"];
            $this->db->insert("magazine_data_dtl",array(
              "magz_fk_id"        =>$hdr_id,
              "issue_url"         =>$urldtl,
              "issue_title"       =>ucwords(strtolower($title)),
              "issue_desc"        =>$desc,
              "issue_category"    =>$category,
              "issue_pdf_file"    =>$pdf,
              "issue_updrec_date" =>tgl("full"))
            );          
            if($this->db->insert_id()){    
            #insert to gallery      
                $this->db->insert("magazine_gallery",array(
                  "gallery_fk_id"=>$result_array[0]["magz_id"],
                  "gallery_description"=>'cover',
                  "gallery_path"=>"magazine/cover/",
                  "gallery_updrec_date"=>tgl("full"))
                ); 
                $this->db->insert_id();
            }
          }
          $result = "0";  
        }else{
          $return = "2";
        }
      }else{
        $result = "1";
      }      
      return $result;
    }
	}
?>