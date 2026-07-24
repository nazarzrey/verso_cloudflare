<?php
class Mod_Login_mobile extends CI_Model {
  function cek() {
    return $this->db->get("magazine_users_hdr");
  }
  function signup($email, $name, $no_hp, $password) {
    $this->db->insert("magazine_users_hdr",
      array(
        "name"=>$name,
        "user_email"=>$email,
        "user_phone"=>$no_hp,
        "user_password"=>$password
      )
    ); 

    $this->db->where('user_email', $email);
    $this->db->where('user_password', $password);
    $this->db->select('user_name, name, user_email');
    return $this->db->get("magazine_users_hdr")->result_array(); 
  }
  function signin($user_name, $password) {
    $this->db->where('user_email', $user_name);
    $this->db->where('user_password', $password);
    $this->db->select('user_name, name, user_email');
    return $this->db->get("magazine_users_hdr")->result_array(); 
  }
  
  function changePassw($user_name, $password) {
    $this->db->set('user_password', $password);
    $this->db->where('user_id', $user_name);
    $this->db->update('magazine_users_hdr');
  }

  function getId($email) {
    $this->db->where('user_email', $email);
    $this->db->select('user_id');
    return $this->db->get("magazine_users_hdr")->result_array(); 
  }

  // function cek($id, $tipe, $pass = "") {
  //     if($tipe=="fb"){
  //       $this->db->where("user_fb_id", $id);
  //     }elseif($tipe=="tw"){
  //       $this->db->where("user_tw_id", $id);
  //     }elseif($tipe=="go"){
  //       $this->db->where("user_go_id", $id);
  //     }else{
  //       $this->db->where("user_email", $id);
  //       $this->db->where("user_password", $pass);
  //     }
  //     return $this->db->get("magazine_users_hdr");
  //   }
}
?>
