<?php
	class Mod_comment extends CI_Model {
    #function get_comment($magz_edisi,$magz_section,$uid){

    #$save   = $this->Mod_comment->post_comment($cm_id,$cm_uid,$cm_nem,$cm_eds,$cm_sec);
    function post_comment($id,$uid,$name,$edisi,$section,$isi){
      $cmnt_table = "openview_comment";
        if($id==""){
          $id=0;
        }
        $insert = $this->db->insert($cmnt_table,
          array(
          "cmnt_reply"=>$id,
          "cmnt_user"=>$uid,
          "cmnt_name"=>$name,
          "cmnt_magz_desc"=>$edisi,
          "cmnt_magz_section"=>$section,
          "cmnt_text"=>$isi,
          "cmnt_created"=>date("Y-m-d H:i:s")
          )
        );
        return $insert;
    }
    function get_comment($magz_edisi,$magz_section){
      $cmnt_table = "openview_comment";
      $magz_edisi="bca-87";
      // $magz_section="regional";
      // $magz_section="";
      $parent = "select cmnt_id,cmnt_reply,cmnt_name,cmnt_text,DATE_FORMAT(cmnt_created,'%d-%m-%Y %H:%i') AS tanggal from $cmnt_table where cmnt_reply='0' and cmnt_magz_desc='$magz_edisi' and ifnull(cmnt_magz_section,'')='$magz_section' order by cmnt_created asc";
      $query  = $this->db->query($parent);
      return all_query($query);
    }
    function get_comment_child($cmnt_id){
      $cmnt_table = "openview_comment";
      $magz_edisi="bca-87";
      $magz_section="regional";
      $magz_section="";
      #$parent = "select cmnt_id,cmnt_name,cmnt_text,cmnt_created from $cmnt_table where cmnt_reply='$cmnt_id' and cmnt_key='$cmnt_key' order by cmnt_created desc";
      #$parent = "select cmnt_id,cmnt_name,cmnt_text,cmnt_created from $cmnt_table where cmnt_reply='$cmnt_id' and cmnt_key='$cmnt_key' order by cmnt_created desc";
      $parent = "SELECT a.cmnt_id,a.cmnt_reply,a.cmnt_name,a.cmnt_text,DATE_FORMAT(a.cmnt_created,'%d-%m-%Y %H:%i') AS tanggal,COUNT(b.cmnt_id) AS reply FROM $cmnt_table a LEFT JOIN $cmnt_table b ON a.cmnt_id=b.cmnt_reply WHERE a.cmnt_reply=$cmnt_id GROUP BY a.cmnt_id ORDER BY a.cmnt_created asc";
      $query  = $this->db->query($parent);
      return all_query($query);
    }
}
?>