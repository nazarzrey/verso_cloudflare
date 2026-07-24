<?php
  class Mod_Login extends CI_Model {
 
      function cek($useremail, $password,$tipe) {
#		echo $useremail." - ". $password. " - ". $tipe;
        /*
        if($tipe=="fb"){
          $find = "user_fb_id='$password'";
        }elseif($tipe=="tw"){
          $find = "user_tw_id='$password'";
        }elseif($tipe=="go"){
          $find = "user_go_id='$password'";
        }else{
          $find = "user_password='$password'";
        }
        echo $sintak = "select 1 from magazine_users_hdr where user_email='$useremail' and $find";        
        var_dump($this->db->query($sintak));
        */
        if($tipe=="fb"){
          $this->db->where("user_email", $useremail);
          $this->db->where("user_fb_id", $password);
        }elseif($tipe=="tw"){
          $this->db->where("user_email", $useremail);
          $this->db->where("user_tw_id", $password);
        }elseif($tipe=="go"){
          $this->db->where("user_email", $useremail);
          $this->db->where("user_go_id", $password);
        }else{
          $this->db->where("user_email", $useremail);
          $this->db->where("user_password", $password);
        }
        return $this->db->get("magazine_users_hdr");
      }
      function fb_auth($fbid,$mail,$fbdata){
        #                       0     1       2      3       4          5        6
        #$fb_array = array("nazrey","nazar","zrey","male","indonesia","ganteng","url");
        $fb_data = "fb_name:".$fbdata[0].",fb_first_name:".$fbdata[1].",fb_last_name:".$fbdata[2].",fb_sex:".$fbdata[3].",fb_country:".$fbdata[4].",fb_image:".$fbdata[5].",fb_url".$fbdata[6]."";
        $this->db->where("user_fb_id='$fbid'");
        $get    = $this->db->get("magazine_users_hdr"); 
        $result = $get->result();
        if(count($result)==0){ 
          $this->db->where("user_email='$mail'");
          $get2    = $this->db->get("magazine_users_hdr"); 
          $result2 = $get2->result();
            if(count($result2)==0){ 
              $this->db->insert("magazine_users_hdr",array(
                "user_name"=>$fbdata[0],
                "name"=>$fbdata[0],
                "user_email"=>$mail,
                "user_fb_id"=>$fbid,
                "user_fb_img"=>$fbdata[5],
                "user_fb_link"=>$fbdata[6],
                "user_fb_data"=>$fb_data,
                "user_updrec_date"=>tgl("full")
              ));          
            }else{    
              $data = array(
                "user_fb_id"=>$fbid,
                "user_fb_img"=>$fbdata[5],
                "user_fb_link"=>$fbdata[6],
                "user_fb_data"=>$fb_data,
                "user_updrec_date"=>tgl("full")
              );
              $this->db->where('user_email', $mail);
              $this->db->update('magazine_users_hdr', $data);  
            }
          $this->db->where("user_fb_id='$fbid' or user_email='$mail'");
          $get    = $this->db->get("magazine_users_hdr"); 
          $result = $get->result();
        }
        return $result;
      }
      function tw_auth($twid,$mail,$twdata){
        #                       0     1       2      3       4          5        6
        #$tw_array = array("nazrey","nazar","zrey","male","indonesia","ganteng","url"); 
        $tw_data = "tw_name:".$twdata[0].",tw_screen_name:".$twdata[1].",tw_country:".$twdata[2].",tw_image:".$twdata[3].",tw_url".$twdata[4]."";
        $this->db->where("user_tw_id='$twid'");
        $get    = $this->db->get("magazine_users_hdr"); 
        $result = $get->result();
        if(count($result)==0){
          $this->db->where("user_email='$mail'");
          $get2    = $this->db->get("magazine_users_hdr"); 
          $result2 = $get2->result();
          if(count($result2)==0){
            $this->db->insert("magazine_users_hdr",array(
              "user_name"=>$twdata[0],
              "user_email"=>$mail,
              "user_tw_id"=>$twid,
              "user_tw_img"=>$twdata[3],
              "user_tw_link"=>$twdata[4],
              "user_tw_data"=>$tw_data,
              "user_updrec_date"=>tgl("full")
            ));
          }else{    
            $data = array(
              "user_tw_id"=>$twid,
              "user_tw_img"=>$twdata[3],
              "user_tw_link"=>$twdata[4],
              "user_tw_data"=>$tw_data,
              "user_updrec_date"=>tgl("full")
            );
            $this->db->where('user_email', $mail);
            $this->db->update('magazine_users_hdr', $data);  
          }  
          $this->db->where("user_tw_id='$twid' or user_email='$mail'");
          $get    = $this->db->get("magazine_users_hdr"); 
          $result = $get->result();
        }
        return $result;
      }
      function go_auth($goid,$mail,$godata){
        #                       0     1       2      3       4          5        6
        #$go_array = array("nazrey","nazar","zrey","male","indonesia","ganteng","url");
        $go_data = "go_name:".$godata[0].",go_first_name:".$godata[1].",go_last_name:".$godata[2].",go_sex:".$godata[3].",go_country:".$godata[4].",go_image:".$godata[5].",go_url".$godata[6]."";
        $this->db->where("user_go_id='$goid'");
        $get    = $this->db->get("magazine_users_hdr"); 
        $result = $get->result();
        if(count($result)==0){ 
          $this->db->where("user_email='$mail'");
          $get2    = $this->db->get("magazine_users_hdr"); 
          $result2 = $get2->result();
            if(count($result2)==0){ 
              $this->db->insert("magazine_users_hdr",array(
                "user_name"=>$godata[0],
                "user_email"=>$mail,
                "user_go_id"=>$goid,
                "user_go_img"=>$godata[5],
                "user_go_link"=>$godata[6],
                "user_go_data"=>$go_data,
                "user_updrec_date"=>tgl("full")
              ));          
            }else{    
              $data = array(
                "user_go_id"=>$goid,
                "user_go_img"=>$godata[5],
                "user_go_link"=>$godata[6],
                "user_go_data"=>$go_data,
                "user_updrec_date"=>tgl("full")
              );
              $this->db->where('user_email', $mail);
              $this->db->update('magazine_users_hdr', $data);  
            }
          $this->db->where("user_go_id='$goid' or user_email='$mail'");
          $get    = $this->db->get("magazine_users_hdr"); 
          $result = $get->result();
        }
        return $result;
      }
    }
/*
        if(count($query->result())==0){
          // direct("404");
          // die();
          $result = "";
        }else{
          foreach ($query->result() as $row) {
            $result[] = $row;
          }
          return $result;
        }*/

 /*
      function getLoginData($usr, $psw) {
        $u = $usr;
        $p = md5($psw);
        $q_cek_login = $this->db->get_where('tuser', array('username' => $u, 'password' => $p));
        if (count($q_cek_login->result()) > 0) {
          foreach ($q_cek_login->result() as $qck) {
            foreach ($q_cek_login->result() as $qad) {
              $sess_data['logged_in'] = TRUE;
              $sess_data['id'] = $qad->id;
              $sess_data['username'] = $qad->username;
              $sess_data['password'] = $qad->password;
              $sess_data['nama'] = $qad->nama;
              $sess_data['level'] = $qad->level; // redirect('route', 'refresh');
              $this->session->set_userdata($sess_data);
            }
          redirect('cms');
          }
        } else {
            $this->session->set_flashdata('result_login', 'Username atau Password yang anda masukkan salah.');
            header('location:' . base_url() . 'login');
          }
      }


      function getID($ID) {
        $this->db->where("id",$ID);
        return $this->db->get("tuser");
      }*/

?>
