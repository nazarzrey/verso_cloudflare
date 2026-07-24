<?php

class Mod_openvi extends CI_Model
{
  function get_hdr_openvi($edisi, $uid)
  {
    $sintak = "
            SELECT REPLACE(a.content,' ','-') AS content,COUNT(c.ovi_like) AS tlike ,COUNT(b.cmnt_id) AS tcmnt
            FROM openview_content_list a
            LEFT JOIN openview_collect c ON a.content=c.ovi_content AND c.ovi_edisi='$edisi'
            LEFT JOIN openview_comment b ON a.content=b.cmnt_magz_content AND b.cmnt_edisi='$edisi'
            GROUP BY a.content;";
    $sql1 = "
                SELECT cmnt_magz_content AS content,COUNT(1) AS tcmnt FROM openview_comment 
                WHERE cmnt_edisi='$edisi'
                GROUP BY cmnt_magz_content";
    $sql2 = "
                SELECT  ovi_content as content,COUNT(1) AS tlike FROM openview_collect
                WHERE ovi_edisi='$edisi' AND ovi_like IS NOT NULL
                GROUP BY ovi_content";
    $query1  = all_query($this->db->query($sql1));
    $query2  = all_query($this->db->query($sql2));

    return array("cmnt" => $query1, "like" => $query2);
  }

  function like($id, $content, $unic_device, $action = 0)
  {
    if ($action == 0) {
      return $this->db->insert(
        "openview_like",
        array(
          "data_id" => $id,
          "content" => $content,
          "local_id" => $unic_device,
        )
      );
    } else {
      return $this->db->delete('openview_like', array('data_id' => $id, 'content' => $content, 'local_id' => $unic_device));
    }
  }

  function post_likebook($cm_tp, $cm_uid, $cm_val, $cm_eds, $cm_sec, $cm_sec_dtl)
  {
    if ($cm_tp == "like") {
      $tipe = "ovi_like";
    } else {
      $tipe = "ovi_bookmark";
    }
    if ($cm_val == "0") {
      $this->db->where($tipe . " is not null");
      $sql = $this->db->delete('openview_collect', array(
        'ovi_edisi' => $cm_eds,
        'ovi_content' => $cm_sec,
        'ovi_content_dtl' => $cm_sec_dtl,
        'user_id' => $cm_uid
      ));
    } else {
      $sql = $this->db->insert(
        "openview_collect",
        array(
          'ovi_edisi' => $cm_eds,
          'ovi_content' => $cm_sec,
          'ovi_content_dtl' => $cm_sec_dtl,
          'user_id' => $cm_uid,
          $tipe => $cm_val
        )
      );
    }
    return $sql;
  }

  function bookmark($id, $content, $unic_device, $action = 0)
  {
    echo "XX";
    if ($action == 0) {
      return $this->db->insert(
        "openview_bookmark",
        array(
          "data_id" => $id,
          "content" => $content,
          "local_id" => $unic_device,
        )
      );
    } else {
      return $this->db->delete('openview_bookmark', array('data_id' => $id, 'content' => $content, 'local_id' => $unic_device));
    }
  }

  function getlike($id = 0)
  {
    if ($id == 0) {
      $sintak = "SELECT count(content) as countnya, content FROM openview_like group by data_id, content";
      $query  = $this->db->query($sintak);
      return all_query($query);
    } else {
      $sintak = "SELECT count(content) as countnya FROM openview_like WHERE data_id='$id'";
      $query  = $this->db->query($sintak);
      return all_query($query);
    }
  }

  function getbookmark($id = 0)
  {
    if ($id == 0) {
      $sintak = "SELECT count(content) as countnya, content FROM openview_bookmark group by data_id, content";
      $query  = $this->db->query($sintak);
      return all_query($query);
    } else {
      $sintak = "SELECT count(data_id) as countnya FROM openview_bookmark WHERE data_id='$id'";
      $query  = $this->db->query($sintak);
      return all_query($query);
    }
  }

