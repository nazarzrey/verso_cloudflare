<?php
Class User_activity extends CI_Model{
function activity(){
  if($this->session->userdata('uid')){
    //  $data['username'] = $session_data['username'];
    /*$data = array(
          'session_id'=>"",
          'ip_address'=>$session_data['ip_address'],
          'user_agent'=>$session_data['user_agent'],
          'username'=>$session_data['username'],
          'time_stmp'=>Now(),
          'user_data'=>$session_data['username']."Logged in Account"
        );
    $this->db->insert('user_activity',$data); */
        return array(
          'uid' => $this->session->userdata["uid"],
          'uname' => $this->session->userdata["uname"],
          'utype' => $this->session->userdata["utype"],
          'uem' => $this->session->userdata["uem"],
          'uph' => $this->session->userdata["uph"],
          'uimg' => $this->session->userdata["uimg"],
          'prov' => $this->session->userdata["prov"]
        );
    }else{
      redirect('login');
    }
  }
}
?>