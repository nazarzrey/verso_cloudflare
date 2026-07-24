<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mod_sync extends CI_Model
{
  function Query($table, $where_array)
  {
    $qry = $this->db->get_where($table, $where_array);
    $rsl = $qry->result();
    return $rsl;
  }

  function Query_in($table, $kolom, $where_array)
  {
    $this->db->get($table);
    $qry = $this->db->where_in($kolom, $where_array);

    $rsl = $qry->result();
    return $rsl;
  }

  function count_table($table, $where_array)
  {
    if (is_array($where_array)) {
      $this->db->select(" count(*) as total ");
      $qry = $this->db->get_where($table, $where_array);
      $rsl = $qry->result();
    } else {
      $qry = $this->db->query("select  count(*) as total from $table");
      $rsl = $qry->result();
    }
    return $rsl;
  }
  function cek_data($project, $rawdata)
  {
    $sql = "select  count(1) as total  from monitoring where project='$project' and rawdata='$rawdata' and tgl(updrec_date)=curdate()";
    $qry = $this->db->query($sql);
    $rsl = $qry->result();
    return $rsl;
  }
  /*
  function user_log()
  {
    $ua  = getBrowser();
    $arr = array("ipaddr" => $_SERVER['REMOTE_ADDR'], "browser" => $ua['name'], "browser_v" => $ua['version'], "os" => $ua['platform'], "timestamp" => date("Y-m-d H:00:00"));
    $data = $this->db->get_where("user_log", $arr);
    if (!$data->result()) {
      $this->db->insert("user_log", $arr);
    };
  }

  function masukin_energy($data, $project)
  {
    $arr = exec_prc("CALL energy('$project','$data','" . date("Y-m-d H:00:00") . "')");
    return $arr;
  }
*/
  public function get_content($tbl, $kolom, $id)
  {
    if (is_array($kolom)) {
      $has =  $this->db->get_where($tbl, $kolom);
    } else {
      $has =  $this->db->get_where($tbl, array($kolom => $id));
    }
    // $ttl = count($has->result());
    return each_query($has);
  }

  function updDataForm($tbl, $tipe, $kolom, $uid,  $data_array)
  {
    if (is_array($kolom)) {
      $has =  $this->db->get_where($tbl, $kolom);
    } else {
      $has =  $this->db->get_where($tbl, array($kolom => $uid));
    }
    $ttl = count($has->result());
    if ($tipe == "Hapus") {
      $result = $this->hapusin_data($tbl, $kolom, $uid);
    } else {
      if ($ttl == 0) {
        $result = $this->masukin_data($data_array, $tbl, "");
      } else {
        if (is_array($kolom)) {
          $where  = $kolom;
        } else {
          $where  = array($kolom => $uid);
        }
        $result = $this->editin_data($data_array, $tbl, "", $where);
      }
    }
    return $result;
  }

  function masukin_data($array, $table, $tipe)
  {
    if ($tipe == "batch") {
      $this->db->insert_batch($table, $array);
    } else {
      $this->db->insert($table, $array);
    }
    if ($this->db->affected_rows() > 0) {
      return TRUE;
    }
    return FALSE;
  }

  function masukin_cek($array, $table, $tipe)
  {
    $cek = $this->db->get_where($table, $array);
    if (count($cek->result()) == 0) {
      $this->masukin_data($array, $table, $tipe);
    } else {
      return false;
    }
  }

  function editin_data($array, $table, $tipe, $where)
  {
    if ($tipe == "batch") {
      $y = $this->db->insert_batch($table, $array);
    } else {
      $this->db->where($where);
      $y = $this->db->update($table, $array);
    }
    return $y;
  }

  function hapusin_data($table, $kolom, $id)
  {
    $this->db->where($kolom, $id);
    $y = $this->db->delete($table);
    return $y;
  }

  function random_key()
  {
    $keys   = ranKey("6");
    $this->db->where("link_url", $keys);
    $query  = $this->db->get("new_link");
    if ($query->num_rows($query) == 0) {
      $url  = $keys;
    } else {
      $url  = tgl("sort");
    }
    return $url;
  }
  function dynKey()
  {
    $keys   = ranKey("5");
    $this->db->where("link_url", $keys);
    $query  = $this->db->get("new_link");
    if ($query->num_rows($query) == 0) {
      $url  = $keys;
    } else {
      $url  = $this->random_key();
    }
    return $url;
  }
  function qryOther($sql)
  {
    $sql   =  $this->db->query($sql);
    return all_query($sql);
  }
  function cekOther($tabel, $array)
  {
    $query = "select * from $tabel " . db_array($array, "select");
    $sql   =  $this->db->query($query);
    return all_query($sql);
  }
  function saveOther($tabel, $array, $tipe)
  {
    if ($tipe == "add") {
      $query = " insert into $tabel " . db_array($array, "insert");
    } elseif ($tipe == "update") {
      $query = "update $tabel " . db_array($array, "update");
    } elseif ($tipe == "delete") {
      $query = "delete from $tabel " . db_array($array, "delete");
    }
    #debug($query);
    $sql   =  $this->db->query($query);
    return $sql;
  }
}
