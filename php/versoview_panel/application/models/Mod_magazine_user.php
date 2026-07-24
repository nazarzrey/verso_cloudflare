<?php
class Mod_magazine_user extends CI_Model {
    function issue_view($uid,$tipe){
    	if($tipe=="" || strlen($tipe)==0){
    		$sintak = "SELECT IFNULL((SELECT val FROM magazine_user_setting WHERE user_id='$uid'),'1') AS val";
			if($uid=="47"){
				echo $sintak;
			}
    		return single_query($this->db->query($sintak));
    	}
    }
}