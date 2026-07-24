<?php
  class Mod_Login extends CI_Model {
 
      function cek($useremail, $password) {
        $this->db->where("user_email", $useremail);
        $this->db->where("user_password", $password);
        return $this->db->get("magazine_users_hdr");
      }
 
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
      }
  }
?>
