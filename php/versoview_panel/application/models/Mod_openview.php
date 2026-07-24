<?php
class Mod_openview extends CI_Model
{
  function link($id)
  {
    $sintak = "SELECT issue_path  FROM magazine_data_dtl WHERE magz_dtl_id='$id'";
    $path = single_query($this->db->query($sintak));
    if (empty($path)) {
      return "0";
    } else {
      return $path;
    }
  }
  function api($id)
  {
    $sintak = "SELECT ov_flipbook ,ov_openview  FROM magazine_openview_path WHERE ov_id='$id'";
    $path = single_query($this->db->query($sintak));
    if (empty($path)) {
      return "0";
    } else {
      return $path;
    }
  }
  function openview_content($id, $page)
  {
    #echo $page;
    $sintak = "SELECT * FROM api_openview_dtl WHERE magz_dtl_id='$id' and magz_page='$page'";
    #echo $sintak;
    $dtl_qry = each_query($this->db->query($sql));
    if (empty($dtl_qry)) {
      return "0";
    } else {
      return $dtl_qry;
    }
  }
  function openview_hdr($id)
  {
    #echo $page;
    $sintak = "SELECT * FROM api_openview_hdr WHERE magz_dtl_id='$id' order by magz_page asc";
    $hdr_qry  = each_query($this->db->query($sintak));
    if (empty($hdr_qry)) {
      return "x";
    } else {
      return $hdr_qry;
    }
  }
  function openview_edisi($id)
  {
    $sintak = "SELECT  replace(REPLACE(LOWER(b.`issue_title`),'edisi',''),' ','') AS edisi,b.issue_title AS judul,b.`issue_path` as url FROM 
    openview_data_hdr  a LEFT JOIN magazine_data_dtl b ON a.`magz_dtl_fk_id`=b.`magz_dtl_id`
    WHERE magz_dtl_fk_id='$id' ";
    $hdr_qry  = each_query($this->db->query($sintak));
    if (empty($hdr_qry)) {
      return "x";
    } else {
      return $hdr_qry;
    }
  }
  function openview_dtl($id, $page)
  {
    #echo $page;
    $xpage = str_replace("p", "", $page);
    if ($page == "all") {
      $sintak = "SELECT * FROM api_openview_dtl WHERE magz_dtl_id='$id' order by magz_page asc";
    } else {
      if (!is_numeric($xpage)) {
        $sintak = "SELECT * FROM api_openview_dtl WHERE magz_dtl_id='$id' AND REPLACE(content,' ','-')='$page'";
      } else {
        $sintak = "SELECT * FROM api_openview_dtl WHERE magz_dtl_id='$id' AND content = (SELECT content FROM api_openview_dtl  WHERE magz_dtl_id='$id' AND  magz_page='$xpage')";
      }
    }
    #echo $sintak;
    $dtl_qry = each_query($this->db->query($sintak));
    if (empty($dtl_qry)) {
      return "0";
    } else {
      return $dtl_qry;
    }
  }
  function cek_openview($id, $page)
  {
    $sintak = "SELECT count(1) as total FROM magazine_data_openivew a LEFT JOIN magazine_data_dtl b ON a.magz_dtl_fk_id=b.magz_dtl_id WHERE b.magz_dtl_id='$id'";
    $sql    = $sintak . " and magz_page='$page'";
    $query  = single_query($this->db->query($sintak));
    if (empty($query) || $query->total == 0) {
      return "x";
    } else {
      $query = single_query($this->db->query($sql));
      if (empty($query) || $query->total == 0) {
        return "0";
      } else {
        return $query->total;
      }
    }
  }
  function yang_isi_anantara()
  {
    $sintak = "
        SELECT * FROM api_openview_hdr WHERE title IS NOT NULL AND magz_id = '41'
      ";
    #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
    return result_query($this->db->query($sintak));
  }
  function detil_isi_anantara($id = '')
  {
    $id = str_replace('%20', ' ', $id);
    $sintak = ($id == "0") ? "SELECT * FROM api_openview_dtl WHERE magz_id = '41'" : "SELECT * FROM api_openview_dtl WHERE magz_id = '41' AND content='$id'";
    #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
    return result_query($this->db->query($sintak));
  }
  function detail_isi_anantara($id = '')
  {
    $id = str_replace('%20', ' ', $id);
    $sintak = ($id == "0") ? "SELECT * FROM api_openview_dtl WHERE magz_id = '41'" : "SELECT * FROM api_openview_dtl WHERE issue_id='$id'";
    #AND magz_fk_id=(SELECT magz_id FROM magazine_data_hdr WHERE LOWER(magz_url='colours'))
    return result_query($this->db->query($sintak));
  }
}