  function post_comment($id, $uid, $name, $edisi, $section, $isi, $share)
  {
    $sintak = "select cmnt_user,cmnt_name from openview_comment where cmnt_id='$id'";
    $cmnt_table = "openview_comment";
    if ($id == "") {
      $id = 0;
    } else {
      $isi = $this->get_repl_text($id, $uid, $isi)[0]->txt;
    }
    $insert = $this->db->insert(
      $cmnt_table,
      array(
        "cmnt_reply" => $id,
        "cmnt_user" => $uid,
        "cmnt_name" => $name,
        "cmnt_edisi" => $edisi,
        "cmnt_magz_content" => $section,
        "cmnt_magz_content_dtl" => $share,
        "cmnt_text" => $isi,
        "cmnt_created" => date("Y-m-d H:i:s")
      )
    );
    return $this->db->insert_id();
  }
  function post_content($id, $uid, $name, $edisi, $section, $isi, $share, $hdr, $dtl)
  {
    $sintak = "select cmnt_user,cmnt_name from openview_comment where cmnt_id='$id'";
    $cmnt_table = "openview_comment";
    if ($id == "") {
      $id = 0;
    } else {
      $isi = $this->get_repl_text($id, $uid, $isi)[0]->txt;
    }
    $insert = $this->db->insert(
      $cmnt_table,
      array(
        "cmnt_reply" => $id,
        "cmnt_user" => $uid,
        "cmnt_name" => $name,
        "cmnt_edisi" => $edisi,
        "cmnt_magz_content" => $section,
        "cmnt_magz_content_dtl" => $share,
        "cmnt_text" => $isi,
        "cmnt_content_hdr" => $hdr,
        "cmnt_content_dtl" => $dtl,
        "cmnt_created" => date("Y-m-d H:i:s")
      )
    );
    return $this->db->insert_id();
  }
  function get_repl_text($id, $uid, $txt)
  {
    $sintak = "select ifnull((SELECT IF('$uid'=cmnt_user,'$txt',CONCAT('@',cmnt_name,' ','$txt')) FROM openview_comment WHERE cmnt_id='$id'),'') as txt";
    $qry = $this->db->query($sintak);
    return all_query($qry);
  }
  function get_repl_count($arr)
  {
    $sql = "select cmnt_id from openview_comment where cmnt_reply in ($arr)";
    // echo "<br>";
    $qry = $this->db->query($sql);
    return all_query($qry);
  }
  function get_comment($magz_edisi, $magz_section, $limit)
  {
    $cmnt_table = "openview_comment";
    $parent = "SELECT a.cmnt_id as id,a.cmnt_reply as rpl,a.cmnt_name as nme,a.cmnt_text as txt,  
                 a.cmnt_content_hdr as cnt_hdr,a.cmnt_content_dtl as cnt_dtl,              
                  IF(TIMESTAMPDIFF(YEAR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                    IF(TIMESTAMPDIFF(MONTH, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                      IF(TIMESTAMPDIFF(DAY, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                         IF(TIMESTAMPDIFF(HOUR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                            IF(TIMESTAMPDIFF(MINUTE, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,((CONCAT(TIMESTAMPDIFF(SECOND, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' second'))
                            ),(CONCAT(TIMESTAMPDIFF(MINUTE, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' minute')))
                         ),(CONCAT(TIMESTAMPDIFF(HOUR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' hour')))
                      ),(CONCAT(TIMESTAMPDIFF(DAY, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' day')))
                    ),(CONCAT(TIMESTAMPDIFF(MONTH, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' month')))
                  ),(CONCAT(TIMESTAMPDIFF(YEAR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' year'))) AS tgl,
                  COUNT(b.cmnt_id) AS ttl,           
                  (SELECT CONCAT(
                    'id:',c.cmnt_id,',',
                    'rpl:',c.cmnt_reply,',',
                    'nme:',c.cmnt_name,',',
                    'txt:',c.cmnt_text,',',
                    'tgl:',(IF(TIMESTAMPDIFF(YEAR, c.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                              IF(TIMESTAMPDIFF(MONTH, c.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                                IF(TIMESTAMPDIFF(DAY, c.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                                   IF(TIMESTAMPDIFF(HOUR, c.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                                      IF(TIMESTAMPDIFF(MINUTE, c.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,((CONCAT(TIMESTAMPDIFF(SECOND, c.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' second'))
                                      ),(CONCAT(TIMESTAMPDIFF(MINUTE, c.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' minute')))
                                   ),(CONCAT(TIMESTAMPDIFF(HOUR, c.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' hour')))
                                ),(CONCAT(TIMESTAMPDIFF(DAY, c.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' day')))
                              ),(CONCAT(TIMESTAMPDIFF(MONTH, c.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' month')))
                            ),(CONCAT(TIMESTAMPDIFF(YEAR, c.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' year')))),',',
                    'ttl:0')
                   FROM openview_comment c WHERE c.cmnt_reply=a.cmnt_id ORDER BY c.cmnt_created DESC LIMIT 1) AS chld, ifnull(a.cmnt_magz_content_dtl,'') as dibagi,
                   ifnull(a.cmnt_magz_content,'') as magz_hdr
                  FROM openview_comment a LEFT JOIN openview_comment b ON a.cmnt_id=b.cmnt_reply
                  WHERE a.cmnt_reply='0' AND a.cmnt_edisi='$magz_edisi' AND IFNULL(a.cmnt_magz_content,'')='$magz_section' 
                  GROUP BY a.cmnt_id  ORDER BY a.cmnt_created desc $limit";
    #echo $parent;                  
    $query  = $this->db->query($parent);
    return all_query($query);
  }
  function get_comment_ttl($magz_edisi, $magz_section, $cmnt_reply)
  {
    if ($cmnt_reply != "") {
      $where = "WHERE cmnt_reply='$cmnt_reply'";
    } else {
      $where = "WHERE cmnt_reply='0' AND cmnt_edisi='$magz_edisi' AND IFNULL(cmnt_magz_content,'')='$magz_section'";
    }
    $cmnt_table = "openview_comment";
    $magz_edisi = "bca-87";
    $parent = "SELECT 'total','0','comment',COUNT(1) AS ttl,'' FROM openview_comment " . $where;
    $query  = $this->db->query($parent);
    return all_query($query);
  }
  function get_comment_child($cmnt_id, $limit, $tipe)
  {
    $cmnt_table = "openview_comment";
    $where = "a.cmnt_reply";
    if ($limit == "post") {
      $where = "a.cmnt_id";
      $limit = "";
      $add   = "a.cmnt_magz_content as magz_hdr,";
      if ($tipe == "cntn") {
        $add = "a.cmnt_content_hdr as cnt_hdr,a.cmnt_content_dtl as cnt_dtl,a.cmnt_magz_content as magz_hdr,";
      }
    }
    $parent = "SELECT a.cmnt_id,a.cmnt_reply,a.cmnt_name,a.cmnt_text," . $add . "
                  IF(TIMESTAMPDIFF(YEAR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                    IF(TIMESTAMPDIFF(MONTH, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                      IF(TIMESTAMPDIFF(DAY, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                         IF(TIMESTAMPDIFF(HOUR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                            IF(TIMESTAMPDIFF(MINUTE, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,((CONCAT(TIMESTAMPDIFF(SECOND, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' second'))
                            ),(CONCAT(TIMESTAMPDIFF(MINUTE, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' minute')))
                         ),(CONCAT(TIMESTAMPDIFF(HOUR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' hour')))
                      ),(CONCAT(TIMESTAMPDIFF(DAY, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' day')))
                    ),(CONCAT(TIMESTAMPDIFF(MONTH, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' month')))
                  ),(CONCAT(TIMESTAMPDIFF(YEAR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' year'))) AS tgl, ifnull(a.cmnt_magz_content_dtl,'') as dibagi,
                  -- DATE_FORMAT(a.cmnt_created,'%d-%m-%y %H:%i') AS tanggal,
                  COUNT(b.cmnt_id) AS rpl FROM $cmnt_table a LEFT JOIN $cmnt_table b ON a.cmnt_id=b.cmnt_reply WHERE $where=$cmnt_id GROUP BY a.cmnt_id ORDER BY a.cmnt_created desc " . $limit;
    // echo $parent;
    $query  = $this->db->query($parent);
    return all_query($query);
  }
  function get_repl_data($arr_reply, $limit)
  {
    $limit = "limit " . $limit;
    $timer  = " IF(TIMESTAMPDIFF(YEAR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                    IF(TIMESTAMPDIFF(MONTH, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                      IF(TIMESTAMPDIFF(DAY, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                         IF(TIMESTAMPDIFF(HOUR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,(
                            IF(TIMESTAMPDIFF(MINUTE, a.cmnt_created, '" . date('Y-m-d H:i:s') . "')<1,((CONCAT(TIMESTAMPDIFF(SECOND, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' second'))
                            ),(CONCAT(TIMESTAMPDIFF(MINUTE, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' minute')))
                         ),(CONCAT(TIMESTAMPDIFF(HOUR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' hour')))
                      ),(CONCAT(TIMESTAMPDIFF(DAY, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' day')))
                    ),(CONCAT(TIMESTAMPDIFF(MONTH, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' month')))
                  ),(CONCAT(TIMESTAMPDIFF(YEAR, a.cmnt_created, '" . date('Y-m-d H:i:s') . "'),' year'))) AS tgl";
    // $timer  = "DATE_FORMAT(a.cmnt_created,'%d-%m-%y %H:%i') AS tanggal";
    $parent = "SELECT a.cmnt_id as id,a.cmnt_reply as rpl,a.cmnt_name as nme,a.cmnt_text as txt,
                 $timer,
                 null as chld, ifnull(cmnt_magz_content_dtl,'') as dibagi FROM openview_comment a WHERE cmnt_id in ($arr_reply) ORDER BY a.cmnt_created asc " . $limit;
    $query  = $this->db->query($parent);
    return all_query($query);
  }

  function view_hdr()
  {
    $sintak = "SELECT a.*,SUM(view_like) AS `like`,SUM(view_comment) AS `cmnt`,SUM(view_bookmark) AS book FROM openview_data_hdr a LEFT JOIN openview_data_view b ON a.`ov_hdr_id`=b.`ov_hdr_fk_id`
      GROUP BY a.`ov_hdr_id` ORDER BY 1 DESC";
    $query  = $this->db->query($sintak);
    return all_query($query);
  }

  function view_dtl($zahwa)
  {
    $sintak = "SELECT magz_page,content,title,`lead`,b.`ov_path` FROM openview_data_dtl a LEFT JOIN openview_data_hdr b 
    ON a.ov_hdr_fk_id=b.`magz_dtl_fk_id`
    WHERE ov_hdr_fk_id='$zahwa' AND IFNULL(title,'')!='';";
    $query  = $this->db->query($sintak);
    return all_query($query);
  }

  function theme_view_logo($adelia)
  {
    $sintak = "SELECT magz_logo,magz_logo_height from magazine_data_hdr d WHERE (magz_url ='" . $adelia . "') AND magz_openview='1'";
    $query  = $this->db->query($sintak);
    return single_query($query);
  }
  function theme_view_hdr($adelia)
  {
    $sintak = "
    SELECT a.ov_hdr_id,a.magz_dtl_fk_id,content_title,content_desc,c.issue_path AS ov_path,d.magz_logo as logo,ov_coment,IFNULL(SUM(view_like) ,0)AS `like`,IFNULL(SUM(view_comment) ,'0')AS `cmnt`,IFNULL(SUM(view_bookmark),0) AS book FROM openview_data_hdr a 
    LEFT JOIN openview_data_view b ON a.`ov_hdr_id`=b.`ov_hdr_fk_id` 
    LEFT JOIN magazine_data_dtl c ON a.magz_dtl_fk_id=c.magz_dtl_id
    LEFT JOIN magazine_data_hdr d ON c.magz_fk_id = d.magz_id WHERE (magz_url ='" . $adelia . "') AND magz_openview='1'
    GROUP BY a.`ov_hdr_id` ORDER BY 1 DESC";
    $query  = $this->db->query($sintak);
    return all_query($query);
  }

  function theme_view_dtl($zahwa)
  {
    $sintak = "SELECT '1' AS magz_page,'x' as magz_image,'cover' AS content, upper(issue_title) AS title,content_title AS `lead`,`issue_path` AS ov_path 
                    FROM openview_data_hdr c
                    LEFT JOIN magazine_data_dtl d ON c.`magz_dtl_fk_id`=d.magz_dtl_id WHERE magz_dtl_fk_id='$zahwa'
                    UNION 
                    SELECT magz_page, ifnull(magz_image,'x') as magz_image,content,title,`lead`,b.`issue_path` AS ov_path 
                    FROM openview_data_dtl a 
                    LEFT JOIN magazine_data_dtl  b ON a.`ov_hdr_fk_id`=b.magz_dtl_id
                    WHERE ov_hdr_fk_id='$zahwa' AND IFNULL(title,'')!=''";
    $query  = $this->db->query($sintak);
    return all_query($query);
  }
  function magazine_data($magz_id)
  {
    if ($magz_id != "archive") {
      $sintak = "SELECT  magz_name,issue_title,issue_desc,magz_openview,magz_comment FROM magazine_data_dtl a LEFT JOIN magazine_data_hdr b ON a.`magz_fk_id`=b.magz_id WHERE magz_dtl_id='$magz_id' OR magz_url='$magz_id'  ORDER BY magz_dtl_id DESC LIMIT 1";
      return single_query($this->db->query($sintak));
    } else {
      $sintak = "SELECT MAX(magz_dtl_id) AS magz_dtl_id,magz_url,magz_name,magz_desc,magz_openview,magz_comment,magz_logo_height ,
      COUNT(c.`magz_dtl_fk_id`) AS total,
      b.`issue_path`
      FROM magazine_data_hdr  a 
      LEFT JOIN magazine_data_dtl b ON a.`magz_id`=b.`magz_fk_id`
      LEFT JOIN openview_data_hdr c ON b.magz_dtl_id=c.`magz_dtl_fk_id`
      WHERE magz_openview='1'
      GROUP BY a.`magz_id`
      ORDER BY COUNT(c.`magz_dtl_fk_id`)  DESC";
      return all_query($this->db->query($sintak));
    }
  }

  /*
  function api($id){    
      $sintak = "SELECT ov_flipbook ,ov_openview  FROM magazine_openview_path WHERE ov_id='$id'";
      $path = single_query($this->db->query($sintak));
      if(empty($path)){
        return "0";
      }else{
        return $path;
      }
  }
  function openview_content($id,$page){
    #echo $page;
      $sintak = "SELECT * FROM api_openview_dtl WHERE magz_dtl_id='$id' and magz_page='$page'";
      #echo $sintak;
      $dtl_qry = each_query($this->db->query($sql));
      if(empty($dtl_qry)){
        return "0";
      }else{
        return $dtl_qry;
      }
  }
  function openview_hdr($id){
    #echo $page;
     $sintak = "SELECT * FROM api_openview_hdr WHERE magz_dtl_id='$id'";
      $hdr_qry  = each_query($this->db->query($sintak));      
      if(empty($hdr_qry)){
        return "x";
      }else{
          return $hdr_qry;
      }        
  }
  function openview_dtl($id,$page){
    #echo $page;
    $xpage = str_replace("p","", $page);
    if($page=="all"){
         $sintak = "SELECT * FROM api_openview_dtl WHERE magz_dtl_id='$id'";
    }else{      
      if(!is_numeric($xpage)){
        $sintak = "SELECT * FROM api_openview_dtl WHERE magz_dtl_id='$id' AND REPLACE(content,' ','-')='$page'";
      }else{
        $sintak = "SELECT * FROM api_openview_dtl WHERE magz_dtl_id='$id' AND content = (SELECT content FROM api_openview_dtl  WHERE magz_dtl_id='$id' AND  magz_page='$xpage')";
      }
    }
      #echo $sintak;
      $dtl_qry = each_query($this->db->query($sintak));
      if(empty($dtl_qry)){
        return "0";
      }else{
        return $dtl_qry;
      }
  }
  function cek_openview($id,$page){    
      $sintak = "SELECT count(1) as total FROM magazine_data_openivew a LEFT JOIN magazine_data_dtl b ON a.magz_dtl_fk_id=b.magz_dtl_id WHERE b.magz_dtl_id='$id'";
      $sql    = $sintak." and magz_page='$page'";
      $query  = single_query($this->db->query($sintak));
      if(empty($query) || $query->total==0){
        return "x";
      }else{
        $query = single_query($this->db->query($sql));
        if(empty($query) || $query->total==0){
          return "0";
        }else{
          return $query->total;
        }
      }
  }
  function yang_isi_anantara() {
      $sintak = "
        SELECT * FROM api_openview_hdr WHERE title IS NOT NULL AND magz_id = '41'
      ";
        #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
      return result_query($this->db->query($sintak));
  }
  function detil_isi_anantara($id = '') {
      $id = str_replace('%20', ' ', $id);
      $sintak = ($id == "0") ? "SELECT * FROM api_openview_dtl WHERE magz_id = '41'" : "SELECT * FROM api_openview_dtl WHERE magz_id = '41' AND content='$id'";
        #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
      return result_query($this->db->query($sintak));
  }
  function detail_isi_anantara($id = '') {
      $id = str_replace('%20', ' ', $id);
      $sintak = ($id == "0") ? "SELECT * FROM api_openview_dtl WHERE magz_id = '41'" : "SELECT * FROM api_openview_dtl WHERE issue_id='$id'";
        #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
      return result_query($this->db->query($sintak));
  }
  */
}
