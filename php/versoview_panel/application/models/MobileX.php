<?php
class MobileX extends CI_Model {  
  function login($email) {
    $this->db->where('email', $email);
    $this->db->select('email');
    $data = $this->db->get("magazine_mobile_login")->result_array();
    if (!isset($data[0])){
      $this->db->insert("magazine_mobile_login",
        array(
          "email"=>$email
        )
      );
      return 1;
    }else{
      return 0;
    }
  }

  function login_email($name, $email, $password) {
    $this->db->where('email', $email);
    $this->db->select('email');
    $data = $this->db->get("magazine_mobile_login")->result_array();
    if (!isset($data[0])){
      $this->db->insert("magazine_mobile_login",
        array(
          "name"=>$name,
          "email"=>$email,
          "password"=>$password
        )
      );
      return $name;
    }else{
      return 1;
    }
  }

  function signin_email($email, $password) {
    $this->db->where('email',$email);
    $this->db->where('password',$password);
    $this->db->select('email');
    $data = $this->db->get("magazine_mobile_login")->result_array();
    if (!isset($data[0])){     
      return 0;
    }else{
      return 1;
    }
    // return $data;
  }

  function bookmark($login, $page, $status, $pagedetail, $issue) {
    if ($status == 0){
      $this->db->insert("magazine_mobile_bookmark",
        array(
          "email"=>$login,
          "page"=>$page,
          "issue_id"=>$issue,
          "pagedetail"=>$pagedetail
        )
      );
      return 0;
    }elseif($status == 1){
      $this->db->delete('magazine_mobile_bookmark', array('email' => $login, 'page' => $page, 'issue_id' => $issue));
      return 1;
    }else{
      $this->db->where('magazine_mobile_bookmark.email', $login);
      $this->db->select('magazine_detail.title, magazine_detail.lead, magazine_detail.page, magazine_mobile_bookmark.pagedetail, magazine_detail.written');
      $this->db->join('magazine_mobile_bookmark', 'magazine_mobile_bookmark.page = magazine_detail.page', 'left');
      $data = $this->db->get("magazine_detail")->result_array();
      return $data;
    }

  }

  function favorite($login, $page, $status, $pagedetail, $issue) {
    if ($status == 0){
      $this->db->insert("magazine_mobile_favorite",
        array(
          "email"=>$login,
          "page"=>$page,
          "issue_id"=>$issue,
          "pagedetail"=>$pagedetail
        )
      );
      return 0;
    }elseif($status == 1){
      $this->db->delete('magazine_mobile_favorite', array('email' => $login, 'page' => $page, 'issue_id' => $issue));
      return 1;
    }else{
      $this->db->where('magazine_mobile_favorite.email', $login);
      $this->db->select('magazine_detail.title, magazine_detail.lead, magazine_detail.page, magazine_mobile_favorite.pagedetail, magazine_detail.written');
      $this->db->join('magazine_mobile_favorite', 'magazine_mobile_favorite.page = magazine_detail.page', 'left');
      $data = $this->db->get("magazine_detail")->result_array();
      return $data;
    }

  }
  
  function getMagazine($find) {
    if ($find != "")
      return $this->db->like('detail', $find)->get("magazine_detail")->result_array(); 
    else return "0";
  }

  function getDemo($value,$tipe) {
			  #$this->db->where("");
	if($tipe!="demo"){
		#$this->db->where("magazine_name",$value);		
		$sql  = "SELECT * FROM (SELECT *,'medium/1.jpg' as magazine_image FROM openview_app_demo WHERE magazine_name='$value' AND magazine_used=1 )AS a
				UNION 
				SELECT * FROM (SELECT *,'medium/1.jpg' as magazine_image FROM openview_app_demo WHERE magazine_name='$value' AND magazine_used=0 ORDER BY id DESC) AS b";
		$data = $this->db->query($sql)->result();
	}else{
				$this->db->select("*,'medium/1.jpg' as magazine_image");
		$data = $this->db->get("openview_app_demo")->result();
	}
    return $data;
  }

  function getMagz($value,$tipe) {
	if($tipe=="live"){
		#$this->db->where("magazine_name",$value);		
		$sql  = "SELECT * FROM (SELECT *,'medium/1.jpg' as magazine_image FROM openview_app WHERE magazine_name='$value' AND magazine_used=1 AND recid=1 )AS a
				UNION 
				SELECT * FROM (SELECT *,'medium/1.jpg' as magazine_image FROM openview_app WHERE magazine_name='$value' AND magazine_used=0 AND recid=1 ORDER BY id DESC) AS b";
		$data = $this->db->query($sql)->result();
	}else{
				$this->db->select("*,'medium/1.jpg' as magazine_image");
		$data = $this->db->get("openview_app")->result();
	}
    return $data;
  }
  function getNzr($value,$tipe) {
	if($tipe=="live"){
		#$this->db->where("magazine_name",$value);		
		$sql  = "SELECT * FROM (SELECT *,'medium/1.jpg' as magazine_image FROM openview_app WHERE magazine_name='$value' AND magazine_used=1 AND recid=1 )AS a
				UNION 
				SELECT * FROM (SELECT *,'medium/1.jpg' as magazine_image FROM openview_app WHERE magazine_name='$value' AND magazine_used=0 AND recid=1 ORDER BY id DESC) AS b";
		$data = $this->db->query($sql)->result();
	}else{
				$this->db->select("*,'medium/1.jpg' as magazine_image");
		$data = $this->db->get("openview_app")->result();
	}
    return $data;
  }
}
?>

